<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
use TheCatzPajamaz\ScrapsToScrumptious;
use TheCatzPajamaz\ScrapsToScrumptious\User;

/**
 * api for signing up too DDC ScrapsToScrumptious
 *
 * @author Eric Martinez <emartinez451@cnm.edu>
 **/
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/scraps.ini");
	$pdo = $secrets->getPdoObject();
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userEmail = filter_input(INPUT_GET, "userEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userFirstName = filter_input(INPUT_GET, "userFirstName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userHandle = filter_input(INPUT_GET, "userHandle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userLastName = filter_input(INPUT_GET, "userLastName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	if($method === "POST") {
		//decode the json and turn it into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//user email is a required field
		if(empty($requestObject->userEmail) === true) {
			throw(new \InvalidArgumentException ("No user email present", 405));
		}

		//user first name is a required field
		if(empty($requestObject->userFirstName) === true) {
			throw(new \InvalidArgumentException ("Please enter first name", 405));
		}

		//user handle is a required field
		if(empty($requestObject->userHandle) === true) {
			throw(new \InvalidArgumentException ("No user handle", 405));
		}

		//user last name is a required field
		if(empty($requestObject->userLastName) === true) {
			throw(new \InvalidArgumentException ("Please enter last name", 405));
		}

		//verify that user password is present
		if(empty($requestObject->userPassword) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}
		//verify that the confirm password is present
		if(empty($requestObject->userPasswordConfirm) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}
		
		//make sure the password and confirm password match
		if ($requestObject->userPassword !== $requestObject->userPasswordConfirm) {
			throw(new \InvalidArgumentException("passwords do not match"));
		}
		$hash = password_hash($requestObject->userPassword, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$userActivationToken = bin2hex(random_bytes(16));
		//create the user object and prepare to insert into the database
		$user = new User(generateUuidV4(), $userActivationToken, $requestObject->userEmail, $requestObject->userFirstName, $requestObject->userHandle, $hash, $requestObject->userLastName);
		//insert the user into the database
		$user->insert($pdo);
		//compose the email message to send with th activation token
		$messageSubject = "One step closer to Sticky Head -- Account Activation";
		//building the activation link that can travel to another server and still work. This is the link that will be clicked to confirm the account.
		//make sure URL is /public_html/api/activation/$activation
		$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);
		//create the path
		$urlglue = $basePath . "/api/activation/?activation=" . $userActivationToken;
		//create the redirect link
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;
		//compose message to send with email
		$message = <<< EOF
<h2>Thanks for signing up :-)).</h2>
<p><a href="$confirmLink">$confirmLink</a></p>
EOF;
		//create swift email
		$swiftMessage = new Swift_Message();
		// attach the sender to the message
		// this takes the form of an associative array where the email is the key to a real name
		$swiftMessage->setFrom(["NOREPLY@scrapstoscrumptious.com" => "NOREPLY@scrapstoscrumptious.com"]);
		/**
		 * attach recipients to the message
		 * notice this is an array that can include or omit the recipient's name
		 * use the recipient's real name where possible;
		 * this reduces the probability of the email is marked as spam
		 */
		//define who the recipient is
		$recipients = [$requestObject->userEmail];
		//set the recipient to the swift message
		$swiftMessage->setTo($recipients);
		//attach the subject line to the email message
		$swiftMessage->setSubject($messageSubject);
		/**
		 * attach the message to the email
		 * set two versions of the message: a html formatted version and a filter_var()ed version of the message, plain text
		 * notice the tactic used is to display the entire $confirmLink to plain text
		 * this lets users who are not viewing the html content to still access the link
		 */
		//attach the html version fo the message
		$swiftMessage->setBody($message, "text/html");
		//attach the plain text version of the message
		$swiftMessage->addPart(html_entity_decode($message), "text/plain");
		/**
		 * send the Email via SMTP; the SMTP server here is configured to relay everything upstream via CNM
		 * this default may or may not be available on all web hosts; consult their documentation/support for details
		 * SwiftMailer supports many different transport methods; SMTP was chosen because it's the most compatible and has the best error handling
		 * @see http://swiftmailer.org/docs/sending.html Sending Messages - Documentation - SwitftMailer
		 **/
		//setup smtp
		$smtp = new Swift_SmtpTransport(
			"localhost", 25);
		$mailer = new Swift_Mailer($smtp);
		//send the message
		$numSent = $mailer->send($swiftMessage, $failedRecipients);
		/**
		 * the send method returns the number of recipients that accepted the Email
		 * so, if the number attempted is not the number accepted, this is an Exception
		 **/
		if($numSent !== count($recipients)) {
			// the $failedRecipients parameter passed in the send() method now contains contains an array of the Emails that failed
			throw(new RuntimeException("unable to send email", 400));
		}
		// update reply
		$reply->message = "Thank you for being a user of Scraps to Scrumptious";
	} else {
		throw (new InvalidArgumentException("invalid http request"));
	}
} catch(\Exception |\TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
}
header("Content-type: application/json");
echo json_encode($reply);
<?php
//require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
//require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
//require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
//require_once dirname(__DIR__, 3) . "/lib/jwt.php";
//require_once dirname(__DIR__, 3) . "/lib/uuid.php";
//require_once("/etc/apache2/capstone-mysql/Secrets.php");
//use TheCatzPajamaz\ScrapsToScrumptious\User;

require_once dirname(__DIR__, 3) . "/php/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";

use TheCatzPajamaz\ScrapsToScrumptious\User;

/**
 * API for User
 *
 *
 * @author Gkephart
 * @author  tgray19
 * @version 1.0
 */
//verify the session, if it is not active start it
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//verify the session, if it is not active start it
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	//grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/scraps.ini");
	$pdo = $secrets->getPdoObject();
	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];
	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userEmail = filter_input(INPUT_GET, "userEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userFirstName = filter_input(INPUT_GET, "userFirstName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userHandle = filter_input(INPUT_GET, "userHandle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userLastName = filter_input(INPUT_GET, "userLastName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//gets a user by content
		if(empty($id) === false) {
			$reply->data = User::getUserByUserId($pdo, $id);
		} else if(empty($userEmail) === false) {
			$reply->data = User::getUserByUserEmail($pdo, $userEmail);
		}
	} elseif($method === "PUT") {
		//enforce that the XSRF token is present in the header
		verifyXsrf();
		//enforce the end user has a JWT token
		validateJwtHeader();
		//enforce the user is signed in and only trying to edit their own user
		if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this user", 403));
		}
//		validateJwtHeader();
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//retrieve the user to be updated
		$user = User::getUserByUserId($pdo, $id);
		if($user === null) {
			throw(new RuntimeException("User does not exist", 404));
		}
		//user email is a required field
			//user email is a required field
			if(empty($requestObject->userEmail) === true) {
				throw(new \InvalidArgumentException ("No user email present", 405));
			}

			//user email is a required field
			if(empty($requestObject->userFirstName) === true) {
				throw(new \InvalidArgumentException ("No first name", 405));
			}
				//userHandle
				if(empty($requestObject->userHandle) === true) {
					throw(new \InvalidArgumentException ("No userHandle", 405));
				}

				//user email is a required field
				if(empty($requestObject->userLastName) === true) {
					throw(new \InvalidArgumentException ("No user last name", 405));
				}
					// Do i include id here too?$user->setUserEmail($requestObject->userEmail);
					$user->setUserEmail($requestObject->userEmail);
					$user->setUserFirstName($requestObject->userFirstName);
					$user->setUserHandle($requestObject->userHandle);
					$user->setUserLastName($requestObject->userLastName);
					$user->update($pdo);
					// update reply
					$reply->message = "User information updated";
				}
				// catch any exceptions that were thrown and update the status and message state variable fields
			}
		catch
			(\Exception | \TypeError $exception) {
				$reply->status = $exception->getCode();
				$reply->message = $exception->getMessage();
			}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
//var_dump($reply->data);
echo json_encode($reply);










//
//
//require_once dirname(__DIR__, 3) . "/php/vendor/autoload.php";
//require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
//require_once("/etc/apache2/capstone-mysql/Secrets.php");
//require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
//require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
//require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
//
//
//
//use TheCatzPajamaz\ScrapsToScrumptious\ {
//	User
//};
//
///**
// * API for User
// *
// * @author Gkephart
// * @version 1.0
// */
//
////verify the session, if it is not active start it
//if(session_status() !== PHP_SESSION_ACTIVE) {
//	session_start();
//}
////prepare an empty reply
//$reply = new stdClass();
//$reply->status = 200;
//$reply->data = null;
//
//try {
//	//grab the mySQL connection
//
//	$secrets = new \Secrets("/etc/apache2/capstone-mysql/scraps.ini");
//	$pdo = $secrets->getPdoObject();
//
//
//	//determine which HTTP method was used
//	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
//	// sanitize input
//	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//	$userHandle = filter_input(INPUT_GET, "userHandle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//	$userEmail = filter_input(INPUT_GET, "userEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//
//
//	// make sure the id is valid for methods that require it
//	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
//		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
//	}
//
//	if($method === "GET") {
//		//set XSRF cookie
//		setXsrfCookie();
//
//		//gets a post by content
//		if(empty($id) === false) {
//			$reply->data = User::getUserByUserId($pdo, $id);
////		} else if(empty($userHandle) === false) {
////			$reply->data = User::getUserByUserHandle($pdo, $userHandle);
//
//		} else if(empty($userEmail) === false) {
//
//			$reply->data = User::getUserByUserEmail($pdo, $userEmail);
//		}
//
//	} elseif($method === "PUT") {
//
//		//enforce that the XSRF token is present in the header
//		verifyXsrf();
//
//		//enforce the end user has a JWT token
//		//validateJwtHeader();
//
//		//enforce the user is signed in and only trying to edit their own user
//		if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $id) {
//			throw(new \InvalidArgumentException("You are not allowed to access this user", 403));
//		}
//
//		validateJwtHeader();
//
//		//decode the response from the front end
//		$requestContent = file_get_contents("php://input");
//		$requestObject = json_decode($requestContent);
//
//		//retrieve the user to be updated
//		$user = User::getUserByUserId($pdo, $id);
//		if($user === null) {
//			throw(new RuntimeException("User does not exist", 404));
//		}
//
//
//		//user handle
//		if(empty($userHandle) === true) {
//			throw(new \InvalidArgumentException ("No user handle", 405));
//		}
//
//		//user email is a required field
//		if(empty($userEmail) === true) {
//			throw(new \InvalidArgumentException ("No user email present", 405));
//		}
//
//		$user->setUserHandle($requestObject->userHandle);
//		$user->setUserEmail($requestObject->userEmail);
//		$user->update($pdo);
//
//		// update reply
//		$reply->message = "User information updated";
//
//
//	} elseif($method === "DELETE") {
//
//		//verify the XSRF Token
//		verifyXsrf();
//
//		//enforce the end user has a JWT token
//		//validateJwtHeader();
//
//		$user = User::getUserByUserId($pdo, $id);
//		if($user === null) {
//			throw (new RuntimeException("User does not exist"));
//		}
//
//		//enforce the user is signed in and only trying to edit their own user
//		if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $user->getUserId()->toString()) {
//			throw(new \InvalidArgumentException("You are not allowed to access this user", 403));
//		}
//
//		validateJwtHeader();
//
//		//delete the post from the database
//		$user->delete($pdo);
//		$reply->message = "User Deleted";
//
//	} else {
//		throw (new InvalidArgumentException("Invalid HTTP request", 400));
//	}
//	// catch any exceptions that were thrown and update the status and message state variable fields
//} catch
//(\Exception | \TypeError $exception) {
//	$reply->status = $exception->getCode();
//	$reply->message = $exception->getMessage();
//}
//
//header("Content-type: application/json");
//if($reply->data === null) {
//	unset($reply->data);
//}
//
//// encode and return reply to front end caller
////$reply->data=utf8_encode($reply->data);
//echo json_encode($reply);

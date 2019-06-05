<?php
require_once dirname(__DIR__, 3) . "/php/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";

use TheCatzPajamaz\ScrapsToScrumptious\Cookbook; {
};
/**
 * Api for the Cookbook class
 *
 * @author george kephart
 */
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/scraps.ini");
	$pdo = $secrets->getPdoObject();
	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];
	//sanitize the search parameters
	$cookbookRecipeId = $id = filter_input(INPUT_GET, "cookbookRecipeId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$cookbookUserId = $id = filter_input(INPUT_GET, "cookbookUserId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//gets  a specific cookbook associated based on its composite key
		if ($cookbookRecipeId !== null && $cookbookUserId !== null) {
			$cookbook = Cookbook::getCookbookByCookbookRecipeIdAndCookbookUserId($pdo, $cookbookUserId, $cookbookRecipeId);
			if($cookbook!== null) {
				$reply->data = $cookbook;
			}
			//if none of the search parameters are met throw an exception
		} else if(empty($cookbookUserId) === false) {
			$reply->data = Cookbook::getCookbooksByCookbookUserId($pdo, $cookbookUserId)->toArray();
			//get all the cookbooks associated with the recipeId
		} else if(empty($cookbookRecipeId) === false) {
			$reply->data = Cookbook::getCookbookByCookbookRecipeIdAndCookbookUserId($pdo, $cookbookRecipeId, $cookbookUserId);
		} else {
			throw new InvalidArgumentException("incorrect search parameters ", 404);
		}
	} else if($method === "POST" || $method === "PUT") {
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		if(empty($requestObject->cookbookUserId) === true) {
			throw (new \InvalidArgumentException("No User linked to the Cookbook", 405));
		}
		if(empty($requestObject->cookbookRecipeId) === true) {
			throw (new \InvalidArgumentException("No recipe linked to the Cookbook", 405));
		}
		if($method === "POST") {
			//enforce that the end user has a XSRF token.
			verifyXsrf();
			//enforce the end user has a JWT token
			//validateJwtHeader();
			// enforce the user is signed in
			if(empty($_SESSION["user"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in too cookbook posts", 403));
			}
			validateJwtHeader();
			$cookbook = new Cookbook($_SESSION["user"]->getUserId(), $requestObject->cookbookRecipeId);
			$cookbook->insert($pdo);
			$reply->message = "cookbook recipe successful";
		} else if($method === "PUT") {
			//enforce the end user has a XSRF token.
			verifyXsrf();
			//enforce the end user has a JWT token
			validateJwtHeader();
			//grab the cookbook by its composite key
			$cookbook = Cookbook::getCookbookByCookbookRecipeIdAndCookbookUserId($pdo, $requestObject->cookbookUserId, $requestObject->cookbookRecipeId);
			if($cookbook === null) {
				throw (new RuntimeException("Cookbook does not exist"));
			}
			//enforce the user is signed in and only trying to edit their own cookbook
			if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId() !== $cookbook->getCookbookUserId()) {
				throw(new \InvalidArgumentException("You are not allowed to delete this recipe", 403));
			}
			//validateJwtHeader();
			//preform the actual delete
			$cookbook->delete($pdo);
			//update the message
			$reply->message = "Cookbook successfully deleted";
		}
		// if any other HTTP request is sent throw an exception
	} else {
		throw new \InvalidArgumentException("invalid http request", 400);
	}
	//catch any exceptions that is thrown and update the reply status and message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);
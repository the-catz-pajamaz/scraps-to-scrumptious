<?php
require_once dirname(__DIR__, 2) . "/php/vendor/autoload.php";
require_once dirname(__DIR__, 2) . "/php/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 2) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 2) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 2) . "/php/lib/uuid.php";

use TheCatzPajamaz\ScrapsToScrumptious\Recipe; {

};
/**
 * api for the Recipe class
 *
 * @author Valente Meza <valebmeza@gmail.com>
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
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/scraps.ini");
	$pdo = $secrets->getPdoObject();
	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];
	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeUserId = filter_input(INPUT_GET, "recipeUserId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeDescription = filter_input(INPUT_GET, "recipeDescription", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeIngredients = filter_input(INPUT_GET, "recipeIngredients", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeMedia = filter_input(INPUT_GET, "recipeMedia", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeSteps = filter_input(INPUT_GET, "recipeSteps", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeTitle = filter_input(INPUT_GET, "recipeTitle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true )) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 402));
	}
	// handle GET request - if id is present, that recipe is returned, otherwise all recipes are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//get a specific recipe or all recipes and update reply
		if(empty($id) === false) {
			$reply->data = Recipe::getRecipeByRecipeId($pdo, $id);
		} else if(empty($recipeUserId) === false) {
			// if the user is logged in grab all the recipes by that user based  on who is logged in
			$reply->data = Recipe::getRecipesByRecipeUserId($pdo, $recipeUserId)->toArray();
		} else if(empty($recipeContent) === false) {
			$reply->data = Recipe::getRecipesByRecipeTitle($pdo, $recipeTitle)->toArray();
		} else {
			$reply->data = Recipe::getAllRecipes($pdo)->toArray();
		}
	} else if($method === "PUT" || $method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();
		// enforce the user is signed in
		if(empty($_SESSION["user"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to post recipes", 401));
		}
		$requestContent = file_get_contents("php://input");
		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);
		// This Line Then decodes the JSON package and stores that result in $requestObject
		//make sure recipe content is available (required field)
		if(empty($requestObject->recipeDescription) === true) {
			throw(new \InvalidArgumentException ("No description for Recipe.", 405));
		}
		if(empty($requestObject->recipeIngredients) === true) {
			throw(new \InvalidArgumentException ("No ingredients for Recipe.", 405));
		}
		if(empty($requestObject->recipeSteps) === true) {
			throw(new \InvalidArgumentException ("No steps for Recipe.", 405));
		}
		if(empty($requestObject->recipeTitle) === true) {
			throw(new \InvalidArgumentException ("No content for Recipe.", 405));
		}
		//perform the actual put or post
		if($method === "PUT") {
			// retrieve the recipe to update
			$recipe = Recipe::getRecipeByRecipeId($pdo, $id);
			if($recipe === null) {
				throw(new RuntimeException("Recipe does not exist", 404));
			}
			//enforce the end user has a JWT token
			//enforce the user is signed in and only trying to edit their own recipe
			if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $recipe->getRecipeUserId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this recipe", 403));
			}
			validateJwtHeader();
			// update all attributes
			$recipe->setRecipeDescription($requestObject->recipeDescription);
			$recipe->setRecipeIngredients($requestObject->recipeIngredients);
			$recipe->setRecipeMedia($requestObject->recipeMedia);
			$recipe->setRecipeSteps($requestObject->recipeSteps);
			$recipe->setRecipeTitle($requestObject->recipeTitle);
			$recipe->update($pdo);
			// update reply
			$reply->message = "Recipe updated";
		} else if($method === "POST") {
			// enforce the user is signed in
			if(empty($_SESSION["user"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post recipes", 403));
			}
			//enforce the end user has a JWT token
			validateJwtHeader();
			// create new recipe and insert into the database
			$recipe = new Recipe(generateUuidV4(), $_SESSION["user"]->getUserId(), $requestObject->recipeDescription, $requestObject->recipeIngredients,  $requestObject->recipeMedia, $requestObject->recipeSteps, $requestObject->recipeTitle);
			$recipe->insert($pdo);
			// update reply
			$reply->message = "Recipe created OK " . $recipe->getRecipeId();
		}
	} else if($method === "DELETE") {
		//enforce that the end user has a XSRF token.
		verifyXsrf();
		// retrieve the Recipe to be deleted
		$recipe = Recipe::getRecipeByRecipeId($pdo, $id);
		if($recipe === null) {
			throw(new RuntimeException("Recipe does not exist", 404));
		}
		//enforce the user is signed in and only trying to edit their own recipe
		if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $recipe->getRecipeUserId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this recipe", 403));
		}
		//enforce the end user has a JWT token
		validateJwtHeader();
		// delete recipe
		$recipe->delete($pdo);
		// update reply
		$reply->message = "Recipe deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request", 418));
	}
// update the $reply->status $reply->message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);
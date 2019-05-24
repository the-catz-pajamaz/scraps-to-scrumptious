<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
use TheCatzPajamaz\ScrapsToScrumptious;{
	Recipe, Media
};
/**
 * Cloudinary API for Medias
 *
 * @author Eric Martinez
 * @version 1.0
 */
// start session
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// prepare an empty reply
$reply = new StdClass();
$reply->status = 200;
$reply->data = null;
try {
	// Grab the MySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/ddcscraps.ini");
	$pdo = $secrets->getPdoObject();
	//determine which HTTP method is being used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];
	$recipeId = filter_input(INPUT_GET, "recipeId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userId = filter_input(INPUT_GET, "userId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$config = readConfig("/etc/apache2/capstone-mysql/ddcscraps.ini");
	$cloudinary = json_decode($config["cloudinary"]);
	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);
	// process GET requests
	if($method === "GET") {
		// set XSRF token
		setXsrfCookie();
		//get a specific media by id and update reply
		if(empty($id) === false) {
			$media = Media::getMediaByMediaId($pdo, $id);
		} elseif(empty($recipeId) === false) {
			$reply->data = Media::getMediaByMediaRecipeId($pdo, $recipeId)->toArray();
		} elseif(empty($userId) === false) {
			$reply->data = Media::getMediaByUserId($pdo, $userId)->toArray();
		}
	} elseif($method === "DELETE") {
		//enforce that the end user has a XSRF token.
		verifyXsrf();
		// retrieve the Media to be deleted
		$media = Media::getMediaByMediaId($pdo, $id);
		if($media === null) {
			throw(new RuntimeException("Media does not exist", 404));
		}
		//enforce the user is signed in and only trying to edit their own media
		// use the media id to get the recipe id to get the user id to compare it to the session user id
		if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId() !== Recipe::getRecipeByRecipeId($pdo, $media->getMediaRecipeId())->getRecipeUserId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this media", 403));
		}
		//enforce the end user has a JWT token
		validateJwtHeader();
		// delete media from cloudinary
		$cloudinaryResult = \Cloudinary\Uploader::destroy($media->getMediaCloudinaryToken());
		// delete media database
		$media->delete($pdo);
		// update reply
		$reply->message = "Media deleted OK";
	} elseif($method === "POST") {
		//enforce that the end user has a XSRF token.
		verifyXsrf();
		// verify the user is logged in
		if(empty($_SESSION["user"]) === true) {
			throw (new \InvalidArgumentException("you must be logged in to post medias", 401));
			// verify user is logged into the user posting the recipe before uploading an media
		} elseif($_SESSION["user"]->getUserId() !== Recipe::getRecipeByRecipeId($pdo, $recipeId)->getRecipeUserId()) {
			throw(new \InvalidArgumentException("You are not allowed to post an media to someone else's recipe", 403));
		}
		// assigning variable to the user user, add media extension
		$tempUserFileName = $_FILES["media"]["tmp_name"];
		// upload media to cloudinary and get public id
		$cloudinaryResult = \Cloudinary\Uploader::upload($tempUserFileName, array("width" => 500, "crop" => "scale"));
		// after sending the media to Cloudinary, create a new media
		$media = new Media(generateUuidV4(), $recipeId, $cloudinaryResult["signature"], $cloudinaryResult["secure_url"]);
		$media->update($pdo);
		// update reply
		$reply->message = "Media uploaded Ok";
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-Type: application/json");
// encode and return reply to front end caller
echo json_encode($reply);
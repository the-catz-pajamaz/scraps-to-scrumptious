<?php

namespace TheCatzPajamaz\ScrapsToScrumptious;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/php/vendor/autoload.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once(dirname(__DIR__, 1) . "/php/lib/uuid.php");

class DataDownloader {
	public static function pullRecipes() {
		$newRecipes = null;
		$urlBase = "https://www.hikingproject.com/data/get-Recipes?lat=35.085470&lon=-106.649072&maxDistance=25&maxResults=500&key=200416450-0de1cd3b087cf27750e880bc07021975";
		$newRecipes = self::readDataJson($urlBase);
	}

	public static function readDataJson($url) {
		$context = stream_context_create(["http" => ["ignore_errors" => true, "method" => "GET"]]);
		try {
			//file-get-contents returns file in string context
			if(($jsonData = file_get_contents($url, null, $context)) === false) {
				throw(new \RuntimeException("url doesn't produce results"));
			}
			//decode the Json file
			$jsonConverted = json_decode($jsonData);
			//format
			$jsonFeatures = $jsonConverted->Recipes;
			$newRecipes = \SplFixedArray::fromArray($jsonFeatures);
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($newRecipes);
	}
}

echo DataDownloader::pullRecipes() . PHP_EOL;

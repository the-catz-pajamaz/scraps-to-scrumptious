<?php

namespace TheCatzPajamaz\ScrapsToScrumptious;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/php/vendor/autoload.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once(dirname(__DIR__, 2) . "/php/lib/uuid.php");

class DataDownloader {
	public static function pullRecipes() {
		$newRecipes = null;
		$urlBase = "https://services.campbells.com/api/Recipes//recipe";
		for ($i = 0; $i <= 0; $i++) {
			$newRecipes = self::readDataJson($urlBase . "?pageIndex=" . $i);
			$secrets = new \Secrets("/etc/apache2/capstone-mysql/scraps.ini");
			$pdo = $secrets->getPdoObject();


			foreach($newRecipes as $value) {
				$recipeId = generateUuidV4();

				$recipeDescription = $value->Description;

				// hardcoding Erics user id for campbells
				$recipeUserId = "0bd7303a-00e9-4921-9ffd-91467b4814f8";

				// package ingredients from campbells
				$ingredients = "";
				foreach($value->Ingredients as $ingredient) {
					$recipeIngredient = $ingredient->DescriptionFormatter;
					if (empty($ingredient->ExternalProduct->Name) !== true) {
						$recipeIngredient = str_replace("{product}", $ingredient->ExternalProduct->Name, $recipeIngredient);
					}
					$amount = $ingredient->Amount;
					$unit = $ingredient->Unit;
					$plural = "";
					if ($amount > 1 ) {
						$plural = "s";
					}
					$ingredientString = $amount;
					if ($unit !== " ") {
						$ingredientString = $ingredientString . " " . $unit . $plural;
					}
					$ingredientString = $ingredientString . " " . $recipeIngredient;
					$ingredients = $ingredients . $ingredientString . "<br>";
				}
				// package steps for recipe
				$steps = "";
				foreach($value->RecipeSteps as $step) {
					$steps = $steps . $step->Description . "<br>";
				}
				$name = $value->Name;


				// retrieve and store the picture
				$pictureUrl = "";
				foreach($value->RecipeMetaRecords as $meta) {
					if ($meta->Key === "recipe-image-wide") {
						$pictureUrl = $meta->Value;
					}
				}

				try {
					$recipe = new Recipe($recipeId, $recipeUserId, $recipeDescription, $ingredients, $pictureUrl, $steps, $name);
					$recipe->insert($pdo);
				} catch(\TypeError $typeError) {
					echo("Error Connecting to database");
				}
			}
		}

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
			$jsonFeatures = $jsonConverted->Result;
			$newRecipes =\SplFixedArray::fromArray($jsonFeatures);
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($newRecipes);
	}
}

echo DataDownloader::pullRecipes() . PHP_EOL;

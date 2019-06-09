<?php

namespace TheCatzPajamaz\ScrapsToScrumptious;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/php/vendor/autoload.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once(dirname(__DIR__, 2) . "/php/lib/uuid.php");
use TheCatzPajamaz\ScrapsToScrumptious\User;
class DataDownloader {
	public static function pullRecipes() {
		$newRecipes = null;
		$urlBase = "https://services.campbells.com/api/Recipes//recipe";
		$secrets = new \Secrets("/etc/apache2/capstone-mysql/scraps.ini");
		$pdo = $secrets->getPdoObject();
		$password = "abc123";
		$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$activationToken = bin2hex(random_bytes(16));
		$user = new User(generateUuidV4(), null, "campbells@api.sucks", "campbells", "campbells", $hash, "soup");
		$user->insert($pdo);

		for ($i = 0; $i <= 0; $i++) {
			$newRecipes = self::readDataJson($urlBase . "?pageIndex=" . $i);



			foreach($newRecipes as $value) {
				$recipeId = generateUuidV4();

				$recipeDescription = $value->Description;




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
					$recipe = new Recipe($recipeId, $user->getUserId(), $recipeDescription, $ingredients, $pictureUrl, $steps, $name);
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

<?php

/**
 * gets the recipe by recipeId
 *
 *@param \PDO $pdo PDO connection object
 *@param Uuid|string $recipeID recipe id to search for
 *@return Recipe|null Recipe found or null if not found
 *@throws \PDOException when mySQL related errors occur
 *@throws \TypeError when a variable are not the correct data type
 **/
Public static function getRecipeByRecipeId($recipeId) : ?Recipe {
	// sanitize the recipeId before searching
	try {
			$recipeId = self::validatedUuid($recipeId);
	} catch(\InvalidArgumentException | \RaneException | \Exception | \TypeError $exception)

	{
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	//  create query template
	$query = “SELECT recipeId, recipeUserId, recipeMedia, recipeIngredients, recipeDescription, recipeSteps, recipeTitle FROM recipe WHERE recipeId = :authorId”;

$statement = $pdo->prepare($query);

// bind the recipe id to the place holder in the template
$parameters = [“recipeId => $recipeId->getBytes()];
$statement->execute($parameters);

	// grab the recipe from mySQL
	try {
		$recipe = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		If($row !== false) {
		$recipe = new recipe($row[“recipeId], $row[recipeUserId], $row[recipeMedia], $row[recipeIngredients], $row[recipeDescription], $row[recipeSteps], $row[recipeTitle]);
		}
	} catch(\Exception $exception) {
		//if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception>getMessage(), 0, $exception));
	}
	return($recipe);
}

	/**
	 *  accesor method for recipeId
	 * @return Uuid value of recipeId (or null if new Recipe)
	 */

	public function getRecipeId(): Uuid {
				return (this->recipeId);
}
	/**
	 * mutator method for recipe id
	 *
	 * @param Uuid| string $newRecipeId value of new recipe id
	 * @throws \RangeException if $newAuthorId value is not positive
	 * @throws \TypeError if the id is not
	 **/
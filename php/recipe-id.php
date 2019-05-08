<?php




class Recipe {
	use ValidateUuid;
	/**
	 * id for this Recipe: this is the primary key
	 * @var Uuid $recipeId
	 **/
	private $recipeId;
	/**
	 * at handle for this Recipe; this is a unique index
	 * @var string $recipeDescription
	 **/
	private $recipeDescription;
	/**
	 * description for this recipe; this is a unique index
	 * @var $recipeSteps
	 */
	private $recipeSteps;
	/**
	 * title for this recipe, this is a unique index
	 * @var recipeTitle
	 */
	private $recipeTitle;
	/**
	 * ingredients for this recipe, this is a unique index
	 * @var recipeIngredients
	 */
	private $recipeIngredients;
	/**
	 *
	 *
	 */
	private $recipeMedia;
	/**
	 * recipe user id for this recipe, this is a unique index
	 * @var recipeUserId
	 */
	private $recipeUserId;
}
/**
 * constructor for recipe
 *
 *
 *
 */

	public function__construct(string $newRecipeId, string $newRecipeDescription, string $newRecipeSteps, string $newRecipetTitle, string $newRecipeIngredients, string $newRecipeMedia string $newRecipeUserId) {
		try {
			$this->setRecipeId($newRecipeId);
			$this->setRecipeDescription($newRecipeDescription);
			$this->setRecipeSteps($newResipeSteps);
			$this->setRecipeTitle($newRecipeTitle);
			$this->setRecipeIngredients($newRecipeIngredients);
			$this->setRecipeMedia($newRecipeMedia);
			$this->setRecipeUserId($newRecipeUserId);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception |\TypeError $exception) {
			echo"Try Again";
		}
	}

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

	public function setRecipeId( $newRecipeId): void {
		try {
			$uuid = self::validateUuid($newRecipeId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the recipe id
		$this->recipeId = $uuid;
}

/**
 * gets recipe by recipeUserId
 *
 */
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
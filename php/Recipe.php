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
	 * @var $recipeTitle
	 */
	private $recipeTitle;
	/**
	 * ingredients for this recipe, this is a unique index
	 * @var $recipeIngredients
	 */
	private $recipeIngredients;
	/**
	 *
	 *
	 */
	private $recipeMedia;
	/**
	 * recipe user id for this recipe, this is a unique index
	 * @var $recipeUserId
	 */
	private $recipeUserId;

	/**
	 * constructor for recipe
	 *
	 *
	 */

	public function __construct(string $newRecipeId, ?string $newRecipeDescription, string $newRecipeSteps, string $newRecipeTitle, string $newRecipeIngredients, ?string $newRecipeMedia, string $newRecipeUserId) {
		try {
			$this->setRecipeId($newRecipeId);
			$this->setRecipeDescription($newRecipeDescription);
			$this->setRecipeSteps($newRecipeSteps);
			$this->setRecipeTitle($newRecipeTitle);
			$this->setRecipeIngredients($newRecipeIngredients);
			$this->setRecipeMedia($newRecipeMedia);
			$this->setRecipeUserId($newRecipeUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception |\TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
			echo "Try Again";
		}
	}
	/**
	 *  accesor method for recipeId
	 * @return Uuid value of recipeId (or null if new Recipe)
	 */

	public function getRecipeId() :Uuid {
		return ($this->recipeId);
}

	/**
	 * mutator method for recipe id
	 *
	 * @param Uuid|string $newRecipeId value of new recipe id
	 * @throws \RangeException if $newAuthorId value is not positive
	 * @throws \TypeError if the id is not
	 **/

	public function setRecipeId($newRecipeId): void {
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
	 * accesor method for recipeUserID
	 * @return Uuid value of recipeId (or null if new Recipe Id)
	 */
	public function getRecipeUserID(): Uuid {
		return ($this->recipeUserId);
	}

	/**
	 * mutator method for recipe user id
	 *
	 * @param Uuid|string $newRecipeUserId value of new recipe user id
	 * @throws |RangeException if $newRecipeUserId value is not
	 */

	public function setRecipeUserId($newRecipeUserId): void {
		try {
			$uuid = self::validateUuid($newRecipeUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the recipe user id
		$this->recipeUserId = $uuid;
	}
	/**
	 *
	 *
	 */

	/**
	 * accessor method for recipe media
	 *
	 * @param string $newRecipeMedia
	 * @throws \InvalidArgumentException if $newRecipeMedia is not a string or insecure
	 * @throws \RangeException if $newRecipeMedia is > 32 characters
	 * @throws \TypeError if $newRecipeMedia is not a string
	 */
	public function setRecipeMedia(?string $newRecipeMedia): void {
		// verify the media will fit in the database
		$newRecipeMedia = trim($newRecipeMedia);
		$newRecipeMedia = filter_var($newRecipeMedia, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(strlen($newRecipeMedia) > 255) {
			throw(new \rangeException("media is too large"));
		}
		// store the media
		$this->recipeMedia = $newRecipeMedia;
	}

	/**
 	* accessor method for recipe title
 	*
 	* @return string value of recipe title
 	*/
	public function getRecipeTitle(): string {
		return $this->recipeTitle;
	}

	/** mutator method for recipe title
	 *
	 * @param string $newRecipeTitle new value of recipe title
	 * @throws \InvalidArgumentException if $newRecipeTitle is not a valid title or insecure
	 * @throws \RangeException if $newRecipeTitle is >128 characters
	 * @throws \TypeError if $newRecipeTitle is not a string
	 */
	public function setRecipeTitle(string $newRecipeTitle): void {
		// verify the recipe title is secure
		$newRecipeTitle = trim($newRecipeTitle);
		$newRecipeTitle = filter_var($newRecipeTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeTitle) === true) {
			throw(new \InvalidArgumentException("recipe title is too long or insecure"));
		}
		// verify the recipe title will fit in the database
		if (strlen($newRecipeTitle) > 128) {
			throw(new \RangeException("recipe title is too large"));
		}
		// store the recipe title
		$this->recipeTitle = $newRecipeTitle;
	}

	/**
	 * accessor method for recipe description
	 *
	 * @return string value of recipe description
	 **/
	public function getRecipeDescription(): ?string {
		return ($this->recipeDescription);
	}

	/**
	 * mutator method for recipe description
	 * @param string $newRecipeDescription new value of recipe description
	 * @throws \TypeError if $newRecipeDescription is not a string
	 **/
	public function setRecipeDescription($newRecipeDescription): void {
		$newRecipeDescription = trim($newRecipeDescription);
		$newRecipeDescription = filter_var($newRecipeDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the recipe description will fit in the database
		if(strlen($newRecipeDescription) > 65535) {
			throw(new \RangeException("recipe description too large"));
		}
	}

	/**
	 * accessor method for recipe ingredients
	 *
	 * @return string value of recipe ingredients
	 **/
	public function getRecipeIngredients(): string {
		return ($this->recipeIngredients);
	}

	/**
	 * mutator method for recipe ingredients
	 * @param string $newRecipeIngredients new value of recipe ingredients
	 * @throws \TypeError if $newRecipeIngredients is not a string
	 **/
	public function setRecipeIngredients($newRecipeIngredients): void {
		$newRecipeIngredients = trim($newRecipeIngredients);
		$newRecipeIngredients = filter_var($newRecipeIngredients, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeIngredients) === true) {
			throw(new \InvalidArgumentException("recipe ingredients is empty or insecure"));
		}


		// verify the recipe ingredients will fit in the database
		if(strlen($newRecipeIngredients) > 65535) {
			throw(new \RangeException("recipe ingredients too large"));
		}
	}

	/**
	 * accessor method for recipe steps
	 *
	 * @return string value of recipe steps
	 **/
	public function getRecipeSteps(): string {
		return ($this->recipeSteps);
	}

	/**
	 * mutator method for recipe steps
	 * @param string $newRecipeSteps new value of recipe description
	 * @throws \TypeError if $newRecipeSteps is not a string
	 **/
	public function setRecipeSteps($newRecipeSteps): void {
		$newRecipeSteps = trim($newRecipeSteps);
		$newRecipeSteps = filter_var($newRecipeSteps, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeSteps) === true) {
			throw(new \InvalidArgumentException("recipe steps is empty or insecure"));
		}


		// verify the recipe steps will fit in the database
		if(strlen($newRecipeSteps) > 65535) {
			throw(new \RangeException("recipe steps too large"));
		}
	}


	/**
	 * gets the recipe by recipeId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $recipeID recipe id to search for
	 * @return Recipe|null Recipe found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getRecipeByRecipeId(\PDO $pdo, $recipeId): Recipe {
		// sanitize the recipeId before searching
		try {
			$recipeId = self::validatedUuid($recipeId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception)
		{
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//  create query template
		//$query = “SELECT recipeId, recipeUserId, recipeMedia, recipeIngredients, recipeDescription, recipeSteps, recipeTitle FROM recipe WHERE recipeId = :recipeId”;

	$statement = $pdo->prepare($query);

// bind the recipe id to the place holder in the template
$parameters = ["recipeId" => $recipeId->getBytes()];
$statement->execute($parameters);

// grab the recipe from mySQL
	try {
		$recipe = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			$recipe = new Recipe($row[“recipeId"], $row["recipeUserId"], $row["recipeMedia"], $row["recipeIngredients"], $row["recipeDescription"], $row["recipeSteps"], $row["recipeTitle"]);
	   }
	} catch(\Exception $exception) {
		//if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	return($recipe);
}

	/**
	* get the recipe by user id
	*
	* @param \PDO $pdo PDO connection object
   * @param Uuid|string $recipeUserId user id to search for
   * @return Recipe|null Recipoe found or null if not found
   * @throws \PDOException when mySQL related errors occur
   * @throws \TypeError when a variable are not the correct data type
   **/
public static function getRecipeUserIdByRecipeUserId($recipeUserId) : ?Author {
	// sanitize the recipeUserId before searching
	try {
			$recipeUserId = self::validateUuid($recipeUserId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception)

	{
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	// create query template
	$query = "SELECT recipeId, recipeUserId, recipeMedia, recipeIngredients, recipeDescription, recipeSteps, recipeTitle, FROM recipe WHERE recipeUserId = : recipUserId";

	$statement = $pdo->prepare($query);

// bind the recip user id to the place holder in the template
$parameters = ["recipeUserId" => $recipeUserId->getBytes()];
$statement->execute($parameters);
	






}
<?php
namespace TheCatzPajamaz\ScrapsToScrumptious;
require_once ("autoload.php");
use Ramsey\Uuid\Uuid;


class Recipe implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * id for this Recipe: this is the primary key
	 * @var Uuid $recipeId
	 **/
	private $recipeId;

	/**
	 * recipe user id for this recipe
	 * @var $recipeUserId
	 */
	private $recipeUserId;

	/**
	 * description of recipe
	 * @var string $recipeDescription
	 **/
	private $recipeDescription;

	/**
	 * ingredients for this recipe
	 * @var $recipeIngredients
	 */
	private $recipeIngredients;

	/**
	 *recipe media
	 * @var $recipeMedia
	 */
	private $recipeMedia;

	/**
	 * steps for this recipe
	 * @var $recipeSteps
	 */
	private $recipeSteps;

	/**
	 * title for this recipe
	 * @var $recipeTitle
	 */
	private $recipeTitle;





	/**
	 * constructor for recipe
	 * @param string|Uuid $newRecipeId id of this Recipe or null if a new Recipe
	 * @param string|Uuid $newRecipeUserId id of this Recipe that sent this Recipe
	 * @param string $newRecipeDescription string containing actual recipe data
	 * @param string $newRecipeIngredients contains ingredients of recipe
	 * @param string $newRecipeMedia contains media of recipe
	 * @param string $newRecipeSteps contains steps for recipe
	 * @param string $newRecipeTitle contains title of recipe
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */

	public function __construct(string $newRecipeId, string $newRecipeUserId, ?string $newRecipeDescription, string $newRecipeIngredients, ?string $newRecipeMedia, string $newRecipeSteps, string $newRecipeTitle) {
		try {
			$this->setRecipeId($newRecipeId);
			$this->setRecipeUserId($newRecipeUserId);
			$this->setRecipeDescription($newRecipeDescription);
			$this->setRecipeIngredients($newRecipeIngredients);
			$this->setRecipeMedia($newRecipeMedia);
			$this->setRecipeSteps($newRecipeSteps);
			$this->setRecipeTitle($newRecipeTitle);


		} catch(\InvalidArgumentException | \RangeException | \Exception |\TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
			echo "Try Again";
		}
	}

	/**
	 *  accessor method for recipeId
	 * @return Uuid value of recipeId (or null if new Recipe)
	 */
	public function getRecipeId(): Uuid {
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
	 * accessor method for recipeUserID
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
	 * accessor Method for recipe media
	 */
	public function getRecipeMedia(): string {
		return $this->recipeMedia;
	}

	/**
	 * mutator method for recipe media
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
		if(strlen($newRecipeTitle) > 128) {
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

		$this->recipeDescription=$newRecipeDescription;
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
		$this->recipeIngredients=$newRecipeIngredients;
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
		$this->recipeSteps=$newRecipeSteps;
	}

	/**
	 * inserts this Recipe into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {

		// create query template
		$query = "INSERT INTO recipe(recipeId, recipeUserId, recipeDescription, recipeIngredients, recipeMedia, recipeSteps, recipeTitle) VALUES(:recipeId, :recipeUserId, :recipeDescription, :recipeIngredients, :recipeMedia, :recipeSteps, :recipeTitle)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["recipeId" => $this->recipeId->getBytes(), "recipeUserId" => $this->recipeUserId->getBytes(), "recipeDescription" => $this->recipeDescription, "recipeIngredients" => $this->recipeIngredients, "recipeMedia" => $this->recipeMedia, "recipeSteps" => $this->recipeSteps, "recipeTitle" => $this->recipeTitle];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Recipe from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {

		// create query template
		$query = "DELETE FROM recipe WHERE recipeId = :recipeId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["recipeId" => $this->recipeId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this Recipe in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {

		// create query template
		$query = "UPDATE recipe SET recipeId = :recipeId, recipeUserId = :recipeUserId, recipeDescription = :recipeDescription, recipeIngredients = :recipeIngredients, recipeMedia = :recipeMedia, recipeSteps = :recipeSteps, recipeTitle = :recipeTitle WHERE recipeId = :recipeId";
		$statement = $pdo->prepare($query);

		$parameters = ["recipeId" => $this->recipeId->getBytes(), "recipeUserId" => $this->recipeUserId->getBytes(), "recipeDescription"=> $this->recipeDescription, "recipeIngredients"=> $this->recipeIngredients, "recipeMedia" => $this->recipeMedia, "recipeSteps"=> $this->recipeSteps, "recipeTitle"=> $this->recipeTitle];
		$statement->execute($parameters);
	}

	/**
	 * gets the recipe by recipeId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $recipeId recipe id to search for
	 * @return Recipe|null Recipe found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getRecipeByRecipeId(\PDO $pdo, $recipeId): ?Recipe {
		// sanitize the recipeId before searching
		try {
			$recipeId = self::validateUuid($recipeId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException(($exception->getMessage()), 0, $exception));
		}
		//  create query template
		$query = "SELECT recipeId, recipeUserId, recipeDescription, recipeIngredients, recipeMedia, recipeSteps, recipeTitle FROM recipe WHERE recipeId = :recipeId";

		$statement = $pdo->prepare($query);

		// bind the recipe id to the place holder in the template
		$parameters = ["recipeId" => $recipeId->getBytes()];
		$statement->execute($parameters);

		// get the recipe from mySQL
		try {
			$recipe = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$recipe = new Recipe($row["recipeId"], $row["recipeUserId"], $row["recipeDescription"], $row["recipeIngredients"], $row["recipeMedia"], $row["recipeSteps"], $row["recipeTitle"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($recipe);
	}

	/**
	 * get the recipe by recipeUserId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $recipeUserId user id to search for
	 * @return Recipe|null Recipe found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getRecipesByRecipeUserId(\PDO $pdo, string $recipeUserId): \SplFixedArray {
		// sanitize the recipeUserId before searching
		try {
			$recipeUserId = self::validateUuid($recipeUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT recipeId, recipeUserId, recipeDescription, recipeIngredients, recipeMedia, recipeSteps, recipeTitle FROM recipe WHERE recipeUserId = :recipeUserId";

		$statement = $pdo->prepare($query);

		// bind the recipe user id to the place holder in the template
		$parameters = ["recipeUserId" => $recipeUserId->getBytes()];
		$statement->execute($parameters);

		// build an array of recipes
		$recipes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$recipe = new Recipe($row["recipeId"], $row["recipeUserId"], $row["recipeDescription"], $row["recipeIngredients"], $row["recipeMedia"], $row["recipeSteps"], $row["recipeTitle"]);
				$recipes [$recipes->key()] = $recipe;
				$recipes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($recipes);

	}

	/**
	 * gets the recipe by recipeTitle
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $recipeTitle recipe title to search for
	 * @return Recipe|null Recipe Title found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getRecipesByRecipeTitle(\PDO $pdo, string $recipeTitle): \SPLFixedArray {
		// sanitize the recipe title before searching
		$recipeTitle = trim($recipeTitle);
		$recipeTitle = filter_var($recipeTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($recipeTitle) === true) {
			throw(new \PDOException("not a valid recipe title"));
		}
		// create query template
		$query = "SELECT recipeId, recipeUserId, recipeDescription, recipeIngredients, recipeMedia, recipeSteps, recipeTitle FROM recipe WHERE recipeTitle = :recipeTitle";

		$statement = $pdo->prepare($query);

		// bind the recipe title to the place holder in the template
		$parameters = ["recipeTitle" => $recipeTitle];
		$statement->execute($parameters);

		// build an array of recipes
		$recipes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$recipe = new Recipe($row["recipeId"], $row["recipeUserId"], $row["recipeDescription"], $row["recipeIngredients"], $row["recipeMedia"], $row["recipeSteps"], $row["recipeTitle"]);
				$recipes [$recipes->key()] = $recipe;
				$recipes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($recipes);
	}

	/**
	 * get the recipes
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray Recipe found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getAllRecipes(\PDO $pdo): \SplFixedArray {
		// create query template
		$query = "SELECT recipeId, recipeUserId, recipeDescription, recipeIngredients, recipeMedia, recipeSteps, recipeTitle FROM recipe ";

		$statement = $pdo->prepare($query);

		$statement->execute();

		// build an array of recipes
		$recipes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$recipe = new Recipe($row["recipeId"], $row["recipeUserId"], $row["recipeDescription"], $row["recipeIngredients"], $row["recipeMedia"], $row["recipeSteps"], $row["recipeTitle"]);
				$recipes [$recipes->key()] = $recipe;
				$recipes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($recipes);

	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);

		$fields["recipeId"] = $this->recipeId->toString();
		$fields["recipeUserId"] = $this->recipeUserId->toString();

		return ($fields);
	}
}





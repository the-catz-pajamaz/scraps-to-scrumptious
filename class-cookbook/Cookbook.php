<?php
namespace ScrapsToScrumptious;
require_once(dirname(__DIR__) . "class-cookbook/autoload.php");
use Ramsey\Uuid\Uuid;
/**
 * @author Sam Nelson <snelson54@cnm.edu>
 **/
class Cookbook {
	use ValidateUuid;
	/**
	 * id for this cookbook recipe;
	 * @var Uuid $cookbookRecipeId
	 */
	private $cookbookRecipeId;
	/**
	 *
	 * @var string for cookbookRecipeId
	 */
	private $cookbookUserId;
	/**
	 * @var string for cookbookUserId
	 * @var cookbookUserId
	 */
	/**
	 * constructor for cookbook
	 */
	public function __construct(string $newCookbookRecipeId, string $newCookbookUserId) {
		try {
			$this->cookbookRecipeId($newCookbookRecipeId);
			$this->cookbookUserId($newCookbookUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for cookbookRecipeId
	 * @return Uuid value of cookbookRecipeId
	 */
	public function getCookbookRecipeId(): Uuid {
		return ($this->cookbookRecipeId);
	}

	/**
	 * mutator method for cookbookRecipeId
	 *
	 * @param Uuid | string $newCookbookRecipeId value of cookbookRecipeId
	 * @throws \RangeException if $newCookbookRecipeId is not positive
	 * @throws \TypeError if the cookbookRecipeId is not a string
	 */
	public function setCookbookRecipeId($newCookbookRecipeId): void {
		try {
			$uuid = self::validateUuid($newCookbookRecipeId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the cookbookRecipeId
		$this->cookbookRecipeId = $uuid;
	}

	/**
	 * accessor method for cookbookUserId
	 * @return Uuid value of cookbookUserId
	 */
	public function getCookbookUserId(): Uuid {
		return ($this->cookbookUserId);
	}

	/**
	 * mutator method for cookbookUserId
	 *
	 * @param Uuid | string $newCookbookUserId value of cookbookUserId
	 * @throws \RangeException if $newCookbookUserId is not positive
	 * @throws \TypeError if the cookbookUserId is not a string
	 */
	public function setCookbookUserId($newCookbookUserId): void {
		try {
			$uuid = self::validateUuid($newCookbookUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the cookbookUserId
		$this->cookbookUserId = $uuid;
	}
	/**
	 * inserts cookbook into mySQL
	 * @param \PDO $pdo
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) : void {
		$query = "insert into cookbook(cookbookRecipeId, cookbookUserId) values (:cookbookRecipeId, :cookbookUserId)";
  		$statement = $pdo->prepare($query);
  		$paramaters = ["cookbookRecipeId" => $this->cookbookRecipeId->getBytes(), $this->cookbookUserId];
  		$statement->execute($paramaters);
	}
	/**
	 * deletes this cookbook from MySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo
	 */
	public function delete(\PDO $pdo) : void {
		$query = "DELETE FROM cookbook WHERE cookbookUserId = :cookbookUserId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holder in the template
		$parameters = ["cookbookUserId" =>$this->cookbookUserId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this cookbook in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) : void {
		//create query template
		$query = "UPDATE cookbook SET cookbookRecipeId = :cookbookRecipeId, cookbookUserId = :cookbookUserId";
		$statement = $pdo->prepare($query);

		$parameters = ["cookbookUserId" =>$this->cookbookUserId->getBytes(), "cookbookRecipeId" => $this->cookbookRecipeId->getBytes()];
		$statement->execute($parameters);
	}
}

/**
 * @param \PDO $pdo
 * @param $cookbookRecipeId
 * @return \SplFixedArray
 * @throws \PDOException if can't be converted.
 */
public static function getCookbooksByCookbookRecipeId(\PDO $pdo, $cookbookRecipeId) : \SplFixedArray {
	//Sanitize the cookbookRecipeId before accessing
	try {
		$cookbookRecipeId = self::validateUuid($cookbookRecipeId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		throw(new \PDOException($exception->getMessage(),0, $exception));
	}

	//Create query template
	$query = "SELECT cookbookRecipeId FROM cookbook WHERE cookbookRecipeId = :cookbookRecipeId";
	$statement = $pdo->prepare($query);

	//Bind the recipeId to the template placeholder.
	$parameters = ["cookbookRecipeId" => $cookbookRecipeId->getBytes()];
	$statement->execute($parameters);

	//Build array of cookbookRecipeIds
	$cookbookRecipeId = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			$cookbookRecipeId = new cookbookRecipeId($row["cookbookRecipeId"]);
			$cookbookRecipeId->next();
		} catch(\Exception $exception) {
			//if the row can't be converted, rethrow
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return($cookbookRecipeId);
}

/**
 * @param \PDO $pdo
 * @param $cookbookRecipeId
 * @return \SplFixedArray
 * @throws \PDOException if can't be converted.
 */
public static function getCookbooksByCookbookUserId(\PDO $pdo, $cookbookUserId) : \SplFixedArray {
	//Sanitize the cookbookUserId before accessing
	try {
		$cookbookUserId = self::validateUuid($cookbookUserId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		throw(new \PDOException($exception->getMessage(),0, $exception));
	}

	//Create query template
	$query = "SELECT cookbookUserId FROM cookbook WHERE cookbookUserId = :cookbookUserId";
	$statement = $pdo->prepare($query);

	//Bind the userId to the template placeholder.
	$parameters = ["cookbookUserId" => $cookbookUserId->getBytes()];
	$statement->execute($parameters);

	//Build array of cookbookUserIds
	$cookbookUserId = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			$cookbookUserId = new cookbookRecipeId($row["cookbookRecipeId"]);
			$cookbookUserId->next();
		} catch(\Exception $exception) {
			//if the row can't be converted, rethrow
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return($cookbookUserId);
}

/*
 * get cookbook by user id,
 * display all recipes within a given cookbook
 *
 */
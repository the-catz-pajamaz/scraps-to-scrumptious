<?php
namespace theCatzPajamaz\scrapsToScrumptious;
require_once ("autoload.php");
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
	 * @var Uuid for cookbookUserId
	 * @var $cookbookUserId
	 */

	private $cookbookUserId;

	/**
	 * constructor for cookbook
	 */

	public function __construct(string $newCookbookRecipeId, string $newCookbookUserId) {
		try {
			$this->setCookbookRecipeId($newCookbookRecipeId);
			$this->setCookbookUserId($newCookbookUserId);
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

	public function insert(\PDO $pdo): void {
		$query = "insert into cookbook(cookbookRecipeId, cookbookUserId) values (:cookbookRecipeId, :cookbookUserId)";
		$statement = $pdo->prepare($query);
		$parameters = ["cookbookRecipeId" => $this->cookbookRecipeId->getBytes(), $this->cookbookUserId];
		$statement->execute($parameters);
	}

	/**
	 * deletes this cookbook from MySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo
	 */

	public function delete(\PDO $pdo): void {
		$query = "DELETE FROM cookbook WHERE cookbookUserId = :cookbookUserId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holder in the template
		$parameters = ["cookbookUserId" => $this->cookbookUserId->getBytes()];
		$statement->execute($parameters);
	}


//	/**
//	 * @param \PDO $pdo
//	 * @param $cookbookRecipeId
//	 * @return \SplFixedArray
//	 * @throws \PDOException if can't be converted.
//	 */
//	public static function getCookbooksByCookbookRecipeId(\PDO $pdo, $cookbookRecipeId): \SplFixedArray {
//
//		//Sanitize the cookbookRecipeId before accessing
//
//		try {
//			$cookbookRecipeId = self::validateUuid($cookbookRecipeId);
//		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
//			throw(new \PDOException($exception->getMessage(), 0, $exception));
//		}
//
//		//Create query template
//
//		$query = "SELECT cookbookRecipeId FROM cookbook WHERE cookbookRecipeId = :cookbookRecipeId";
//		$statement = $pdo->prepare($query);
//
//		//Bind the recipeId to the template placeholder.
//
//		$parameters = ["cookbookRecipeId" => $cookbookRecipeId->getBytes()];
//		$statement->execute($parameters);
//
//		//Build array of cookbookRecipeIds
//
//		$cookbookRecipeId = new \SplFixedArray($statement->rowCount());
//		$statement->setFetchMode(\PDO::FETCH_ASSOC);
//		while(($row = $statement->fetch()) !== false) {
//			try {
//				// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//				$cookbookRecipeId = new cookbookRecipeId($row["cookbookRecipeId"]);
//				$cookbookRecipeId->next();
//			} catch(\Exception $exception) {
//				//if the row can't be converted, rethrow
//				throw (new \PDOException($exception->getMessage(), 0, $exception));
//			}
//		}
//		return ($cookbookRecipeId);
//	}

	/**
	 * @param \PDO $pdo
	 * @param $cookbookRecipeId
	 * @return \SplFixedArray
	 * @throws \PDOException if can't be converted.
	 */
	public static function getCookbooksByCookbookUserId(\PDO $pdo, $cookbookUserId): \SplFixedArray {
		//Sanitize the cookbookUserId before accessing
		try {
			$cookbookUserId = self::validateUuid($cookbookUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//Create query template
		$query = "SELECT cookbookRecipeId, cookbookUserId FROM cookbook WHERE cookbookUserId = :cookbookUserId";
		$statement = $pdo->prepare($query);

		//Bind the userId to the template placeholder.
		$parameters = ["cookbookUserId" => $cookbookUserId->getBytes()];
		$statement->execute($parameters);

		//Build array of cookbookUserIds
		$cookbook = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$cookbook = new Cookbook($row["cookbookRecipeId"], $row["cookbookUserId"]);
				$cookbook[$cookbook->key()] = $cookbook;
				$cookbook->next();
			} catch(\Exception $exception) {
				//if the row can't be converted, rethrow
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($cookbook);
	}

	public static function getCookbookByCookbookRecipeIdAndCookbookUserId(\PDO $pdo, $cookbookRecipeId, $cookbookUserId): Cookbook {
		//Sanitize the cookbookRecipeId and cookbookUserId before accessing
		try {
			$cookbookRecipeId = self::validateUuid($cookbookRecipeId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		try {
			$cookbookUserId = self::validateUuid($cookbookUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//Create the query template.
		$query = "SELECT cookbookRecipeId, cookbookUserId FROM cookbook WHERE cookbookRecipeId = :cookbookRecipeId AND cookbookUserId = :cookbookUserId";
		$statement = $pdo->prepare($query);
		//Bind the cookbookRecipeId abd cookbookUserId to the template placeholder.
		$parameters = ["cookbookRecipeId" => $cookbookRecipeId->getBytes(), "cookbookUserId" => $cookbookUserId->getBytes()];
		$statement->execute($parameters);

		//Grab the cookbook from mySQL
		try {
			$cookbook = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$cookbook = new Cookbook($row["cookbookRecipeId"], $row["cookbookUserId"]);
			}
		} catch(\Exception $exception) {
			//if the row can't be converted, rethrow
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($cookbook);
	}
}
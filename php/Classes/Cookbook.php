<?php
namespace TheCatzPajamaz\ScrapsToScrumptious;
require_once ("autoload.php");

require_once(dirname(__DIR__) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

/**
 * @author Sam Nelson <snelson54@cnm.edu>
 **/

class Cookbook implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * Uuid for this cookbook recipe;
	 * @var Uuid $cookbookRecipeId
	 */

	private $cookbookRecipeId;

	/**
	 * Uuid for cookbookUserId
	 * @var Uuid $cookbookUserId
	 */

	private $cookbookUserId;

	/**
	 * constructor for cookbook
	 */

	public function __construct($newCookbookRecipeId, $newCookbookUserId) {
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
	 * @param Uuid $newCookbookRecipeId value of cookbookRecipeId
	 * @throws \RangeException if $newCookbookRecipeId is not positive
	 * @throws \TypeError if the cookbookRecipeId is not a Uuid
	 */

	public function setCookbookRecipeId($newCookbookRecipeId): void {
		try {
			$uuid = self::validateUuid($newCookbookRecipeId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the cookbookRecipeId
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
	 * @param Uuid $newCookbookUserId value of cookbookUserId
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

		// convert and store the cookbookUserId
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
		$parameters = ["cookbookRecipeId" => $this->cookbookRecipeId->getBytes(), "cookbookUserId" => $this->cookbookUserId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * deletes this cookbook from MySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo
	 */

	public function delete(\PDO $pdo): void {
		$query = "DELETE FROM cookbook WHERE cookbookRecipeId = :cookbookRecipeId AND cookbookUserId = :cookbookUserId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holder in the template
		$parameters = ["cookbookRecipeId" => $this->cookbookRecipeId->getBytes(), "cookbookUserId" => $this->cookbookUserId->getBytes()];
		$statement->execute($parameters);
	}

// Commented out because no need for counting recipe saves.
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
	 * @param Uuid $cookbookUserId
	 * @return \SplFixedArray
	 * @throws \PDOException if we get a PDO error.
	 */
	public static function getCookbooksByCookbookUserId(\PDO $pdo, Uuid $cookbookUserId): \SplFixedArray {
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
		$cookbooks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$cookbook = new Cookbook($row["cookbookRecipeId"], $row["cookbookUserId"]);
				$cookbooks[$cookbooks->key()] = $cookbook;
				$cookbooks->next();
			} catch(\Exception $exception) {
				//if the row can't be converted, rethrow
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($cookbooks);
	}

	/**
	 * @param \PDO $pdo
	 * @param Uuid $cookbookRecipeId
	 * @param Uuid $cookbookUserId
	 * @return Cookbook the cookbook with both cookbookRecipeId and cookbookUserId
	 * @throws \PDOException if we get a PDO error.
	 */
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

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["tweetId"] = $this->cookbookRecipeId->toString();
		$fields["tweetProfileId"] = $this->cookbookUserId->toString();

		return($fields);
	}
}
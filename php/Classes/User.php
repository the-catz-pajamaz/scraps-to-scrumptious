<?php
/**
 * specify name-space, uuid validation method, composer/autoload stuff
 */
namespace TheCatzPajamaz\ScrapsToScrumptious;
require_once ("autoload.php");
use Ramsey\Uuid\Uuid;

// create class for table 'user'
class User implements \JsonSerializable {
	// validate uuid for pk, create private variables for all table elements
	use ValidateUuid;

	/**
	 * Id for user, this is primary key
	 * @var Uuid $userId
	 */
	private $userId;

	/**
	 * token to validate the profile
	 * @var $userActivationToken
	 */
	private $userActivationToken;

	/**
	 * email for this profile
	 * @var $userEmail
	 */
	private $userEmail;

	/**
	 * This is the user's first name
	 * @var $userFirstName
	 */
	private $userFirstName;

	/**
	 *this is the users chosen handle
	 * @var $userHandle
	 */
	private $userHandle;

	/**
	 * hash for user password
	 * @var $userHash
	 */
	private $userHash;

	/**
	 *this is the user's last name
	 * @var $userLastName
	 */
	private $userLastName;

	/**
	 * constructor method for table user
	 * @param Uuid $newUserId id of this user
	 * @param string $newUserActivationToken to protect against malicious accounts
	 * @param string $newUserEmail string with user's email
	 * @param string $newUserFirstName string with user's first name
	 * @param string $newUserHandle string with user's handle
	 * @param string $newUserHash string with user's hash
	 * @param string $newUserLastName string with user's last name
	 * @throws \RangeException if strings are the improper character count or negative values
	 * @throws \TypeError if data violates something specific to that objects requirements
	 * @throws \Exception in the event of some other nonsense
	 */

	public function __construct ($newUserId, ?string $newUserActivationToken, string $newUserEmail,
										  string $newUserFirstName, string $newUserHandle, string $newUserHash,
										  string $newUserLastName) {
		try{
			$this->setUserId($newUserId);
			$this->setUserActivationToken($newUserActivationToken);
			$this->setUserEmail($newUserEmail);
			$this->setUserFirstName($newUserFirstName);
			$this->setUserHandle($newUserHandle);
			$this->setUserHash($newUserHash);
			$this->setUserLastName($newUserLastName);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}



	/**
	 * accessor method for UserId
	 * @return Uuid
	 */
	public function getUserId(): Uuid {
		return $this->userId;
	}

	/**
	 * mutator method for userId
	 *
	 * @param Uuid $newUserId
	 * @throws \RangeException if $newUserId value is too large
	 * @throws \TypeError if the userId is not is not a Uuid
	 */

	public function setUserId($newUserId): void {
		try {
			$uuid = self::validateUuid($newUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store userId
		$this->userId = $uuid;
	}

	/**
	 * Accessor method for userActivationToken
	 * @return string for activation token
	 */
	public function getUserActivationToken(): string {
		return $this->userActivationToken;
	}

	/**
	 * mutator method for userActivationToken
	 * @param string $newUserActivationToken
	 * @throws \RangeException if caught by ctype_xdigit method
	 */

		public function setUserActivationToken(?string $newUserActivationToken): void {
			if($newUserActivationToken === null) {
				$this->userActivationToken = null;
				return;
			}
//			$newUserActivationToken = strtolower(trim($newUserActivationToken));
		elseif((ctype_xdigit(strtolower(trim($newUserActivationToken)))=== false)) {
			throw(new\RangeException("user activation is not valid"));
		}
		$this->userActivationToken = $newUserActivationToken;
	}

	/**
	 * accessor method for userEmail :)
	 * @return string for userEmail
	 */
	public function getUserEmail():string {
		return $this->userEmail;
	}


	/**
	 *mutator method for userEmail
	 *
	 *@param string $newUserEmail
	 *@throws \ InvalidArgumentException if $newEmail is not valid email or insecure
	 *@throws \RangeException if $newEmail is >128 characters
	 */

	public function setUserEmail( string $newUserEmail): void{
		$newUserEmail = trim($newUserEmail);
		$newUserEmail = filter_var($newUserEmail, FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL);
		if(empty($newUserEmail) === true) {
			throw(new \InvalidArgumentException("userEmail is empty or insecure"));
		}
		if(strlen($newUserEmail) >128) {
			throw(new \RangeException("User Email is too large"));
		}
		$this->userEmail = $newUserEmail;
	}

	/**
	 * accessor method for userFirstName
	 * @return string containing userFirstName
	 *
	 */
	public function getUserFirstName():string {
		return $this->userFirstName;
	}

	/**
	 * Mutator Method for userFirstName
	 * @param string
	 * @throws \InvalidArgumentException
	 * @throws \RangeException
	 */
	public function setUserFirstName($newUserFirstName): void {
		$newUserFirstName = trim($newUserFirstName);
		$newUserFirstName = filter_var($newUserFirstName ,FILTER_SANITIZE_STRING);
		if(empty($newUserFirstName)=== true){
			throw(new \InvalidArgumentException("You didn't put a name in here."));
		}
		if(strlen($newUserFirstName)>32){
			throw(new \RangeException("First Name Not Valid"));
		}
		$this->userFirstName = $newUserFirstName;
	}

	/**
	 * accessor method for userHandle
	 * @return string with userHandle
	 */
	public function getUserHandle():string {
		return $this->userHandle;
	}

	/**
	 * mutator method for UserHandle
	 * @param string
	 * @throws \InvalidArgumentException if empty
	 * @throw range exception
	 */
	public function setUserHandle($newUserHandle): void {
		$newUserHandle = trim($newUserHandle);
		$newUserHandle = filter_var($newUserHandle, FILTER_SANITIZE_STRING);
		if(empty($newUserHandle)=== true) {
			throw (new \InvalidArgumentException("Not a valid Handle"));
		}
		if(strlen($newUserHandle)>64){
			throw(new \RangeException("User Handle Not Valid"));
		}
		$this->userHandle = $newUserHandle;
	}

	/**
	 *accessor method for user hash
	 *
	 * @return string value userHash
	 */
	public function getUserHash():string {
		return $this->userHash;
	}

	/**
	 * Mutator method for user hash
	 * @param string $newUserHash
	 * @throws \InvalidArgumentException if the hash is empty, or not a hash
	 * @throws \RangeException if the hash is not exactly 97 characters
	 */
	public function setUserHash(string $newUserHash): void {
		//enforce hash formatting
		$newUserHash = trim($newUserHash);
		$newUserHash = filter_var($newUserHash, FILTER_SANITIZE_STRING);
		if(empty($newUserHash) === true) {
			throw(new \InvalidArgumentException("User hash is not a valid hash"));
		}
		//enforce that it is an argon hash
		$newUserHashInfo = password_get_info($newUserHash);
		if($newUserHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("user hash is not a valid hash"));
		}
		if(strlen($newUserHash) !== 97) {
			throw(new \RangeException("user hash must be 97 characters"));
		}
		$this->userHash = $newUserHash;
	}

	/**
	 * accessor method for userLastName
	 * @return string for userLastName
	 *
	 */
	public function getUserLastName():string {
		return $this->userLastName;
	}

	/**
	 * Mutator Method for userLastName
	 * @param string
	 * @throws \InvalidArgumentException if empty
	 * @throws \RangeException if last name is too long
	 */
	public function setUserLastName($newUserLastName): void {
		$newUserLastName = filter_var($newUserLastName,FILTER_SANITIZE_STRING);
		$newUserLastName = trim($newUserLastName);
		if(empty($newUserLastName)=== true){
			throw(new\InvalidArgumentException ("not real last name"));
		}
		if(strlen($newUserLastName)>32){
			throw(new \RangeException("Last Name Not Valid"));
		}
		$this->userLastName = $newUserLastName;
	}

	/**
	 * inserts user into mySQL
	 *
	 * @param \PDO
	 * @throws \PDOException when mySQL errors happen
	 * @throws \TypeError when \PDO errors happen
	 */
	public function insert (\PDO $pdo) : void {

		//query template
		$query = "insert into `user`(userId, userActivationToken, userEmail, userFirstName, userHandle, userHash, userLastName) 
					values (:userId, :userActivationToken, :userEmail, :userFirstName, :userHandle, :userHash, :userLastName)";
		$statement = $pdo->prepare($query);

		//bind variables to template
		$parameters = [
			"userId" => $this->userId->getBytes(),
			"userActivationToken" => $this->userActivationToken,
			"userEmail" => $this->userEmail,
			"userFirstName" => $this->userFirstName,
			"userHandle" => $this->userHandle,
			"userHash" => $this->userHash,
			"userLastName" => $this->userLastName,
		];
		$statement->execute($parameters);
	}

	/**
	 * delete statement for table user
	 * @param \PDO
	 * @throws \PDOException when mySQL errors happen
	 * @throws \TypeError when \PDO errors happen
	 */
	public function delete(\PDO $pdo) : void {

		//query template
		$query = "delete from `user` where userId = :userId";
		$statement = $pdo->prepare($query);

		//bind variables to template
		$parameters = ["userId" => $this->userId->getBytes()];
		$statement->execute($parameters);
	}

	public function update(\PDO $pdo) : void {

		//query template
		$query = "update `user` set 
    		userActivationToken = :userActivationToken, 
    		userEmail = :userEmail, 
    		userFirstName = :userFirstName, 
    		userHandle = :userHandle, 
    		userHash = :userHash, 
    		userLastName = :userLastName 
		where userId = :userId";
		$statement = $pdo->prepare($query);

		//bind variables to template
		$parameters = [
			"userId" => $this->userId->getBytes(),
			"userActivationToken" => $this->userActivationToken,
			"userEmail" => $this->userEmail,
			"userFirstName" => $this->userFirstName,
			"userHandle" => $this->userHandle,
			"userHash" => $this->userHash,
			"userLastName" => $this->userLastName,
		];
		$statement->execute($parameters);
	}

	/**
	 * gets user by userId
	 * @param PDO $pdo
	 * @param Uuid $userId
	 * @return User|null
	 * @throws \PDOException
	 */
	public static function getUserByUserId (\PDO $pdo, $userId) : ?User {
		try{
		$userId = self::validateUuid($userId);
	}
	catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
	throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	$query = "select userId, userActivationToken, userEmail, userFirstName, userHandle, userHash, userLastName from `user` where userId = :userId";
		$statement = $pdo->prepare($query);
		
		$parameters = ["userId" => $userId->getBytes()];
		$statement->execute($parameters);

		try{
			$user = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$user = new user($row["userId"], $row["userActivationToken"], $row["userEmail"], $row["userFirstName"], $row["userHandle"], $row["userHash"], $row["userLastName"]);
			}
		}
		catch(\Exception $exception) {
			throw(new \PDOException($exception->getmessage(), 0, $exception));
		}
		return($user);
	}


	/**
	 * get user by email
	 * @param PDO $pdo
	 * @param $userEmail
	 * @return User
	 * @throws \InvalidArgumentException if empty
	 * @throws \RangeException if too long
	 * @throws \Exception
	 */
	public static function getUserByUserEmail (\PDO $pdo, $userEmail) : ?User {
		$userEmail = trim($userEmail);
		$userEmail = filter_var($userEmail, FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL);
		if(empty($userEmail) === true) {
			throw(new \InvalidArgumentException("userEmail is empty or insecure"));
		}
		if(strlen($userEmail) > 128) {
			throw(new \RangeException("User Email is too large"));
		}

		$query = "select userId, userActivationToken, userEmail, userFirstName, userHandle, userHash, userLastName from `user` where userEmail = :userEmail";
		$statement = $pdo->prepare($query);

		$parameters = ["userEmail" => $userEmail];
		$statement->execute($parameters);

		try{
			$user = null;
			$statement->setFetchMode(\PDO:: FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$user = new user($row["userId"], $row["userActivationToken"], $row["userEmail"], $row["userFirstName"], $row["userHandle"], $row["userHash"], $row["userLastName"]);
			}
		}


		catch(\Exception $exception) {
			throw(new \PDOException($exception->getmessage(), 0, $exception));
		}
		return($user);
	}

	/**
	 * gets user by activation token
	 * @param \PDO $pdo
	 * @param $userActivationToken
	 * @return User|null
	 * @throws RangeException if not a token
	 * @throws \PDOException in event of mySQL Errors
	 */
	public static function getUserByUserActivationToken (\PDO $pdo, $userActivationToken) : ?User {
		if(ctype_xdigit($userActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		$query = "select userId, userActivationToken, userEmail, userFirstName, userHandle, userHash, userLastName from `user` where userActivationToken = :userActivationToken";
		$statement = $pdo->prepare($query);

		$parameters = ["userActivationToken" => $userActivationToken];
		$statement->execute($parameters);

		try{
			$user = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$user = new user($row["userId"], $row["userActivationToken"], $row["userEmail"], $row["userFirstName"], $row["userHandle"], $row["userHash"], $row["userLastName"]);
			}
		}

		catch(\Exception $exception) {
			throw(new \PDOException($exception->getmessage(), 0, $exception));
		}
		return($user);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["userId"] = $this->userId->toString();
		unset($fields["userActivation"]);
		unset($fields["userHash"]);
		return ($fields);

	}


}


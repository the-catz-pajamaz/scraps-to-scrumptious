<?php
/**
 * specify name-space, uuid validation method, composer/autoload stuff
 */

//create class for table 'user'

class
user{
	// validate uuid for pk, create private variables for all table elements
	use ValidateUuid;
	private $userId;

	private $userActivationToken;
	private $userEmail;
	private $userFirstName;
	private $userHandle;
	private $userHash;
	private $userLastName;

	//constructor method for table user

	public function __construct ($newUserId, string $newUserActivationToken, string $newUserEmail,
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
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * mutator method for userId
	 *
	 * @param Uuid| string $newUserId
	 * @throws \RangeException if $newUserId value is too large
	 * @throws \TypeError if the userId is not positive
	 * @throws \TypeError if the userId is not
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
	 */
	public function getUserActivationToken(): ?string {
		return $this->userActivationToken;
	}

	/**
	 * mutator method for userActivationToken
	 * @param string $userActivationToken
	 * @throws if not hexidecimal
	 * @throws if not exactly __ characters
	 */

		public function setUserActivationToken(?string $newUserActivationToken): void {
			if($newUserActivationToken === null) {
				$this->userActivationToken = null;
				return;
			}
		if(ctype_xdigit($newUserActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		$this->userActivationToken = $newUserActivationToken;
	}

	/**
	 * accessor method for userEmail :)
	 */
	public function getUserEmail():?string {
		return $this->userEmail;
	}


	/**
	 *mutator method for userEmail
	 *
	 *@param string $newUserEmail new email
	 *@throws \ InvalidArgumentException if $newEmail is not valid email or insecure
	 *@throws \RangeException if $newEmail is >128 characters
	 *@throws \TypeError if $newEmail is not a string
	 */

	public function setUserEmail( string $newUserEmail): void{
		$newUserEmail = trim($newUserEmail);
		$newUserEmail = filter_var($newUserEmail, FILTER_VALIDATE_EMAIL);
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
	 *
	 */
	public function getUserFirstName():?string {
		return $this->userFirstName;
	}

	/**
	 * Mutator Method for userFirstName
	 * @param string
	 * @throw range exception
	 */
	public function setUserFirstName($newUserFirstName): void {
		$newUserFirstName = trim($newUserFirstName);
		if(strlen($newUserFirstName)>32){
			throw(new \RangeException("First Name Not Valid"));
		}
		$this->userFirstName = $newUserFirstName;
	}

	/**
	 * accessor method for userHandle
	 */
	public function getUserHandle():?string {
		return $this->userHandle;
	}

	/**
	 * mutator method for UserHandle
	 * @param string
	 * @throw range exception
	 */
	public function setUserHandle($newUserHandle): void {
		$newUserHandle = trim($newUserHandle);
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

	public function getUserHash():?string {
		return $this->userHash;
	}

	/**
	 * Mutator method for user hash
	 * @param string $newUserHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is >97 characters
	 */
	public function setUserHash(string $newUserHash): void {
		//enforce hash formatting
		$newUserHash = trim($newUserHash);
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
	 *
	 */
	public function getUserLastName():?string {
		return $this->userLastName;
	}

	/**
	 * Mutator Method for userFirstName
	 * @param string
	 * @throw range exception
	 */
	public function setUserLastName($newUserLastName): void {
		$newUserLastName = trim($newUserLastName);
		if(strlen($newUserLastName)>32){
			throw(new \RangeException("First Name Not Valid"));
		}
		$this->userLastName = $newUserLastName;
	}
	
	
	
	
}
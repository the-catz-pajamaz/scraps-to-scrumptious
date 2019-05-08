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

	public function __construct ($newUserId, string $newUserActivationToken, string $newUserEmail, string $newUserFirstName,
										  string $newUserHandle, string $newUserHash, string $newUserLastName) {
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
	public function getUserActivationToken() {
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
	public function getUserEmail() {
		return $this->userEmail;
	}

}
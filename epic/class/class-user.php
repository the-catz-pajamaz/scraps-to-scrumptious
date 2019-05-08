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

		}
	}





}
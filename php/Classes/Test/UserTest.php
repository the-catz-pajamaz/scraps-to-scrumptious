<?php

namespace TheCatzPajamaz\ScrapsToScrumptious\Test;

use mysql_xdevapi\Exception;
use TheCatzPajamaz\ScrapsToScrumptious\User;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the User class
 *
 * This is a complete PHPUnit test of the User class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see User
 **/

class UserTest extends ScrapsToScrumptiousTest {

	/**
	 * placeholder until account activation is created
	 * @var string $VALID_ACTIVATION
	 */
	protected $VALID_ACTIVATION_TOKEN;

	/**
	 * valid email to use
	 * @var string $VALID_EMAIL
	 **/
	protected $VALID_EMAIL = "test@catz.pj";

	/**
	 * valid at handle to use
	 * @var string $VALID_USERFIRSTNAME
	 **/
	protected $VALID_FIRST_NAME = "Ice";

	/**
	 * valid at handle to use
	 * @var string $VALID_HANDLE
	 **/
	protected $VALID_HANDLE = "iceburg";

	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;

	/**
	 * valid at handle to use
	 * @var string $VALID_USERLASTNAME
	 **/
	protected $VALID_LAST_NAME = "Burg";

	/**
	 * run the default setup operation to create activation token and hash.
	 * @throws \Exception, 	 */
	public final function setUp() : void {
		parent::setUp();

		$password = "abc123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
	}

	/**
	 * test inserting User
	 * verify that the mySQL data matches
	 **/
	public function testInsertValidUser() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");
		
		$userId = generateUuidV4();

		$user = new User($userId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_EMAIL, $this->VALID_FIRST_NAME, $this->VALID_HANDLE, $this->VALID_HASH, $this->VALID_LAST_NAME);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());


		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_FIRST_NAME);
		$this->assertEquals($pdoUser->getUserHandle(), $this->VALID_HANDLE );
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_LAST_NAME);
	}

	/**
	 * test inserting a User, editing it, and then updating it
	 **/
	public function testUpdateValidUser() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");


		// create a new User and insert to into mySQL
		$userId = generateUuidV4();
		$user = new User($userId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_EMAIL, $this->VALID_FIRST_NAME, $this->VALID_HANDLE, $this->VALID_HASH, $this->VALID_LAST_NAME);
		$user->insert($this->getPDO());


		// edit the User and update it in mySQL
		$user->setUserHandle($this->VALID_HANDLE);
		$user->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_FIRST_NAME);
		$this->assertEquals($pdoUser->getUserHandle(), $this->VALID_HANDLE);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_LAST_NAME);
	}

	/**
	 * test creating a User and then deleting it
	 **/
	public function testDeleteValidUser() : void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		$userId = generateUuidV4();
		$user = new User($userId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_EMAIL, $this->VALID_FIRST_NAME, $this->VALID_HANDLE, $this->VALID_HASH, $this->VALID_LAST_NAME);
		$user->insert($this->getPDO());

		// delete the User from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$user->delete($this->getPDO());

		// grab the data from mySQL and enforce the User does not exist
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertNull($pdoUser);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("user"));
	}

	/**
	 * test for function that gets a user by that user's id
	 **/
	public function testGetValidUserByUserId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		$userId = generateUuidV4();
		$user = new User($userId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_EMAIL, $this->VALID_FIRST_NAME, $this->VALID_HANDLE, $this->VALID_HASH, $this->VALID_LAST_NAME);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_FIRST_NAME);
		$this->assertEquals($pdoUser->getUserHandle(), $this->VALID_HANDLE);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_LAST_NAME);
	}

	/**
	 * test grabbing a User that does not exist
	 **/
	public function testGetInvalidUserByUserId() : void {

		// grab a user id that exceeds the maximum allowable user id
		$fakeUserId = generateUuidV4();
		$user = User::getUserByUserId($this->getPDO(), $fakeUserId);
		$this->assertNull($user);
	}


	/**
	 * test for function that gets a user by that user's id
	 **/
	public function testGetValidUserByUserEmail() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		$userId = generateUuidV4();
		$user = new User($userId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_EMAIL, $this->VALID_FIRST_NAME, $this->VALID_HANDLE, $this->VALID_HASH, $this->VALID_LAST_NAME);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserEmail($this->getPDO(), $user->getUserEmail());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_FIRST_NAME);
		$this->assertEquals($pdoUser->getUserHandle(), $this->VALID_HANDLE);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_LAST_NAME);
	}

	/**
	 * test grabbing a User by an email that does not exists
	 **/
	public function testGetInvalidUserByEmail() : void {
		// grab an email that does not exist
		$user = User::getUserByUserEmail($this->getPDO(), "does@not.exist");
		$this->assertNull($user);
	}

	/**
	 * tests a valid user by their activation token
	 */
	public function testGetValidUserByUserActivationToken() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		$userId = generateUuidV4();
		$user = new User($userId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_EMAIL, $this->VALID_FIRST_NAME, $this->VALID_HANDLE, $this->VALID_HASH, $this->VALID_LAST_NAME);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserActivationToken($this->getPDO(), $user->getUserActivationToken());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFirstName(), $this->VALID_FIRST_NAME);
		$this->assertEquals($pdoUser->getUserHandle(), $this->VALID_HANDLE);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_HASH);
		$this->assertEquals($pdoUser->getUserLastName(), $this->VALID_LAST_NAME);
	}

	/**
	 **/
	public function testGetInvalidUserByActivationToken() : void {
		$user = User::getUserByUserActivationToken($this->getPDO(), "1234567891011");
		$this->assertNull($user);
	}




}

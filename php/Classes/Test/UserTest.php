<?php

namespace theCatzPajamaz\scrapsToScrumptious;

use theCatzPajamaz\scrapsToScrumptious\User;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/ramsey/uuid.php");

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
	 */
	public final function setUp() : void {
		parent::setUp();
		//
		$password = "abc123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
	}

	/**
	 * test inserting a valid User and verify that the actual mySQL data matches
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




}
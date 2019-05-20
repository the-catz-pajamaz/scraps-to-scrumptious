<?php

namespace theCatzPajamaz\scrapsToScrumptious;
require_once ("autoload.php");

require_once(dirname(__DIR__) . "/validateuuid.php");

use theCatzPajamaz\scrapsToScrumptious\{User, Recipe, Cookbook};

/**
 * Full PHP Unit test for the Cookbook class
 *
 * This is a full PHPUnit test of the Cookbook class. It is full because all mySQL and PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see \theCatzPajamaz\scrapsToScrumptious\Cookbook
 * @author Samuel Nelson <snelson54@cnm.edu>
 */

class CookbookTest extends ScrapsToScrumptiousTest {

	/**
	 * User that owns the Cookbook; this is a foreign key relations
	 * @var User $user
	 */
	protected $user;

	/**
	 * Recipe id that is in a Cookbook; this is a foreign key relations
	 * @var Recipe $recipe
	 */
	protected $recipe;

	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;

	/**
	 * valid activation token
	 * @var string $VALID_ACTIVATION
	 */
	protected $ACTIVE_VALIDATION;

	/**
	 * creates dependent objects before running test
	 */
	public final function setUp() : void {
		// Run the default setUp() method first
		parent::setUp();

		// Create a salt and hash for the mocked User
		$password = "fakePass123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);

		// Create and insert the mocked User
		// Not sure any of this is right, forgive me George.
		$this->user = new User(generateUuidV4(), null,"@phpunit", "https://www.fillmurray.com/460/300", "test@phpunit.de", $this->VALID_HASH, "+12345678911");)
		$this->user->insert($this->getPDO());

		// Create and insert the mocked Cookbook
		$this->cookbook = new Cookbook(generateUuidV4(), $this->cookbook->getCookbookId());
		$this->cookbook->insert($this->getPDO());

		/**
		 * test inserting a valid Cookbook and verify that the mySQL data matches
		 */
		public function testInsertValidCookbook() : void {
			// Create a new Cookbook and insert it into mySQL
			$cookbook = new Cookbook($this->user->getUserId(), $this->recipe->getRecipeId());
			$cookbook->insert($this->getPDO());

			// Make sure cookbook doesn't already exist in mySQL
			$pdoCookbook = Cookbook::getCookbookByCookbookRecipeIdAndCookbookUserId($this->getPdo(), $this->user->getUserId(), $this->recipe->getRecipeId());
			$this->assertNull($pdoCookbook);
		}
	}

	/**
	 * Test creating a Cookbook and then deleting it
	 **/
	public function testInsertValidCookbook() : void {
		// Create a new Cookbook and insert it into mySQL
		$cookbook = new Cookbook($this->user->getUserId(), $this->recipe->getRecipeId());
		$cookbook->insert($this->getPDO());

		// Delete Cookbook from mySQL
		$this->assertEquals Cookbook($this->user->getUserId(), $this->recipe->getRecipeId());
			$cookbook->delete($this->getPDO());

			// Make sure cookbook doesn't already exist in mySQL
			$pdoCookbook = Cookbook::getCookbookByCookbookRecipeIdAndCookbookUserId($this->getPdo(), $this->user->getUserId(), $this->recipe->getRecipeId());
			$this->assertNull($pdoCookbook);

			}


		/**
	 * Test inserting a Cookbook and regrabbing it from mySQL
	 */
	public function testGetCookbookByCookbookRecipeIdAndCookbookUserId() : void {
		// Create a new Cookbook and insert it into mySQL
		$cookbook = new Cookbook($this->user->getUserId(), $this->recipe->getRecipeId());
		$cookbook->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match expected output
		$pdoCookbook = Cookbook::getCookbookByCookbookRecipeIdAndCookbookUserId($this->getPdo(), $this->user->getUserId(), $this->recipe->getRecipeId());
		$this->assertEquals($pdoCookbook->getCookbookRecipeId(), $this->recipe->getRecipeId());
		$this->assertEquals($pdoCookbook->getCookbookUserId(), $this->user->getUserId());
		}

		/**
		 * test grabbing a Cookbook that doesn't exist
		 */
		public function testGetInvalidCookbookByCookbookRecipeIdAndCookbookUserId() :void {
			// grab a recipe id and user id that exceeds the max character limit
			$cookbook = Cookbook::getCookbookByCookbookRecipeIdAndCookbookUserId($this->getPDO(), generateUuidV4(), generateUuidV4());
			$this->assertNull($cookbook);
		}

		/**
		 * Test grabbing a Cookbook by User id
		 **/
		public function testGetValidCookbookByUserId() : void {
			// Create a new Cookbook and insert it into mySQL
			$cookbook = new Cookbook($this->user->getUserId(), $this->recipe->getRecipeId());
			$cookbook->insert($this->getPDO());

			// grab the data from mySQL and enforce the fields match expected output
			$pdoCookbook = Cookbook::getCookbookByCookbookRecipeIdAndCookbookUserId($this->getPdo(), $this->user->getUserId(), $this->recipe->getRecipeId());
			$this->assertEquals($pdoCookbook->getCookbookRecipeId(), $this->recipe->getRecipeId());
			$this->assertEquals($pdoCookbook->getCookbookUserId(), $this->user->getUserId());
		}


	}
}

<?php

namespace TheCatzPajamaz\ScrapsToScrumptious\Test;

use Ramsey\Uuid\Uuid;
use TheCatzPajamaz\ScrapsToScrumptious\{User, Recipe, Cookbook};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

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
	 * @var Cookbook $cookbook
	 */
	protected $cookbook;

	/**
	 * Recipe id that is in a Cookbook; this is a foreign key relations
	 * @var Recipe $recipe
	 */
	protected $recipe;

	/**
	 * User that owns the Cookbook; this is a foreign key relations
	 * @var User $user
	 */
	protected $user = null;


	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$activationToken = bin2hex(random_bytes(16));

		// create and insert a User to own the test Recipe
		$this->user = new User(generateUuidV4(), $activationToken, "a@bc.com", "jack", "jackLinks", $hash, "sasquatch");
		$this->user->insert($this->getPDO());

		$this->recipe = new Recipe(generateUuidV4(), $this->user->getUserId(), "Food", "blue", "www.google.com", "steps", "This Recipe");
		$this->recipe->insert($this->getPDO());

	}
		/**
		 * test inserting a valid Cookbook and verify that the mySQL data matches
		 */
		public function testInsertValidCookbook() : void {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("cookbook");

			// Create a new Cookbook and insert it into mySQL
			$cookbook = new Cookbook($this->recipe->getRecipeId(), $this->user->getUserId());
			$cookbook->insert($this->getPDO());

			// Make sure cookbook doesn't already exist in mySQL
			$pdoCookbook = Cookbook::getCookbookByCookbookRecipeIdAndCookbookUserId($this->getPdo(), $this->recipe->getRecipeId(), $this->user->getUserId());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("cookbook"));
			$this->assertEquals($pdoCookbook->getCookbookRecipeId(), $cookbook->getCookbookRecipeId()->toString());
			$this->assertEquals($pdoCookbook->getCookbookUserId(), $cookbook->getCookbookUserId()->toString());
		}


	/**
	 * Test creating a Cookbook and then deleting it
	 **/
	public function testDeleteValidCookbook() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("cookbook");

		// Create a new Cookbook and insert it into mySQL
		$cookbook = new Cookbook($this->recipe->getRecipeId(), $this->user->getUserId());
		$cookbook->insert($this->getPDO());

		// Delete Cookbook from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("cookbook"));
			$cookbook->delete($this->getPDO());

			// Make sure cookbook doesn't already exist in mySQL
			$pdoCookbook = Cookbook::getCookbookByCookbookRecipeIdAndCookbookUserId($this->getPdo(), $this->recipe->getRecipeId(), $this->user->getUserId());
			$this->assertNull($pdoCookbook);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("cookbook"));
		}

		/**
	 * Test inserting a Cookbook and regrabbing it from mySQL
	 */
	public function testGetCookbookByCookbookRecipeIdAndCookbookUserId() : void {
		// Create a new Cookbook and insert it into mySQL
		$cookbook = new Cookbook($this->recipe->getRecipeId(), $this->user->getUserId());
		$cookbook->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match expected output
		$pdoCookbook = Cookbook::getCookbookByCookbookRecipeIdAndCookbookUserId($this->getPdo(), $this->recipe->getRecipeId(), $this->user->getUserId());
		$this->assertEquals($pdoCookbook->getCookbookRecipeId(), $this->recipe->getRecipeId());
		$this->assertEquals($pdoCookbook->getCookbookUserId(), $this->user->getUserId());
		}

		/**
		 * test grabbing a Cookbook that doesn't exist
		 */
		public function testGetInvalidCookbookByCookbookRecipeIdAndCookbookUserId() :void {
			// grab a recipe id and user-api id that exceeds the max character limit
			$cookbook = Cookbook::getCookbookByCookbookRecipeIdAndCookbookUserId($this->getPDO(), generateUuidV4(), generateUuidV4());
			$this->assertNull($cookbook);
		}

		/**
		 * Test grabbing a Cookbook by User id
		 **/
		public function testGetValidCookbookByUserId() : void {
			// Create a new Cookbook and insert it into mySQL
			$cookbook = new Cookbook($this->recipe->getRecipeId(), $this->user->getUserId());
			$cookbook->insert($this->getPDO());
			$results = Cookbook::getCookbooksByCookbookUserId($this->getPDO(), $this->user->getUserId());
			$this->assertCount(1, $results);

			// grab result from the array and validate it
			$pdoCookbook = $results[0];
			$this->assertEquals($pdoCookbook->getCookbookRecipeId(), $this->recipe->getRecipeId());
			$this->assertEquals($pdoCookbook->getCookbookUserId(), $this->user->getUserId());
		}

		/**
		 * Test grabbing a Cookbook by a User Id that does not exit should be a duplicate of line 114
		 */

	/**
	 * !!! Unsure if needed !!!
	 *
	 * Test grabbing a Cookbook by Recipe Id
	 **/
//	public function testGetValidCookbookByRecipeId() : void {
//		// Create a new Cookbook and insert it into mySQL
//		$cookbook = new Cookbook($this->recipe->getRecipeId(), $this->user-api->getUserId());
//		$cookbook->insert($this->getPDO());
//
//		$results = Cookbook::getCookbooksbyCookbookRecipeId($this->getPDO(), $this->recipe->getRecipeId());
//		$this->assertCount(1, $results);
//		// grab result from the array and validate it
//		$pdoCookbook = $results[0];
//		$this->assertEquals($pdoCookbook->getCookbookRecipeId(), $this->recipe->getCookbookRecipeId());
//		$this->assertEquals($pdoCookbook->getCookbookUserId(), $this->user-api->getUserId());
//	}
}

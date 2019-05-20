<?php
namespace theCatzPajamaz\scrapsToScrumptious;

use theCatzPajamas\scrapsToScrumptious\{Profile, Recipe};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 *  Full PHPUnit test for the Recipe class
 *
 * This is a complete PHPUnit test of the Recipe class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Recipe
 * @author Eric Martinez <emartinez451@cnm.edu>
 **/
class RecipeTest extends scrapsToScrumptiousTest {
	/**
	 * Profile that created the Recipe; this is for foreign key relations
	 * @var Recipe profile
	 **/
	protected $recipe = null;


	/**
	 * content of the Recipe
	 * @var string $VALID_RECIPEDESCRIPTION
	 **/
	protected $VALID_RECIPEDESCRIPTION = "PHPUnit test passing";

	/**
	 * content of the updated Recipe
	 * @var string $VALID_RECIPEDESCRIPTION2
	 **/
	protected $VALID_RECIPEDESCRIPTION2 = "PHPUnit test still passing";

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);

		// create and insert a Profile to own the test Recipe
		$this->profile = new Profile(generateUuidV4(), null, "@handle", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "test@phpunit.de", $this->VALID_PROFILE_HASH, "+12125551212");
		$this->profile->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_TWEETDATE = new \DateTime();

		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));


	}

	/**
	 * test inserting a valid Recipe and verify that the actual mySQL data matches
	 **/
	public function testInsertValidRecipe() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->recipe->getRecipeId(), $this->VALID_RECIPEDESCRIPTION, $this->VALID_RECIPEDATE);
		$recipe->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRecipe = Recipe::getRecipeByRecipeId($this->getPDO(), $recipe->getRecipeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipeId);
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $this->recipe->getRecipeId());
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPEDESCRIPTION);

	}



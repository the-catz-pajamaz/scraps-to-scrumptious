<?php

namespace TheCatzPajamaz\ScrapsToScrumptious\Test;

use Ramsey\Uuid\Uuid;
use TheCatzPajamaz\ScrapsToScrumptious\{User, Recipe};

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
class RecipeTest extends ScrapsToScrumptiousTest {
	/**
	 * User that created the Recipe; this is for foreign key relations
	 * @var User user-api
	 **/
	protected $user = null;

	/**
	 * ingredients for this recipe
	 * @var $recipeIngredients
	 */
	protected $VALID_RECIPE_INGREDIENTS = "can of cream of mushroom soup, green beans";

	/**
	 *recipe media
	 * @var $recipeMedia
	 */
	protected $VALID_RECIPE_MEDIA = "http://google.com";

	/**
	 * steps for this recipe
	 * @var $recipeSteps
	 */
	protected $VALID_RECIPE_STEPS = "add green beans to cream of mushroom soup";

	/**
	 * title for this recipe
	 * @var $recipeTitle
	 */
	protected $VALID_RECIPE_TITLE = "green bean casserole";

	/**
	 * content of the Recipe
	 * @var string $VALID_RECIPE_DESCRIPTION
	 **/
	protected $VALID_RECIPE_DESCRIPTION = "PHPUnit test passing";

	/**
	 * content of the updated Recipe
	 * @var string $VALID_RECIPE_DESCRIPTION_2
	 **/
	protected $VALID_RECIPE_DESCRIPTION_2 = "PHPUnit test still passing";

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

	}

	/**
	 * test inserting a valid Recipe and verify that the actual mySQL data matches
	 **/
	public function testInsertValidRecipe(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->user->getUserId(), $this->VALID_RECIPE_DESCRIPTION, $this->VALID_RECIPE_INGREDIENTS, $this->VALID_RECIPE_MEDIA, $this->VALID_RECIPE_STEPS, $this->VALID_RECIPE_TITLE);
		$recipe->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRecipe = Recipe::getRecipeByRecipeId($this->getPDO(), $recipe->getRecipeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipeId);
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $recipe->getRecipeUserId()->toString());
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION);
		$this->assertEquals($pdoRecipe->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeMedia(), $this->VALID_RECIPE_MEDIA);
		$this->assertEquals($pdoRecipe->getRecipeSteps(), $this->VALID_RECIPE_STEPS);
		$this->assertEquals($pdoRecipe->getRecipeTitle(), $this->VALID_RECIPE_TITLE);

	}

	/**
	 * test inserting a Recipe, editing it, and then updating it
	 **/
	public function testUpdateValidRecipe(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->user->getUserId(), $this->VALID_RECIPE_DESCRIPTION, $this->VALID_RECIPE_INGREDIENTS, $this->VALID_RECIPE_MEDIA, $this->VALID_RECIPE_STEPS, $this->VALID_RECIPE_TITLE);
		$recipe->insert($this->getPDO());

		// edit the Recipe and update it in mySQL
		$recipe->setRecipeDescription($this->VALID_RECIPE_DESCRIPTION_2);
		$recipe->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRecipe = Recipe::getRecipeByRecipeId($this->getPDO(), $recipe->getRecipeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipeId);
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $this->user->getUserId());
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION_2);
		$this->assertEquals($pdoRecipe->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeMedia(), $this->VALID_RECIPE_MEDIA);
		$this->assertEquals($pdoRecipe->getRecipeSteps(), $this->VALID_RECIPE_STEPS);
		$this->assertEquals($pdoRecipe->getRecipeTitle(), $this->VALID_RECIPE_TITLE);

	}

	/**
	 * test creating a Recipe and then deleting it
	 **/
	public function testDeleteValidRecipe(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->user->getUserId(), $this->VALID_RECIPE_DESCRIPTION, $this->VALID_RECIPE_INGREDIENTS, $this->VALID_RECIPE_MEDIA, $this->VALID_RECIPE_STEPS, $this->VALID_RECIPE_TITLE);
		$recipe->insert($this->getPDO());

		// delete the Recipe from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$recipe->delete($this->getPDO());

		// grab the data from mySQL and enforce the Recipe does not exist
		$pdoRecipe = Recipe::getRecipeByRecipeId($this->getPDO(), $recipe->getRecipeId());
		$this->assertNull($pdoRecipe);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("recipe"));
	}

	/**
	 * test grabbing all Recipes
	 **/
	public function testGetAllValidRecipes(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->user->getUserId(), $this->VALID_RECIPE_DESCRIPTION, $this->VALID_RECIPE_INGREDIENTS, $this->VALID_RECIPE_MEDIA, $this->VALID_RECIPE_STEPS, $this->VALID_RECIPE_TITLE);
		$recipe->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Recipe::getAllRecipes($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("TheCatzPajamaz\\ScrapsToScrumptious\\Recipe", $results);

		// grab the result from the array and validate it
		$pdoRecipe = $results[0];
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipeId);
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $this->user->getUserId());
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION);
		$this->assertEquals($pdoRecipe->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeMedia(), $this->VALID_RECIPE_MEDIA);
		$this->assertEquals($pdoRecipe->getRecipeSteps(), $this->VALID_RECIPE_STEPS);
		$this->assertEquals($pdoRecipe->getRecipeTitle(), $this->VALID_RECIPE_TITLE);

	}

	/**
	 * test grabbing all Recipes by recipe id
	 **/
	public function testGetValidRecipesByRecipeId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->user->getUserId(), $this->VALID_RECIPE_DESCRIPTION, $this->VALID_RECIPE_INGREDIENTS, $this->VALID_RECIPE_MEDIA, $this->VALID_RECIPE_STEPS, $this->VALID_RECIPE_TITLE);
		$recipe->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Recipe::getAllRecipes($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("TheCatzPajamaz\\ScrapsToScrumptious\\Recipe", $results);

		// grab the result from the array and validate it
		$pdoRecipe = $results[0];
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipeId);
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $this->user->getUserId());
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION);
		$this->assertEquals($pdoRecipe->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeMedia(), $this->VALID_RECIPE_MEDIA);
		$this->assertEquals($pdoRecipe->getRecipeSteps(), $this->VALID_RECIPE_STEPS);
		$this->assertEquals($pdoRecipe->getRecipeTitle(), $this->VALID_RECIPE_TITLE);

	}

	/**
	 * test grabbing all Recipes by recipe user-api id
	 **/
	public function testGetValidRecipesByRecipeUserId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->user->getUserId(), $this->VALID_RECIPE_DESCRIPTION, $this->VALID_RECIPE_INGREDIENTS, $this->VALID_RECIPE_MEDIA, $this->VALID_RECIPE_STEPS, $this->VALID_RECIPE_TITLE);
		$recipe->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Recipe::getRecipesByRecipeUserId($this->getPDO(), $recipe->getRecipeUserID());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("TheCatzPajamaz\\ScrapsToScrumptious\\Recipe", $results);

		// grab the result from the array and validate it
		$pdoRecipe = $results[0];
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipeId);
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $this->user->getUserId());
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION);
		$this->assertEquals($pdoRecipe->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeMedia(), $this->VALID_RECIPE_MEDIA);
		$this->assertEquals($pdoRecipe->getRecipeSteps(), $this->VALID_RECIPE_STEPS);
		$this->assertEquals($pdoRecipe->getRecipeTitle(), $this->VALID_RECIPE_TITLE);

	}

	/**
	 * test grabbing all Recipes by recipe title
	 **/
	public function testGetValidRecipesByRecipeTitle(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->user->getUserId(), $this->VALID_RECIPE_DESCRIPTION, $this->VALID_RECIPE_INGREDIENTS, $this->VALID_RECIPE_MEDIA, $this->VALID_RECIPE_STEPS, $this->VALID_RECIPE_TITLE);
		$recipe->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Recipe::getRecipesByRecipeTitle($this->getPDO(), $recipe->getRecipeTitle());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("TheCatzPajamaz\\ScrapsToScrumptious\\Recipe", $results);

		// grab the result from the array and validate it
		$pdoRecipe = $results[0];
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipeId);
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $this->user->getUserId());
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION);
		$this->assertEquals($pdoRecipe->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeMedia(), $this->VALID_RECIPE_MEDIA);
		$this->assertEquals($pdoRecipe->getRecipeSteps(), $this->VALID_RECIPE_STEPS);
		$this->assertEquals($pdoRecipe->getRecipeTitle(), $this->VALID_RECIPE_TITLE);

	}

}



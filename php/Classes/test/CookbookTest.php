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
	 * creates dependent objects before running test
	 */
	public final function setUp() : void {
		// Run the default setUp() method first
		parent::setUp();

		// Create and insert the mocked User

	}
}

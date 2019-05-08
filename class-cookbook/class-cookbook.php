<?php
class Cookbook {
	use ValidateUuid;
	/**
	 * id for this cookbook recipe;
	 * @var Uuid $cookbookRecipeId
	 */
	private $cookbookRecipeId;
	/**
	 *
	 * @var string for cookbookRecipeId
	 */
	private $cookbookUserId;
	/**
	 * @var string for cookbookUserId
	 * @var cookbookUserId
	 */
	/**
	 * constructor for author
	 */
	public function __construct(string $newCookbookRecipeId, string $newCookbookUserId) {
		try {
			$this->cookbookRecipeId($newCookbookRecipeId);
			$this->cookbookUserId($newCookbookUserId);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			echo "Invalid request, Id not found";
		}
	}
	/**
	 * accessor method for cookbookRecipeId
	 * @return Uuid value of cookbookRecipeId
	 */
	public function getCookbookRecipeId(): Uuid {
		return ($this->cookbookRecipeId);
	}
}
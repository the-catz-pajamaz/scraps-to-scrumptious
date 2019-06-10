import React, {useEffect} from 'react';
import {Route} from 'react-router';
import {getAllRecipes, getRecipeByRecipeId} from "../shared/actions";
import {connect} from "react-redux";

const RecipeComponent= (props) => {
	const {match, getAllRecipes, recipes} = props;
	useEffect(()=>  {
		getAllRecipes()
	}, [getAllRecipes]);
	const filterRecipe = recipes.filter(recipe => recipe.recipeId === match.params.recipeId);
	const recipe = {...filterRecipe[0]};
	console.log(recipe);
	return (
		<section>
		<div className="card">
			<h1><em>{recipe.recipeTitle}</em></h1>
			<h3>Description</h3>
			<p>{recipe.recipeDescription}</p>
			<h3>Ingredients</h3>
			<p>{recipe.recipeIngredients}</p>
			<h3>Steps</h3>
			{recipe.recipeSteps}
		</div>
	</section>
	)
};

const mapStateToProps = ({recipes}) => {
	return {recipes: recipes};
};

export const Recipe = connect(mapStateToProps, {getAllRecipes})(RecipeComponent);




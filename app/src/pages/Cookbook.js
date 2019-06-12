import React from 'react';
import {Route} from 'react-router';
import {getAllRecipes, getRecipeByRecipeId} from "../shared/actions";
import {getRecipeByRecipeTitle} from "../shared/actions";
import {connect} from "react-redux";

const CookbookComponent= (props) => {
	// const {match, getRecipeByRecipeId, recipes} = props;
	// useEffect(()=>  {
	// 	getRecipeByRecipeId()
	// }, [getRecipeByRecipeId]);
	// const filterRecipe = recipes.filter(recipe => recipe.recipeId === match.params.recipeId);
	// const recipe = {...filterRecipe[0]};
	// console.log(recipe);
	return (
		<div>
			my cookbook
		</div>
	)
};

export const Cookbook =(CookbookComponent);


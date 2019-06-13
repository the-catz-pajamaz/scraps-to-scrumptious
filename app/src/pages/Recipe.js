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

	return (
		<section>
		<div className="card" id="myCard">
			<h1 id="title"><em>{recipe.recipeTitle}</em></h1>
			<img className="card-img-top" id="cardImg" src={recipe.recipeMedia ? recipe.recipeMedia : "/images/bloodyMary.jpg"}
				  alt="recipe image"/>
			<h3 id="descriptionTitle">Description</h3>
			<p id="description">{recipe.recipeDescription}</p>
			<h3 id="ingredientsTitle">Ingredients</h3>
			<p id="ingredients">{recipe.recipeIngredients}</p>
			<h3 id="stepsTitle">Steps</h3>
			<p id="steps">{recipe.recipeSteps}</p>
		</div>
	</section>
	)
};

const mapStateToProps = ({recipes}) => {
	return {recipes: recipes};
};

export const Recipe = connect(mapStateToProps, {getAllRecipes})(RecipeComponent);




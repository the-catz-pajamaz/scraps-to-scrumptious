import React from 'react';
import { Route } from 'react-router';


export const RecipeCard = ({recipe}) => {


	return (
		<>
			<div className="card" id="recipeCard">
				<img className="card-img-top" id="cardImg" src={recipe.recipeMedia ? recipe.recipeMedia : "images/bloodyMary.jpg"}
					  alt="Humpty Dumpty"/>
				<div className="card-body">
					<h5 className="card-title">{recipe.recipeTitle}</h5>
					<p className="card-text">{recipe.recipeDescription}</p>
					<Route render={ ({history}) => (<button className="btn btn-info"  onClick={() => { history.push(`recipe/${recipe.recipeId}`)}}>Recipe</button>)}/>
				</div>
			</div>
		</>
	)
};


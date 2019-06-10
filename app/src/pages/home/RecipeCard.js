import React from 'react';
import { Route } from 'react-router';


export const RecipeCard = ({recipe}) => {


	return (
		<>
			<div className="card">
				<img className="card-img-top" src={recipe.recipeMedia ? recipe.recipeMedia : "images/egg.jpg"} width="200px"
					  height="200px"
					  alt="Humpty Dumpty"/>
				<div className="card-body">
					<h5 className="card-title">{recipe.recipeTitle}</h5>
					<p className="card-text">{recipe.recipeDescription}</p>
					<Route render={ ({history}) => (<button className="btn btn-primary" onClick={history.push(`recipe/${recipe.recipeId}`)}/>)}/>
				</div>
			</div>

		</>
	)
};


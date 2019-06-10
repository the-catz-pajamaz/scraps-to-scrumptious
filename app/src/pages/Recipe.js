import React, {useEffect} from 'react';
import {Route} from 'react-router';
import {getRecipeByRecipeId} from "../shared/actions";
import {connect} from "react-redux";

const RecipeComponent= (props) => {
	const {match, getRecipeByRecipeId, recipe} = props;
	useEffect(()=>  {
		getRecipeByRecipeId(match.params.recipeId)
	}, [getRecipeByRecipeId]);
	return (<h1>{recipe.recipeId}</h1>)
};

const mapStateToProps = ({recipes}) => {
	return {recipe: recipes};
};

export const Recipe = connect(mapStateToProps, {getRecipeByRecipeId})(RecipeComponent);



{/*<section>*/}
{/*	<div className="card">*/}
{/*		<h1><em>Smores</em></h1>*/}
{/*		<h3>Description</h3>*/}
{/*		<p>A delicious, warm, and gooey treat unsurpassed in the long, lovely catalogue of human*/}
{/*			pleasures.</p>*/}
{/*		<h3>Ingredients</h3>*/}
{/*		<ol>*/}
{/*			<li>Marshmallow</li>*/}
{/*			<li>Graham Cracker</li>*/}
{/*			<li>Chocolate Bar</li>*/}
{/*			<li>Stick</li>*/}
{/*			<li>Fire</li>*/}
{/*		</ol>*/}
{/*		<h3>Steps</h3>*/}
{/*		<ol>*/}
{/*			<li>Place a square of chocolate on a graham cracker</li>*/}
{/*			<li>Remove marshmallow from bag</li>*/}
{/*			<li>Place marshmallow on stick</li>*/}
{/*			<li>Hold stick from the end without the marshmallow</li>*/}
{/*			<li>Keep marshmallow near fire until desired cookedness</li>*/}
{/*			<li>Remove marshmallow from heat</li>*/}
{/*			<li>Place marshmallow on chocolate/graham cracker</li>*/}
{/*			<li>Place another graham cracker on top</li>*/}
{/*			<li>Apply gentle force to both graham crackers and remove stick from marshmallow</li>*/}
{/*			<li>Enjoy!</li>*/}
{/*		</ol>*/}
{/*	</div>*/}
{/*</section>*/}
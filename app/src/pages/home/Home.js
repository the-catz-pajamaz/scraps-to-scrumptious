import React, {useEffect} from 'react';
import {RecipeCard} from "./RecipeCard";
import {getAllRecipes} from "../../shared/actions";
import {connect} from "react-redux";
import {HomeJumbotron} from "../../shared/components/HomeJumbotron";
import {Footer} from "../../shared/components/Footer";
import {NavBar} from "../../shared/components/NavBar/NavBar";


const HomeComponent = ({getAllRecipes, recipes}) => {

	useEffect(() => {
			getAllRecipes()
	},
		[getAllRecipes]
	);
	return(
		<>
		<HomeJumbotron/>
		<main className="container">
		<div className="card-columns">
			{
				recipes.map(recipe=> (
					<RecipeCard recipe={recipe} key={recipe.recipeId}/>
					))
			}

		</div>

		</main>
	</>
	)
};

const mapStateToProps = ({recipes}) => {
	return{recipes};
};



export const Home = connect(mapStateToProps, {getAllRecipes})(HomeComponent);

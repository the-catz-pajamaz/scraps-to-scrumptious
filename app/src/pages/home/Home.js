import React, {useEffect} from 'react';
import {RecipeCard} from "./RecipeCard";
import {getAllRecipes} from "../../shared/actions";
import {connect} from "react-redux";


const HomeComponent = ({getAllRecipes, recipes}) => {
	
	useEffect(() => {
			getAllRecipes()
	},
		[getAllRecipes]
	);
	console.log(recipes);
	return(
		<main className="container">
		<RecipeCard recipes={recipes}/>
		</main>
	)
};

const mapStateToProps = ({recipes}) => {
	return{recipes};
};



export const Home = connect(mapStateToProps, {getAllRecipes})(HomeComponent);

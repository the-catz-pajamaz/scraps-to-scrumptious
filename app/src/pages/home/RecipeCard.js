import React from 'react';
const RecipeCardComponent = ({recipes}) => {

	console.log("line for recipeCard.js", recipes);


	return(
		<>
			{recipes.map(recipe => (
					<section id="recipe-card">
						<div className="container justify-content-center ">
							<div className="row">
								<div className="card col-lg-3 col-sm-10">
									<img className="card-img-top" src={recipe.recipeMedia ? recipe.recipeMedia : "images/egg.jpg"} width="200px" height="200px"
										  alt="Humpty Dumpty"/>
									<div className="card-body">
										<h5 className="card-title">{recipe.recipeTitle}</h5>
										<p className="card-text">{recipe.recipeDescription}</p>
										<a href="#" className="btn btn-primary">DELICIOUSNESS</a>
									</div>
								</div>
							</div>
						</div>
					</section>

				)
			)
			}
			</>
	)
};

export const RecipeCard = (RecipeCardComponent);
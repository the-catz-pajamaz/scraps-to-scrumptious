import React from 'react';
const RecipeCardComponent = ({recipes}) => {

	console.log("line for recipeCard.js", recipes);

	return(
		<>
			{recipes.map(recipe => (
					<section id="recipe-card">
						<div className="container justify-content-center">
							<div className="row">
								<div className="card col-lg-3 col-sm-10">
									<img className="card-img-top" src="/app/public/images/egg.jpg" width="200px" height="200px"
										  alt="egg"/>
									<div className="card-body">
										<h5 className="card-title">{recipe.recipeTitle}</h5>
										<p className="card-text">Some quick example text to build on the card title and make up the
											bulk
											of the card's content.</p>
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
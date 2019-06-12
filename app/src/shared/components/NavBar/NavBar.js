import React from "react";
import {SignUpModal} from "./Sign-Up/SignUpModal";
import {SignInModal} from "./Sign-In/SignInModal";


export const NavBar = () => (
	<>
		{/*<!-- Font Awesome -->*/}
		{/* <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"*/}
		{/* 		integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay"*/}
		{/* 		crossOrigin="anonymous"/>*/}


		{/*<!--Navbar beginning -->*/}
		{/*<nav className="navbar navbar-dark bg-white fluid d-flex justify-content-end text-monospace">*/}

		<nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
					  aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-item nav-link active" href="#">Scraps to Scrumptious <span class="sr-only">(current)</span></a>
					<a class="nav-item nav-link" href="#">Home</a>
					<a class="nav-item nav-link" href="#">Cookbook</a>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">


					</div>
				</div>
				<form class="form-inline my-2 my-lg-0 ml-auto">
					<input class="form-control  mx-1" type="search" placeholder="Search" aria-label="Search"/>
					<button class="btn btn-info  mx-2" type="reset">Search</button>
				</form>
				<form className="form-inline"/>
					<SignUpModal/>
					<SignInModal/>
				<br/>
			</div>

			{/*<button className="btn btn-outline-warning" type="button"></button>*/}
			{/*<button className="btn btn-outline-warning" type="button">Favorites</button>*/}
		</nav>
	</>
);
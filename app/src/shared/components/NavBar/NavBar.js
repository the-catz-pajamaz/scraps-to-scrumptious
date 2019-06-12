import React from "react";
import {SignUpModal} from "./Sign-Up/SignUpModal";
import {SignInModal} from "./Sign-In/SignInModal";


export const NavBar = () => (
	<>

		{/*<!-- Font Awesome -->*/}
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
				integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay"
				crossOrigin="anonymous"/>


		{/*<!--Navbar beginning -->*/}
		<nav className="navbar navbar-dark bg-dark fluid d-flex justify-content-end text-monospace">
			<form className="form-inline"/>
			<SignUpModal/>
			<SignInModal/>
			{/*<button className="btn btn-outline-warning" type="button"></button>*/}
			{/*<button className="btn btn-outline-warning" type="button">Favorites</button>*/}
		</nav>
	</>
);
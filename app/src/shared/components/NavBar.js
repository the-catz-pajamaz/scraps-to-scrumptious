import React from "react";


export const NavBar = () => (
	<header>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-item nav-link active" href="#">Scraps to Scrumptious <span class="sr-only">(current)</span></a>
					<a class="nav-item nav-link" href="#">Home</a>
					<a class="nav-item nav-link" href="#">Cookbook</a>
					<a class="nav-item nav-link" href="#">Login</a>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">


					</div>
				</div>
				<form class="form-inline my-2 my-lg-0 ml-auto">
					<input class="form-control" type="search" placeholder="Search" aria-label="Search"/>
						<button class="btn btn-danger" type="reset"><i class="fa fa-search"></i></button>
				</form>
			</div>
		</nav>
	</header>
)
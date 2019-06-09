import React from "react";


export const NavBar = () => (
	<header>
		<nav className="navbar navbar-expand-lg navbar-light bg-light">
			<button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span className="navbar-toggler-icon"></span>
			</button>
			<div className="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div className="navbar-nav">
					<a className="nav-item nav-link active" href="#">Scraps to Scrumptious <span className="sr-only">(current)</span></a>
					<a className="nav-item nav-link" href="#">Home</a>
					<a className="nav-item nav-link" href="#">Cookbook</a>
					<a className="nav-item nav-link" href="#">Login</a>
					<div className="collapse navbar-collapse" id="navbarSupportedContent">


					</div>
				</div>
				<form className="form-inline my-2 my-lg-0 ml-auto">
					<input className="form-control" type="search" placeholder="Search" aria-label="Search"/>
						<button className="btn btn-danger" type="reset"><i className="fa fa-search"></i></button>
				</form>
			</div>
		</nav>
	</header>
)
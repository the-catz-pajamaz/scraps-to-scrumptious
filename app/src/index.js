import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import {Route, BrowserRouter,Switch} from "react-router-dom";
import {Home} from "./pages/home/Home";


const Routing = () => (
	<>

		<BrowserRouter>
			<Switch>
				<Route exact path="/" component={Home}/>
			</Switch>
		</BrowserRouter>

	</>
) ;

ReactDOM.render(Routing() , document.querySelector('#root'));
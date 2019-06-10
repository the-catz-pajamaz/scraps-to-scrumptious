import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import {Route, BrowserRouter,Switch} from "react-router-dom";
import {Home} from "./pages/home/Home";
import {HomeJumbotron} from "./shared/components/HomeJumbotron";
import {Footer} from "./shared/components/Footer";
import {NavBar} from "./shared/components/NavBar";
import {FourOhFour} from "./pages/four-oh-four/FourOhFour";
import {Provider} from "react-redux";
import {applyMiddleware, createStore} from "redux";
import thunk from "redux-thunk";
import reducers from "./shared/reducers";

// import {HomeJumbotron} from "./shared/components/HomeJumbotron";

const store = createStore(reducers, applyMiddleware(thunk));

const Routing = (store) => (
	<>
		<Provider store={store}>

		<BrowserRouter>
			<NavBar/>
			<HomeJumbotron/>
			<Switch>
				<Route exact path="/" component={Home}/>
				<Route component={FourOhFour}/>
			</Switch>
			<Footer/>
		</BrowserRouter>
	</Provider>
	</>
) ;

ReactDOM.render(Routing(store) , document.querySelector('#root'));
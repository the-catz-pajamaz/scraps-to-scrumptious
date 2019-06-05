import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';


const App = () => ( <h1 className="text-info">hello world</h1> );
ReactDOM.render(<App/>, document.querySelector('#root'));
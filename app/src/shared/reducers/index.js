import {combineReducers} from "redux"

import userReducer from "./userReducer";
import recipeReducer from "./recipeReducer";



export default combineReducers({
	recipes: recipeReducer,
	users: userReducer

})

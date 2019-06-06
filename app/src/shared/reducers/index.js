import {combineReducers} from "redux"
import postsReducer from "./recipeReducer";



export default combineReducers({
	posts: recipeReducer(),

})

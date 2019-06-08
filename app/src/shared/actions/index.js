import {httpConfig} from "../misc/http-config";

export const getUserByUserId = () => async dispatch => {
	const {data} = await httpConfig("/apis/post/");
	dispatch({type: "GET_USER", payload: data})
};

export const getUserByUserEmail = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/post/${id}`);
	dispatch({type: "GET_USER", payload: data})
};

export const getRecipeByRecipeId = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/post/${id}`);
	dispatch({type: "GET_RECIPE", payload: data})
};

export const getRecipesByRecipeUserId = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/post/${id}`);
	dispatch({type: "GET_RECIPES", payload: data})
};

export const getRecipesByRecipeTitle = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/post/${id}`);
	dispatch({type: "GET_RECIPES", payload: data})
};

export const getAllRecipes = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/post/${id}`);
	dispatch({type: "GET_ALL_RECIPES", payload: data})
};

export const getCookbooksByCookbookUserId = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/post/${id}`);
	dispatch({type: "GET_COOKBOOKS", payload: data})
};

export const getCookbookByCookbookRecipeIdAndCookbookUserId = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/post/${id}`);
	dispatch({type: "GET_COOKBOOK", payload: data})
};

import {httpConfig} from "../misc/http-config";

export const getUserByUserId = () => async dispatch => {
	const {data} = await httpConfig("/apis/post/");
	dispatch({type: "GET_ALL_RECIPES", payload: data})
};

export const getPostByPostId = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/post/${id}`);
	dispatch({type: "GET_RECIPE", payload: data})
};
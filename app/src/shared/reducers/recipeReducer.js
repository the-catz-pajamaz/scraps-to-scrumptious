export default (state = [], action) => {
	switch(action.type) {
		case "GET_RECIPE":
			return action.payload;
		case "GET_RECIPES":
			return action.payload;
		case "GET_ALL_RECIPES":
			return action.payload;
		default:
			return state;

	}
}
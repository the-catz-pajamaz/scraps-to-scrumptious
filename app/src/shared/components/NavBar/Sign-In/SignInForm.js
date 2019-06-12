import React from 'react';
import {httpConfig} from "../../../misc/http-config";
import {Formik} from "formik/dist/index";
import * as Yup from "yup";
import {SignInFormContent} from "./SignInFormContent";
import { Route } from 'react-router';



export const SignInForm = ({history}) => {
	const validator = Yup.object().shape({
		userEmail: Yup.string()
			.email("oopsie made a poopsie")
			.required('email is required'),
		userPassword: Yup.string()
			.required("Password is required")
			.min(8, "Password must be at least eight characters")
	});

	//the initial values object defines what the request payload is.
	const signIn = {
		userEmail: "",
		userPassword: ""
	};

	const submitSignIn = (values, {resetForm, setStatus}) => {
		httpConfig.post("/apis/sign-in/", values)
			.then(reply => {
				let {message, type} = reply;
				setStatus({message, type});
				if(reply.status === 200 && reply.headers["x-jwt-token"]) {
					window.localStorage.removeItem("jwt-token");
					window.localStorage.setItem("jwt-token", reply.headers["x-jwt-token"]);


					// history.push(`/cookbook/${message}`);
				}
			});
	};
	return (
		<>
			<Formik
				initialValues={signIn}
				onSubmit={submitSignIn}
				validationSchema={validator}
			>
				{SignInFormContent}
			</Formik>
		</>
	)
};


import React, {useState} from 'react';
import {httpConfig} from "../../../misc/http-config";
import * as Yup from "yup";
import {Formik} from "formik";

import {SignUpFormContent} from "./SignUpFormContent";

export const SignUpForm = () => {
	const signUp = {
		userEmail: "",
		userHandle: "",
		userFirstName: "",
		userLastName: "",
		userPassword: "",
		userPasswordConfirm: ""
	};

	const [status, setStatus] = useState(null);
	const validator = Yup.object().shape({
		userEmail: Yup.string()
			.email("email must be a valid email")
			.required('email is required'),
		userHandle: Yup.string()
			.required("@userHandle"),
		userFirstName: Yup.string()
			.required("user First Name is required"),
		userLastName: Yup.string()
			.required("user Last Name is required"),
		userPassword: Yup.string()
			.required("Password is required")
			.min(8, "Password must be at least eight characters"),
		userPasswordConfirm: Yup.string()
			.required("Password Confirm is required")
			.min(8, "Password must be at least eight characters"),
	});

	const submitSignUp = (values,{setStatus, resetForm}) => {

		console.log('opps');
		httpConfig.post("/apis/sign-up/", values)
			.then(reply => {
					let {message, type} = reply;
					setStatus({message, type});
					if(reply.status === 200) {
						resetForm();
					}
				}
			);
	};

	return (
		<Formik
			initialValues={signUp}
			onSubmit={submitSignUp}
			validationSchema={validator}
		>
			{SignUpFormContent}
		</Formik>
	)
};
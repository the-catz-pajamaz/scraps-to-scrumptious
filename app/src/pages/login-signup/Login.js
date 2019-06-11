import React, {useState} from 'react';
import {httpConfig} from "app/src/shared/misc/http-config.js";
import * as Yup from "yup";
import {Formik} from "formik/dist/index";

import {SignUpFormContent} from "app/src/pages/login-signup/SignUpLoginFormContent.js";
import {connect} from "react-redux";
import {getAllRecipes} from "../../shared/actions";
import {SignUpForm from "SignUpLoginFormContent.js";

export const SignUpForm = () => {
	const signUp = {
		userEmail: "",
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

export const loginSignup = connect(mapStateToProps, {})(LoginComponent);
















// import React from 'react';
//
// export const Login = () => {
//
//
// 	return (
// 		<>
// 			<br/>
// 			<h1 className="card-title text-center" id="title">Signup</h1>
//
//
// 			<section id="section-1">
// 				<div className="col-lg-4 col-sm-10 container " id="signup">
// 					<form id="Signup">
//
// 						<div className="form-group">
// 							<label htmlFor="Username" className="text-white">Username<span className="text-danger"/></label>
// 							<div className="input-group">
// 								<div className="input-group-prepend">
// 									<span className="input-group-text"/>
// 								</div>
// 								<input type="text" className="form-control" id="email" name="Email" placeholder="Email"/>
// 							</div>
// 						</div>
//
//
// 						<div className="form-group">
// 							<label htmlFor="password" className="text-white"><span className="text-danger"/></label>
// 							<div className="input-group">
// 								<div className="input-group-prepend">
// 									<span className="input-group-text"/>
// 								</div>
// 								<input type="text" className="form-control" id="password" name="password"
// 										 placeholder="Password"/>
// 							</div>
// 						</div>
//
// 						<div className="form-group">
// 							<label htmlFor="password" className="text-white"><span className="text-danger"/></label>
// 							<div className="input-group">
// 								<div className="input-group-prepend">
// 									<span className="input-group-text"/>
// 								</div>
// 								<input type="text" className="form-control" id="first-name" name="first-name"
// 										 placeholder="First Name"/>
// 							</div>
// 						</div>
//
// 						<div className="form-group">
// 							<label htmlFor="password" className="text-white"><span className="text-danger"/></label>
// 							<div className="input-group">
// 								<div className="input-group-prepend">
// 									<span className="input-group-text"/>
// 								</div>
// 								<input type="text" className="form-control" id="last-name" name="last-name"
// 										 placeholder="Last Name"/>
// 							</div>
// 						</div>
// 						<button className="btn btn-success" type="submit"><i className="fa fa-paper-plane"/>Submit</button>
// 						<br/>
// 						<br/>
// 						<br/>
// 					</form>
// 				</div>
//
// 			</section>
//
//
// 			<br/>
// 			<h1 className="card-title text-center" id="title">Login</h1>
//
//
// 			<section id="section-2">
// 				<div className="col-lg-4 col-sm-10 container " id="login">
// 					<form id="Login">
//
// 						<div className="form-group">
// 							<label htmlFor="Username" className="text-white">Username<span className="text-danger"/></label>
// 							<div className="input-group">
// 								<div className="input-group-prepend">
// 									<span className="input-group-text"/>
// 								</div>
// 								<input type="text" className="form-control" id="email" name="Email" placeholder="Email"/>
// 							</div>
// 						</div>
//
//
// 						<div className="form-group">
// 							<label htmlFor="password" className="text-white"><span className="text-danger"/></label>
// 							<div className="input-group">
// 								<div className="input-group-prepend">
// 									<span className="input-group-text"/>
// 								</div>
// 								<input type="text" className="form-control" id="password" name="password"
// 										 placeholder="Password"/>
// 							</div>
// 						</div>
//
// 						<button className="btn btn-success" type="submit"><i className="fa fa-paper-plane"/>Submit</button>
// 						<br/>
// 						<br/>
// 						<br/>
// 					</form>
// 				</div>
//
// 			</section>
//
// 		</>)
//
//
// };
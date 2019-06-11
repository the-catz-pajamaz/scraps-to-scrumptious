import React from "react";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome/index";
import {FormDebugger} from "app/src/pages/login-signup/FormDebugger.js";

export const SignUpFormContent = (props) => {
	const {
		submitStatus,
		values,
		errors,
		touched,
		dirty,
		isSubmitting,
		handleChange,
		handleBlur,
		handleSubmit,
		handleReset
	} = props;
	return (
		<>
			<form onSubmit={handleSubmit}>
				{/*controlId must match what is passed to the initialValues prop*/}
				<div className="form-group">
					<label htmlFor="userEmail">Email Address</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<i className="far fa-envelope"></i>
							</div>
						</div>
						<input
							className="form-control"
							id="userEmail"
							type="email"
							value={values.userEmail}
							placeholder="Enter email"
							onChange={handleChange}
							onBlur={handleBlur}

						/>
					</div>
					{
						errors.userEmail && touched.userEmail && (
							<div className="alert alert-danger">
								{errors.userEmail}
							</div>
						)

					}
				</div>
				{/*controlId must match what is defined by the initialValues object*/}
				<div className="form-group">
					<label htmlFor="userPassword">Password</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<i className="fas fa-unlock-alt"></i>
							</div>
						</div>
						<input
							id="userPassword"
							className="form-control"
							type="password"
							placeholder="Password"
							value={values.userPassword}
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{errors.userPassword && touched.userPassword && (
						<div className="alert alert-danger">{errors.userPassword}</div>
					)}
				</div>
				<div className="form-group">
					<label htmlFor="userPasswordConfirm">Confirm Your Password</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<i className="fas fa-unlock-alt"></i>
							</div>
						</div>
						<input

							className="form-control"
							type="password"
							id="userPasswordConfirm"
							placeholder="Password Confirm"
							value={values.userPasswordConfirm}
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{errors.userPasswordConfirm && touched.userPasswordConfirm && (
						<div className="alert alert-danger">{errors.userPasswordConfirm}</div>
					)}
				</div>


				<div className="form-group">
					<label htmlFor="userFirstName">First Name</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
							</div>
						</div>
						<input
							className="form-control"
							id="userFirstName"
							type="text"
							value={values.userFirstName}
							placeholder="@FirstName"
							onChange={handleChange}
							onBlur={handleBlur}

						/>
					</div>
					{
						errors.userFirstName && touched.userFirstName && (
							<div className="alert alert-danger">
								{errors.userFirstName}
							</div>
						)
					}
				</div>


				<div className="form-group">
					<label htmlFor="userLastName">Last Name</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<i className="fas fa-user"></i>
							</div>
						</div>
						<input
							className="form-control"
							id="userLastName"
							type="text"
							value={values.userLastName}
							placeholder="@LastName"
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{
						errors.userLastName && touched.userLastName && (
							<div className="alert alert-danger">
								{errors.userLastName}
							</div>
						)

					}
				</div>
				<div className="form-group">
					<button className="btn btn-outline-warning mb-2" type="submit">Submit</button>
					<button
						className="btn btn-outline-warning mb-2"
						onClick={handleReset}
						disabled={!dirty || isSubmitting}
					>
						Reset
					</button>
				</div>
				<FormDebugger {...props} />
			</form>
			{console.log(
				submitStatus
			)}
			{
				submitStatus && (<div className={submitStatus.type}>{submitStatus.message}</div>)
			}
		</>


	)
};
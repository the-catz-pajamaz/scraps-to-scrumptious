import React from "react";

export const SignInFormContent = (props) => {
	const {
		status,
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
							<div className="alert alert-info">
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
						<div className="alert alert-info">{errors.userPassword}</div>
					)}
				</div>

				<div className="form-group">
					<button className="btn btn-info mb-2" type="submit">Submit</button>
					<button
						className="btn btn-info mb-2"
						onClick={handleReset}
						disabled={!dirty || isSubmitting}
					>Reset
					</button>
				</div>
			</form>
			{/*{status && (<div className={status.type}>{status.message}</div>)}*/}
		</>
	)
};
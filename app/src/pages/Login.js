import React from 'react';

export const Login = () => {


	return (
		<>
			<br/>
			<h1 className="card-title text-center" id="title">Signup</h1>


			<section id="section-1">
				<div className="col-lg-4 col-sm-10 container " id="signup">
					<form id="Signup">

						<div className="form-group">
							<label htmlFor="Username" className="text-white">Username<span className="text-danger"/></label>
							<div className="input-group">
								<div className="input-group-prepend">
									<span className="input-group-text"/>
								</div>
								<input type="text" className="form-control" id="email" name="Email" placeholder="Email"/>
							</div>
						</div>


						<div className="form-group">
							<label htmlFor="password" className="text-white"><span className="text-danger"/></label>
							<div className="input-group">
								<div className="input-group-prepend">
									<span className="input-group-text"/>
								</div>
								<input type="text" className="form-control" id="password" name="password"
										 placeholder="Password"/>
							</div>
						</div>

						<div className="form-group">
							<label htmlFor="password" className="text-white"><span className="text-danger"/></label>
							<div className="input-group">
								<div className="input-group-prepend">
									<span className="input-group-text"/>
								</div>
								<input type="text" className="form-control" id="first-name" name="first-name"
										 placeholder="First Name"/>
							</div>
						</div>

						<div className="form-group">
							<label htmlFor="password" className="text-white"><span className="text-danger"/></label>
							<div className="input-group">
								<div className="input-group-prepend">
									<span className="input-group-text"/>
								</div>
								<input type="text" className="form-control" id="last-name" name="last-name"
										 placeholder="Last Name"/>
							</div>
						</div>
						<button className="btn btn-success" type="submit"><i className="fa fa-paper-plane"/>Submit</button>
						<br/>
						<br/>
						<br/>
					</form>
				</div>

			</section>


			<br/>
			<h1 className="card-title text-center" id="title">Login</h1>


			<section id="section-2">
				<div className="col-lg-4 col-sm-10 container " id="login">
					<form id="Login">

						<div className="form-group">
							<label htmlFor="Username" className="text-white">Username<span className="text-danger"/></label>
							<div className="input-group">
								<div className="input-group-prepend">
									<span className="input-group-text"/>
								</div>
								<input type="text" className="form-control" id="email" name="Email" placeholder="Email"/>
							</div>
						</div>


						<div className="form-group">
							<label htmlFor="password" className="text-white"><span className="text-danger"/></label>
							<div className="input-group">
								<div className="input-group-prepend">
									<span className="input-group-text"/>
								</div>
								<input type="text" className="form-control" id="password" name="password"
										 placeholder="Password"/>
							</div>
						</div>

						<button className="btn btn-success" type="submit"><i className="fa fa-paper-plane"/>Submit</button>
						<br/>
						<br/>
						<br/>
					</form>
				</div>

			</section>

		</>)


};
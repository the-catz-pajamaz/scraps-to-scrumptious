<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required META tags -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>My Cookbook</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
			integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Parallax -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/parallax.js/1.4.2/parallax.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"><script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<title>Home</title>
</head>
<body>
	<!-- Parallax Img -->
		<section>
			<div class="parallax-container" data-parallax="scroll" data-bleed="10" data-speed="0.2"
				  data-image-src="food2.jpg" data-natural-width="1920" data-natural-height="1280" id="titleBackground"
				  style="height: 120vh;">
				<div class="card bg-dark text-white text-border-dark border-0">
					<div class="card-img-overlay" id="titleText">

						<h1 class="card-title text-center " id="title" style="font-family: 'Montserrat', sans-serif; ">Upload Recipe</h1>
						<p class="card-text text-center"></p>
					</div>
				</div>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>

		<section id="section-1">
			<div class="col-4 container " id="upload">
				<form id="upload-recipe col-4 mt-12rem ">

					<div class="form-group">
						<label for="title" class="text-white">Recipe Title <span class="text-danger">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"></span>
								<i class="fa fa-user" aria-hidden="true"></i>
							</div>
							<input type="text" class="form-control" id="title" name="title" placeholder="Recipe Title">
						</div>
					</div>


					<div class="form-group">
						<label for="media" class="text-white">Recipe Media <span class="text-danger">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"></span>
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</div>
							<input type="image" class="form-control" id="media" name="media" placeholder="Insert a picture! :)" alt="">
						</div>
					</div>

					<div class="form-group">
						<label for="ingredients" class="text-white">Recipe Ingredients <span class="text-danger">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"></span>
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</div>
							<input type="text" class="form-control" id="ingredients" name="ingredients" placeholder="Recipe Ingredients">
						</div>
					</div>

					<div class="form-group">
						<label for="description" class="text-white" >Recipe Description <span class="text-danger">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"></span>
								<i class="fa fa-comment" aria-hidden="true"></i>
							</div>
							<textarea class="form-control" id="description" name="description" placeholder="(2000 characters max)"></textarea>
						</div>
					</div>

					<div class="form-group">
						<label for="steps" class="text-white">Recipe Steps <span class="text-danger">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"></span>
								<i class="fa fa-comment" aria-hidden="true"></i>
							</div>
							<textarea class="form-control" id="steps" name="steps" placeholder="(2000 characters max)"></textarea>
						</div>
					</div>

					<button class="btn btn-success" type="submit"><i class="fa fa-paper-plane"></i> Upload! :)</button>

				</form>
			</div>

		</section>
	</div>
	</section>

	</body>
</html>

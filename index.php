<?php

	if (!isset($_SESSION)) {
		session_start();
	}

	//clear session data for user
	if (isset($_GET['logout'])) {
		unset($_SESSION['username']);
	}


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>KAMSSA</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel = "icon" type = "image/png" href = "Images/logo.jpeg	">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

	<style>
		body {
			background-image: linear-gradient(to right, #ABC , rgb(168, 162, 204));
		}

		.container .jumbotron {
			border-radius: 6px ;
		}
	</style>

	<script src="jQuery/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">

			
			<!-- begin logo section -->
			<div class="text-center">
				<img  src="Images/logo.jpeg" alt="John Doe" class="mr-3 mt-3 " style="width:150px;">
			</div>
			<br>
			<!-- End of logo section -->

			<div class="jumbotron jumbotron-fluid">
				<div class="container ">

					<?php
						if (isset($_SESSION['Errors'])):
					?>
						<div class="alert alert-danger" role="alert">
						<?=$_SESSION['Errors']?>
						</div>
					<?php
						unset($_SESSION['Errors']);
						endif;
					?>
					
					
					<h4  class="text-center">Login</h4> 
					
					<!-- begin login form -->
					<form action="Includes/authenticate_login.php" method = "POST" class="was-validated">
						<div class="form-group">
						  <label for="user_name">Username:</label>
						  <input type="text" class="form-control" id="user_name" placeholder="Enter username" name="user_name" required>
						  <div class="valid-feedback">Valid.</div>
						  <div class="invalid-feedback">Please fill out this field.</div>
						</div>
						<div class="form-group">
						  <label for="password">Password:</label>
						  <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
						  <div class="valid-feedback">Valid.</div>
						  <div class="invalid-feedback">Please fill out this field.</div>
						</div>
						<div class="form-group form-check">
						  <label class="form-check-label">
							<input class="form-check-input" type="checkbox" name="remember" > Remember Password
						  </label>
						</div>
						<input type="hidden" name="submit">
						<button type="submit" class="btn btn-primary">Login</button>
					</form>
					<!-- end login form -->

				</div>
			</div>
		</div>
		<div class="col-md-3"></div>
	</div>

</div>

</body>
</html>
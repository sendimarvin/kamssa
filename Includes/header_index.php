<?php

	if (!isset($_SESSION)) {
		session_start();
	}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>KAMSSA</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel = "icon" type = "image/png" href = "Images/logo.jpeg">
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

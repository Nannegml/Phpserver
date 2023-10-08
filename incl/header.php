<?php
@session_start();


$option = "Login";

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	$option = "Logout"; 
}	

?>

<!doctype html>

<html lang="sv">
	<head>
		<meta charset="utf-8">
		<title>Northspawn</title>
		<link rel="stylesheet" href="index.css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<style> 

		</style>
	</head>

	
	<body>
		<header>
			<h1><a href="index.php">Northspawn</a></h1>
			
		</header>
	
		<nav>
			<form action="index.php?pageid=login" method="post">
			<input type="submit" name="logout" id="logoutButton" value="<?php echo $option; ?>">
			</form>
			<p><a href="?pageid=register">register</a></p>
			<p><a href="?pageid=buy">buy</a></p>
			<p><a href="?pageid=cart"><i class="fa fa-shopping-cart"></i></a></p>
			

		</nav>
		
		<div class="content">
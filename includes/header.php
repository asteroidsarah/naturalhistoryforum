<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300' rel='stylesheet' type='text/css'>
	<title>NZ Natural History Forum</title>
	<link rel="stylesheet" href="assets/stylesheets/styles.css">
	
</head>
<body>
	<div class="container">
		<div class="header">
			<div class="topBar">
				<div id="searchBox">
					<input type="text"><input type="button" value="Search">
				</div>
				<?php
				if(isset($_SESSION['userID'])){
					$oUser = new User();
					$oUser->load($_SESSION['userID']);
				echo("<p>Hi, <a href='userdetails.php'>".$oUser->firstName."</a>! &nbsp; <a href='logout.php'>Log out</a></p>");
				}else{
					echo("<p><a href='login.php'>Log in</a> or <a href='register.php'>Register</a></p>");
				}
				?>
			</div>		
			<h1 class="hideText">NZ NATURAL HISTORY FORUM</h1>
		</div>
		<div class="main">
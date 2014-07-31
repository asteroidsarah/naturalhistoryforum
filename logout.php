<?php 
ob_start();
	session_start();
	unset($_SESSION["userID"]);
	// unset($_SESSION["Cart"]);

	require_once("includes/view.php");

	require_once("includes/header.php");

	header("Location:index.php");
	exit;

	require_once("includes/footer.php");
  ?>
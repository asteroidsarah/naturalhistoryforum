<?php 
ob_start();

	require_once("includes/view.php");
	require_once("includes/model_collection.php");
	require_once("includes/view_form.php");
	require_once("includes/model_post.php");

	$oPost = new Post();
	$oPost->load($_GET["postID"]);
	$oPost->postActive = 0;

	$oPost->save();
	header("Location: controller_threadposts.php?threadID=".$oPost->threadID);
 	exit;


 ?>
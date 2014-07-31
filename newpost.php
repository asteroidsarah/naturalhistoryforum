<?php 
ob_start();
require_once("includes/model_collection.php");
require_once("includes/view_form.php");
require_once("includes/model_post.php");
require_once("includes/model_user.php");
session_start();


require_once("includes/header.php");
 ?>
	<div class="topicsBar">
		<h2><a href="index.php">Home</a> > Write new post</h2>
	</div>

 <?php 

 if(isset($_SESSION["userID"]) == false){
		header("Location:login.php");
		exit;
}

$oForm = new form();

if(isset($_POST["submit"])){
	$oForm->data = $_POST;

	$oForm->checkRequired("postMessage");

	if($oForm->isValid){

			$oPost = new Post();
			$oPost->userID = $_SESSION['userID'];
			$oPost->postMessage = $_POST["postMessage"];
			$oPost->threadID =$_GET['threadID'];
			$oPost->postActive = 1;
			$oPost->save();

			header("Location: controller_threadposts.php?threadID=".$oPost->threadID);
			exit;
		}
}

	$oForm->makeTextArea("Post message", "postMessage");
	$oForm->makeSubmit("Submit", "submit");

	echo $oForm->html;

	require_once("includes/footer.php");


  ?>
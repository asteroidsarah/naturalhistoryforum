<?php 
ob_start();
	require_once("includes/view.php");
	require_once("includes/model_collection.php");
	require_once("includes/view_form.php");
	require_once("includes/model_post.php");


	$oPost = new Post();
	$oPost->load($_GET["postID"]);
	//store the existing form data in an array
	$aExistingData = array();
	$aExistingData["postMessage"] = $oPost->postMessage;

	$oForm = new Form();
	$oForm->data = $aExistingData; //use the to setter populate the form with the array of data.

	if(isset($_POST["submit"])){
		$oForm->checkRequired("postMessage");

		if($oForm->isValid){
			$oPost->postMessage = $_POST["postMessage"];

			$oPost->save();
	 		header("Location: controller_threadposts.php?threadID=".$oPost->threadID);
 			exit;
		}
	}

	require_once("includes/header.php");
 ?>

	<div class="profileBar">
		<h2><a href="index.php">Board index > </a>Edit post</h2>
	</div>

 <?php 
 	$oForm->makeTextArea("Post message", "postMessage");
	$oForm->makeSubmit("Submit", "submit");

 	echo $oForm->html;
	require_once("includes/footer.php");
  ?>
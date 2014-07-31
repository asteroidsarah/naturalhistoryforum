<?php 
ob_start();
require_once("includes/model_collection.php");
require_once("includes/view_form.php");
require_once("includes/view.php");
require_once("includes/model_post.php");
require_once("includes/model_topic.php");
require_once("includes/model_thread.php");
session_start();

require_once("includes/header.php");
 ?>
	<div class="topicsBar">
		<h2><a href="index.php">Home</a> > Add new thread</h2>
	</div>

 <?php 
 if(isset($_SESSION["userID"]) == false){
		header("Location:login.php");
		exit;
}

$oForm = new form();

if(isset($_POST["submit"])){
	$oForm->data = $_POST;

	$oForm->checkRequired("threadTitle");

	if($oForm->isValid){
		$oThread = new Thread();
		$oThread->userID = $_SESSION["userID"];
		$oThread->threadTitle = $_POST["threadTitle"];
		$oThread->topicID =$_GET['topicID'];

		$oThread->save();

		header("Location: controller_topicthreads.php?topicID=".$oThread->topicID);
		exit;
	}
}

	$oForm->makeTextInput("Thread title", "threadTitle");
	$oForm->makeSubmit("Submit", "submit");

	echo $oForm->html;

	require_once("includes/footer.php");


  ?>
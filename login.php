<?php 
ob_start();
require_once("includes/view_form.php");
require_once("includes/view.php");
require_once("includes/model_collection.php");
require_once("includes/encoder.php");

session_start();

require_once("includes/header.php");
 ?>
	<div class="topicsBar">
		<h2><a href="index.php">Board index > </a>Login</h2>
	</div>
 <?php 
 	$oForm = new Form();

 	if(isset($_POST["submit"])){

 		$oForm->data = $_POST;

 		$oForm->checkRequired("username");
 		$oForm->checkRequired("password");

 		if($oForm->isValid){
 			$oCollection = new Collection();
 			$oUser = $oCollection->findUserByUsername($_POST["username"]);

 			if($oUser == false){

 				$oForm->raiseCustomError("username", "Incorrect username");
 			} else {
 				$sUserPassword = $oUser->password;

 				if(Encoder::encode($_POST["password"]) != $sUserPassword){
 					$oForm->raiseCustomError("password", "Incorrect password");
 				}

 				if($oForm->isValid){

 					$iUserID = $oUser->userID;
 					$_SESSION["userID"] = $iUserID;

					//now every page can use the value stored in the session array to determine which customer is logged in.
 					
 					header("Location: index.php");
 					exit;
 				}
 			}
 		}
 	}

 	//if validation passes, generate form elements and echo them out
	$oForm->makeTextInput("Username*", "username");
	$oForm->makeTextInput("Password*", "password");
	$oForm->makeSubmit("Login", "submit");

	echo $oForm->html;


require_once("includes/footer.php");

  ?>
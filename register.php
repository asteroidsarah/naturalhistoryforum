<?php 
ob_start();
 define("MAX_SIZE","10000000");
require_once("includes/model_collection.php");
require_once("includes/view_form.php");
require_once("includes/model_user.php");
require_once("includes/encoder.php");

// echo "<pre>";
// print_r($_FILES);
// echo "</pre>";
require_once("includes/header.php");
?>
	<div class="topicsBar">
		<h2><a href="index.php">Board index</a> > Register</h2>
	</div>
<?php

	$oCollection = new Collection();
	$oForm = new Form('registration');

	if(isset($_POST["submit"])){
		$oForm->data = $_POST;
		$oForm->files = $_FILES;

		$oForm->checkRequired("username");
		$oForm->checkRequired("password");
		$oForm->checkRequired("confirm_password");
		$oForm->checkRequired("first_Name");
		$oForm->checkRequired("last_Name");
		$oForm->checkRequired("occupation");
		$oForm->checkRequired("interests");
		$oForm->checkRequired("email");

		$oForm->checkMatching("password", "confirm_password");
		$oForm->checkUpload("photo_path", "image/jpeg", MAX_SIZE);

		//check whether username already exists; if so, raise custom error
		$oUser = $oCollection->findUserByUsername($_POST["username"]);
			if($oUser != false){
				$oForm->raiseCustomError("username", "Sorry, that username already exists! Choose another");
			}
	//if aErrors is empty, validation has passed and we can proceed to saving the customer to the database.
	//Since aErrors is private, we need to use the getter to check whether aErrors is empty.
		if($oForm->isValid){
			$sPhotoName = "avatar".date("Y-m-d-H-i-s").".jpg"; //changes name from upload name, add date to make name unique

			$oUser = new User();
			$oUser->userLevel = 1;

			$oUser->username = $_POST["username"];
			$oUser->password = Encoder::encode($_POST["password"]);
			$oUser->firstName = $_POST["first_Name"];
			$oUser->lastName = $_POST["last_Name"];
			$oUser->occupation = $_POST["occupation"];
			$oUser->interests = $_POST["interests"];
			$oUser->email = $_POST["email"];
			$oUser->avatarPhotopath = $sPhotoName;

			$oForm->moveFile("photo_path", $sPhotoName);


			$oUser->save();

			header("Location: index.php");
			exit;

		}
	}

		$oForm->makeTextInput("Username*", "username");
		$oForm->makeTextInput("Password*", "password");
		$oForm->makeTextInput("Confirm Password*", "confirm_password");	
		$oForm->makeTextInput("First Name*", "first_Name");
		$oForm->makeTextInput("Last Name*", "last_Name");
		$oForm->makeTextInput("Occupation", "occupation");
		$oForm->makeTextInput("Interests", "interests");
		$oForm->makeTextInput("Email*", "email");

		$oForm->makeHiddenField("MAX_FILE_SIZE", MAX_SIZE);
		$oForm->makeUpLoadBox("Choose avatar to upload","photo_path"); 


		$oForm->makeSubmit("Register", "submit");


	 	echo $oForm->html;

require_once("includes/footer.php");

 ?>
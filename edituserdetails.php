<?php 
ob_start();

require_once("includes/view.php");
require_once("includes/model_collection.php");
require_once("includes/view_form.php");
require_once("includes/model_user.php");

session_start();

if(isset($_SESSION["userID"]) == false){
		header("Location:login.php");
		exit;
} //if the user is not logged in, redirect. Otherwise:

//set a variable to the session variable
$iUserID = $_SESSION["userID"];

//make a new user object and load it
$oUser = new User();
$oUser->load($iUserID);

//store the existing form data in an array
$aExistingData = array();
$aExistingData["occupation"] = $oUser->occupation;
$aExistingData["interests"] = $oUser->interests;
$aExistingData["email"] = $oUser->email;


$oForm = new Form();
$oForm->data = $aExistingData; //use the to setter populate the form with the array of data.

//check whether the data is there via being submitted (ie. whether the key "submit" is in the POST array)

if(isset($_POST["submit"])){
	//if so, use the POST data in the form

	//check fields are not empty
	$oForm->checkRequired("occupation");
	$oForm->checkRequired("interests");
	$oForm->checkRequired("email");

	if($oForm->isValid){
		//user setter to set the user info

		$oUser->occupation = $_POST["occupation"];
		$oUser->interests = $_POST["interests"];
		$oUser->email = $_POST["email"];

		$oUser->save();
 		header("Location: userdetails.php");
 		exit;
	}
}

$oForm->makeTextInput("Occupation", "occupation"); 
$oForm->makeTextInput("Interests", "interests"); 
$oForm->makeTextInput("Email", "email");

$oForm->makeSubmit("Submit", "submit");

require_once("includes/header.php");
?>
	<div class="profileBar">
		<h2><a href="index.php">Board index > </a>User profile</h2>
	</div>
<?php
echo $oForm->html;
require_once("includes/footer.php");
 ?>
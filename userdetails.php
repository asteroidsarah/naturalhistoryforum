<?php 
ob_start();
session_start();
require_once("includes/model_user.php");
require_once("includes/view.php");
require_once("includes/header.php");

?>
	<div class="profileBar">
		<h2><a href="index.php">Board index > </a>User profile</h2>
	</div>
<?php
//checks whether a user is logged in. If not (eg. if they try to just get to the details page using a URL), redirect to the login page
if(isset($_SESSION["userID"]) == false){
		header("Location:login.php");
		exit;
}

//load a user corresponding to the CustomerID stored in the SESSION
$oUser = new User();
$oUser->load($_SESSION['userID']);

$oView = new View();
echo $oView->renderUserDetails($oUser);

require_once("includes/footer.php");

 ?>
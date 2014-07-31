<?php 
ob_start();

require_once("includes/view.php");
require_once("includes/model_thread.php");
require_once("includes/model_user.php");
require_once("includes/model_topic.php");
session_start();
//-------for renderPost function
$oView = new View();
$oThread = new Thread();

$iThreadID = 1;
if(isset($_GET["threadID"])){
	$iThreadID = $_GET["threadID"];
}

$oThread->load($iThreadID);
//-----------------------------------


require_once("includes/header.php");
echo $oView->renderThread($oThread);
require_once("includes/footer.php");
 ?>
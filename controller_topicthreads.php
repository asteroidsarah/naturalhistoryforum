<?php 
ob_start();
session_start();
require_once("includes/view.php");
require_once("includes/model_topic.php");
require_once("includes/model_user.php");
require_once("includes/model_thread.php");


//-------for renderPost function
$oView = new View();
$oTopic = new Topic();

$iTopicID = 1;
if(isset($_GET["topicID"])){
	$iTopicID = $_GET["topicID"];
}

$oTopic->load($iTopicID);
//-----------------------------------


require_once("includes/header.php");
echo $oView->renderTopic($oTopic);

require_once("includes/footer.php");





 ?>
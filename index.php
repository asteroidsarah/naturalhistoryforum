<?php 
ob_start();
session_start();
require_once("includes/view.php");
require_once("includes/model_collection.php");
require_once("includes/model_topic.php");

$oView = new View();
$oCollection = new Collection();

//here we get an array of all the topics in the database
$aTopics = $oCollection->getAllTopics();

require_once("includes/header.php");
//here we render out as HTML that array of topics we just got from the database and stored as aTopics
echo $oView->renderIndex($aTopics);
require_once("includes/footer.php");




 ?>
<?php 
require_once("connection.php");

class Post{
	//declare variables
	private $iPostID;
	private $iUserID;
	private $iThreadID;
	private $sPostMessage;
	private $tPostDate;


	//instantiate with constructor
	public function __construct(){

		$this->iPostID = 0;
		$this->iUserID = 0;
		$this->iThreadID = 0;
		$this->sPostMessage = "";
		$this->tPostDate = "";

	}


	//load function to get info from database
	public function load($iID){
		//1.make connection
		$oConnection = new Connection();

		//2.query database
		$sSQL = "SELECT postID, userID, threadID, postMessage, postDate
				FROM tbpost
				WHERE postID=".$iID;

		$oResult = $oConnection->query($sSQL);

		//3.extract data from resultset
		$aPost = $oConnection->fetch_array($oResult); //data from resultset comes out as assoc array which we then use as our values below

		$this->iPostID = $aPost["postID"];
		$this->iUserID = $aPost["userID"];
		$this->iThreadID = $aPost["threadID"];
		$this->sPostMessage = $aPost["postMessage"];
		$this->tPostDate = $aPost["postDate"];


		//4.close connection
		$oConnection->close_connection();
	}


	//save function to insert & update post info into database


	//getter for load private info
	public function __get($var){
		switch ($var) {
			case 'postID':
				return $this->iPostID;
				break;
			case 'userID':
				return $this->iUserID;
				break;
			case 'threadID':
				return $this->iThreadID;
				break;
			case 'postMessage':
				return $this->sPostMessage;
				break;
			case 'postDate':
				return $this->tPostDate;
				break;
			
			default:
				die($var . "does not exist in posts, you need to add it into the getter");
		}

	}


	//setter for save private info
}



// --------TESTING-------------------------------

// Test getter
// $oPost = new Post();

// echo"<pre>";
// print_r($oPost);
// echo $oPost->postID = 1;
// echo $oPost->threadID = 1;
// echo $oPost->postMessage = "hello I am a test";
// echo $oPost->postDate = "1000-01-01 00:00:00";
// echo"</pre>";









 ?>
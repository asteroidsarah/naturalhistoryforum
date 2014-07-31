<?php 
require_once("connection.php");

class Post{
	//declare variables
	private $iPostID;
	private $iUserID;
	private $iThreadID;
	private $sPostMessage;
	private $tPostDate;
	private $iPostActive;
	private $bExisting;


	//instantiate with constructor
	public function __construct(){

		$this->iPostID = 0;
		$this->iUserID = 0;
		$this->iThreadID = 0;
		$this->sPostMessage = "";
		$this->tPostDate = "";
		$this->iPostActive = 0;
		$this->bExisting = false;

	}


	//load function to get info from database
	public function load($iID){
		//1.make connection
		$oConnection = new Connection();

		//2.query database
		$sSQL = "SELECT postID, userID, threadID, postMessage, postDate, postActive
				FROM tbpost
				WHERE postID=".$oConnection->escape_value($iID);

		$oResult = $oConnection->query($sSQL);

		//3.extract data from resultset
		$aPost = $oConnection->fetch_array($oResult); //data from resultset comes out as assoc array which we then use as our values below

		$this->iPostID = $aPost["postID"];
		$this->iUserID = $aPost["userID"];
		$this->iThreadID = $aPost["threadID"];
		$this->sPostMessage = $aPost["postMessage"];
		$this->tPostDate = $aPost["postDate"];
		$this->iPostActive = $aPost["postActive"];

		//4.close connection
		$oConnection->close_connection();

		$this->bExisting = true; //maintaining the flag meaningfully
	}


	//save function to insert & update post info into database
	public function save(){
		//1. Make connection
		$oConnection = new Connection();
		//2. Query database
		if($this->bExisting == false){
			$sSQL = "INSERT INTO tbpost (userID, threadID, postMessage, postActive) 
				VALUES ('".$oConnection->escape_value($this->iUserID)."',
						'".$oConnection->escape_value($this->iThreadID)."',
						'".$oConnection->escape_value($this->sPostMessage)."',
						'".$oConnection->escape_value($this->iPostActive)."')";

			$bResult = $oConnection->query($sSQL);

				if($bResult == true){
					//retrieve the last autoincremented ID (to make php reflect db, since we removed primary key ID from query)
					//$this->iPostID = $oConnection->get_insert_id();
					//here, we modify that previous way of getting the last autoincremented id back out from the database by further using it to load the whole object again from the database, so that last generated values such as timestamp will be reflected back accurately.
					$this->load($oConnection->get_insert_id());
				} else {
					die($sSQL . "fails - check model_post.php");
				}
		} else {
			$sSQL = "UPDATE tbpost
					SET userID =  '".$oConnection->escape_value($this->iUserID)."',
						threadID =  '".$oConnection->escape_value($this->iThreadID)."',
						postMessage =  '".$oConnection->escape_value($this->sPostMessage)."',
						postActive =  '".$oConnection->escape_value($this->iPostActive)."'
					WHERE  tbpost.postID=".$oConnection->escape_value($this->iPostID);

			$bResult = $oConnection->query($sSQL);

				if($bResult == false){
						die($sSQL . "is a failed query in UPDATE");
					}
		}
		//4. Close connection
		$oConnection->close_connection();
	}


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
			case 'postActive':
				return $this->iPostActive;
				break;
			default:
				die($var . "does not exist in posts, you need to add it into the getter");
		}

	}

	//setter for save private info
	public function __set($var, $value){

		switch ($var) {
			case 'userID':
				$this->iUserID = $value;
				break;
			case 'threadID':
				$this->iThreadID = $value;
				break;
			case 'postMessage':
				$this->sPostMessage = $value;
				break;
			// case 'postDate':
			// 	$this->tPostDate = $value;
			// 	break;
			case 'postActive':
				$this->iPostActive = $value;
				break;
			
			default:
				die($var . "can't be set in model_post");
				break;
		}
	}
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
// echo $oPost->postActive = 1;
// echo"</pre>";

//-----------------------TESTING SAVE FUNCTION (INSERT) AND SETTER

// $oPost = new Post(); //create new post

// $oPost->userID = 2;
// $oPost->threadID = 5; //use setter to set values
// $oPost->postMessage = "testing the save function in model_post.php after making thread save function";
// $oPost->postActive = 1;


// $oPost->save(); //save all this new stuff set by the setter to the db :)

// echo "<pre>";
// print_r($oPost);
// echo "</pre>";

//--------------------------TESTING SAVE FUNCTION (UPDATE)

// $oPost = new Post();

// $oPost->load(3);

// //print to check the object has the right properties
// echo "<pre>";
// print_r($oPost); //testing that the getter works
// echo "</pre>";

// //use setter to set values
// $oPost->postMessage = "Testing the update part of save function"; //this will be an update, since the flag was turned to true
// $oPost->save(); //save all this new stuff set by the setter to the db :)
// echo $oPost->postActive;






 ?>
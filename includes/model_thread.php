<?php 
require_once("connection.php");
require_once("model_post.php");

class Thread{
	private $iThreadID;
	private $iUserID;
	private $iTopicID;
	private $sThreadTitle;
	private $tThreadDate;
	private $aThreadPosts;

	public function __construct(){

		$this->iThreadID = 0;
		$this->iUserID = 0;
		$this->iTopicID = 0;
		$this->sThreadTitle = "";
		$this->tThreadDate = "";
		$this->aThreadPosts = array();
	}

	public function load($iID){
		//1.make connection
		$oConnection = new Connection();

		//2.query database
		$sSQL = "SELECT threadID, userID, topicID, threadTitle, threadDate
				FROM tbthread
				WHERE threadID=".$oConnection->escape_value($iID);

		$oResult = $oConnection->query($sSQL);

		//3.extract data from resultset
		$aThread = $oConnection->fetch_array($oResult); //data from resultset comes out as assoc array which we then use as our values below

		$this->iThreadID = $aThread["threadID"];
		$this->iUserID = $aThread["userID"];
		$this->iTopicID = $aThread["topicID"];
		$this->sThreadTitle = $aThread["threadTitle"];
		$this->tThreadDate = $aThread["threadDate"];

			//use a while loop to load all the posts in a thread
			$sSQL = "SELECT postID
					FROM tbpost
					WHERE threadID=".$oConnection->escape_value($iID)." AND postActive = 1 ORDER BY postDate";

			$oResult = $oConnection->query($sSQL);

			while($aRow = $oConnection->fetch_array($oResult)){
				//create new post object
				$oPost = new Post();

				//load the post
				$oPost->load($aRow["postID"]);

				//add it into the array aThreadPosts
				$this->aThreadPosts[] = $oPost;
			}


		//4.close connection
		$oConnection->close_connection();
	}

	//save function to insert thread info into database
	public function save(){
		//1. Make connection
		$oConnection = new Connection();
		//2. Query database
		$sSQL = "INSERT INTO tbthread (userID, topicID, threadTitle)  
				VALUES ('".$oConnection->escape_value($this->iUserID)."',
						'".$oConnection->escape_value($this->iTopicID)."',
						'".$oConnection->escape_value($this->sThreadTitle)."')";

		$bResult = $oConnection->query($sSQL);

		if($bResult == true){
			//retrieve the last autoincremented ID (to make php reflect db, since we removed primary key ID from query)
			//$this->iPostID = $oConnection->get_insert_id();
			//here, we modify that previous way of getting the last autoincremented id back out from the database by further using it to load the whole object again from the database, so that last generated values such as timestamp will be reflected back accurately.
			$this->load($oConnection->get_insert_id());
		} else {
			die($sSQL . "fails - check model_thread.php");
		}
		//4. Close connection
		$oConnection->close_connection();
	}

	public function __get($var){
		switch ($var) {
			case 'threadID':
				return $this->iThreadID;
				break;
			case 'userID':
				return $this->iUserID;
				break;
			case 'topicID':
				return $this->iTopicID;
				break;
			case 'threadTitle':
				return $this->sThreadTitle;
				break;
			case 'threadDate':
				return $this->tThreadDate;
				break;
			case 'threadPosts':
				return $this->aThreadPosts;
				break;
			default:
				die($var . "does not exist in threads, you need to add it into the getter");
		}
	}

	public function __set($var, $value){
		switch ($var) {
			case 'userID':
				$this->iUserID = $value;
				break;
			case 'topicID':
				$this->iTopicID = $value;
				break;
			case 'threadTitle':
				$this->sThreadTitle = $value;
				break;
			default:
				die($var . "can't be set in model_thread");
		}
	}

}

//-------------------------------TESTING

// $oThread = new Thread();
// $oThread->load(1);


// echo "<pre>";
// //return out the list of products for the loaded product type
// print_r($oThread->threadPosts);

// //test out the getter
// echo $oThread->threadTitle;
// echo $oThread->userID;
// echo "</pre>";

//-----------------------TESTING SAVE FUNCTION (INSERT) AND SETTER

// $oThread = new Thread(); //create new thread

// $oThread->userID = 1;
// $oThread->topicID = 1; //use setter to set values
// $oThread->threadTitle = "testing the save function in model_thread.php";


// $oThread->save(); //save all this new stuff set by the setter to the db :)

// echo "<pre>";
// print_r($oThread);
// echo "</pre>";









 ?>
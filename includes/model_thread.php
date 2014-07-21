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
				WHERE threadID=".$iID;

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
					WHERE threadID=".$iID;

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

}

//-------------------------------TESTING

$oThread = new Thread();
$oThread->load(1);


echo "<pre>";
//return out the list of products for the loaded product type
print_r($oThread->threadPosts);

//test out the getter
echo $oThread->threadTitle;
echo $oThread->userID;
echo "</pre>";









 ?>
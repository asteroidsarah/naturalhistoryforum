<?php 

require_once("connection.php");
require_once("model_thread.php");

class Topic{
	private $iTopicID;
	private $sTopicPhotopath;
	private $sTopicTitle;
	private $sTopicSubtitle;
	private $sTopicDescription;
	private $aTopicThreads;

	public function __construct(){
		$this->iTopicID = 0;
		$this->sTopicPhotopath = "";
		$this->sTopicTitle = "";
		$this->sTopicSubtitle = "";
		$this->sTopicDescription = "";
		$this->aTopicThreads = array();


	}

	public function load($iID){
		//1.make connection
		$oConnection = new Connection();

		//2.query database
		$sSQL = "SELECT topicID, topicPhotopath, topicTitle, topicSubtitle, topicDescription
				FROM tbtopic
				WHERE topicID=".$iID;

		$oResult = $oConnection->query($sSQL);

		//3.extract data from resultset
		$aTopic = $oConnection->fetch_array($oResult); //data from resultset comes out as assoc array which we call aTopic. Then use for our values below

		$this->iTopicID = $aTopic["topicID"];
		$this->sTopicPhotopath = $aTopic["topicPhotopath"];
		$this->sTopicTitle = $aTopic["topicTitle"];
		$this->sTopicSubtitle = $aTopic["topicSubtitle"];
		$this->sTopicDescription = $aTopic["topicDescription"];

			//use a while loop to load all the threads in a topic
			$sSQL = "SELECT threadID
					FROM tbthread
					WHERE topicID=".$iID;

			$oResult = $oConnection->query($sSQL);

			while($aRow = $oConnection->fetch_array($oResult)){
				//create new thread object
				$oThread = new Thread();

				//load the thread
				$oThread->load($aRow["threadID"]);

				//add it into the array aTopicThreads
				$this->aTopicThreads[] = $oThread;
			}


		//4.close connection
		$oConnection->close_connection();
	}


	public function __get($var){
		switch ($var) {
			case 'topicID':
				return $this->iTopicID;
				break;
			case 'topicPhotopath':
				return $this->iTopicPhotopath;
				break;
			case 'topicTitle':
				return $this->sTopicTitle;
				break;
			case 'topicSubtitle':
				return $this->sTopicSubtitle;
				break;
			case 'topicDescription':
				return $this->sTopicDescription;
				break;
			case 'topicThreads':
				return $this->aTopicThreads;
			default:
				die($var . "does not exist in topics, you need to add it into the getter");
		}
	}

}

//--------------------TESTING----------

// $oTopic = new Topic();
// $oTopic->load(1);


// echo "<pre>";
// //return out the list of products for the loaded product type
// print_r($oTopic->topicThreads);

// //test out the getter
// echo $oTopic->topicTitle;
// echo $oTopic->topicSubtitle;
// echo "</pre>";




 ?>
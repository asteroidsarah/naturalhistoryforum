<?php 

require_once("connection.php");
require_once("model_topic.php");
require_once("model_user.php");

class Collection{

	//a function to load all topics for use on index page
	public function getAllTopics(){
		//declare an array to load all topics into
		$aTopics = array();

		//1.make connection
		$oConnection = new Connection();

		//2. execute query
		$sSQL = "SELECT topicID FROM tbtopic";

		$oResult = $oConnection->query($sSQL);

		//3. extract data from resultset
		while ($aRow = $oConnection->fetch_array($oResult)){
			//create a new topic object
			$oTopic = new Topic();

			//load it
			$oTopic->load($aRow["topicID"]);

			//add it into the aTopics array
			$aTopics[] = $oTopic;
		}

		//4. close connection
		$oConnection->close_connection();

		return $aTopics;
	}

	public function findUserByUsername($sUsername){
		//this function should return false or a valid user object.
		//can then find use the username to find the userID and load that particular user.
		$aUser = array(); //an array to store the user in, if they are in db

		//1. Make connection
		$oConnection = new Connection();

		//2. Execute query
		$sSQL = 'SELECT userID
				FROM tbuser
				WHERE username="'.$oConnection->escape_value($sUsername).'"';

		$oResult = $oConnection->query($sSQL);
		$aUser = $oConnection->fetch_array($oResult);

		//3. Close connection
		$oConnection->close_connection();

		//So, if the username already exists the above code will add it into the array aUser. If the username does not exist, false is returned.
		if($aUser == true){
			$oUser = new User();
			$oUser->load($aUser["userID"]);

			return $oUser;

		}else{
			return false;
		}
	}


	




}




 ?>
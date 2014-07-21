<?php 

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






}




 ?>
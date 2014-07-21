<?php 
require_once("connection.php");

//only need to make arrays for user threads and posts if you want to echo them out eg. in profile.

class User{
		private $iUserID;
		private $iUserLevel;
		private $sUsername;
		private $sPassword;
		private $sFirstName;
		private $sLastName;
		private $sOccupation;
		private $sInterests;
		private $sAvatarPhotopath;
		private $sEmail;

		public function __construct(){
			$this->iUserID = 0;
			$this->iUserLevel = 0;
			$this->sUsername = "";
			$this->sPassword = "";
			$this->sFirstName = "";
			$this->sLastName = "";
			$this->sOccupation = "";
			$this->sInterests = "";
			$this->sAvatarPhotopath = "";
			$this->sEmail = "";

		}

		public function load($iID){
			//1. make connection
			$oConnection = new Connection();

			//2. query database
			$sSQL = "SELECT userID, userLevel, username, password, firstName, lastName, occupation, interests, avatarPhotopath, email
					FROM tbuser
					WHERE userID=".$iID;

			$oResult = $oConnection->query($sSQL);

			//3. extract data from resultset
			$aUser = $oConnection->fetch_array($oResult);

			$this->iUserID = $aUser["userID"];
			$this->iUserLevel = $aUser["userLevel"];
			$this->sUsername =  $aUser["username"];
			$this->sPassword =  $aUser["password"];
			$this->sFirstName =  $aUser["firstName"];
			$this->sLastName =  $aUser["lastName"];
			$this->sOccupation =  $aUser["occupation"];
			$this->sInterests = $aUser["interests"];
			$this->sAvatarPhotopath =  $aUser["avatarPhotopath"];
			$this->sEmail =  $aUser["email"];


			//4. close connection
			$oConnection->close_connection();

		}

		//getter

		public function __get($var){
			switch ($var) {
				case 'userID':
					return $this->iUserID;
					break;
				case 'userLevel':
					return $this->iUserLevel;
					break;
				case 'username':
					return $this->sUsername;
					break;
				case 'password':
					return $this->sPassword;
					break;
				case 'firstName':
					return $this->sFirstName;
					break;
				case 'lastName':
					return $this->sLastName;
					break;
				case 'occupation':
					return $this->sOccupation;
					break;
				case 'interests':
					return $this->sInterests;
					break;
				case 'avatarPhotopath':
					return $this->sAvatarPhotopath;
					break;
				case 'email':
					return $this->sEmail;
					break;			
				default:
					die($var . "does not exist in users, you need to add it into the getter");

			}
		}
	}
//--------------------TESTING----------

// $oUser = new User();
// $oUser->load(2);


// echo "<pre>";

// //test out the getter
// echo $oUser->username;
// echo $oUser->occupation;
// echo "</pre>";






 ?>
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
		private $bExisting;

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
			$this->bExisting = false;

		}

		public function load($iID){
			//1. make connection
			$oConnection = new Connection();

			//2. query database
			$sSQL = "SELECT userID, userLevel, username, password, firstName, lastName, occupation, interests, avatarPhotopath, email
					FROM tbuser
					WHERE userID=".$oConnection->escape_value($iID);

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

			$this->bExisting = true; //maintaining the flag meaningfully

		}

		public function save(){
			//1. Make connection
			$oConnection = new Connection();
			//2. Query database
			if($this->bExisting == false){
				$sSQL = "INSERT INTO tbuser (userLevel, username, password, firstName, lastName, occupation, interests, avatarPhotopath, email) 
					VALUES ('".$oConnection->escape_value($this->iUserLevel)."',
							'".$oConnection->escape_value($this->sUsername)."',
							'".$oConnection->escape_value($this->sPassword)."', 
							'".$oConnection->escape_value($this->sFirstName)."', 
							'".$oConnection->escape_value($this->sLastName)."', 
							'".$oConnection->escape_value($this->sOccupation)."', 
							'".$oConnection->escape_value($this->sInterests)."', 
							'".$oConnection->escape_value($this->sAvatarPhotopath)."', 
							'".$oConnection->escape_value($this->sEmail)."')";

				$bResult = $oConnection->query($sSQL);

				if($bResult == true){
					//retrieve the last autoincremented id (ie. to make our php accurately reflect the database, since we removed CustomerID from our query in order to prevent anyone overriding the autoincrement)
					$this->iUserID = $oConnection->get_insert_id();
				} else{
					die($sSQL . "fails");
				}
			} else{
				$sSQL = "UPDATE tbuser 
						SET firstName =  '".$oConnection->escape_value($this->sFirstName)."',
							lastName =  '".$oConnection->escape_value($this->sLastName)."',
							occupation =  '".$oConnection->escape_value($this->sOccupation)."',
							interests =  '".$oConnection->escape_value($this->sInterests)."',
							email =  '".$oConnection->escape_value($this->sEmail)."'
						WHERE  tbuser.userID=".$oConnection->escape_value($this->iUserID);

					$bResult = $oConnection->query($sSQL);

					if($bResult == false){
						die($sSQL . "is a failed query in UPDATE");
					}

			}
			//4. Close connection
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


		public function __set($var, $value){
			switch ($var) {
				case 'userLevel':
					$this->iUserLevel = $value;
					break;
				case 'username':
					$this->sUsername = $value;
					break;
				case 'password':
					$this->sPassword = $value;
					break;
				case 'firstName':
					$this->sFirstName = $value;
					break;
				case 'lastName':
					$this->sLastName = $value;
					break;
				case 'occupation':
					$this->sOccupation = $value;
					break;
				case 'interests':
					$this->sInterests = $value;
					break;
				case 'avatarPhotopath':
					$this->sAvatarPhotopath = $value;
					break;
				case 'email':
					$this->sEmail = $value;
					break;			
				default:
					die($var . "can't be set in model_user");
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

//-----------------------TESTING SAVE FUNCTION (INSERT) AND SETTER

// $oUser = new User(); //create new customer

// echo $oUser->userLevel = 1; //use setter to set values
// echo $oUser->username = "testinsertfunction";
// echo $oUser->password = "1";
// echo $oUser->firstName = "test";
// echo $oUser->lastName = "user";
// echo $oUser->occupation = "testing stuff";
// echo $oUser->interests = "testing mroe stuff";
// echo $oUser->avatarPhotopath = "tuatara.jpg";
// echo $oUser->email = "bla@bla.com";

// $oUser->save(); //save all this new stuff set by the setter to the db :)

// echo "<pre>";
// print_r($oUser);
// echo "</pre>";

// //--------------------------TESTING SAVE FUNCTION (UPDATE)

// $oUser = new User();

// $oUser->load(2);

// //print to check the object has the right properties
// echo "<pre>";
// print_r($oUser); //testing that the getter works
// echo "</pre>";

// //use setter to set values
// $oUser->interests = "Testing the update part of save function"; //this will be an update, since the flag was turned to true
// $oUser->save(); //save all this new stuff set by the setter to the db :)
// echo $oUser->username;





 ?>
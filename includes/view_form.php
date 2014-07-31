<?php 
class Form {

		private $sHTML;
		private $aData;
		private $aErrors;
		private $aFiles;

		public function __construct($sID="") {

			$this->sHTML = '<form action="" method="post" enctype="multipart/form-data" id="'.$sID.'">'."\n";
			$this->aData = array();
			$this->aErrors = array();
			$this->aFiles = array();

		}

		// FORM BUILDING FUNCTIONS
		public function makeTextInput($sLabel, $sControlName ) {
			//make data sticky
			$sData = "";
			
			if(isset($this->aData[$sControlName])){
				$sData = $this->aData[$sControlName];
			}

			//get control error
			$sError = "";
			
			if(isset($this->aErrors[$sControlName])){
				$sError = $this->aErrors[$sControlName];
			}

				$this->sHTML .= '<label for="'.$sControlName.'" class= "formLabel">'.$sLabel.'</label>'."\n";
				$this->sHTML .= '<input type="text" id="'.$sControlName.'" name="'.$sControlName.'" value="'.$sData.'" class="formInput"/>';
				$this->sHTML .= '<span class="errorMessage" id="'.$sControlName.'errorMessage">'.$sError.'</span>'."\n";

		}


		public function makeTextArea($sLabelText, $sControlName){
		//make data sticky
		$sData = "";
		//use the controlname as a key. If it's there, extract the data out and save it in sData. Then use sData as default value in sHTML
		if(isset($this->aData[$sControlName])){
			$sData = $this->aData[$sControlName];
		}

		$sError = "";

		if(isset($this->aErrors[$sControlName])){
			$sError = $this->aErrors[$sControlName];
		}

		$this->sHTML .= '<label for="'.$sControlName.'">'.$sLabelText.'</label>
				<textarea id="'.$sControlName.'" name="'.$sControlName.'" rows="20" cols="100">'.$sData.'</textarea>';
		$this->sHTML .= '<span>'.$sError.'</span>'; //add any error messages into the span
		}
		

		public function makeUpLoadBox($sLabelText, $sControlName){
		
	
		//getting control's error
		$sError = "";
		if(isset($this->aErrors[$sControlName])){
			$sError = $this->aErrors[$sControlName];
		}

		$this->sHTML .= '<label for="'.$sControlName.'">'.$sLabelText.'</label>
				<input type="file" id="'.$sControlName.'" name="'.$sControlName.'" />';
		$this->sHTML .='<span>'.$sError.'</span>';
		}
	

		public function makeHiddenField($sControlName, $sValue){
			
			$this->sHTML .= '<input type="hidden" name="'.$sControlName.'" value="'.$sValue.'" />';
		}


		public function makeSubmit($sValue, $sControlName) {

			 $this->sHTML .= '<input type="'.$sControlName.'" name="'.$sControlName.'" value="'.$sValue.'" class="formInput"/>'."\n";

		} 


		//FORM VALIDATION FUNCTIONS
		public function checkRequired($sControlName){
			$sData = "";
		
			if(isset($this->aData[$sControlName])){
				$sData = $this->aData[$sControlName];
			}

			if(trim($sData)==""){
				
				$this->aErrors[$sControlName] = "Must not be empty"; 
			}

		}

		public function checkMatching($sControlName1, $sControlName2){

			$sData1 = "";
			if(isset($this->aData[$sControlName1])){
				$sData1 = $this->aData[$sControlName1];
			}

			$sData2 = "";
			if(isset($this->aData[$sControlName2])){
				$sData2 = $this->aData[$sControlName2];
			}


			if(trim($sData1) != trim($sData2)){
				
				$this->aErrors[$sControlName2] = "Password did not match! Try again. "; 
			}
		}


		public function checkUpload($sControlName, $sMimeType, $iSize){
		
			$sErrorMessage = "";
	
			if(empty($this->aFiles[$sControlName]["name"])){				
				$sErrorMessage = "No files specified";				
			}elseif($this->aFiles[$sControlName]['error'] != UPLOAD_ERR_OK){					
				$sErrorMessage = "File cannot be uploaded";					
			}elseif($this->aFiles[$sControlName]["type"] != $sMimeType){					
				$sErrorMessage = "Only ".  $sMimeType ." format can be uploaded";						
			}elseif($this->aFiles[$sControlName]["size"] > $iSize){				
				$sErrorMessage = "Files cannot exceed ".$iSize." bytes in size";	
			}			
				//if there is any error, Assign error message to aValidationError 
				if ($sErrorMessage != ""){
					$this->aErrors[$sControlName] = $sErrorMessage;
				}
		}

		//-----------moving file function------------------------------------
		public function moveFile($sControlName, $sNewFileName){			
			$newname = dirname(__FILE__).'/../assets/images/'.$sNewFileName;			
			move_uploaded_file($_FILES[$sControlName]['tmp_name'],$newname);		
		}

		public function raiseCustomError($sControlName, $sErrorMessage){
			//can add any error message you pass in into aErrors under any control name
			$this->aErrors[$sControlName] = $sErrorMessage;
		}


		public function __get($var) {

			switch($var) {
				case "html":
					return $this->sHTML . '</form>';
					break;
			case "isValid": //checks whether form is valid (by checking whether there is anything in aErrors).
				if(count($this->aErrors) == 0){
					return true;
				}else{
					return false;
				}
				break;
				default:
				 	die("fails");
				}
		}

		public function __set($var, $value){

			switch ($var) {
			case "data":
				$this->aData = $value; //take the value you're trying to set and put it into the var. No return needed
				break;
			case "files":
		        $this->aFiles = $value;
		        break;
			default:
				die($var . "cannot be set in Form");
			}

		}

	}




 ?>
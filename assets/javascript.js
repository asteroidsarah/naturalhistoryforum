function checkFilled(sInputId){
	var bFilled = false;

	var oInput = document.getElementById(sInputId); //eg firstName, lastName, email
	var sInputValue = oInput.value; //.value extracts the user input

	var oOutputMessage = document.getElementById(sInputId+"errorMessage");
	if (sInputValue.length == 0) {
		oOutputMessage.innerHTML = "Must not be empty";

	} else {

		bFilled = true;

	}

	return bFilled;
}

//use this one to check whether name is valid (only alphabetical characters)
// function checkName(sInputId) {
// 	var bFilled = checkFilled(sInputId);
// 	var bValid = false;

// 	if (bFilled == true) {
// 	var oInput = document.getElementById(sInputId); //eg firstName, lastName, email
// 	var sInputValue = oInput.value; //.value extracts the user input

// 	var oOutputMessage = document.getElementById(sInputId+"Message");
	
// 		//check for valid name
// 		var oRegExp = new RegExp("[^a-zA-Z]");
		
// 		if (oRegExp.test(sInputValue) == false) {

// 			bValid = true;

// 		} else {
// 			oOutputMessage.innerHTML = "Must be alphabetical";
			
// 		}
		
// 	}
// 	return bValid;
// }

function checkEmail(sInputId) {
	var bFilled = checkFilled(sInputId);
	var bValid = false;

	if (bFilled == true) {
	var oInput = document.getElementById(sInputId); //eg firstName, lastName, email
	var sInputValue = oInput.value; //.value extracts the user input

	var oOutputMessage = document.getElementById(sInputId+"errorMessage");

	
		//check for valid email
		var oRegExpEmail = new RegExp("^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$");
		if (oRegExpEmail.test(sInputValue) == true) {
			bValid = true;
		} else {
			oOutputMessage.innerHTML = "Not a valid email";
		}
	}
	return bValid;

}

function checkMatching(sInputID1, sInputID2){
	var bValid = false;
	var bCheckInput1 = checkFilled(sInputID1);
	var bCheckInput2 = checkFilled(sInputID2);

	if((bCheckInput1 == true) && (bCheckInput2 == true)){

		var oInput1 = document.getElementById(sInputID1);
		var oInput1Value = oInput1.value;

		var oInput2 = document.getElementById(sInputID2);
		var oInput2Value = oInput2.value;

		var oOutputMessage = document.getElementById(sInputID2+"errorMessage");

			if(oInput1Value != oInput2Value){
				oOutputMessage.innerHTML = "Passwords do not match";
			} else {
				bValid = true;
			}

	}

	return bValid;
}


function checkAll(){
	var bValidEmail = checkEmail("email");
	var bValidUsername = checkFilled("username");
	var bValidFirstName = checkFilled("first_Name");
	var bValidLastName = checkFilled("last_Name");
	var bValidOccupation = checkFilled("occupation");
	var bValidInterests = checkFilled("interests");
	var bValidPassword = checkMatching("password", "confirm_password");

	var bValid = bValidEmail && bValidUsername && bValidFirstName && bValidLastName && bValidOccupation && bValidInterests && bValidPassword;

	return bValid;
}


document.getElementById('username').onblur = function() {
	checkFilled(this.id); 
}

document.getElementById('first_Name').onblur = function(){
	checkFilled(this.id);
}

document.getElementById('last_Name').onblur = function(){
	checkFilled(this.id);
}

document.getElementById('occupation').onblur = function(){
	checkFilled(this.id);
}

document.getElementById('interests').onblur = function(){
	checkFilled(this.id);
}

document.getElementById('confirm_password').onblur = function(){
	checkMatching('password', this.id);
}


document.getElementById('email').onblur = function(){
	checkEmail(this.id);
}

document.getElementById('registration').onsubmit = function(){
	
	var bCheckAll = checkAll();
	return bCheckAll;
}


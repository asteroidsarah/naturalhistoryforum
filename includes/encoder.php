<?php
class Encoder{

	static public function encode($sPassword){
		$sSalt = hash('sha1', $sPassword."blahblah");
		$sHashedPassword = hash('md5', $sSalt.$sPassword.$sSalt);

		return $sHashedPassword;
	}

}

?>
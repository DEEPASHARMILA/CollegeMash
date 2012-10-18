<?php
/*********************************************************
tokenGenerator

This generates a token that is used for...
-Confirming users email address
-Deciding how many times to hash the password
*********************************************************/
function tokenGenerator($tokenType)
{
  $token = '';
  $tokenArr = array(0,1,2,3,4,5,6,7,8,9,
					'A','B','C','D','E',
					'F','G','H','I','J',
					'K','L','M','N','O',
					'P','Q','R','S','T',
					'U','V','W','X','Y',
					'Z','a','b','c','d',
					'e','f','g','h','i',
					'j','k','l','m','n',
					'o','p','q','r','s',
					't','u','v','w','x',
					'y','z');
  //For Email/Hashing Password
  if($tokenType == 'password'){
	for($i = 0; $i < 21; $i++){
	    $rand = $tokenArr[rand(0, 61)];
	    $token = $token.$rand;
	  }
    return $token;
  }
  //For Image Token
  else if($tokenType == 'image'){
	for($i = 0; $i < 5; $i++){
		$rand = $tokenArr[rand(0,35)];
		$token = $token.$rand;
	}
	return $token;
  }
  else
	echo "ERROR: Invalid token type!";
}
//Test tokenGenerator
//echo tokenGenerator('password');
?>
<?php
/*********************************************************
passwordHash

This hashes a password, and should be used for...
-Registration
-Login
*********************************************************/
function passwordHash($password, $salt)
{
	$salt = '$2a$13$'.$salt;
	$hash = crypt($password, $salt);
	return $hash;
}
?>
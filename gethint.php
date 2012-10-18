<?php
include '/incl/db.php';
$q=$_GET["q"];

//Ensure the email is students.niu.edu
$email = strrev($q);
$email = str_split($email, 16);
$email = strrev($email[0]);
if($email != 'students.niu.edu')
	{
	echo "Sorry but currently collegeMASH is only open to NIU students.<br/>";
	die;
	}
	else
	{
	$college_id = "1";
	}

//Make sure the email address has not already been used.
$query = "SELECT * FROM register WHERE email='".mysql_real_escape_string($q)."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
$emailNum = mysql_num_rows($result);
if($emailNum > 0)
	{
	echo "The email address ".$q." has already been taken, did you receive a confirmation email?<br/>";
	die;
	}

echo "That email address looks perfect!";
mysql_close($db);
?>
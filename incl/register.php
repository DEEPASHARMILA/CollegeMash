<?php
require 'db.php';
include 'func/token.php';
include 'func/pwHash.php';

//Process the form information.
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$cemail = $_POST['cemail'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$passLength = strlen($password);
$gender = $_POST['gender'];
$dobMonth = $_POST['month'];
$dobDay = $_POST['day'];
$dobYear = $_POST['year'];
$error = 0;

//Error handling.
if($fname == "")
	{
	echo "Your first name must not be blank.<br/>";
	$error++;
	}
if($lname == "")
	{
	echo "Your last name must not be blank.<br/>";
	$error++;
	}
if($email == "")
	{
	echo "Your email must not be blank.<br/>";
	$error++;
	}
if($email != $cemail)
	{
	echo "Your email address does not match.</br>";
	$error++;
	}
if($password == "")
	{
	echo "Your password must not be blank.<br/>";
	$error++;
	}
if($password != $cpassword)
	{
	echo "Your passwords don't match.<br/>";
	$error++;
	}
	
if($passLength < 8)
	{
	echo "Sorry your password must be at least 8 characters in length.<br/>";
	$error++;
	}
if($gender == "ERROR"){
	echo "You need to choose a gender.";
	$error++;
	}
//Ensure the email is students.niu.edu
$cemail = strrev($cemail);
$cemail = str_split($cemail, 16);
$cemail = strrev($cemail[0]);
if($cemail != 'students.niu.edu')
	{
	echo "Sorry but currently collegeMASH is only open to NIU students.<br/>";
	$error++;
	}
	else
	{
	$college_id = "1";
	}

//Make sure the email address has not already been used.
$query = "SELECT * FROM register WHERE email='".mysql_real_escape_string($email)."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
$emailNum = mysql_num_rows($result);
if($emailNum > 0)
	{
	echo "The email address ".$email." has already been taken, did you receive a confirmation email?<br/>";
	$error++;
	}
	
if($error > 0)
	{
	if($error > 1)
		{
		echo "Fix the ".$error." errors before proceeding.";
		}
		else
		{
		echo "Fix the ".$error." error before proceeding.";
		}
	die;
	}
//Generate DOB in YYYY-MM-DD
$dob = $dobYear.'-'.$dobMonth.'-'.$dobDay;
$signup = date('Y-m-d');

//Generate registration Token, stored as $token.
$token = tokenGenerator("password");

//Hash the password.
$password = passwordHash($password, $token);

//Insert into REGISTER
$query = "INSERT INTO register (email, token)
		VALUES ('".mysql_real_escape_string($email)."',
				'".mysql_real_escape_string($token)."'
				)";
mysql_query($query, $db) or die(mysql_error($db));

//Get the users ID
$query = "SELECT * FROM register WHERE email='".mysql_real_escape_string($email)."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
$row = mysql_fetch_array($result);
$user_id = $row['user_id'];

//Insert into LOGIN
$query = "INSERT INTO login (user_id, email, password)
		VALUES ('".mysql_real_escape_string($user_id)."',
				'".mysql_real_escape_string($email)."',
				'".mysql_real_escape_string($password)."'
				)";
mysql_query($query, $db) or die(mysql_error($db));

//Insert into BASICINFO
$query = "INSERT INTO basicInfo (user_id, college_id, fname, lname, dob, signup, gender)
		VALUES ('".mysql_real_escape_string($user_id)."',
				'".mysql_real_escape_string($college_id)."',
				'".mysql_real_escape_string($fname)."',
				'".mysql_real_escape_string($lname)."',
				'".mysql_real_escape_string($dob)."',
				'".mysql_real_escape_string($signup)."',
				'".mysql_real_escape_string($gender)."'
				)";
mysql_query($query, $db) or die(mysql_error($db));

//Email the user their token to finish registration.
$to = $email;
$subject = "collegeMash Registration.";
$message = "Hello ".$fname.", thank you for registering on collegeMASH! 
			All we need now is for you to go to http://www.collegemash.net/token.php?user=".$user_id."&token=".$token." After that you should be good to go!";
$headers = "From: validation@collegemash.net";
mail($to, $subject, $message, $headers);

echo "<br/>Registration went well. Check you email to validate you are who you say you are and you can login.";
echo "<br/>Example email message.<br/>".$message;
?>
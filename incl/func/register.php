<?php
//require '/incl/db.php';
//session_start();
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
//$signup = date("Y-m-d"); <- process only after there are no errors found
$error = 0;

/****************************************************
*Basic Error Checking
*
*Just do some basic error checking before letting
*doing anything with the database.
*
*Before the website launches it will be done using
*JavaScript, this is ONLY for testing.
****************************************************/
if($fname == ''){
	$error++;
	echo "Your first name can't be blank.<br/>";
}
if($lname == ''){
	$error++;
	echo "Your last name can't be blank.<br/>";
}
if($email == ''){
	$error++;
	echo "Your email can't be blank.<br/>";
}
if($cemail != $email){
	$error++;
	echo "Your emails do not match.<br/>";
}
if($passLength < 8){
	$error++;
	echo "Your password must be at least 8 characters long.<br/>";
}
if($cpassword != $password){
	$error++;
	echo "Your passwords do not match.<br/>";
}
if($gender == 'ERROR'){
	$error++;
	echo "Please pick a gender.<br/>";
}
if($dobMonth == 'ERROR'){
	$error++;
	echo "Please pick a valid month.<br/>";
}
if($dobDay == 'ERROR'){
	$error++;
	echo "Please pick a valid day.<br/>";
}
if($dobYear == 'ERROR'){
	$error++;
	echo "Please pick a valid year.<br/>";
}

//If there are any errors end the script, don't process any more information.
if($error > 0)
	exit("Please fix your errors.");
	
//Clean up any user defined variables
$fname = mysql_real_escape_string($fname);
$lname = mysql_real_escape_string($lname);
$email = mysql_real_escape_string($email);
$password = mysql_real_escape_string($password);

//Make sure email isn't already in use.

//Make sure the user is old enough?

//Generate tokens and hash password.

//Add user to the database.

//Email them verification shit.
?>
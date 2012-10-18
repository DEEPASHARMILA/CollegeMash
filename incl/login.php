<?php
//Connect to DB
require 'db.php';
include 'func/pwHash.php';

//Set Variables
$email = $_POST['email'];
$password = $_POST['password'];

//Search DB for userful information
$query = "SELECT * FROM login WHERE email='".$email."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
if(mysql_num_rows($result) == 0){
	echo "That email does not exist in our database.";
	die;
	}
$row = mysql_fetch_array($result);
$user_id = $row['user_id'];
$DBpassword = $row['password'];
$isActive = $row['is_active'];

//Get the users registration token
$query = "SELECT * FROM register WHERE user_id='".$user_id."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
$row = mysql_fetch_array($result);
$token = $row['token'];

$password = passwordHash($password, $token);

//Make sure everything matches up
if($password != $DBpassword)
	{
	echo "Sorry but you entered the wrong password. Please try again.<br/>";
	die;
	}
if($isActive != 1)
	{
	echo "Sorry but it looks like you haven't validated your identity. Check your email.<br/>";
	die;
	}

//Let the user in
session_start();
$_SESSION['userid'] = $user_id;

//Set the college_id session
$query = "SELECT * FROM basicinfo WHERE user_id='".$user_id."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
$row = mysql_fetch_array($result);
$college_id = $row['college_id'];
$_SESSION['college_id'] = $college_id;

//Get the users logins from userstats
$query = "SELECT logins FROM userstats WHERE user_id='".$user_id."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
$row = mysql_fetch_array($result);
$logins = $row['logins'];

//Increment
$logins++;

//Activate the user.
mysql_query("UPDATE userstats SET logins = ".$logins." WHERE user_id =".$user_id);

header('Location: ../account.php');
?>
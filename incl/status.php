<?php
session_start();
require 'db.php';

//Process the form information.
$user_id = $_SESSION['userid'];
$college_id = $_SESSION['college_id'];
//Status
$status = htmlspecialchars($_POST['status'], ENT_QUOTES);
$statuslength = strlen($status);
$status_id = $user_id.'-'.time();
$error = 0;

//Error checking status.
	if($statuslength > 420)
		{
		echo "Your status is too long!<br/>";
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

//Add Status
$query = "INSERT INTO status (status_id, user_id, college_id, status)
	VALUES ('$status_id', '$user_id', '$college_id', '".mysql_real_escape_string($status)."')";
mysql_query($query, $db) or die(mysql_error($db));

//Get the users logins from userstats
$query = "SELECT status FROM userstats WHERE user_id='".$user_id."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
$row = mysql_fetch_array($result);
$status = $row['status'];

//Increment
$status++;

//Activate the user.
mysql_query("UPDATE userstats SET status = ".$status." WHERE user_id =".$user_id);
header('Location: ../account.php');
?>
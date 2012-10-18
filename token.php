<?php
//Connect to DB
require 'incl/db.php';

//Set Variables
$token = $_GET["token"];
$user_id = $_GET["user"];

//Check Token
//EXAMPLE URL token.php?user=1&token=6831312639
$query = "SELECT * FROM register WHERE user_id=".$user_id;
$result = mysql_query($query, $db) or die(mysql_error($db));
	$row = mysql_fetch_array($result);
	if($token != $row['token'])
		{
		echo "Invalid token.";
		die;
		}
		
//Activate the user.
mysql_query("UPDATE login SET is_active = '1' WHERE user_id =".$user_id);

//Insert into userstats, they get 10 points for finishing up registration.
$query = "INSERT INTO userstats (user_id, points)
		VALUES ('".mysql_real_escape_string($user_id)."',
				'10'
				)";
mysql_query($query, $db) or die(mysql_error($db));
//NEEDS TO REDIRECT ON SUCCESS
?>
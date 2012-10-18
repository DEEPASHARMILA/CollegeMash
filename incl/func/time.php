<?php
/********************************************************
timeOnline

Tracks how much time the user has been online this session.
********************************************************/
function timeOnline(){
	if(isset($_SESSION['startTime'])){
		$time = time();
		$_SESSION['time'] = $time - $_SESSION['startTime'];
		/* CURRENTLY GIVES WARNINGS AND WORKS ON AND OFF... */
		if($_SESSION['time'] > 60){
			insertTime();
			//Set the time again.
			$time = time();
			$_SESSION['time'] = 0;
			$_SESSION['startTime'] = $time;
		}
	}
	else{
		$time = time();
		$_SESSION['time'] = 0;
		$_SESSION['startTime'] = $time;
	}
}
/********************************************************
printTime

Displays how long the user has been logged in.
********************************************************/
function printTime(){
	$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die ('Our hamsters that power the servers seem to be taking a break.');
	mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$query = "SELECT timeOnline FROM userstats WHERE user_id='".$_SESSION['userid']."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
$row = mysql_fetch_array($result);
echo formatTime($row['timeOnline'], 'NaS').' online!';
}

/********************************************************
insertTime

Insert updated time into DB.
********************************************************/
function insertTime(){
//Get the users timeOnline from userstats
//include '/../db.php';
$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die ('Our hamsters that power the servers seem to be taking a break.');
	mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
$query = "SELECT timeOnline FROM userstats WHERE user_id='".$_SESSION['userid']."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
$row = mysql_fetch_array($result);
$time = $row['timeOnline'];

//Increment
$time += $_SESSION['time'];

//Activate the user.
mysql_query("UPDATE userstats SET timeOnline = ".$time." WHERE user_id =".$_SESSION['userid']);
}

/********************************************************
formattime

Takes the time from the database and lets the user how
long ago the entry was made to the database.

Example, a message was sent 2 days ago instead of giving
the actual date.

Returns $time.
********************************************************/
function formatTime($time, $type)
{
	if($type == 'string'){/*If it needs to be converted to seconds.*/
	$time = strtotime($time);
	$time = time() - $time;
	}/*If it is already in seconds, do nothing.*/
	
	//Seconds
	if($time < 60)
		{
		if($time == 1)
			$time = $time.' second ';
		else
			$time = $time.' seconds ';
		}
	//Minutes
	if($time >= 60 && $time < 3600)
		{
		$time = $time / 60;
		if(round($time) == 1)
			$time = round($time).' minute ';
		else
			$time = round($time).' minutes ';
		}
	//Hours
	if($time >= 3600 && $time < 86400)
		{
		$time = $time / 60 / 60;
		if(round($time) == 1)
			$time = round($time).' hour ';
		else
			$time = round($time).' hours ';
		}
	//Days
	if($time >= 86400 && $time < 604800)
		{
		$time = $time / 60 / 60 / 24;
		if(round($time) == 1)
			$time = round($time).' day ';
		else
			$time = round($time).' days ';
		}
	//Weeks
	if($time >= 604800 && $time < 2592000)
		{
		$time = $time / 60 / 60 / 24 / 7;
		if(round($time) == 1)
			$time = round($time).' week ';
		else
			$time = round($time).' weeks ';
		}
	//Months
	if($time >= 2592000)
		{
		$time = $time / 60 / 60 / 24 / 30;
		if(round($time) == 1)
			$time = '1 month ago.';
		else
			$time = round($time).' months ';
		}
return $time;
}
?>
<?php
/********************************************************
List of Functions

passwordHash
tokenGenerator
notifications - DB INFO
formatTime - EDIT
setProfile
********************************************************/

/********************************************************
DB Connection

Establish a connection to the database.
********************************************************/
function databaseConnect()
{
define('MYSQL_HOST','localhost');
define('MYSQL_USER','snuser');
define('MYSQL_PASSWORD','password');
define('MYSQL_DB','socialnetwork');

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die ('Our hamsters that power the servers seem to be taking a break.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
}

/*********************************************************
passwordHash

This hashes a password, and should be used for...
-Registration
-Login
*********************************************************/
function passwordHash($password)
{
  $counter = 9999; //DB defined number
  //Salt the password first
  
  //Hash password many times
  for($i = 0; $i < $counter; $i++)
  {
    $password = hash("sha512", $password);
	echo $password.'<br/>';
  }  
}
//Test passwordHash
//passwordHash("something");

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
					'Z');
  //For Email Verification
  if($tokenType == 'email')
  {
    for($i = 0; $i < 10; $i++)
      {
	    $rand = $tokenArr[rand(0, 35)];
	    $token = $token.$rand;
	  }
    echo $token.'<br/>';
  }
  //For Hashing Password
  if($tokenType == 'hash')
  {
    $token = 1;
    for($i = 0; $i < 4; $i++)
      {
	    $rand = $tokenArr[rand(0, 9)];
	    $token = $token.$rand;
	  }
    echo $token;
  }
}
//Test tokenGenerator
tokenGenerator('hash');

/********************************************************
notifications

This function will get notifications and display them.
********************************************************/
function notifications($userID)
{
  //Check for new messages
  $query = "SELECT * FROM message WHERE recipient_id = '".$userID."' AND status = 0";
  $result = mysql_query($query, $db) or die(mysql_error($db));
  $messageNum = mysql_num_rows($result);
  if($messageNum > 0)
	$message = '<a title="New Messages!" href="messages.php"><img src="img/newmsg.png" /></a>';
  else
	$message = '<a title="No New Messages, Sucks To Suck" href="messages.php"><img src="img/readmsg.png" /></a>';
}

/********************************************************
formatTime

Takes the time from the database and lets the user how
long ago the entry was made to the database.

Example, a message was sent 2 days ago instead of giving
the actual date.

This will likely need to be edited.
********************************************************/
function formatTime($time)
{
	//Set Time
	$time = strtotime($row['time']);
	$time = time() - $time;
	//Seconds
	if($time < 60)
		{
		if($time == 1)
			$Time = $time.' second ago.';
		else
			$Time = $time.' seconds ago.';
		}
	//Minutes
	if($time >= 60 && $time < 3600)
		{
		$time = $time / 60;
		if(round($time) == 1)
			$Time = round($time).' minute ago';
		else
			$Time = round($time).' minutes ago.';
		}
	//Hours
	if($time >= 3600 && $time < 86400)
		{
		$time = $time / 60 / 60;
		if(round($time) == 1)
			$Time = round($time).' hour ago.';
		else
			$Time = round($time).' hours ago.';
		}
	//Days
	if($time >= 86400 && $time < 604800)
		{
		$time = $time / 60 / 60 / 24;
		if(round($time) == 1)
			$Time = round($time).' day ago.';
		else
			$Time = round($time).' days ago.';
		}
	//Weeks
	if($time >= 604800)
		{
		$time = $time / 60 / 60 / 24 / 7;
		if(round($time) == 1)
			$Time = round($time).' week ago.';
		else
			$Time = round($time).' weeks ago.';
		}	
}

/********************************************************
setProfile

Set up the variables that are used on the users profile.
********************************************************/
function setProfile($userID){
//QUERY
$query = "SELECT * FROM userinfo WHERE user_id='".$profileid."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
$row = mysql_fetch_array($result);

//START DECLARING
$fname = $row['fname'];
$lname = $row['lname'];
$about = nl2br($row['about']);
$profilepic = $row['profilepic'];
$relationship = $row['relationship'];
$sex = $row['sex'];
$name = $row['name'];
$dob = $row['dob'];
$signup = $row['signup'];

//Set Sex To He/She Him/Her Etc... CHANGE TO SWITCH STATEMENT
if($sex == 0)
	{
	$gender = "Unknown";
	}
if($sex == 1)
	{
	$gender = "Male";
	}
if($sex == 2)
	{
	$gender = "Female";
	}

//Set Relationship To Something Meaningful
if($relationship == 1)
	$relationship = "Single";
if($relationship == 2)
	$relationship == "It's Complicated";
if($relationship == 3)
	$relationship == "In a Relationship";
if($relationship == 4)
	$relationship == "Married";
if($relationship == 5)
	$realtionship == "Divorced";

}










?>
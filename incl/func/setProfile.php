<?php
/********************************************************
setProfile

Set up the variables that are used on the users profile.
********************************************************/
function setProfile($userID){
//QUERY
$query = "SELECT * FROM basicInfo WHERE user_id='".$userID."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
$row = mysql_fetch_array($result);

//START DECLARING
$fname = $row['fname'];
$lname = $row['lname'];
$about = nl2br($row['about']);
$profilepic = $row['profilepic'];
$dbRelationship = $row['relationship'];
$dbGender = $row['gender'];
$name = $row['name'];
$dob = $row['dob'];
$signup = $row['signup'];

//Set Sex To He/She Him/Her Etc... CHANGE TO SWITCH STATEMENT
if($dbGender == 0)
	{
	$gender = "Unknown";
	}
if($dbGender == 1)
	{
	$gender = "Male";
	}
if($dbGender == 2)
	{
	$gender = "Female";
	}

//Set Relationship To Something Meaningful
if($dbRelationship == 1)
	$relationship = "Single";
if($dbRelationship == 2)
	$relationship == "It's Complicated";
if($dbRelationship == 3)
	$relationship == "In a Relationship";
if($dbRelationship == 4)
	$relationship == "Married";
if($dbRelationship == 5)
	$realtionship == "Divorced";

}
?>
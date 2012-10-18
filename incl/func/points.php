<?php
/********************************************************
points

Adds points to the userPoints table and updates totals.
********************************************************/
function points($userID, $points){
//QUERY
$query = "SELECT * FROM userPoints WHERE user_id='".$userID."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
$row = mysql_fetch_array($result);
$currentPoints = $points + $row['user_points'];

//$points = $points + $currentPoints;

//UPDATE
$query = "UPDATE userPoints SET user_points ='".$currentPoints."' WHERE user_id='".$userID."'";
$result = mysql_query($query, $db) or die(mysql_error($db));


}

/********************************************************
getPoints

Queries the pointAmount database based on the name of
the points and returns the point amount.
********************************************************/
function getPoints($pointName){
$query = "SELECT * FROM pointAmount WHERE point_name='".$pointName."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
$row = mysql_fetch_array($result);
$points = $row['point_amt'];
return $points;
}
?>
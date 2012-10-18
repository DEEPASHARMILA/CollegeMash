<?php
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
?>
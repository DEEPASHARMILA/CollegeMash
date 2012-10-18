<?php
session_start();
date_default_timezone_set('America/Chicago');
//echo $_SESSION['userid'];
include '/incl/html_codes.php';
include '/incl/db.php';
include '/incl/func/time.php';
timeOnline();
?>
<html lang="en">
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<title>collegeMash</title>
	<link rel=stylesheet href="css/main.css">
	<link rel=stylesheet href="css/forms.css">
	<link rel=stylesheet href="css/account.css">
	
<!--JavaScript Fun! -->
<script type="text/javascript">
	function textCounter(field,cntfield,maxlimit) {
	if (field.value.length > maxlimit) // if too long...trim it!
		field.value = field.value.substring(0, maxlimit);
	// otherwise, update 'characters left' counter
	else
		cntfield.value = maxlimit - field.value.length;
	}
</script>

</head> 
<body>
<header id="main_header">
	<div id="wrapper">
		<div id="rightAlign">
		<form action="profile.php" method="post">
		<table class="search">
		<tr>
			<td><input type="text" name="search" class="input" value="Search" /></td>
			<td><input type="image" name="searchButton" src="img/search.png" class="sButton"/></td>
		</tr>
		</table>
		</form>
		</div>
		<a href="index.php"><img height="55px" alt="CloneBook" src="img/logo.png"></a>
</header>
	</div>
<div id="wrapper">
<?php //header_code(); ?>
	<aside id="left_side">
	<div id="wall">
	<h4>Navigation</h4>
	<p class="nav">Events</p><hr/>
	<p class="nav">Question & Answer</p><hr/>
	<p class="nav">Friend Finder</p>
	</div>
	<div id="wall">
	<h4>Account Management</h4>
	<p class="nav"><a href="edit.php">Edit Profile</a></p><hr/>
	<p class="nav">Privacy Settings</p><hr/>
	<p class="nav">Edit Friends</p><hr/>
	<p class="nav"><?php printTime(); ?></p>
	</div>
	</aside>
	<div id="right_side">
		<div id="wall">
			<table>
			<tr>
			<form name="statusUpdate" action="incl/status.php" method="post">
			<td><textarea name="status" rows="3" cols="80"
				onKeyDown="textCounter(document.statusUpdate.status,document.statusUpdate.remLen,420)"
				onKeyUp="textCounter(document.statusUpdate.status,document.statuUpdate,remLen,420)"
				></textarea>
				<br/>
				<input readonly type="text" name="remLen" size="3" maxlength="3" value="420">
				characters left</td>
			<td><input type="submit" value="Share" class="button"></td>
			</form>
			</tr>
			</table>
		</div>
		<?php
		//Get Status'
		$query = "SELECT * FROM status WHERE college_id = '".$_SESSION['college_id']."' ORDER BY time DESC";
		$result = mysql_query($query, $db) or die(mysql_error($db));
		$counter = 0;
		$adCounter = 3;
		while($row = mysql_fetch_array($result)){
			$user_id = $row['user_id'];
			$status = $row['status'];
			//Set Time
			$time = formatTime($row['time'], 'string').' ago.';
			
			$qury = "SELECT * FROM basicinfo WHERE user_id = '".$user_id."'";
			$rsult = mysql_query($qury, $db) or die(mysql_error($db));
			$row = mysql_fetch_array($rsult);
			$name = $row['fname'].' '.$row['lname'];
			$profilepic = $row['profilepic'];
			if($counter < $adCounter){
				echo '<div id="wall">
						<p class="floatLeft"><img width="35px" src="img/test-profile.png"></p>
						<p class="username">'.$name.'</p>
						<p class="time">'.$time.'</p>
						<hr/>
						<p class="wallText">'.$status.'</p>
					  </div>';
					$counter++;
			}else{
				echo '<div id="wall">
					<p class="username">Sponsor</p>
					<p><img src="img/728-advertisement.png"></p>
				</div>';
				$counter = 0;
				$adCounter *= 1.5;
			}
			}
		?>
	</div>
</div>
	<div id="main_footer"> 
		<?php footer_code(); ?>
	</div> 
</div>
</div>
</body> 
</html>
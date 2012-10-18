<?php
include '/incl/html_codes.php';
include '/incl/func/time.php';
include '/incl/db.php';
timeOnline();
$profileID = $_GET['id'];

		//Get BasicInfo
		$query = "SELECT * FROM basicInfo WHERE user_id = '".$profileID."'";
		$result = mysql_query($query, $db) or die(mysql_error($db));
		$row = mysql_fetch_array($result);
			$name = $row['fname'].' '.$row['lname'];
			$major = $row['major_id'];
			$college = $row['college_id'];
			$dob = $row['dob'];
			$relationship = $row['relationship'];
			$profilepic = $row['profilepic'];
			$about = $row['about'];
			$gender = $row['gender'];
?>
<html lang="en">
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<title><?php echo $name.' - '.$college;?></title>
	<link rel=stylesheet href="css/main.css">
	<link rel=stylesheet href="css/forms.css">
	<link rel=stylesheet href="css/profile.css">
</head> 
<body>
<div id="header">
	<form action="profile.php" method="post">
	<table class="search">
		<tr>
			<td width="105px"><input type="text" name="search" class="input" value="Search" /></td>
			<td><input type="image" name="login" src="img/search.png" class="sButton"/></td>
		</tr>
	</table>
	</form>
</div>
<div id="wrapper">
<?php //header_code(); ?>
	<div id="userInfo">
		<h4 class="profileName">Cody Engel</h4>
		<img class="profilePic" width="150px" src="img/profile/<?php echo $profilepic;?>">
		<input type="submit" name="addfriend" value="Add Friend" class="topButton"/>
		<input type="submit" name="block" value="Block" class="topButton"/>
		<p class="info">
			<?php echo "Studying ".$major." at ".$college; ?>
		</p>
		<p class="info">Lives in DeKalb, IL (Needs To Be Added To DB)</p>
		<p class="info">
			<?php echo $relationship; ?> (Single and currently looking.)
		</p>
		<p class="info"></p>
		<?php
		for($i = 0; $i < 5; $i++)
			echo '<img src="img/test-profile.png" class="recentPicture"> ';
		?>
	</div>
	<aside id="left_side">
	<?php
		//Get Status'
		$query = "SELECT * FROM status WHERE user_id = '".$profileID."' ORDER BY time DESC";
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
						<p class="floatLeft"><img width="35px" src="img/profile/'.$profilepic.'"></p>
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
	</aside>
	<section id="right_side">
		<div id="wall">
			<table>
			<tr>
			<form>
			<td><textarea rows="5" cols="40">Hey what's up?</textarea></td>
			<td><input type="submit" value="Message" class="button"></td>
			</form>
			</tr>
			</table>
		</div>
		<div id="wall">
		<h4>Friends</h4>
		<hr/>
		<table>
		 <tr>
			<td>
			<p class="floatLeft"><img width="55px" height="45" src="img/test-profile.png"></p>
			<p class="username">Some Stalker</p>
			<p class="time">2 Mutual Friends</p>
			<p class="wallText">Add Friend</p>
			</td>
			<td>
			<p class="floatLeft"><img width="55px" height="45" src="img/test-profile.png"></p>
			<p class="username">Cody The Second</p>
			<p class="time">4 Mutual Friends</p>
			<p class="wallText">Add Friend</p>
			</td>
		 <tr>
		 <tr>
			<td>
			<p class="floatLeft"><img width="55px" height="45" src="img/test-profile.png"></p>
			<p class="username">Some Stalker</p>
			<p class="time">2 Mutual Friends</p>
			<p class="wallText">Add Friend</p>
			</td>
			<td>
			<p class="floatLeft"><img width="55px" height="45" src="img/test-profile.png"></p>
			<p class="username">Cody The Second</p>
			<p class="time">4 Mutual Friends</p>
			<p class="wallText">Add Friend</p>
			</td>
		 <tr>
		</table>
		</div>
		<div id="wall">
			<p class="username">Sponsor</p>
			<p><img src="img/468-advertisement.png"></p>
		</div>
		<div id="wall">
		<h4>Trophies</h4>
		<hr/>
		<table>
		 <tr>
			<td>
			<p class="floatLeft"><img width="55px" height="45" src="img/trophy.png"></p>
			<p class="username">Staff Trophy</p>
			<p class="time">Unlocked 3 days ago.</p>
			<p class="wallText">Work at collegeMash</p>
			</td>
			<td>
			<p class="floatLeft"><img width="55px" height="45" src="img/trophy.png"></p>
			<p class="username">Login Noob</p>
			<p class="time">Unlocked 20 minutes ago.</p>
			<p class="wallText">Log into collegeMash 5 times.</p>
			</td>
		 <tr>
		</table>
		</div>
	</section>
</div>
	<div id="main_footer"> 
		<?php footer_code(); ?>
	</div> 
</div>
<?php
//Measure Time To Load Script
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
//Start of actual script.
for($i = 0, $num = 3; $i <= $num; $i++){
	if($num > 100)
		break;
	else if($i != $num){
		echo "not an advertisement :(<br/>";
	}
	else{
		echo "ADVERTISEMENT!<br/>";
		$num *= 2;
		$i = 0;
	}
}
//How Long It Took To Generate Script
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Script generated in '.$total_time.' seconds.';
?>
</div>
</body> 
</html>
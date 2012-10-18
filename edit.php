<?php
session_start();
if($_SESSION['userid'] == 0)
	{
	echo "You must be logged in to access this page.";
	die;
	}
include '/incl/db.php';
include '/incl/html_codes.php';
include '/incl/func/time.php';
timeOnline();
//Set session variables
$userID = $_SESSION['userid'];
$college_id = $_SESSION['college_id'];

//Search USER INFO for userful information
$query = "SELECT * FROM basicinfo WHERE user_id='".$userID."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
$row = mysql_fetch_array($result);
//Declare variables
$fname = $row['fname'];
$lname = $row['lname'];
$major = $row['major_id'];
$about = $row['about'];
$relationship = $row['relationship'];

//Drop down list of majors
$query = "SELECT * FROM major WHERE college_id = '".$college_id."'";
$result = mysql_query($query, $db) or die(mysql_error($db));
$majoroptions = "";
while($row = mysql_fetch_array($result)){
	$id = $row['major_id'];
	$major = $row['major'];
	$majoroptions .="<option value=\"$id\">".$major;
}
?>
<html lang="en">
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<title>collegeMash | <?php echo $fname.' '.$lname;?></title>
	<link rel=stylesheet href="css/main.css">
	<link rel=stylesheet href="css/forms.css">
	<link rel=stylesheet href="css/account.css">
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
		<h2>Control Panel v1</h2>
		<h3>Profile Picture</h3>
		<form action="upload.php" method="post" enctype="multipart/form-data">
		   <table>
			<tr>
			 <td>Upload Image:
			 <input type="file" name="uploadfile" /><br/>
			  <small><em>Image Must Be A JPG or JPEG!
			   </em></small>
			 </td>
			 <td style="text-align: center">
			  <input type="submit" name="submit" value="Upload"/>
			 </td>
			</tr>
		   </table>
		  </form>
		<h3>Profile Information</h2>
		<table>
		<form action="update.php" method="post">
		<tr>
			<td>Major:</td>
			<td>
			<select name = "major">
			<option value = "0">Choose A Major</option>
			$majoroptions
			</select>
			</td>
		</tr>
		<tr>
			<td>Relationship Status:</td>
			<td>
			<select name = "relationship">
			<option value = "ERROR">Choose Relationship</option>
			<option value = "1">Single</option>
			<option value = "2">It's Complicated</option>
			<option value = "3">In a Relationship</option>
			<option value = "4">Married</option>
			<option value = "5">Divorced</option>
			</select>
			</td>
		</tr>
		<tr>
			<td>First Name:</td>
			<td><textarea name="fname" cols="40" rows="1" /><?php echo $fname; ?></textarea></td>
		</tr>
		<tr>
			<td>Last Name:</td>
			<td><textarea name="lname" cols="40" rows="1" /><?php echo $lname; ?></textarea></td>
		</tr>
		<tr>
			<td>About You:<br/><sub><b><font color="red">5,000 Character Limit!</font></sub></td>
			<td><textarea name="about" cols="40" rows="5" /><?php echo $about; ?></textarea></td>
		</tr>
		<tr>
			<td>Gender:</td>
			<td>
			<select name = "sex">
			<option value = "ERROR">What Gender Are You?</option>
			<option value = "1">Male</option>
			<option value = "2">Female</option>
			</select>
			</td>
		</tr>
		<tr>
		<td></td>
		<td><input type="submit" name="update" value="Update" /></td>
		</tr>
		</form>
		</table>
		</div><!--End of white background-->
	</div>
</div>
<div id="main_footer"> 
	<?php footer_code(); ?>
</div> 
</div>
</body> 
</html>
<?php
session_start();
session_destroy();
include '/incl/html_codes.php';

function yearFill($numYears){
	$currentYear = date('Y')-18; //Must be 18 to register!
	$years = array();
	for($i = 0; $i < $numYears; $i++){
		$years[$i] = $currentYear;
		$currentYear--;
		}
	return $years;
}

function dateFill($numDates){
	$date = array();
	for($i = 0; $i < $numDates ; $i++)
		$date[$i] = $i+1;
	return $date;
}
?>

<!DOCTYPE html>
<html lang="en"> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<title>Welcome to collegeMash!</title>
	<link rel=stylesheet href="css/main.css">
	<link rel=stylesheet href="css/forms.css">
	<link rel=stylesheet href="css/register.css">
	
<!--JavaScript Stuff!-->
<script type="text/javascript">
	function checkEmail(str)
	{
	if (str.length==0)
	  { 
	  document.getElementById("txtHint").innerHTML="";
	  return;
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("checkEmail").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","incl/ajax/checkEmail.php?q="+str,true);
	xmlhttp.send();
	}
	
	function compareEmail() {
    var email = document.register.email.value;
	var cemail = document.register.cemail.value;
	if(email != cemail)
		document.getElementById("compareEmail").innerHTML="Your email doesn't match.";
	else
		document.getElementById("compareEmail").innerHTML="";
	}
	
	function comparePassword() {
    var password = document.register.password.value;
	var cpassword = document.register.cpassword.value;
	if(password != cpassword){
		document.getElementById("comparePassword").innerHTML="Your password doesn't match.";
		document.getElementById("comparePassword2").innerHTML="Your password match.";
		}
	else{
		document.getElementById("comparePassword").innerHTML="";
		document.getElementById("comparePassword2").innerHTML="";
		}
	}
</script>
<!--End of JavaScript Stuff!-->
</head> 
<body>
	<header id="main_header">
	<div id="wrapper">
			<div id="rightAlign">
			<form action="incl/login.php" method="post">
			<table align="bottom">
			<tr height="15px"><!--Stupid Fix--></tr>
			<tr>
				<td><h5>Email</h4></td>
				<td><input style="height:20px"; type="text" name="email"/></td>
				<td><h5>Password</h4></td>
				<td><input style="height:20px"; type="password" name="password"/></td>
				<td align="right" colspan="2"><input type="submit" name="login" value="Login" class="button"/></td>
			</tr>
			</table>
			</form>
			</div>
		<a href="index.php"><img height="55px" alt="CloneBook" src="img/logo.png"></a>
		</header>
	<div><!--End of Wrapper-->
<div id="wrapper">
	<aside id="left_side">
		<img src="img/home_left.png">
	</aside>
	<section id="right_side">
	<div id="generalForm">
	<h3>Register</h3>
		<form name="register" action="incl/register.php" method="post">
		<table>
			<tr>
				<td width="100px"><h4>First Name:</h4></td>
				<td><input type="text" name="fname" class="input"/></td>
			</tr>
			<tr>
				<td><h4>Last Name:</h4></td>
				<td><input type="text" name="lname" class="input"/></td>
			</tr>
			<tr>
				<td><h4>Your Email:</h4></td>
				<td><input type="text" name="email" onchange="checkEmail(this.value)" class="input" />
				<p><span id="checkEmail"></span></p></td>
			</tr>
			<tr>
				<td><h4>Confirm Email:</h4></td>
				<td><input type="text" name="cemail" onchange="compareEmail()" class="input"/>
				<p><span id="compareEmail"></span></p></td>
			</tr>
			<tr>
				<td><h4>Password:</h4></td>
				<td><input type="password" name="password" class="input"/>
				<p><span id="comparePassword"></span></p></td>
			</tr>
			<tr>
				<td><h4>Confirm Password:</h4></td>
				<td><input type="password" name="cpassword" onchange="comparePassword()" class="input"/>
				<p><span id="comparePassword2"></span></p></td>
			</tr>
			<tr>
			<td><h4>I am:</h4></td>
			<td>
			<select name="gender" class="gender">
			<option value="ERROR">Select Gender</option>
			<option value="01">A Guy</option>
			<option value="02">A Girl</option>
			</select>
			</td>
			</tr>
			<tr>
				<td><h4>Date&nbspof&nbspBirth:</h4></td>
				<td>				
					<?php
					$month = dateFill(12);
					echo '<select name="month" class="dates"><option value="ERROR">Month</option>';
					for($i = 0; $i < 12; $i++)
						echo '<option value="'.$month[$i].'">'.$month[$i].'</option>';
					echo '</select>';

					$day = dateFill(31);
					echo '<select name="day" class="dates"><option value="ERROR">Day</option>';
					for($i = 0; $i < 31; $i++)
						echo '<option value="'.$day[$i].'">'.$day[$i].'</option>';
					echo '</select>';

					$years = yearFill(122);
					echo '<select name="year" class="dates"><option value="ERROR">Year</option>';
					for($i = 0; $i < 122; $i++)
						echo '<option value="'.$years[$i].'">'.$years[$i].'</option>';
					echo '</select>';
					?>
			</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="register" value="Sign Up" class="button"/></td>
			</tr>
		</table>
		</form>
		</div>
	</section>
</div>
	<div id="main_footer"> 
		<?php footer_code(); ?>
		<h2>Test Stuff</h2>
		
	</div> 
</div> 
</body> 
</html>
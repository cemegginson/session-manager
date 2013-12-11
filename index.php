<?php
session_start();

if(!$_SESSION['uname']){
    header("Location: http://localhost/login.php");
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8">
		<title>COTO Cisco Networking Academy</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div id="container">
			<h2 class="centered">College of the Ouachitas</h2>
			<h3 class="centered">Local Cisco Networking Academy</h3>
			<p>
				<div id="links">CNWT 1434 <a href="http://cisco.coto.edu:8080/cisco1">Exploratory 1 - Network Fundamentals</a><br /><br />
					CNWT 1444 <a href="http://cisco.coto.edu:8080/cisco2">Exploratory 2 - Routing Protocols and Concepts</a><br /><br />
					CNWT 1436 <a href="http://cisco.coto.edu:8080/cisco3">Exploratory 3 - LAN Switching and Wireless</a><br /><br />
					<a href="http://cisco.coto.edu:8080/cisco4">Exploratory 4 - Accessing the WAN</a><br /><br />
				</div>
				Instructors: <br />
				Adrian Ashley, Chair<br />
				Applied Science Technology<br />
				(501) 332-0262<br />
				<a href="aashley@coto.edu">aashley@coto.edu</a><br /><br />

				Susan Bailey, Instructor<br />
				Applied Science Technology/ Computer Information Systems<br />
				(501) 332-0266<br />
				<a href="mailto:sebailey@coto.edu">sebailey@coto.edu</a><br /><br />
				<a href="changepass.php">Change Password</a>
				<?php
				if($_SESSION['class'] == 0){
				    echo "<a href=\"manageuser.php\">Manage Users</a>";
				}
				?>
		</div>
	</body>
</html>

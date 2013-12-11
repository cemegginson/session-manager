<?php
session_start();

if(!$_SESSION['uname'])
    header("Location: http://localhost");

if(isset($_POST['oldpass'])){
	$username = $_SESSION['uname'];
	$oldpass = htmlspecialchars($_POST['oldpass']);
	$newpass1 = htmlspecialchars($_POST['newpass1']);
	$newpass2 = htmlspecialchars($_POST['newpass2']);
	$oldhash = md5($username . $oldpass);

	if($newpass1 != $newpass2){
		die("The new password fields don't match, please try again.");
	}

	$newhash = md5($username . $newpass1);

	//Grab user info from db and check if they knew the old password
	$sql = new mysqli('localhost', 'phpuser', 'password', 'cisco');

	$query = "SELECT * FROM students WHERE username=?";

	if($stmt = $sql->prepare($query)){
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->bind_result($col1, $col2, $col3);
		$stmt->fetch();
		//$stmt->close;
	}

	if($oldhash != $col2){
		die("Wrong password, please try again.");
	}

	//Update the table with the new password
	$query2 = "UPDATE students SET password=? WHERE username=?";

	$sql = new mysqli('localhost', 'phpuser', 'testing', 'cisco');

	if($update = $sql->prepare($query2)){
		$update->bind_param('ss', $newhash, $username);
		$update->execute();
		$update->close;
		header('Location: http://localhost');
	}
	else{
		die("Query failed.");
	}

	$sql->close;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8">
		<title>Change Password</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<form class="changepass" action="changepass.php" method="post">
		    <p>Old Password: <input type="password" name="oldpass" /></p>
		    <p>New Password: <input type="password" name="newpass1" /></p>
		    <p>New Password: <input type="password" name="newpass2" /></p>
		    <p><input type="submit" value="Change"  /></p>
		</form>
	</body>
</html>

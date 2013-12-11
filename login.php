<?php
session_start();

//Has form data been submitted?
if(isset($_POST['username'])){
	//Retrieving input from HTML form
	$username =  htmlspecialchars($_POST['username']);
	$password =  htmlspecialchars($_POST['password']);

	//This implementation uses salted hashes
	$hashpass = md5($username . $password);

	//SQL stuff
	if(!$sql = new mysqli('localhost', 'phpuser', 'password', 'cisco'))
		die('Unable to establish SQL connection:' . mysqli_connect_error());

	$query = "SELECT * FROM students WHERE username=?";

	if($stmt = $sql->prepare($query)){
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->bind_result($col1, $col2, $col3);
		$stmt->fetch();
		$stmt->close;
	}
	$sql->close;

	//Test the login attempt and let them in if it works
	if($username == $col1 && $hashpass == $col2){
		//session_start();
		$_SESSION['uname'] = $col1;
		$_SESSION['class'] = $col3;
		header('Location: http://localhost');
	}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<form name="login" class="login" action="login.php" method="post">
	    	<p>Username: <input type="text" name="username" autofocus="autofocus" /></p>
	    	<p>Password: <input type="password" name="password" /></p>
	    	<p><input type="submit" value="Login"  /></p>
		</form>
	</body>
</html>

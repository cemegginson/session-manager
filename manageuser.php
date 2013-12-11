<?php
session_start();

//Do you belong here?
if(!isset($_SESSION['class']) || $_SESSION['class'] != 0){
    header('Location: http://localhost');
}

//Establish connection with MySQL
$sql = new mysqli('localhost', 'phpuser', 'password', 'cisco');

//if users is set, put it's contents in response
if(isset($_POST['users'])){
	$response = $_POST['users'];
}

//Respond to checkbox input
if(isset($_POST['action'])){
	switch($_POST['action']){
		//Nuke them from the database
		case "delete":
			$query = "DELETE FROM students WHERE username=?";
			$remove = $sql->prepare($query);
			for($i = 0; $i < count($response); $i++){
				$remove->bind_param('s', $response[$i]);
				$remove->execute();
			}
			break;
		//Set to Cisco 1
		case "cisco1":
			$query = "UPDATE students SET class=1 WHERE username=?";
			$cisco1 = $sql->prepare($query);
			for($i = 0; $i < count($response); $i++){								
				$cisco1->bind_param('s', $response[$i]);
				$cisco1->execute();
			}													
			break;
		//Set to Cisco 2
		case "cisco2":
			$query = "UPDATE students SET class=2 WHERE username=?";
			$cisco2 = $sql->prepare($query);
			for($i = 0; $i < count($response); $i++){
				$cisco2->bind_param('s', $response[$i]);
				$cisco2->execute();
			}
			break;
		//Set to Cisco 3/4
		case "cisco3":
			$query = "UPDATE students SET class=3 WHERE username=?";
			$cisco3 = $sql->prepare($query);
			for($i = 0; $i < count($response); $i++){	
				$cisco3->bind_param('s', $response[$i]);
				$cisco3->execute();
			}
			break;
		//Put them in charge
		case "admin":
			$query = "UPDATE students SET class=0 WHERE username=?";
			$admin = $sql->prepare($query);
			for($i = 0; $i < count($response); $i++){
				$admin->bind_param('s', $response[$i]);
				$admin->execute();
			}
			break;
	}
}

//Create user segment
else if(isset($_POST['newusername'])){
	//Retrieving input from HTML form
	$username =  htmlspecialchars($_POST['newusername']);
	$password =  htmlspecialchars($_POST['newpassword']);
	$class = htmlspecialchars($_POST['newclass']);

	//This implementation uses salted hashes
	$hashpass = md5($username . $password);

	$query = "INSERT INTO students VALUES (?, ?, ?)";

	if($stmt = $sql->prepare($query)){
		$stmt->bind_param('ssi', $username, $hashpass, $class);
		$stmt->execute();
		//echo $username . " was created successfully.";
	}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8">
		<title>Manage Users</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div id="container">
			<form action="manageuser.php" method="post">
				<table>
<?php

$sql->real_query("SELECT * FROM students ORDER BY class,username;");
$res = $sql->use_result();

while($row = $res->fetch_assoc()){
	//Using a switch block to work out what class they're in to show it in a human readable format, also spit out html checkbox lines
	switch($row['class']){
		case 0:
			$class = "Admin";
			break;
		case 1:
			$class = "Cisco 1";
			break;
		case 2:
			$class = "Cisco 2";
			break;
		case 3:
			$class = "Cisco 3/4";
			break;
	}
	echo "\t\t\t\t\t<tr><td> <input type=\"checkbox\" name=\"users[]\" value=\"" . $row['username'] . "\"/></td><td>" . $row['username'] . "</td><td> " . $class . "</td></tr>\n";
}

?>
					<tr><td></td><td>
						<select name="action">
							<option value="cisco1">Set to Cisco 1</option>
							<option value="cisco2">Set to Cisco 2</option>
							<option value="cisco3">Set to Cisco 3/4</option>
							<option value="admin">Set to Admin</option>
							<option value="delete">Delete</option>
						</select>
					</td>
					<td>
						<input type="submit" value="Apply" />
					</td></tr>
				</table>
				</form>
				<form action="manageuser.php" method="post">
				Username: <input type="text" name="newusername" />
				Password: <input type="text" name="newpassword" />
				Class:
					<select name="newclass">
						<option value="1">Cisco 1</option>
						<option value="2">Cisco 2</option>
						<option value="3">Cisco 3/4</option>
						<option value="0">Admin</option>
					</select><br />
				<input type="submit" value="Add User" />
			</form>
		</div>
	</body>
</html>


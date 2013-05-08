<?php

if(!isset($_COOKIE['username'])) {
	header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?logout=yes");
}
error_reporting(E_ALL);
session_start();

if (!empty($_SESSION["username"])) {
	$user = $_SESSION["username"];
} else {
	header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?logout=yes");
}

// Receiver for data from JQuery for the list order

$jq_data = isset($_POST['order']) ? $_POST['order'] : '';
//$jq_data = $_POST["order"];
$myFile = "testFile.txt";
$fh = fopen($myFile, 'w') or die("can't open file");
if(is_null($jq_data)){
	fwrite($fh, "jq_data is null");
} else {
	fwrite($fh, $jq_data);
}
fclose($fh);

// Update layout for user

$mysqli = new mysqli("localhost", "root", "Dapp3rDan1", "portal");
if ($mysqli->connect_errno) {
	echo "Connection to portal db failed";
	exit();
}

$mysql_query = "UPDATE user_layouts SET dashLayout=\"" . $jq_data . "\" WHERE userID = \"" . $_SESSION['userid'] . "\"";
$result = $mysqli->query($mysql_query);
if ($mysqli->query($mysql_query) === FALSE) {
	echo "Update record of layout failed";
	exit();
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>


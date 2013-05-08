<?php
error_reporting(E_ALL);
session_start();

if (!empty($_SESSION["username"])) {
	$user = $_SESSION["username"];
} else {
	header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?logout=yes");
}

// Connect to MYSQL server

$mysqli = new mysqli("localhost", "root", "Dapp3rDan1", "portal");
if ($mysqli->connect_errno) {
	//$firephp->log("Connection to portal db failed", 'ERROR');
	echo "Connection to portal db failed";
	exit();
}

$ids = isset($_POST['ids']) ? $_POST['ids'] : '';

$cleanUpSql = "DELETE FROM reports_fav WHERE user_id = " . $_SESSION['userid'] . ";";
$mysqli->query($cleanUpSql);

$exploded = explode(',',$ids);
if(count($exploded) > 0) {
	$counter = 1;
	foreach($exploded as $id) {
		echo $insert = "INSERT INTO reports_fav (user_id,report_id,order_number) VALUES(".$_SESSION['userid'].",".$id.",".$counter.");";
		$mysqli->query($insert);
		$counter++;
	}
}
exit;
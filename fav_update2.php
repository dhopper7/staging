<?php
error_reporting(E_ALL);
session_start();

if (!empty($_SESSION["username"])) {
	$user = $_SESSION["username"];
} else {
	header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?logout=yes");
}


if(is_numeric($_GET['report']) || is_numeric($_GET['remove'])) {
$reportId = is_numeric($_GET['report']) ? $_GET['report'] : $_GET['remove'];
} else {
	exit;	
}

// Connect to MYSQL server
$mysqli = new mysqli("localhost", "root", "Dapp3rDan1", "portal");
if ($mysqli->connect_errno) {
	//$firephp->log("Connection to portal db failed", 'ERROR');
	echo "Connection to portal db failed";
	exit();
}

if(is_numeric($_GET['remove'])) {
	$delete = "DELETE FROM reports_fav WHERE user_id = ".$_SESSION['userid']." AND report_id = ".$reportId.";";
	$mysqli->query($delete);
	exit;
} else {
	// Check if favorite is in their list
	$checkquery = "SELECT report_id FROM reports_fav WHERE user_id = '" . $_SESSION['userid'] . "' AND report_id = '".$reportId."';";
	$checkresult = $mysqli->query($checkquery);
	if($checkresult->num_rows > 0) {
		exit;	
	} elseif($checkresult->num_rows == 12) {
		echo "You have reached your limit of 12 favorites";
		exit;
	} else {
		$insert = "INSERT INTO reports_fav (user_id,report_id) VALUES(".$_SESSION['userid'].",".$reportId.");";
		$mysqli->query($insert);
		exit;
	}
}

exit;
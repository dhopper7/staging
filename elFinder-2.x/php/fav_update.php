<?php

require_once('../../firephp/FirePHP.class.php');
$firephp = FirePHP::getInstance(true);

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

$jq_data = isset($_POST['path']) ? $_POST['path'] : '';
//$firephp->log($jq_data, 'JQDATA');
// Add favorite item to list

// Connect to MYSQL server

$mysqli = new mysqli("localhost", "root", "Dapp3rDan1", "portal");
if ($mysqli->connect_errno) {
	//$firephp->log("Connection to portal db failed", 'ERROR');
	echo "Connection to portal db failed";
	exit();
}

// Get User ID

$mysql_query = "SELECT userID FROM user_acct WHERE userID = \"" . $_SESSION['userid'] . "\"";
//$firephp->log($mysql_query, 'QUERY');
$useridresult = $mysqli->query($mysql_query);
if ($mysqli->query($mysql_query) === FALSE) {
	//$firephp->log("User ID request failed", 'ERROR');
	echo "User ID request failed";
	exit();
}
if($useridresult->num_rows > 0){
	$row = mysqli_fetch_object($useridresult);
	$userid = $row->userID;
	//$firephp->log($userid, 'USERID');
}

// Get current list of favorites

$mysql_query = "SELECT fileNames, filePaths from user_reports WHERE userID = \"" . $userid . "\"";
//$firephp->log($mysql_query, 'QUERY');
$sqlfavs = $mysqli->query($mysql_query);
if ($mysqli->query($mysql_query) === FALSE) {
	//$firephp->log("Could not pull list of favorites", 'ERROR');
	echo "Could not pull list of favorites";
	exit();
}

if($sqlfavs->num_rows > 0){
	$row = mysqli_fetch_object($sqlfavs);
	$jq_datax = explode('\\', $jq_data);
	$row_len = count(explode(',',$row->filePaths));
	$jq_len = count($jq_datax);
	//$firephp->log($row_len, 'JQ_LEN');
	$firephp->log($row_len, 'ROW_LEN');
	if($row_len == 12){
		//echo json_encode("Unable to add item to favorites. Please remove a report from favorites and try again.");
		//echo json_encode("ERROR12");
		echo "ERROR12";
		exit();
	} //else {
		//echo json_encode("Report has been successfully added to Favorites");
	//}
	$filename = $jq_datax[$jq_len-1];
	$filename = "\\" . $filename;
	$path = str_replace($filename, "", $jq_data);
	//$firephp->log($path, 'PATH');
	if($row->filePaths != ""){
		$jq_datapath = $row->filePaths . "," . $path;
	} else {
		$jq_datapath = $row->filePaths . $path;
	}
	$jq_datapath = str_replace("\\", "\\\\", $jq_datapath);
	if($row->fileNames != ""){
		$jq_datafile = $row->fileNames . "," . $jq_datax[$jq_len-1];
	} else {
		$jq_datafile = $row->fileNames . $jq_datax[$jq_len-1];
	}
	
}

// Update current list of reports in sql

$mysql_query = "UPDATE user_reports SET fileNames=\"" . $jq_datafile . "\", filePaths=\"" . $jq_datapath . "\"  WHERE userID = \"" . $userid . "\"";
//$firephp->log($mysql_query, 'QUERY');
$result = $mysqli->query($mysql_query);
if ($mysqli->query($mysql_query) === FALSE) {
	//$firephp->log("Could not update list of favorites", 'ERROR');
	echo "Could not update list of favorites";
	exit();
}

?>
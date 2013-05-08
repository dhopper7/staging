<?php

$counter = 1;
while($counter < 9){
	${"query" . $counter} = "INSERT INTO flash_template VALUES ('',";
	$counter++;
}

$myrows = $_POST['flash_data'];
$myrows = explode('|', $myrows);
foreach($myrows as $row)
{
	$counter = 1;
	$myvalues = explode(";", $row);
	foreach($myvalues as $myvalue){
		if($myvalue == 'NULL'){
			${"query" . $counter} = ${"query" . $counter} . $myvalue . ", ";
		} else {
			${"query" . $counter} = ${"query" . $counter} . "'" . $myvalue . "', ";
		}
		$counter++;
	}
}

$counter = 1;

while($counter < 9){
	${"query" . $counter} = substr(${"query" . $counter},0,strlen(${"query" . $counter})-2);
	$counter++;
}

$counter = 1;

while($counter < 9){
	${"query" . $counter} = ${"query" . $counter} . ")";
	$counter++;
}

$mysqli = new mysqli("localhost", "root", "Dapp3rDan1", "portal");
if ($mysqli->connect_errno) {
	echo "Connection to portal db failed";
	exit();
}

$counter = 1;
while($counter < 9){
	$mysql_query = ${"query" . $counter};
	$result = $mysqli->query($mysql_query);
	//if ($mysqli->query($mysql_query) === FALSE) {
	//	echo "Update record of layout failed";
	//	exit();
	//}
	$counter++;
}
echo $query1;
?>
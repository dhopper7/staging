<?php
session_start();
$path = $_GET['relativepath'];

$path = "\\\\enas11\\ClientSites\\Demo\\Rainmaker Casino Demo\\" . $path;

	$newestfile = "";
	$newesttimestamp = 0;
	
	foreach (new DirectoryIterator($path) as $fileInfo) {
		
    	if($fileInfo->isDot()) continue;
		if($fileInfo->getExtension() == "pdf") {
			$exploded = explode('.',$fileInfo->getFilename());
			$dateString = substr($exploded[count($exploded) - 2],-6);
			$datePieces = array();
			$datePieces[0] = substr($dateString,0,2);
			$datePieces[1] = substr($dateString,2,2);
			$datePieces[2] = substr($dateString,4,2);
			if(is_numeric($datePieces[0]) && is_numeric($datePieces[1]) && is_numeric($datePieces[2])) {
				$currentFileTime = mktime(0,0,0,$datePieces[0],$datePieces[1],$datePieces[2]);
				if(($currentFileTime > $newesttimestamp)){
					$newesttimestamp = $currentFileTime;
					$newestfile = $fileInfo->getPathName();
				}
			}
		}
    	//echo $fileInfo->getFilename() . " " . $fileInfo->getMTime() . "<br>\n";
	}
	//echo $newestfile;
	if($newestfile != "") {
		header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/test_link.php?path=" . $newestfile);
	} else {
		echo "No file found!";
	}


?>

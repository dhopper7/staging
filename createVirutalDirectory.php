<?php

$testArray = array();
$testArray[] = "document1.10-15-12.doc";
$testArray[] = "document1.10/11/12.doc";
$testArray[] = "document109-29-12.doc";
$testArray[] = "document1.11-01-12.doc";
$testArray[] = "pdf12-31-12.pdf";
$testArray[] = "document110-15-11.doc";
$testArray[] = "justafile.xls";
$testArray[] = "document1.10-11-12.doc";

$virtualStructure = array();
$yearCounter = array();
$unsortedStructure = array();
foreach($testArray as $file) {
	$exploded = explode('.',$file);
	$dateString = substr($exploded[count($exploded) - 2],-8);
	$breakCharacter = substr($dateString,2,1);
	$datePieces = explode($breakCharacter,$dateString);
	
	if(@is_numeric($datePieces[2]) && @is_numeric($datePieces[0])) {
		@$yearCounter[$datePieces[2]]++;
		$virtualStructure[$datePieces[2]][$datePieces[0]][] = $file;
	} else {
		$unsortedStructure[] = $file;
	}
	
}
echo "<pre>";
print_r($virtualStructure);
print_r($unsortedStructure);
print_r($yearCounter);
echo "</pre>";

foreach($testArray as $file) {
	
}


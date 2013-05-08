
<?php
$path = "//enas11/test/Rainmaker/Charts/";
/*$data = "hi there";
if(!write_file($this->filepath . "/IN PROCESS/IMAGES/test.txt", $data)) {
	 echo 'Unable to write the file';
	
} else {
	 echo 'File written!';
}*/

function getFileExtension($filename) {
	$explodedFilename = explode('.',$filename);
	if(count($explodedFilename) < 2) {
		return "";
	} else {
		return	strtolower($explodedFilename[count($explodedFilename)-1]);
	}
}


if ($handle = opendir($path)) {
	//$this->fixLinks();
	$i = 0;
	while (false !== ($entry = readdir($handle))) {
		
		if (getFileExtension($entry) == "pdf") {
			$explodedFilename = explode('.',$entry);
			if(!file_exists($path . "#IMAGES/" . $explodedFilename[0] . ".png")) {
				$pathToPng = $path . "#IMAGES/" . $explodedFilename[0] . ".png";
				$pathToPdf = $path . $entry;
				$strCommand = "gs -dGraphicsAlphaBits=4 -dTextAlphaBits=4 -dUseCIEColor -dNOPAUSE -dFirstPage=[last-page-number] -dLastPage=[last-page-number] -sDEVICE=png16m -sOutputFile='".$pathToPng."' '".$pathToPdf."'";
				$result=shell_exec($strCommand);
				echo $result;
			}
				//$this->createNewInvoice($entry);
				echo $entry . "<br >";
				
				$i++;
				
				if($i == 500) {
					break;
				}
				
		}
	}
	
	closedir($handle);
}

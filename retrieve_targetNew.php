<html><head></head><body>
<?php
session_start();
$access_type = $_GET['accesstype'];
$path = $_GET['relativepath'];

if($access_type == "F"){
	header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/elFinder-2.x/elfinder.php?folderpath=\\\\enas11\\" . $path . "&TB_iframe=true");
	exit;
}
else if($access_type == "R"){
	$newestfile = "";
	$newesttimestamp = 0;
	foreach (new DirectoryIterator('\\\\enas11\\test') as $fileInfo) {
    	if($fileInfo->isDot()) continue;
		if(($fileInfo->getMTime() > $newesttimestamp) & ($fileInfo->isFile()) & (($fileInfo->getExtension() == "xls") || ($fileInfo->getExtension() == "xlsx") || ($fileInfo->getExtension() == "doc") || ($fileInfo->getExtension() == "docx") || ($fileInfo->getExtension() == "pdf"))){
			$newesttimestamp = $fileInfo->getMTime();
			$newestfile = $fileInfo->getPathName();
		}
    	//echo $fileInfo->getFilename() . " " . $fileInfo->getMTime() . "<br>\n";
	}
	//echo $newestfile;
	header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/test_link.php?path=" . $newestfile);
}

?>
</body></html>
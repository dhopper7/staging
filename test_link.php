<?php
	//$_GET['path'] = '\test\test.pdf';
	//$file = '\\\\10.10.10.22\test\test.pdf';
	$file =  $_GET['path'];
	if(substr($file, -4) == "docx"){
		
		header('Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Disposition: inline; filename="document.docx"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($file));
		header('Accept-Ranges: bytes');
		
		@readfile($file);
	} else if(substr($file, -4) == ".doc"){
		
		header('Content-type: application/msword');
		header('Content-Disposition: inline; filename="document.doc"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($file));
		header('Accept-Ranges: bytes');
		
		@readfile($file);
	} else if(substr($file, -4) == ".pdf") {
		
		$filename = 'document.pdf'; 
		
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' . $filename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($file));
		header('Accept-Ranges: bytes');
		readfile($file);
	} else if(substr($file, -4) == ".xls") {
		
		$filename = 'document.xls'; 
		
		header('Content-type: application/msexcel');
		//header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: inline; filename="' . $filename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($file));
		header('Accept-Ranges: bytes');
		
		@readfile($file);
	} else if(substr($file, -4) == "xlsx") {
		
		$filename = 'document.xlsx'; 
		
		//header('Content-type: application/msexcel');
		header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: inline; filename="' . $filename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($file));
		header('Accept-Ranges: bytes');
		
		@readfile($file);
	}
?> 
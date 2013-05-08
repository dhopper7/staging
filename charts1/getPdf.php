<?php
$file =  "//enas11/test/Rainmaker/Charts/" . $_GET['path'];
$filename = 'document.pdf'; 

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($file));
header('Accept-Ranges: bytes');
readfile($file);
<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-type: image/png'); 
$path = "//enas11/test/Rainmaker/Charts/#IMAGES/";
$width = 450;
$height = 400;
$dstimage=imagecreatetruecolor($width,$height);
$srcimage=imagecreatefrompng($path . $_GET['file']);
imagecopyresampled($dstimage,$srcimage,0,0,0,0, $width,$height,$width,$height);
$im = imagecreatefrompng($path . $_GET['file']);
imagepng($im);

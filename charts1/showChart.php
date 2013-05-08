<?php
$path = "//enas11/test/Rainmaker/Charts/#IMAGES/";
$info = list($width, $height, $type, $attr) = getimagesize($path.$_GET['file']);
//print_r($info);

if($info[0] > 760) {
	$ratio = $info[0] / $info[1];
	$width = 800 * $ratio;
	$height = 800;
}
?>
<a href="getPdf.php?path=<?php echo str_replace('png','pdf',$_GET['file']); ?>">Print</a><br />
<img src="getImage.php?file=<?php echo $_GET['file']; ?>" height="<?php echo $height; ?>" width="<?php echo $width; ?>" />


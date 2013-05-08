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
<div class="printBtn" style="text-align:center;">
<a href="getPdf.php?path=<?php echo str_replace('png','pdf',$_GET['file']); ?>">Print</a><br />
</div>
<div class="imgShow" style="text-align:center;">
<img src="getImage.php?file=<?php echo $_GET['file']; ?>" height="<?php echo $height; ?>" width="<?php echo $width; ?>" />
</div>

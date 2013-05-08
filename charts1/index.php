<?php
$path = "//enas11/test/Rainmaker/Charts/#IMAGES/";

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
	$files = "";
	while (false !== ($entry = readdir($handle))) {
		
		if (getFileExtension($entry) == "png") {
				$files .= "<li><a target=\"_blank\" href=\"charts1/showChart.php?file=" . $entry . "\"><img src=\"charts1/getImage.php?file=" . $entry . "\" /></a></li>";
				
				$i++;
				
				if($i == 500) {
					break;
				}
				
		}
	}
	
	closedir($handle);
}

?>
        <link href="charts1/css/main.css" rel="stylesheet" type="text/css" />
       
        <script src="charts1/js/jquery.jcarousel.min.js"></script>
        <script src="charts1/js/main.js"></script>



        <div class="sl-main">
            <ul id="sl-thumbs">
                <?php echo $files; ?>
            </ul>
        </div>

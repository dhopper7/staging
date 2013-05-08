<?php
$fileNames  = array();
$filePaths  = array();
$fileTypes  = array();
$fileLabels = array();
$favId      = array();

$mysql_query = "SELECT r.reportTitle, r.accessType, r.relativePath, r.reportClass, r.id FROM rep_rainmaker r, reports_fav f WHERE f.report_id = r.id AND f.user_id = '" . $_SESSION['userid'] . "' GROUP BY f.report_id ORDER BY order_number ASC, fav_id ASC";
$result = $mysqli->query($mysql_query);
if($result->num_rows > 0){
	while($row = mysqli_fetch_object($result)) {
		$fileNames[]  = $row->reportTitle;
		$filePaths[]  = $row->relativePath;
		$fileTypes[]  = $row->accessType;
		$fileLabels[] = $row->reportTitle;
		$favId[]      = $row->id;
	}
}



		$sortableListCounter = 1;
		echo "<ul id=\"sortable1\" class=\"connectedSortable\">";
		for($i = 0; $i < 12; $i++) {
			if($i > 0 && $i % 6 == 0) {
				$sortableListCounter++;
				echo "</ul>";
				echo "<ul id=\"sortable".$sortableListCounter."\" class=\"connectedSortable\">";
			}

			if(isset($fileNames[$i])){
				
				//$fileNamexp = explode(".", $fileNames[$i]);
				//if($fileNamexp[1] == "fld"){
				
				if($fileTypes[$i] == "R") {
					
					$folderpath = $filePaths[$i] . "\\" . $fileNamexp[0];
					$folderpath = urlencode($folderpath);
					echo "<li style=\"display: list-item;\" id=\"item".$i."\"><a id=\"".$favId[$i]."\" target=\"_blank\" href=\"retrieve_target.php?relativepath=" . $folderpath . "&accesstype=R\" title=\"Reports\" filetype=pdf>" . $fileLabels[$i] . "</a></li>";
				} else {
					echo "<li style=\"display: list-item;\" id=\"item".$i."\"><a id=\"".$favId[$i]."\" target=\"_blank\" title=\"".$fileLabels[$i]."\" class=\"thickbox\" href=\"testFolder3.php?fav=" . $filePaths[$i] . "\\" . $fileNamexp[0] . "&TB_iframe=true\" filetype=fld>" . $fileLabels[$i] . "</a></li>";
				}
			}
		} // end for
		echo "</ul>";
		
?>
<div id="reports_add">
        <a href="elFinder-2.x/elfinder.php?TB_iframe=true" class="thickbox"" title="Add Report"><img src='img/ticon_add.png'></a>
        </div>
        <div id="reports_edit">
        <a href="JavaScript:void()" title="Modify Order"><img src='img/ticon_edit.png'></a>
        </div>
        <div id="reports_rem">
        <a href="JavaScript:void()" title="Remove Report"><img src='img/ticon_remove.png'></a>
        </div>
        <div id="reports_done">
        <a href="JavaScript:void()" title="Confirm"><img src='img/ticon_done.png'></a>
        </div>
        <?php
		
		echo "<ul id=\"sortable1\" class=\"connectedSortable\">";
		if(isset($fileNames[0])){
			$fileNamexp = explode(".", $fileNames[0]);
			if($fileNamexp[1] == "fld"){
				$folderpath = "\\\\enas11\\" . $filePaths[0] . "\\" . $fileNamexp[0];
				$folderpath = urlencode($folderpath);
				echo "<li style=\"display: list-item;\" id=\"item0\"><a href=elFinder-2.x/elfinder.php?folderpath=" . $folderpath . "&TB_iframe=true class=\"thickbox\" title=\"Reports\" filetype=fld>" . $fileNamexp[0] . "</a></li>";
			} else {
				echo "<li style=\"display: list-item;\" id=\"item0\"><a href=\"test_link.php?path=" . $filePaths[0] . "\\\\" . $fileNames[0] . "\">" . $fileNamexp[0] . "</a></li>";
			}
		}
		if(isset($fileNames[1])){
			$fileNamexp = explode(".", $fileNames[1]);
			if($fileNamexp[1] == "fld"){
				$folderpath = "\\\\enas11\\" . $filePaths[1] . "\\" . $fileNamexp[0];
				$folderpath = urlencode($folderpath);
				echo "<li style=\"display: list-item;\" id=\"item1\"><a href=elFinder-2.x/elfinder.php?folderpath=" . $folderpath . "&TB_iframe=true class=\"thickbox\" title=\"Reports\" filetype=fld>" . $fileNamexp[0] . "</a></li>";
			} else {
				echo "<li style=\"display: list-item;\" id=\"item1\"><a href=\"test_link.php?path=" . $filePaths[1] . "\\\\" . $fileNames[1] . "\">" . $fileNamexp[0] . "</a></li>";
			}
		}
		if(isset($fileNames[2])){
			$fileNamexp = explode(".", $fileNames[2]);
			if($fileNamexp[1] == "fld"){
				$folderpath = "\\\\enas11\\" . $filePaths[2] . "\\" . $fileNamexp[0];
				$folderpath = urlencode($folderpath);
				echo "<li style=\"display: list-item;\" id=\"item2\"><a href=elFinder-2.x/elfinder.php?folderpath=" . $folderpath . "&TB_iframe=true class=\"thickbox\" title=\"Reports\" filetype=fld>" . $fileNamexp[0] . "</a></li>";
			} else {
				echo "<li style=\"display: list-item;\" id=\"item2\"><a href=\"test_link.php?path=" . $filePaths[2] . "\\\\" . $fileNames[2] . "\">" . $fileNamexp[0] . "</a></li>";
			}
		}
    	echo "</ul>";
    	echo "<ul id=\"sortable2\" class=\"connectedSortable\">";
		if(isset($fileNames[3])){
			$fileNamexp = explode(".", $fileNames[3]);
			if($fileNamexp[1] == "fld"){
				$folderpath = "\\\\enas11\\" . $filePaths[3] . "\\" . $fileNamexp[0];
				$folderpath = urlencode($folderpath);
				echo "<li style=\"display: list-item;\" id=\"item3\"><a href=elFinder-2.x/elfinder.php?folderpath=" . $folderpath . "&TB_iframe=true class=\"thickbox\" title=\"Reports\" filetype=fld>" . $fileNamexp[0] . "</a></li>";
			} else {
				echo "<li style=\"display: list-item;\" id=\"item3\"><a href=\"test_link.php?path=" . $filePaths[3] . "\\\\" . $fileNames[3] . "\">" . $fileNamexp[0] . "</a></li>";
			}
		}
		if(isset($fileNames[4])){
			$fileNamexp = explode(".", $fileNames[4]);
			if($fileNamexp[1] == "fld"){
				$folderpath = "\\\\enas11\\" . $filePaths[4] . "\\" . $fileNamexp[0];
				$folderpath = urlencode($folderpath);
				echo "<li style=\"display: list-item;\" id=\"item4\"><a href=elFinder-2.x/elfinder.php?folderpath=" . $folderpath . "&TB_iframe=true class=\"thickbox\" title=\"Reports\" filetype=fld>" . $fileNamexp[0] . "</a></li>";
			} else {
				echo "<li style=\"display: list-item;\" id=\"item4\"><a href=\"test_link.php?path=" . $filePaths[4] . "\\\\" . $fileNames[4] . "\">" . $fileNamexp[0] . "</a></li>";
			}
		}
		if(isset($fileNames[5])){
			$fileNamexp = explode(".", $fileNames[5]);
			if($fileNamexp[1] == "fld"){
				$folderpath = "\\\\enas11\\" . $filePaths[5] . "\\" . $fileNamexp[0];
				$folderpath = urlencode($folderpath);
				echo "<li style=\"display: list-item;\" id=\"item5\"><a href=elFinder-2.x/elfinder.php?folderpath=" . $folderpath . "&TB_iframe=true class=\"thickbox\" title=\"Reports\" filetype=fld>" . $fileNamexp[0] . "</a></li>";
			} else {
				echo "<li style=\"display: list-item;\" id=\"item5\"><a href=\"test_link.php?path=" . $filePaths[5] . "\\\\" . $fileNames[5] . "\">" . $fileNamexp[0] . "</a></li>";
			}
		}
    	echo "</ul>";
    	echo "<ul id=\"sortable3\" class=\"connectedSortable\">";
		if(isset($fileNames[6])){
			$fileNamexp = explode(".", $fileNames[6]);
			if($fileNamexp[1] == "fld"){
				$folderpath = "\\\\enas11\\" . $filePaths[6] . "\\" . $fileNamexp[0];
				$folderpath = urlencode($folderpath);
				echo "<li style=\"display: list-item;\" id=\"item6\"><a href=elFinder-2.x/elfinder.php?folderpath=" . $folderpath . "&TB_iframe=true class=\"thickbox\" title=\"Reports\" filetype=fld>" . $fileNamexp[0] . "</a></li>";
			} else {
				echo "<li style=\"display: list-item;\" id=\"item6\"><a href=\"test_link.php?path=" . $filePaths[6] . "\\\\" . $fileNames[6] . "\">" . $fileNamexp[0] . "</a></li>";
			}
		}
		if(isset($fileNames[7])){
			$fileNamexp = explode(".", $fileNames[7]);
			if($fileNamexp[1] == "fld"){
				$folderpath = "\\\\enas11\\" . $filePaths[7] . "\\" . $fileNamexp[0];
				$folderpath = urlencode($folderpath);
				echo "<li style=\"display: list-item;\" id=\"item7\"><a href=elFinder-2.x/elfinder.php?folderpath=" . $folderpath . "&TB_iframe=true class=\"thickbox\" title=\"Reports\" filetype=fld>" . $fileNamexp[0] . "</a></li>";
			} else {
				echo "<li style=\"display: list-item;\" id=\"item7\"><a href=\"test_link.php?path=" . $filePaths[7] . "\\\\" . $fileNames[7] . "\">" . $fileNamexp[0] . "</a></li>";
			}
		}
		if(isset($fileNames[8])){
			$fileNamexp = explode(".", $fileNames[8]);
			if($fileNamexp[1] == "fld"){
				$folderpath = "\\\\enas11\\" . $filePaths[8] . "\\" . $fileNamexp[0];
				$folderpath = urlencode($folderpath);
				echo "<li style=\"display: list-item;\" id=\"item8\"><a href=elFinder-2.x/elfinder.php?folderpath=" . $folderpath . "&TB_iframe=true class=\"thickbox\" title=\"Reports\" filetype=fld>" . $fileNamexp[0] . "</a></li>";
			} else {
				echo "<li style=\"display: list-item;\" id=\"item8\"><a href=\"test_link.php?path=" . $filePaths[8] . "\\\\" . $fileNames[8] . "\">" . $fileNamexp[0] . "</a></li>";
			}
		}
    	echo "</ul>";
        echo "<ul id=\"sortable4\" class=\"connectedSortable\">";
		if(isset($fileNames[9])){
			$fileNamexp = explode(".", $fileNames[9]);
			if($fileNamexp[1] == "fld"){
				$folderpath = "\\\\enas11\\" . $filePaths[9] . "\\" . $fileNamexp[0];
				$folderpath = urlencode($folderpath);
				echo "<li style=\"display: list-item;\" id=\"item9\"><a href=elFinder-2.x/elfinder.php?folderpath=" . $folderpath . "&TB_iframe=true class=\"thickbox\" title=\"Reports\" filetype=fld>" . $fileNamexp[0] . "</a></li>";
			} else {
				echo "<li style=\"display: list-item;\" id=\"item9\"><a href=\"test_link.php?path=" . $filePaths[9] . "\\\\" . $fileNames[9] . "\">" . $fileNamexp[0] . "</a></li>";
			}
		}
		if(isset($fileNames[10])){
			$fileNamexp = explode(".", $fileNames[10]);
			if($fileNamexp[1] == "fld"){
				$folderpath = "\\\\enas11\\" . $filePaths[10] . "\\" . $fileNamexp[0];
				$folderpath = urlencode($folderpath);
				echo "<li style=\"display: list-item;\" id=\"item10\"><a href=elFinder-2.x/elfinder.php?folderpath=" . $folderpath . "&TB_iframe=true class=\"thickbox\" title=\"Reports\" filetype=fld>" . $fileNamexp[0] . "</a></li>";
			} else {
				echo "<li style=\"display: list-item;\" id=\"item10\"><a href=\"test_link.php?path=" . $filePaths[10] . "\\\\" . $fileNames[10] . "\">" . $fileNamexp[0] . "</a></li>";
			}
		}
		if(isset($fileNames[11])){
			$fileNamexp = explode(".", $fileNames[11]);
			if($fileNamexp[1] == "fld"){
				$folderpath = "\\\\enas11\\" . $filePaths[11] . "\\" . $fileNamexp[0];
				$folderpath = urlencode($folderpath);
				echo "<li style=\"display: list-item;\" id=\"item11\"><a href=elFinder-2.x/elfinder.php?folderpath=" . $folderpath . "&TB_iframe=true class=\"thickbox\" title=\"Reports\" filetype=fld>" . $fileNamexp[0] . "</a></li>";
			} else {
				echo "<li style=\"display: list-item;\" id=\"item11\"><a href=\"test_link.php?path=" . $filePaths[11] . "\\\\" . $fileNames[11] . "\">" . $fileNamexp[0] . "</a></li>";
			}
		}
    	echo "</ul>";
		?>
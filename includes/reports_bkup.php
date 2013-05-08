<div id="reports_add">
        <a href="elfinder-2.0-rc1/elfinder.html?TB_iframe=true" class="thickbox"" title="Add Report"><img src='img/ticon_add.png'></a>
        </div>
        <div id="reports_edit">
        <a href="#" title="Modify Order"><img src='img/ticon_edit.png'></a>
        </div>
        <div id="reports_rem">
        <a href="#" title="Remove Report"><img src='img/ticon_remove.png'></a>
        </div>
        <div id="reports_done">
        <a href="#" title="Confirm"><img src='img/ticon_done.png'></a>
        </div>
        <?php
		
		echo "<ul id=\"sortable1\" class=\"connectedSortable\">";
		$fileNamexp = explode(".", $fileNames[0]);
        echo "<a href=\"test_link.php?path=" . $filePaths[0] . "\\\\" . $fileNames[0] . "\"><li style=\"display: list-item;\" id=\"item0\">" . $fileNamexp[0] . "</li></a>";
		$fileNamexp = explode(".", $fileNames[1]);
        echo "<a href=\"test_link.php?path=" . $filePaths[1] . "\\\\" . $fileNames[1] . "\"><li style=\"display: list-item;\" id=\"item1\">" . $fileNamexp[0] . "</li></a>";
		$fileNamexp = explode(".", $fileNames[2]);
		echo "<a href=\"test_link.php?path=" . $filePaths[2] . "\\\\" . $fileNames[2] . "\"><li style=\"display: list-item;\" id=\"item2\">" . $fileNamexp[0] . "</li></a>";	
    	echo "</ul>";
    	echo "<ul id=\"sortable2\" class=\"connectedSortable\">";
		$fileNamexp = explode(".", $fileNames[3]);
        echo "<a href=\"test_link.php?path=" . $filePaths[3] . "\\\\" . $fileNames[3] . "\"><li style=\"display: list-item;\" id=\"item5\">" . $fileNamexp[0] . "</li></a>";
		$fileNamexp = explode(".", $fileNames[4]);
        echo "<a href=\"test_link.php?path=" . $filePaths[4] . "\\\\" . $fileNames[4] . "\"><li style=\"display: list-item;\" id=\"item6\">" . $fileNamexp[0] . "</li></a>";
		$fileNamexp = explode(".", $fileNames[5]);
		echo "<a href=\"test_link.php?path=" . $filePaths[5] . "\\\\" . $fileNames[5] . "\"><li style=\"display: list-item;\" id=\"item7\">" . $fileNamexp[0] . "</li></a>";
    	echo "</ul>";
    	echo "<ul id=\"sortable3\" class=\"connectedSortable\">";
		$fileNamexp = explode(".", $fileNames[6]);
        echo "<a href=\"test_link.php?path=" . $filePaths[6] . "\\\\" . $fileNames[6] . "\"><li style=\"display: list-item;\" id=\"item10\">" . $fileNamexp[0] . "</li></a>";
		$fileNamexp = explode(".", $fileNames[7]);
        echo "<a href=\"test_link.php?path=" . $filePaths[7] . "\\\\" . $fileNames[7] . "\"><li style=\"display: list-item;\" id=\"item11\">" . $fileNamexp[0] . "</li></a>";
		$fileNamexp = explode(".", $fileNames[8]);
		echo "<a href=\"test_link.php?path=" . $filePaths[8] . "\\\\" . $fileNames[8] . "\"><li style=\"display: list-item;\" id=\"item12\">" . $fileNamexp[0] . "</li></a>";	
    	echo "</ul>";
        echo "<ul id=\"sortable4\" class=\"connectedSortable\">";
		$fileNamexp = explode(".", $fileNames[9]);
        echo "<a href=\"test_link.php?path=" . $filePaths[9] . "\\\\" . $fileNames[9] . "\"><li style=\"display: list-item;\" id=\"item15\">" . $fileNamexp[0] . "</li></a>";
		$fileNamexp = explode(".", $fileNames[10]);
        echo "<a href=\"test_link.php?path=" . $filePaths[10] . "\\\\" . $fileNames[10] . "\"><li style=\"display: list-item;\" id=\"item16\">" . $fileNamexp[0] . "</li></a>";
		$fileNamexp = explode(".", $fileNames[11]);
		echo "<a href=\"test_link.php?path=" . $filePaths[11] . "\\\\" . $fileNames[11] . "\"><li style=\"display: list-item;\" id=\"item17\">" . $fileNamexp[0] . "</li></a>";	
    	echo "</ul>";
		?>
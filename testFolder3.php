<?php 
session_start();
include"includes/scripts.php";?>
<?php

$mysqli = new mysqli("localhost", "root", "Dapp3rDan1", "portal");
if ($mysqli->connect_errno) {
	echo "Connection to portal db failed";
	exit();
}

$mysql_query = "SELECT report_id FROM reports_fav WHERE user_id = '" . $_SESSION['userid'] . "';";
$result = $mysqli->query($mysql_query);
$favorites = array();
$favCounter = 0;
if($result->num_rows > 0){
	while($row = mysqli_fetch_object($result)) {
		$favorites[$row->report_id] = true;
		$favCounter++;
	}
}



$sql = "SELECT * FROM rep_rainmaker WHERE FIND_IN_SET( 2, rights ) <> 0 ORDER BY accessType DESC, reportTitle ASC;";
$res = $mysqli->query($sql);
$pathArray = array();
$fileData = array();

while($row = mysqli_fetch_object($res)) {
	$fileData[$row->reportClass][$row->id]['title'] = $row->reportTitle;
	$fileData[$row->reportClass][$row->id]['access'] = $row->accessType;
	$fileData[$row->reportClass][$row->id]['path'] = $row->relativePath;
	$fileData[$row->reportClass][$row->id]['id'] = $row->id;
	
}



function buildVirtualStructure($path, $currentArray = array(), $inside = false) {
	$testArray = $currentArray;
	if(!is_dir($path)) {
		return '';
	}
	foreach (new DirectoryIterator($path) as $fileInfo) {
		$explode = explode('.',$fileInfo->getFilename());
		if($fileInfo->isDot()) continue;
		if(($fileInfo->isFile()) && ($fileInfo->getExtension() == "pdf")){
			$testArray[] = $fileInfo->getPathName();
		} elseif($fileInfo->isDir() && !$fileInfo->isDot() && $explode[0] != '') {
			//echo $fileInfo->getPathName() . "<br />";
			buildVirtualStructure($fileInfo->getPathName(),$testArray,true);
		}
	}
	if($inside) {
		//echo 1;
		return '';
	}
	//echo "<pre>";
	//print_r($testArray);
	//echo "</pre>";
	$virtualStructure = array();
	$yearCounter = array();
	$unsortedStructure = array();
	foreach($testArray as $file) {
		$exploded = explode('.',$file);
		$dateString = substr($exploded[count($exploded) - 2],-6);
		//$breakCharacter = substr($dateString,2,1);
		//$datePieces = explode($breakCharacter,$dateString);
		$datePieces = array();
		$datePieces[0] = substr($dateString,0,2);
		$datePieces[1] = substr($dateString,2,2);
		$datePieces[2] = substr($dateString,4,2);
		
		if(@is_numeric($datePieces[2]) && @is_numeric($datePieces[0])) {
			@$yearCounter[$datePieces[2]]++;
			$virtualStructure[$datePieces[2]][$datePieces[0]][] = $file;
		} else {
			$unsortedStructure[] = $file;
		}
		
	}
	
	krsort($virtualStructure);
	return $virtualStructure;
}

function getDirectoryContents($path) { // will return an array of folders and files under that folder
    //echo $path;
	if(is_dir($path)) {
		$dir = new DirectoryIterator($path);
		$data = array();
		$folderData = array();
		$isEmpty = true;
		foreach ( $dir as $node ) {
			$explode = explode('.',$node->getFilename());
			if ( $node->isDir() && !$node->isDot() && $explode[0] != '') {
				
				$tempData = getDirectoryContents($node->getPath() . "\\" . $node->getFilename());
				if(@is_array($tempData)) {
					$folderData[$node->getPath(). "\\" . $node->getFilename()] = $tempData;
					$isEmpty = false;
				}
			} else if ( $node->isFile() && $node->getExtension() == "pdf") {
				$data[] = $node->getPath(). "\\" . $node->getFilename();
				$isEmpty = false;
			}
		}
		if($isEmpty) {
			return "";
		} else {
			foreach($folderData as $key => $value) {
				$data[$key] = $value;
			}
			return $data;
		}
	}
}

function printVirtualArchive($virtualStructure) {
	$data = "";
	if(count($virtualStructure) > 0) {
	$data .= "<ul>";
	foreach($virtualStructure as $year => $month) {
		$data .= "<li>";
		$data .= "<span class=\"folder\"><span class=\"reportTitle\">20" .$year ."</span></span>\n";
		$data .= "<ul>";
		for($m = 12; $m > 0; $m--) {
			$monthFormated = sprintf("%02d", $m);
			if(@is_array($month[$monthFormated])) {
				$data .= "<li>";
				$data .= "<span class=\"folder\"><span class=\"reportTitle\">" . date('F',mktime(0,0,0,$m,1,2013)) ." 20" .$year ."</span></span>\n";
				$data .= "<ul>";
				foreach($month[$monthFormated] as $archivedFile) {
					$explodeFileName = explode('\\',$archivedFile);
					
					$data .= "<li>";
					$data .= "<span class=\"file\">";
					$data .= "<span class=\"reportTitle\"><a target=\"_blank\" href=\"https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/test_link.php?path=" . $archivedFile ."\">";
					$data .= $explodeFileName[count($explodeFileName)-1];
					$data .= "</a></span>";
					$data .= "</span>\n";
					$data .= "</li>";
				}
				$data .= "</ul>";
				$data .= "</ll>";
			}
		}
		$data .= "</ul>";
		$data .= "</ll>";
	}
	$data .= "</ul>";
	}
	return $data;
}

function printArrayOfFolders($array) {
	$data = "";
	if(@is_array($array) && count($array) > 0) {
		$data .= "<ul>\n";
	
		foreach($array as $key => $value) {
			$data .= "<li>\n";
			if(is_array($value)) {
				$explode = explode('\\',$key);
				$data .= "<span class=\"folder\"><span class=\"reportTitle\">" .$explode[count($explode)-1]."</span></span>\n";
				$data .= printArrayOfFolders($value);
			} else {
				$explode = explode('\\',$value);
				$data .= "<span class=\"file\">";
				$data .= "<span class=\"reportTitle\"><a target=\"_blank\" href=\"https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/test_link.php?path=" . $value ."\">";
				$data .= $explode[count($explode)-1];
				$data .= "</a></span>";
				$data .= "</span>\n";
			}
			$data .= "</li>\n";
		}
		$data .= "</ul>\n";
	}
	return $data;
}

echo "<pre>";
//print_r(getDirectoryContents('\\\\enas11\\test\\Rainmaker\\Charts'));
echo "</pre>";

function printArrayAsList($array, $favorites, $stopLoop = 0) {
	$data = "";
	$listOfMainItemsCounter = 0;
	foreach($array as $name => $parent) {
		$filesInCategory = false;
		foreach($parent as $child) {
			if($child['access'] != "F") {
				$lowerStructure = getDirectoryContents('\\\\enas11\\ClientSites\\Demo\\Rainmaker Casino Demo\\' . $child['path']);
				if($lowerStructure != "") {
					$filesInCategory = true;
					break;
				}
			} else {
				$virtualStructure = buildVirtualStructure('\\\\enas11\\ClientSites\\Demo\\Rainmaker Casino Demo\\' . $child['path']);
				if(count($virtualStructure) != 0) {
					$filesInCategory = true;
					break;
				}
			}
		}
		if($filesInCategory) {
			$data .= "<li>\n";
			$data .= "<span class=\"folder\"><span class=\"reportTitle\">" .$name."</span></span>\n";
			$data .= "<ul>\n";
			foreach($parent as $child) {
				
					if($child['access'] != "F") {
						$lowerStructure = getDirectoryContents('\\\\enas11\\ClientSites\\Demo\\Rainmaker Casino Demo\\' . $child['path']);
						if($lowerStructure != "") {
							$data .= "<li>\n";
							$data .= "<span class=\"folder\"><span class=\"reportTitle\">" .$child['title']."</span>";
							if(@!$favorites[$child['id']]) {
								$addShow = "";
								$removeShow = " style=\"display:none\"";
							} else {
								$addShow = " style=\"display:none\"";
								$removeShow = "";
							}
							$data .= "<a".$addShow." href=\"fav_update2.php?report=".$child['id']."\" class=\"icon addFavorite\" id=\"fav-link".$listOfMainItemsCounter."\">Favorite</a>";
							$data .= "<a".$removeShow." href=\"fav_update2.php?remove=".$child['id']."\" class=\"icon removeFavorite\" id=\"unfav-link".$listOfMainItemsCounter."\">Unfavorite</a>";
							$data .= "</span>\n";
							
							$data .= printArrayOfFolders($lowerStructure);
							$data .= "</li>\n";
						}
					} else {
						$virtualStructure = buildVirtualStructure('\\\\enas11\\ClientSites\\Demo\\Rainmaker Casino Demo\\' . $child['path']);
						if(count($virtualStructure) != 0) {
						$data .= "<li>\n";
						$data .= "<span class=\"file\"><span class=\"reportTitle\"><a target=\"_blank\" href='retrieve_target.php?relativepath=".urlencode($child['path'])."&accesstype=".$child['access']."'>" .$child['title']."</a></span> \n";
						if(@!$favorites[$child['id']]) {
							$addShow = "";
							$removeShow = " style=\"display:none\"";
						} else {
							$addShow = " style=\"display:none\"";
							$removeShow = "";
						}
						$data .= "<a".$addShow." href=\"fav_update2.php?report=".$child['id']."\"  class=\"icon addFavorite\" id=\"fav-link".$listOfMainItemsCounter."\">Favorite</a>";
						$data .= "<a".$removeShow." href=\"fav_update2.php?remove=".$child['id']."\"  class=\"icon removeFavorite\"  id=\"unfav-link".$listOfMainItemsCounter."\">Unfavorite</a>";
						$data .= "</span>\n";
						$data .= printVirtualArchive($virtualStructure);
						$data .= "</li>\n";
						}
					}
				
				$listOfMainItemsCounter++;
			}
			$data .= "</ul>\n";
		
		$data .= "</li>\n";
		}
	}	
	return $data;
}

?>

<link rel="stylesheet" href="css/reportStyle.css" />
<link href="css/jquery.treeview.css" rel="stylesheet" type="text/css" />

<script src="js/jquery.cookie.js" type="text/javascript"></script>
<script src="js/jquery.treeview.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	var requestRunning = false;
	var numberOFFavorites = <?php echo $favCounter; ?>;
	$('a.addFavorite').bind("click", function(event) {
		if (numberOFFavorites < 12) { // don't do anything if an AJAX request is pending
			requestRunning = true;
			event.preventDefault();
			var url = $(this).attr("href");
			var idOfCurrent = $(this).attr('id');
			var myID = $(this).attr("id");
			var currentObject = this;
			myID = myID.replace('fav-link','');
			$('#unfav-link'+myID).toggle(800);
			$(currentObject).toggle(800);
			$.get(url, function (resp) {
				if(resp == "You have reached your limit of 12 favorites") {
					alert(resp + "!");
				} else {
					numberOFFavorites++;
				}
				requestRunning = false;
			});
		} else {	
			alert("You have reached your limit of 12 favorites!");
		}
	});
	
	$('a.removeFavorite').bind("click", function(event) {
		event.preventDefault();
		var url = $(this).attr("href");
		var idOfCurrent = $(this).attr('id');
		$(this).toggle(800);
		var myID = $(this).attr("id");
		myID = myID.replace('unfav-link','');
		$('#fav-link'+myID).toggle(800);
		numberOFFavorites--;
		$.get(url, function (resp) {
			//alert(resp + "!");
		});
	});
	
	// first example
	$("#browser").treeview({collapsed: true, unique: true});
	
	// second example
	$("#navigation").treeview({
		persist: "location",
		collapsed: true,
		unique: true
	});
	
	// third example
	$("#red").treeview({
		animated: "fast",
		collapsed: true,
		unique: true,
		persist: "cookie",
		toggle: function() {
			window.console && console.log("%o was toggled", this);
		}
	});
	
	// fourth example
	$("#black, #gray").treeview({
		control: "#treecontrol",
		persist: "cookie",
		cookieId: "treeview-black"
	});

});
</script>

<ul id="browser" class="filetree">
<?php if(@$_GET['fav'] != "") { ?>
<?php
$lowerStructure = getDirectoryContents('\\\\enas11\\ClientSites\\Demo\\Rainmaker Casino Demo\\' . $_GET['fav']);
echo printArrayOfFolders($lowerStructure);
?>
<?php } else { ?>
<?php echo  printArrayAsList($fileData,$favorites); ?>
<?php } ?>
</ul>
<pre>
<?php //print_r($fileData); ?>
</pre>

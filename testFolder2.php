
<?php include"includes/scripts.php";?>
<?php

$mysqli = new mysqli("localhost", "root", "Dapp3rDan1", "portal");
if ($mysqli->connect_errno) {
	echo "Connection to portal db failed";
	exit();
}

$sql = "SELECT * FROM rep_rainmaker WHERE FIND_IN_SET( 2, rights ) <> 0;";
$res = $mysqli->query($sql);
$pathArray = array();
$fileData = array();
while($row = mysqli_fetch_object($res)) {
	$fileData[$row->reportClass][$row->id]['title'] = $row->reportTitle;
	$fileData[$row->reportClass][$row->id]['access'] = $row->accessType;
	$fileData[$row->reportClass][$row->id]['path'] = $row->relativePath;
}


function printArrayAsList($array, $stopLoop = 0) {
	$data = "";
	
	foreach($array as $name => $parent) {
		$data .= "<li>\n";
			$data .= "<span class=\"folder\">" .$name."</span>\n";
			$data .= "<ul>\n";
			foreach($parent as $child) {
				$data .= "<li>\n";
					if($child['access'] == "F") {
					$data .= "<span class=\"folder\"><a href='retrieve_target.php?relativepath=".urlencode($child['path'])."&accesstype=".$child['access']."'>" .$child['title']."</a></span>\n";
					} else {
					$data .= "<span class=\"file\"><a href='retrieve_target.php?relativepath=".urlencode($child['path'])."&accesstype=".$child['access']."'>" .$child['title']."</a></span>\n";
					}
				$data .= "</li>\n";
			}
			$data .= "</ul>\n";
		
		$data .= "</li>\n";
	}	
	return $data;
}

?>

<link href="css/jquery.treeview.css" rel="stylesheet" type="text/css" />

<script src="js/jquery.cookie.js" type="text/javascript"></script>
<script src="js/jquery.treeview.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	// first example
	$("#browser").treeview({collapsed: true});
	
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
<?php echo  printArrayAsList($fileData); ?>
</ul>
<pre>
<?php //print_r($fileData); ?>
</pre>

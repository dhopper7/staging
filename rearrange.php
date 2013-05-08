<?php

if(!isset($_COOKIE['username'])) {
	header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?logout=yes");
}
error_reporting(E_ALL);
session_start();

if (!empty($_SESSION["username"])) {
	$user = $_SESSION["username"];
} else {
	header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?logout=yes");
}

//echo $user;

// code below for user's custom layout
	
$mysqli = new mysqli("localhost", "root", "Dapp3rDan1", "portal");
if ($mysqli->connect_errno) {
	echo "Connection to portal db failed";
	exit();
}

// Attempt to pull user's layout. If it fails, use default layout

$mysql_query = "SELECT dashLayout from user_layouts WHERE userID = \"" . $_SESSION['userid'] . "\"";
$result = $mysqli->query($mysql_query);
if($result->num_rows > 0){
	$row = mysqli_fetch_object($result);
	$user_layout = $row->dashLayout;
	$user_layout = explode(',',$user_layout);
} else {
	$mysql_query = "INSERT INTO user_layouts (userID, dashLayout) VALUES (\"" . $_SESSION['userid'] . "\", \"panela,panelb,panelc,paneld\")";
	if ($mysqli->query($mysql_query) === FALSE) {
		echo "Insert record of layout failed";
		exit();
	}
	$user_layout = array('panela','panelb','panelc','paneld');
}

?>

<!doctype html>
 
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>jQuery UI Sortable - Default functionality</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <!--<script src="js/test_sort.js"></script>-->
    <link rel="stylesheet" href="/resources/demos/style.css" />
    
    <script>
    $(function() {
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
		$( "#sortable" ).bind("sortstop", function(event, ui){
			result = "";
			
			$(this).find("li").each(function(){
				result += $(this).text() + ",";
			});
			result_len = result.length;
			result = jQuery.trim(result).substring(0, result_len - 1);
			//alert(result);
		});
		
		$("#checkmark").click(function(){
		//alert("CLICKED!");
		var JSONObject = {
			"order":result
		};
		$.ajax({
			type: "POST",
			url: "jq_receive.php",
			data: JSONObject,
			cache: false,
			async: false,
			//success: function(){
			//	alert("DEBUG JSON sent to php!");
			//}
		});
		
			window.parent.tb_remove();
			window.parent.location.reload(1);
		
		//alert("TEST");
		//location.replace('https://10.10.10.199/portaljg/success.php');
		});
    });
    </script>
    <link rel="stylesheet" href="css/ccm.base.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/ui.core.css">
    <link rel="stylesheet" href="css/thickbox.css">
</head>
<body>
 

<ul id="sortable">
    <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $user_layout[0]?></li>
    <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $user_layout[1]?></li>
    <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $user_layout[2]?></li>
    <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $user_layout[3]?></li>
    
</ul>

<br>
<div id="checkmark"><a href="#"><img src="img/p2h_icon_checkmark.png"></a></div><div id="x_cancel"><a href="#" onClick="parent.location.reload(1)"><img src="img/p2h_icon_x.png"></a></div>
 
</body>
</html>
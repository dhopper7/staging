<?php
error_reporting(E_ALL ^ E_NOTICE);

session_start();
require_once('firephp/FirePHP.class.php');
$firephp = FirePHP::getInstance(true);
$firephp->log("TEST", 'test');
if(isset($_SESSION['path'])){
	$firephp->log($_SESSION['path'], "PATH");
} else {
	$firephp->log("NOT SET", "PATH");
}
if(isset($_SESSION['startpath'])){
	$firephp->log($_SESSION['startpath'], "STARTPATH");
} else {
	$firephp->log("NOT SET", "STARTPATH");
}
if(isset($_SESSION['debug'])){
	$firephp->log($_SESSION['debug'], "DEBUG");
} else {
	$firephp->log("NOT SET", "DEBUG");
}

$_SESSION['path'] = "";
$_SESSION['startpath'] = "";
$_SESSION['folderpath'] = "";

if(!isset($_COOKIE['username'])) {
	header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?logout=yes");
}
error_reporting(E_ALL);


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
	//$user_layout = array('flash','chart','reports','contacts');
}
	
// Attempt to pull user's reports layout. If it fails, use default blank layout

$mysql_query = "SELECT fileNames, filePaths, pointerTypes, labelNames from user_reports WHERE userID = \"" . $_SESSION['userid'] . "\"";
$result = $mysqli->query($mysql_query);
if($result->num_rows > 0){
$row = mysqli_fetch_object($result);
$fileNames = $row->fileNames;
$filePaths = $row->filePaths;
$fileTypes = $row->pointerTypes;
$fileLabels = $row->labelNames;
$fileNames = explode(',',$fileNames);
$filePaths = explode(',',$filePaths);
$fileTypes = explode(',',$fileTypes);
$fileLabels = explode(',',$fileLabels);

} else {
	$mysql_query = "INSERT INTO user_reports (userID, fileNames, filePaths) VALUES (\"" . $_SESSION['userid'] . "\", \"\",\"\")";
	if ($mysqli->query($mysql_query) === FALSE) {
		echo "Insert record of reports failed";
		exit();
	}
	$fileNames = array("","","","","","","","","","","","","","","","","","","","");
	$filePaths = array("","","","","","","","","","","","","","","","","","","","");
}

	
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        
<?php include"includes/cssLink.php";?>
<?php include"includes/scripts.php";?>	

    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->

        <?php include"includes/header.php"?>

        
        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.min.js"><\/script>')</script>-->

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID.
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script> -->
<!--        <div id = "flash_title">
        </div>-->
        
<div class="dotted-box-top">
<div class="dotted-box-bottom">
		<?php include"includes/tabs.php";?>
</div>
</div>

<div id="charts-section">
<div id="charts" class="box-content">
<?php include"charts1/index.php";?>	
</div>
</div>

<div id="reports-section">
<div id="reports" class="box-content">
<?php include"includes/reports2.php";?>
</div>
<div id="reports_title" align="left">
		<div id="reports_add"><a class="icon add thickbox" href="testFolder3.php?height=400&width=600&TB_iframe=true" title="Add/Browse Reports">Add/Browse Reports</a></div>
        <div id="reports_edit"><a class="icon edit" href="JavaScript:void(0)" title="Modify Order">Edit Reports</a></div>
        <div id="reports_done"><a class="icon done" href="JavaScript:void(0)" title="Confirm">Done</a></div>
        <div id="reports_cancel"><a class="icon cancel" href="JavaScript:location.reload();" title="Cancel">Cancel</a></div>
        <div id="reports_trash"><a class="icon trash" href="#reports" title="Trash">Trash</a>
        	<ul class="connectedSortable" id="sortableTrash"></ul>
        </div>
</div>
</div>
	
<div class="dark-row">
<div class="dark-row-top-shadow">
<div id="dark-row-container" class="box-content">
<div id="dark-row-left" class="left-side">
<div id="contacts_title" class="clearfix">Contacts</div>
<div id="contacts" class="clearfix">
<?php include"includes/contacts.php";?>
</div>
</div>
<div id="dark-row-right" class="right-side">
<?php include"includes/links.php";?>
</div>
</div>
</div><!-- end dark-row-top-shadow -->
</div><!-- end dark-row -->

<?php include"includes/footer.php";?>
</body>
</html>

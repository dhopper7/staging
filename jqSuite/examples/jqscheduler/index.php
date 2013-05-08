<?php 
session_start();
require_once '../../../jqSuitePHP_Sources_4_4_4_0/examples/jqscheduler/tabs.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	  
    <style type="text">
        html, body {
			margin: 0;			/* Remove body margin/padding */
			padding: 0;
		    overflow: hidden;	/* Remove scroll bars on browser window */
	        font-size: 62.5%;

        }
		body {
			font-family: "Trebuchet MS", "Helvetica", "Arial",  "Verdana", "sans-serif";
		}
    </style>
    <title>jqScheduler PHP Demo</title>
    <link rel="stylesheet" type="text/css" media="screen" href="../../../jqSuitePHP_Sources_4_4_4_0/themes/redmond/jquery-ui-custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../../jqSuitePHP_Sources_4_4_4_0/themes/jquery.ui.tooltip.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../../jqSuitePHP_Sources_4_4_4_0/themes/jqscheduler.css" />
    <script src="../../../jqSuitePHP_Sources_4_4_4_0/js/jquery.js" type="text/javascript"></script>
    <script src="../../../jqSuitePHP_Sources_4_4_4_0/js/jquery-ui-custom.min" type="text/javascript"></script>
    <script src="../../../jqSuitePHP_Sources_4_4_4_0/js/jquery.jqScheduler.min.js" type="text/javascript"></script>
	
  </head>
  <body>
<!-- <div id="calendar" style="height: 900px;margin: 0 auto;width:1000px;font-size: 0.8em;"></div> -->
<?php require_once("../../../jqSuitePHP_Sources_4_4_4_0/examples/jqscheduler/eventcal.php");?>
<br/>
<?php tabs(array("eventcal.php"));?>
     
   </body>
</html>

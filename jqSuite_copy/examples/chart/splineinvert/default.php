<?php 
require_once '../../../tabs.php';
?>
<!DOCTYPE html>
<html>
  <head>
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
		#tags {z-index: 900}
    </style>
    <title>jqChart PHP Demo</title>
    <link rel="stylesheet" type="text/css" media="screen" href="../../../../jqSuite/themes/redmond/jquery-ui-custom.css" />
    <script src="../../../../jqSuite/js/jquery.js" type="text/javascript"></script>
    <script src="../../../../jqSuite/js/jquery.jqChart.min.js" type="text/javascript"></script>
     
    <script src="../../../../jqSuite/js/jquery-ui-custom.min.js" type="text/javascript"></script>
  </head>
  <body>
      <div>
		<?php include ("../../../../jqSuite/examples/chart/splineinvert/chart.php");?>
      </div>
      <br/>
      <?php tabs(array("chart.php"));?>
   </body>
</html>

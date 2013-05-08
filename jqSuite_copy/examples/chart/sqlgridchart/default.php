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
    <title>jqChart and jqGrid PHP Demo</title>
    <link rel="stylesheet" type="text/css" media="screen" href="../../../../jqSuite/themes/redmond/jquery-ui-custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../../../jqSuite/themes/ui.jqgrid.css" />
    <script src="../../../../jqSuite/js/jquery.js" type="text/javascript"></script>
    <script src="../../../../jqSuite/js/i18n/grid.locale-en.js" type="text/javascript"></script>

    <script src="../../../../jqSuite/js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <script src="../../../../jqSuite/js/jquery.jqChart.min.js" type="text/javascript"></script>
     
    <script src="../../../../jqSuite/js/jquery-ui-custom.min.js" type="text/javascript"></script>
	<script type="text/javascript"> var mychart; </script>
  </head>
  <body>
		<?php include ("../../../../jqSuite/examples/chart/sqlgridchart/chart.php");?>
		<div style="margin: 0 auto; width:720px">
			<table id="grid"></table>
			<div id="pager"></div>
		</div>
      <br/>
      <?php tabs(array("chart.php"));?>
   </body>
</html>

<?php 
require_once '../../../../jqSuitePHP_Sources_4_4_4_0/tabs.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Highcharts Example</title>

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
    <link rel="stylesheet" type="text/css" media="screen" href="../../../../jqSuitePHP_Sources_4_4_4_0/themes/redmond/jquery-ui-custom.css" />
    <script src="../../../../jqSuitePHP_Sources_4_4_4_0/js/jquery.js" type="text/javascript"></script>
    <script src="../../../../jqSuitePHP_Sources_4_4_4_0/js/jquery.jqChart.min.js" type="text/javascript"></script>
     
    <script src="../../../../jqSuitePHP_Sources_4_4_4_0/js/jquery-ui-custom.min.js" type="text/javascript"></script>
  </head>
  <body>
      <div>
		<?php include ("../../../../jqSuitePHP_Sources_4_4_4_0/examples/chart/combo-multi-axes/chart.php");?>
      </div>
      <br/>
      <?php tabs(array("chart.php"));?>
   </body>
</html>

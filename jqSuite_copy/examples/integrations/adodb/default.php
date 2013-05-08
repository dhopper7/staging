<?php 
require_once '../../../tabs.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>jqGrid PHP Demo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../../../jqSuite/themes/redmond/jquery-ui-custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../../../jqSuite/themes/ui.jqgrid.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../../../jqSuite/themes/ui.multiselect.css" />
    <style type="text">
        html, body {
        margin: 0;			/* Remove body margin/padding */
    	padding: 0;
        overflow: hidden;	/* Remove scroll bars on browser window */
        font-size: 75%;
        }
    </style>
    <script src="../../../../jqSuite/js/jquery.js" type="text/javascript"></script>
    <script src="../../../../jqSuite/js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script type="text/javascript">
	$.jgrid.no_legacy_api = true;
	//$.jgrid.useJSON = true;
	</script>
    <script src="../../../../jqSuite/js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <script src="../../../../jqSuite/js/jquery-ui-custom.min.js" type="text/javascript"></script>
  </head>
  <body>
      <div>
          <?php include ("../../../../jqSuite/examples/integrations/adodb/grid.php");?>
      </div>
      <br/>
      <?php tabs(array("grid.php"));?>
   </body>
</html>

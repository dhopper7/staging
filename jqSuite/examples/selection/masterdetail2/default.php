<?php
require_once '../../../../jqSuitePHP_Sources_4_4_4_0/tabs.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>jqGrid PHP Demo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../../../jqSuitePHP_Sources_4_4_4_0/themes/redmond/jquery-ui-custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../../../jqSuitePHP_Sources_4_4_4_0/themes/ui.jqgrid.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../../../jqSuitePHP_Sources_4_4_4_0/themes/ui.multiselect.css" />
    <style type="text">
        html, body {
        margin: 0;			/* Remove body margin/padding */
    	padding: 0;
        overflow: hidden;	/* Remove scroll bars on browser window */
        font-size: 75%;
        }
    </style>
    <script src="../../../../jqSuitePHP_Sources_4_4_4_0/js/jquery.js" type="text/javascript"></script>
    <script src="../../../../jqSuitePHP_Sources_4_4_4_0/js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script type="text/javascript">
	$.jgrid.no_legacy_api = true;
	$.jgrid.useJSON = true;
	</script>
    <script src="../../../../jqSuitePHP_Sources_4_4_4_0/js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <script src="../../../../jqSuitePHP_Sources_4_4_4_0/js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
  </head>
  <body>
      <div>
          <b>Employees</b>
          <?php include ("../../../../jqSuitePHP_Sources_4_4_4_0/examples/selection/masterdetail2/grid.php");?>
      </div>
      <div>
          <b>Orders for the selected Employee</b>
          <?php include ("../../../../jqSuitePHP_Sources_4_4_4_0/examples/selection/masterdetail2/detail.php");?>
      </div>
      <br/>
      <?php tabs(array("grid.php","detail.php"));?>
   </body>
</html>

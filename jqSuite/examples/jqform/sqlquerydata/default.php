<?php
require_once '../../../../jqSuitePHP_Sources_4_4_4_0/tabs2.php';
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
  <head>
    <title>jqForm PHP Demo</title>
    <link rel="stylesheet" type="text/css" media="screen" href="../../../../jqSuitePHP_Sources_4_4_4_0/themes/redmond/jquery-ui-custom.css" />
    <style type="text/css">
        html, body {
        margin: 0;			/* Remove body margin/padding */
    	padding: 0;
        /*overflow: hidden;*/	/* Remove scroll bars on browser window */
        font-size: 90%;
        }
		body {
			font-family: "Trebuchet MS", "Helvetica", "Arial",  "Verdana", "sans-serif";
		}		
		.ui-input  {padding :4px; margin: 1px;}
		.ui-select  {padding : 3px;}
		.ui-textarea {padding: 3px;}
		#notsupported  { border: 0px none;}
    </style>
    <script src="../../../../jqSuitePHP_Sources_4_4_4_0/js/jquery.js" type="text/javascript"></script>
	<script src="../../../../jqSuitePHP_Sources_4_4_4_0/js/jquery-ui-custom.min.js" type="text/javascript"></script>	
    <script src="../../../../jqSuitePHP_Sources_4_4_4_0/js/jquery.form.js" type="text/javascript"></script>
    <script src="../../../../jqSuitePHP_Sources_4_4_4_0/js/modernizr-2.0.6.js" type="text/javascript"></script>
	<script type="text/javascript">
		jQuery(document).ready(function(){
		  if(Modernizr.inputtypes.number) {
			  jQuery("#supported").append("<div>Your browser support input type: number!</div>");
		  } else {
			  jQuery("#notsupported").append("<div>Your browser does not support input type: number!</div>").addClass('ui-state-error');
		  }
	  });
	</script>
	
  </head>
  <body>
      <div style="margin-left:20px;margin-right: 20px;">
          <?php include ("../../../../jqSuitePHP_Sources_4_4_4_0/examples/jqform/sqlquerydata/sqlquerydata.php");?>
		  <div style="text-align: center;margin-top:10px;">This Form is created with HTML5 PHP jqForm builder</div>
      </div>
      <br/>
	  <div id="supported"></div>
	  <div id="notsupported"></div>
      <?php tabs(array("sqlquerydata.php"));?>
   </body>
</html>

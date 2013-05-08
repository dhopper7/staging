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
    <script src="../../../../jqSuitePHP_Sources_4_4_4_0/js/jquery-ui-custom.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#frozenchange").change(function(){
				if( $(this).val() == "2" ) {
					$("#grid").jqGrid("destroyFrozenColumns")
					.jqGrid("setColProp","OrderID",{frozen:false})
					.jqGrid("setFrozenColumns")
					.trigger("reloadGrid",[{current:true}]);
				} else if($(this).val() == "3") {
					$("#grid").jqGrid("destroyFrozenColumns")
					.jqGrid("setColProp","OrderID",{frozen:true})
					.jqGrid("setFrozenColumns")
					.trigger("reloadGrid",[{current:true}]);
				}
			})
		});
	</script>
  </head>
  <body>
	  <div>
		  <select id="frozenchange">
			  <option value ="2">
				  Froze first two colums
			  </option>
			  <option value ="3">
				  Froze first three colums
			  </option>
		  </select>
	  </div>
      <div>
          <?php include ("../../../../jqSuitePHP_Sources_4_4_4_0/examples/functionality/frozendyn/grid.php");?>
      </div>
      <br/>
      <?php tabs(array("grid.php"));?>
   </body>
</html>

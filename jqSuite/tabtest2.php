<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>jQuery UI Tabs - Default functionality</title>

<link rel="stylesheet" type="text/css" media="screen" href="../jqSuitePHP_Sources_4_4_4_0/jqSuite/themes/redmond/jquery-ui-1.7.2.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../jqSuitePHP_Sources_4_4_4_0/jqSuite/themes/ui.jqgrid.css" />
<script src="../jqSuitePHP_Sources_4_4_4_0/jqSuite/js/jquery.js" type="text/javascript"></script>
<script src="../jqSuitePHP_Sources_4_4_4_0/jqSuite/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="../jqSuitePHP_Sources_4_4_4_0/jqSuite/js/jquery.jqGrid.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="/resources/demos/style.css" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

<script>
$(function() {
$( "#tabs" ).tabs();
});
</script>
</head>
<body>
<div id="tabs">
<ul>
<li><a href="#tabs-1">Flash Template</a></li>
<li><a href="#tabs-2">Charts</a></li>
<li><a href="#tabs-3">Something else</a></li>
</ul>
<div id="tabs-1">

<p>
<?php include "../jqSuitePHP_Sources_4_4_4_0/jqSuite/myfirstgrid.php";?>
</p>
</div>
<div id="tabs-2">
<p></p>
</div>
<div id="tabs-3">
<p></p>
</div>
</div>
</body>
</html>
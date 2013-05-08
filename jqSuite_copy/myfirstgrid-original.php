<?php
require_once 'jq-config.php';
// include the jqGrid Class
require_once "../jqSuite/php/jqGrid.php";
// include the PDO driver class
require_once "../jqSuite/php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);

// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
// We suppose that mytable exists in your database
$grid->SelectCommand = 'SELECT field1, field2, field3  FROM mytable';

// set the ouput format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('myfirstgrid.php');
// Set grid caption using the option caption
$grid->setGridOptions(array(
    "caption"=>"This is custom Caption",
    "rowNum"=>10,
    "sortname"=>"field1",
    "rowList"=>array(10,20,50)
    ));

// Change some property of the field(s)
$grid->setColProperty("field1", array("label"=>"ID", "width"=>60));

// Run the script
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
?>
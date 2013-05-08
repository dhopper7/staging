<?php
require_once '../jqSuitePHP_Sources_4_4_4_0/jqSuite/jq-config.php';
// include the jqGrid Class
require_once "../jqSuitePHP_Sources_4_4_4_0/jqSuite/php/jqGrid.php";
// include the PDO driver class
require_once "../jqSuitePHP_Sources_4_4_4_0/jqSuite/php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);

// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
// We suppose that mytable exists in your database
$grid->SelectCommand = 'SELECT Today, Revenue_Type, Today_Win, LY_Win, MTD_Win, MTDPM_Win, MTDPY_Win, YTD_Win, YTDPY_Win FROM flash_template';

// set the ouput format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('gridtest.php');
// Set grid caption using the option caption
$grid->setGridOptions(array(
    "caption"=>"Flash Template",
    "rowNum"=>10,
    "sortname"=>"ID",
    "rowList"=>array(10,20,50)
    ));

// Change some property of the field(s)
$grid->setColProperty("Revenue_Type", array("label"=>"Revenue_Type", "width"=>200));
$grid->setColProperty("Today_Win", array("label"=>"Win", "width"=>200));
$grid->setColProperty("LY_Win", array("label"=>"Last Year Win", "width"=>200));


$grid->setGridOptions(array("width"=>600,"height"=>400));



// Run the script

$grid->renderGrid('#grid',null,true, null, null, true,true);
?>
<?php
require_once '../../../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
require_once ABSPATH."php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
// Tell the db that we use utf-8
$conn->query("SET NAMES utf8");

// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$grid->SelectCommand = 'SELECT OrderID, OrderDate, CustomerID, ShipName, Freight  FROM orders';
// set the ouput format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// Set the initial sorting column using the sortname oprion
$grid->setGridOptions(array("sortname"=>"OrderID","rowNum"=>10,"rowList"=>array(10,20,30)));
// Disable sorting on these columns
$grid->setColProperty("OrderDate", array(
    "sortable"=>false,
    "formatter"=>"date",
    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y")
    )
);
$grid->setColProperty("OrderID", array("sortable"=>false));
$grid->setColProperty("CustomerID", array("sortable"=>false));
$grid->setColProperty("ShipName", array("sortable"=>false));

// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>

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
$grid->SelectCommand = 'SELECT orders.OrderID, orders.OrderDate, orders.CustomerID, customers.CompanyName, orders.Freight, orders.ShipName FROM orders, customers WHERE orders.CustomerID=customers.CustomerID';
// set the ouput format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// Set grid caption using the option caption
$grid->setGridOptions(array(
    "caption"=>"Arbitrary SQL in action",
    "rowNum"=>10,
    "sortname"=>"OrderID",
    "hoverrows"=>true,
    "rowList"=>array(10,20,50),
    ));
// Change some property of the field(s)
$grid->setColProperty("OrderID", array("label"=>"ID", "width"=>60));
$grid->setColProperty("CustomerID", array("hidden"=>true));
$grid->setColProperty("OrderDate", array(
    "formatter"=>"date",
    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y")
    )
);
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>

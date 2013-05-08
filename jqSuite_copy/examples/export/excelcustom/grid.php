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
$grid->SelectCommand = 'SELECT OrderID, OrderDate, CustomerID, ShipName, Freight FROM orders a';
//$grid->debug = true;
// Set up different query for the export to excel
// Also this command is valid for all exporting modules.
$grid->ExportCommand = 'SELECT a.OrderID, a.OrderDate, b.CompanyName, a.ShipName, a.Freight, a.CustomerID FROM orders a, customers b WHERE a.CustomerID=b.CustomerID';

// Set output format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// Set some grid options
$grid->setGridOptions(array(
    "rowNum"=>10,
    "rowList"=>array(10,20,30),
    "sortname"=>"OrderID",
	"caption"=>"Excel export custom SQL"

));
// Change some property of the field(s)
$grid->setColProperty("OrderDate", array(
    "formatter"=>"date",
    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y"),
    "search"=>false
    )
);

$grid->setColProperty("ShipName", array("width"=>"200"));
// Enable navigator
$grid->navigator = true;
// Enable excel export
$grid->setNavOptions('navigator', array("excel"=>true,"add"=>false,"edit"=>false,"del"=>false,"view"=>false));
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>

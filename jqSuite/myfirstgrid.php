<?php
require_once '/jq-config.php';
// include the jqGrid Class
require_once "/php/jqGrid.php";
// include the PDO driver class
require_once "/php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);

// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
// We suppose that mytable exists in your database
$grid->SelectCommand = 'SELECT ID, Today, Revenue_Type, Today_Win, LY_Win, MTD_Win, MTDPM_Win, MTDPY_Win, YTD_Win, YTDPY_Win FROM flash_template';


// set the ouput format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('jqsuite/myfirstgrid.php');


$dteFilter = "2012-12-08";
// Apply Date filter
$arr = <<< FILTERDATE
   {
      "groupOp":"AND",
      "rules":[
      {"field":"Today","op":"eq","data":$dteFilter}
      ]
   }
FILTERDATE;




// Set grid caption using the option caption
$grid->setGridOptions(array(
    "caption"=>"Daily Flash",
    "rowNum"=>10,
    "sortname"=>"ID",
    "rowList"=>array(10,20,50),
	"hoverrows"=>true,
	"search"=>true,
	"postData"=>array("filters"=>$arr)
    ));

// Change some property of the field(s)
$grid->setColProperty("Today", array("hidden"=>false, "label"=>"Today", "width"=>200));
$grid->setColProperty("Revenue_Type", array("label"=>"Revenue Type", "width"=>200));
$grid->setColProperty("Today_Win", array("label"=>"Win", "align"=>"right", "width"=>200));
$grid->setColProperty("LY_Win", array("label"=>"Last Year Win", "align"=>"right", "width"=>200));
$grid->setColProperty("MTD_Win", array("label"=>"Month To Date", "align"=>"right", "width"=>200));
$grid->setColProperty("MTDPM_Win", array("label"=>"MTD Previous Month", "align"=>"right", "width"=>200));
$grid->setColProperty("MTDPY_Win", array("label"=>"MTD Previous Year", "align"=>"right", "width"=>200));
$grid->setColProperty("YTD_Win", array("label"=>"Year To Date", "align"=>"right", "width"=>200));
$grid->setColProperty("YTDPY_Win", array("label"=>"YTD Previous Year", "align"=>"right", "width"=>200));



$grid->setGridOptions(array("width"=>'950',"height"=>'100%'));



// Run the script

$grid->renderGrid('#grid',null,true, null, null, true,true);
?>

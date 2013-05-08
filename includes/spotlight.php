<?php
error_reporting(E_ALL ^ E_NOTICE);
//Requires the NuSOAP library
$rootPath = str_replace('includes','',__DIR__);
include_once($rootPath.'/nusoap-0.9.5/lib/nusoap.php');

$username = 'FINLEY-COOK\msshare_admin';
$password = '1mbsatnP';
$rowLimit = '60';
$item_gd = ($_GET["gamedate"] != "") ? $_GET['gamedate'] . " 00:00:00" : NULL;
$item_cp = ($_GET["property"] != "") ? $_GET["property"] : "Rainmaker";
$listName = "Portal Spotlight";
$wsdl = "http://10.10.10.199/staging/doc/Lists2.wsdl";
  
//Basic authentication. Using UTF-8 to allow special characters.
$client = new nusoap_client($wsdl, true);
$client->setCredentials($username,$password);
$client->soap_defencoding='UTF-8';

$newestXml ='
	<GetListItems xmlns="http://schemas.microsoft.com/sharepoint/soap/">
	<listName>'.$listName.'</listName>
	<rowLimit>'.$rowLimit.'</rowLimit>
	<query><Query><Where><Eq><FieldRef Name="Property_List" /><Value Type="Choice">' . $item_cp . '</Value></Eq></Where><OrderBy><FieldRef Name="Game_Date" Ascending="False" /></OrderBy></Query></query>
	</GetListItems>
	';
	
$oldestXML = '
	<GetListItems xmlns="http://schemas.microsoft.com/sharepoint/soap/">
	<listName>'.$listName.'</listName>
	<rowLimit>'.$rowLimit.'</rowLimit>
	<query><Query><Where><Eq><FieldRef Name="Property_List" /><Value Type="Choice">' . $item_cp . '</Value></Eq></Where><OrderBy><FieldRef Name="Game_Date" Ascending="True" /></OrderBy></Query></query>
	</GetListItems>
	';
	
$lastClosedXML = '
	<GetListItems xmlns="http://schemas.microsoft.com/sharepoint/soap/">
	<listName>'.$listName.'</listName>
	<rowLimit>1</rowLimit>
	<query><Query><Where><Eq><FieldRef Name="Property_List" /><Value Type="Choice">' . $item_cp . '</Value></Eq></Where><OrderBy><FieldRef Name="Closed" Ascending="False" /><FieldRef Name="Game_Date" Ascending="False" /></OrderBy></Query></query>
	</GetListItems>
	';
	
$newestResult = $client->call('GetListItems', $newestXml);
$oldestResult = $client->call('GetListItems', $oldestXML);

$lastClosedResult = $client->call('GetListItems', $lastClosedXML);
//echo "<pre>";
//print_r($lastClosedResult);
//echo "</pre>";

if($lastClosedResult['GetListItemsResult']['listitems']['data']['row']['!ows_Closed'] == 1) {
	$lastClosed = date('m/d/Y',strtotime($lastClosedResult['GetListItemsResult']['listitems']['data']['row']['!ows_Game_Date']));;
} else {
	$lastClosed = "N/A";
}

$newestDate = strtotime($newestResult['GetListItemsResult']['listitems']['data']['row'][0]['!ows_Game_Date']);
$oldestDate = strtotime($oldestResult['GetListItemsResult']['listitems']['data']['row'][0]['!ows_Game_Date']);

//XML for the request. Add extra fields as necessary
if($item_gd == NULL){
	$xml ='
	<GetListItems xmlns="http://schemas.microsoft.com/sharepoint/soap/">
	<listName>'.$listName.'</listName>
	<rowLimit>1</rowLimit>
	<query><Query><Where><Eq><FieldRef Name="Property_List" /><Value Type="Choice">' . $item_cp . '</Value></Eq></Where><OrderBy><FieldRef Name="Game_Date" Ascending="False" /></OrderBy></Query></query>
	</GetListItems>
	';
} else {
	$xml ='
	<GetListItems xmlns="http://schemas.microsoft.com/sharepoint/soap/">
	<listName>'.$listName.'</listName>
	<rowLimit>1</rowLimit>
	<query><Query><Where><And><Eq><FieldRef Name="Game_Date" /><Value IncludeTimeValue="TRUE" Type="DateTime">' . $item_gd . '</Value></Eq><Eq><FieldRef 		Name="Property_List" /><Value Type="Choice">' . $item_cp . '</Value></Eq></And></Where></Query></query>
	</GetListItems>
	';
}
 
//Invoke the Web Service
$newestResult = $client->call('GetListItems', $newestXml);
$result = $client->call('GetListItems', $xml);

$dateRangeXml ='
	<GetListItems xmlns="http://schemas.microsoft.com/sharepoint/soap/">
	<listName>'.$listName.'</listName>
	<rowLimit>'.$rowLimit.'</rowLimit>
	<query><Query><OrderBy><FieldRef Name="Game_Date" Ascending="False" /></OrderBy></Query></query>
	</GetListItems>
	';
	
$dateRangeResult = $client->call('GetListItems', $dateRangeXml);
$dateArray = array();
//echo "<pre>";
//print_r($dateRangeResult);
//echo "</pre>";
foreach($dateRangeResult['GetListItemsResult']['listitems']['data']['row'] as $dateToGet) {
	$date = $dateToGet['!ows_Game_Date'];
	$datex = explode(' ',$date);
	$dateArray[] = $datex[0];
}




 
//Error check
if(isset($fault)) {
  echo("<h2>Error</h2>". $fault);
}

//echo ($result['GetListItemsResult']['listitems']['data']['row']['!ows_Property_List']);

unset($client);

//return $result;

?>

<script>
$(function() {
	var dates_allowed = {
		<?php
		$i = 0;
		foreach($dateArray as $dataDate) {
			if(($dataDate + (60 * 60 * 24 * 60) > $newestDate)) {
				//$oldestDate = $dataDate[$i - 1];
				break;
			}
			if($i != 0) {
				echo ",";
			}
			$i++;
			echo "'".$dataDate."': 1";
			
		 } ?>
    };
	
	
	$( "#spotdatepicker" ).datepicker({dateFormat:'mm/dd/yy', changeMonth: false, changeYear: false, minDate: new Date(<?php echo date('Y',$oldestDate); ?>,<?php echo (date('m',$oldestDate)-1); ?>,<?php echo date('d',$oldestDate); ?>), maxDate: new Date(<?php echo date('Y',$newestDate); ?>,<?php echo (date('m',$newestDate)-1); ?>,<?php echo date('d',$newestDate); ?>),numberOfMonths: 3, showCurrentAtPos: 2,beforeShowDay: function(date) {

            // prepend values lower than 10 with 0
            function addZero(no) {
                if (no < 10){
                  return "0" + no;
                }  else {
                  return no; 
                }
            }

            var date_str = [
                addZero(date.getFullYear()),
                addZero(date.getMonth() + 1),
                addZero(date.getDate())      
            ].join('-');

            if (dates_allowed[date_str]) {
                return [true, 'good_date', 'This date is selectable'];
            } else {
                return [false, 'bad_date', 'This date is NOT selectable'];
            }
        }
	});
	$( "#spotdatepicker" ).change(function() {
		var mystr = this.value;
		var explodedValue = mystr.split("/");
		var urlToRetrive = "includes/spotlight.php?gamedate="+explodedValue[2]+"-"+explodedValue[0]+"-"+explodedValue[1];
		$.get(urlToRetrive, function (resp) {
			$('#spotlightContainer').html(resp);
		});
		
	});
});
</script>

<?php 
$currentRow = $result['GetListItemsResult']['listitems']['data']['row'];
if($currentRow['!ows_Game_Date'] != "") { ?>

<table width="940px" class="spotlightTable">
	<tr>
    	<th colspan="3" align="center"><strong>SPOTLIGHT Summary</strong></th>
	</tr>
    <tr>
    	<td width="20%"><span style="float: left;">Game Date:</span>
    	  <input style="border: 1px #000 solid; width: 150px; display: block; float: left; text-align: center;" type="date" value="<?php echo date('m/d/Y',strtotime($currentRow['!ows_Game_Date'])); ?>" name="datepicker" id="spotdatepicker" maxlength="10" />
    	</td>
        <td class="spotText" style="border: #000 1px solid;" width="40%" rowspan="3"><?php echo @$currentRow['!ows_Comment']; ?>&nbsp;</td> 
      <td id="spotImage" width="40%" rowspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td>
            <span style="float: left;">Closed?</span> 
            <span style="border: 1px #000 solid; width: 150px; display: block; float: left; text-align: center;"><?php echo (@$currentRow['!ows_Closed'] == 1) ? "Yes" : "No"; ?></span>
        </td>
    </tr>
    <tr>
    	<td>
        	<span style="float: left;">Last Closed:</span> 
            <span style="border: 1px #000 solid; width: 150px; display: block; float: left; text-align: center;"><?php echo $lastClosed; ?></span>
        </td>
    </tr>
</table>

<table width="940px" border="1" class="spotlightTable">
	<tr>
    	<th width="20%">Reporting Area</th>
        <th width="40%">Issue</th>
        <th width="40%">Comments</th>
    </tr>
    <tr>
    	<td rowspan="3">Soft Count</td>
        <td class="spotText"><?php echo @$currentRow['!ows_Soft_Count_1']; ?>&nbsp;</td>
        <td class="spotText"><?php echo @$currentRow['!ows_Soft_Count_Comment_1']; ?>&nbsp;</td>
   	</tr>
    <tr>
    	<td class="spotText"><?php echo @$currentRow['!ows_Soft_Count_2']; ?>&nbsp;</td>
        <td class="spotText"><?php echo @$currentRow['!ows_Soft_Count_Comment_2']; ?>&nbsp;</td>
    </tr>
    <tr>
    	<td class="spotText"><?php echo @$currentRow['!ows_Soft_Count_3']; ?>&nbsp;</td>
        <td class="spotText"><?php echo @$currentRow['!ows_Soft_Count_Comment_3']; ?>&nbsp;</td>
    </tr>
    <tr>
    	<td rowspan="3">Meter</td>
        <td class="spotText"><?php echo @$currentRow['!ows_Meter_Machines_1']; ?>&nbsp;</td>
        <td class="spotText"><?php echo @$currentRow['!ows_Meter_Comment_1']; ?>&nbsp;</td>
    </tr>
    <tr>
    	<td class="spotText"><?php echo @$currentRow['!ows_Meter_Machines_2']; ?>&nbsp;</td>
        <td class="spotText"><?php echo @$currentRow['!ows_Meter_Comment_2']; ?>&nbsp;</td>
    </tr>
    <tr>
    	<td class="spotText"><?php echo @$currentRow['!ows_Meter_Machines_3']; ?>&nbsp;</td>
        <td class="spotText"><?php echo @$currentRow['!ows_Meter_Comment_3']; ?>&nbsp;</td>
    </tr>
    <tr>
    	<td>System</td>
        <td class="spotText"><?php echo @$currentRow['!ows_System']; ?>&nbsp;</td>
        <td class="spotText"><?php echo @$currentRow['!ows_System_Comment']; ?>&nbsp;</td>
    </tr>
    <tr>
    	<td>Other</td>
        <td class="spotText"><?php echo @$currentRow['!ows_Other']; ?>&nbsp;</td>
        <td class="spotText"><?php echo @$currentRow['!ows_Other_Comment']; ?>&nbsp;</td>
    </tr>
</table>


<?php } else { ?>
<p>
Sorry no data avaliable for <?php echo date('m/d/Y',strtotime($item_gd)); ?>!<br />
Please select another date: <input style="border: 1px #000 solid; width: 175px; display: inline; text-align: center;" type="date" value="" name="datepicker" id="spotdatepicker" maxlength="10" /><br />
Newest Game Date is <?php echo date('m/d/Y',strtotime($newestResult['GetListItemsResult']['listitems']['data']['row'][0]['!ows_Game_Date'])); ?>.
</p>
<?php } ?>
<?php

function negativesToPara($string) {
	if(substr($string,0,1) == "-") {
		return "(" . substr($string,1) . ")";
	} else {
		return $string;
	}
}

error_reporting(E_ALL ^ E_NOTICE);
$mysqli = new mysqli("localhost", "root", "Dapp3rDan1", "portal");
if ($mysqli->connect_errno) {
	echo "Connection to portal db failed";
	exit();
}

$mysqlDate = 'SELECT Today FROM flash_template WHERE DATEDIFF(CURDATE(), Today) < 60 GROUP BY Today ORDER BY Today DESC';
$myDateResult = $mysqli->query($mysqlDate);
$dateArray = array();
while($myDateRow = mysqli_fetch_object($myDateResult)) {
	$dateArray[]  = $myDateRow->Today;
}


if($_GET['today'] != ""){
	$setDate = $_GET['today'];
}
else{
	$setDate = $dateArray[0];
}
$newestDate = strtotime($dateArray[0]);
$oldestDate = strtotime($dateArray[count($dateArray)-1]);
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
	
	$( "#datepicker" ).datepicker({changeMonth: false, changeYear: false, minDate: new Date(<?php echo date('Y',$oldestDate); ?>,<?php echo (date('m',$oldestDate)-1); ?>,<?php echo date('d',$oldestDate); ?>), maxDate: new Date(<?php echo date('Y',$newestDate); ?>,<?php echo (date('m',$newestDate)-1); ?>,<?php echo date('d',$newestDate); ?>), dateFormat:'mm/dd/yy',numberOfMonths: 3, showCurrentAtPos: 2, beforeShowDay: function(date) {

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
	$( "#datepicker" ).change(function() {
		var mystr = this.value;
		var explodedValue = mystr.split("/");
		var urlToRetrive = "includes/flash.php?today="+explodedValue[2]+"-"+explodedValue[0]+"-"+explodedValue[1];
		$.get(urlToRetrive, function (resp) {
			$('#flashContainer').html(resp);
		});
		
	});
});
</script>

<table>
<tr>
<td>Game Date:</td>
<td><input name="Today" id="datepicker" value="<?php echo date('m/d/Y',strtotime($setDate)) ?>"/></td>

<?php
$mysql_query = 'SELECT Revenue_Type, Today_Win, LY_Win, MTD_Win, MTDPM_Win, MTDPY_Win, YTD_Win, YTDPY_Win FROM flash_template WHERE Today = "'.$setDate.'"';
$result = $mysqli->query($mysql_query);

if($result->num_rows > 0){
	
$resultArray = array();
$hasDataArray = array();
$hasDataArray[0] = false;
$hasDataArray[1] = false;
$hasDataArray[2] = false;
$hasDataArray[3] = false;
$hasDataArray[4] = false;
$hasDataArray[5] = false;
$hasDataArray[6] = false;
$hasDataArray[7] = false;
$numberOfFilledFields = 0;


while($row = mysqli_fetch_object($result)){
	$resultArray[] = $row;
	$i = 0;
	foreach($row as $field) {
		if($field != "") {
			$hasDataArray[$i] = true;
		}
		$i++;
	}
}

foreach($hasDataArray as $hasdata) {
	if($hasdata) {
		$numberOfFilledFields++;
	}
}
$widthOfCols = 950 / $numberOfFilledFields;
?>

<table width="950px" border="1" class="flashTable">
	<tr>
    	<?php if($hasDataArray[0]) { ?><th width="<?php echo $widthOfCols; ?>px">Revenue Type</th><?php } ?>
        <?php if($hasDataArray[1]) { ?><th width="<?php echo $widthOfCols; ?>px">Win</th><?php } ?>
        <?php if($hasDataArray[2]) { ?><th width="<?php echo $widthOfCols; ?>px">Last Year Win</th><?php } ?>
        <?php if($hasDataArray[3]) { ?><th width="<?php echo $widthOfCols; ?>px">MTD</th><?php } ?>
        <?php if($hasDataArray[4]) { ?><th width="<?php echo $widthOfCols; ?>px">Previous MTD</th><?php } ?>
        <?php if($hasDataArray[5]) { ?><th width="<?php echo $widthOfCols; ?>px">Previous Year MTD</th><?php } ?>
        <?php if($hasDataArray[6]) { ?><th width="<?php echo $widthOfCols; ?>px">YTD</th><?php } ?>
        <?php if($hasDataArray[7]) { ?><th width="<?php echo $widthOfCols; ?>px">Previous YTD</th><?php } ?>
    </tr>
<?php
	foreach($resultArray as $row) {
?>
    <tr>
    	<?php if($hasDataArray[0]) { ?><td class="flashText"><?php echo $row->Revenue_Type; ?></td><?php } ?>
        <?php if($hasDataArray[1]) { ?><td class="flashNum"><?php echo negativesToPara($row->Today_Win); ?></td><?php } ?>
        <?php if($hasDataArray[2]) { ?><td class="flashNum"><?php echo negativesToPara($row->LY_Win); ?></td><?php } ?>
        <?php if($hasDataArray[3]) { ?><td class="flashNum"><?php echo negativesToPara($row->MTD_Win); ?></td><?php } ?>
        <?php if($hasDataArray[4]) { ?><td class="flashNum"><?php echo negativesToPara($row->MTDPM_Win);?></td><?php } ?>
        <?php if($hasDataArray[5]) { ?><td class="flashNum"><?php echo negativesToPara($row->MTDPY_Win); ?></td><?php } ?>
        <?php if($hasDataArray[6]) { ?> <td class="flashNum"><?php echo negativesToPara($row->YTD_Win); ?></td><?php } ?>
        <?php if($hasDataArray[7]) { ?><td class="flashNum"><?php echo negativesToPara($row->YTDPY_Win); ?></td><?php } ?>
    </tr>
<?php
}
?>
</table>

<?php
} else {?>

<table width="950px" border="1" class="flashTable">
	<tr>
    	<th>Revenue Type</th>
        <th>Win</th>
        <th>Last Year Win</th>
        <th>MTD</th>
        <th>Previous MTD</th>
        <th>Previous Year MTD</th>
        <th>YTD</th>
        <th>Previous YTD</th>
    </tr>
    <tr>
    <td colspan="8" class="flashText">NoData</td>
    </tr>
</table>

<?php	}
?>
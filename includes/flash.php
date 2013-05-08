<?php
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
<td>Date:</td>
<td><input name="Today" id="datepicker" value="<?php echo date('m/d/Y',strtotime($setDate)) ?>"/></td>

<?php
$mysql_query = 'SELECT * FROM flash_template WHERE Today = "'.$setDate.'"';
$result = $mysqli->query($mysql_query);
if($result->num_rows > 0){
?>

<table width="950px" border="1" class="flashTable">
	<tr>
    	<th width="118.75px">Revenue Type</th>
        <th width="118.75px">Win</th>
        <th width="118.75px">Last Year Win</th>
        <th width="118.75px">MTD</th>
        <th width="118.75px">Previous MTD</th>
        <th width="118.75px">Previous Year MTD</th>
        <th width="118.75px">YTD</th>
        <th width="118.75px">Previous YTD</th>
    </tr>
<?php
	while($row = mysqli_fetch_object($result)){
?>
    <tr>
    	<td class="flashText"><?php echo $row->Revenue_Type?></td>
        <td class="flashNum"><?php echo $row->Today_Win?></td>
        <td class="flashNum"><?php echo $row->LY_Win?></td>
        <td class="flashNum"><?php echo $row->MTD_Win?></td>
        <td class="flashNum"><?php echo $row->MTDPM_Win?></td>
        <td class="flashNum"><?php echo $row->MTDPY_Win?></td>
        <td class="flashNum"><?php echo $row->YTD_Win?></td>
        <td class="flashNum"><?php echo $row->YTDPY_Win?></td>
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
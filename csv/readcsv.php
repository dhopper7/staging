<?php

$mysqli = new mysqli("localhost", "root", "Dapp3rDan1", "portal");
if ($mysqli->connect_errno) {
	echo "Connection to portal db failed";
	exit();
}

function importCSV($file) {
	

	    return csv_in_array($file); 

		
}

function csv_in_array($url,$delm=",",$encl="\"",$head=false) {
   		
		//$csvxrow = file($url) or die();   // ---- csv rows to array ----
		$handle = @fopen($url, "r"); 
		if ($handle) {
		   while (!feof($handle)) {
			   $csvxrow[] = fgets($handle, 4096);
		   }
		   fclose($handle);
		} 
	    //echo count($csvxrow);
		$csvxrow[0] = chop($csvxrow[0]);
		$csvxrow[0] = str_replace($encl,'',$csvxrow[0]);
		$keydata = explode($delm,$csvxrow[0]);
		$keynumb = count($keydata);
	  
		if ($head === true) {
		$anzdata = count($csvxrow);
		$z=0;
		for($x=1; $x<$anzdata; $x++) {
			$csvxrow[$x] = chop($csvxrow[$x]);
			$csvxrow[$x] = str_replace($encl,'',$csvxrow[$x]);
			$csv_data[$x] = explode($delm,$csvxrow[$x]);
			$i=0;
			foreach($keydata as $key) {
				$out[$z][$key] = $csv_data[$x][$i];
				$i++;
				}   
			$z++;
			}
		}
		else {
			$i=0;
			//print_r($csvxrow);
			foreach($csvxrow as $item) {
				
				$item = chop($item);
				$item = str_replace($encl,'',$item);
				$csv_data = explode($delm,$item);
				for ($y=0; $y<$keynumb; $y++) {
				   @$out[$i][$y] = $csv_data[$y];
				}
			$i++;
			//echo $i . "<br />";
			}
			
		}
	
	return $out;
}

$csv = importCSV('reports.csv');
$mysql_query = "DELETE FROM rep_rainmaker";
$mysqli->query($mysql_query);
foreach($csv as $line) {
	$exploded = explode('/',$line[5]);
	if(count($exploded) > 1) {
		$reportTitle = "";
		$accessType = "";
		$relativePath = "";
		$reportClass = "";
		$rights = "1,2,3,10";
		if($line['6'] != 2) {
			$accessType = "F";
		} else {
			$accessType = "R";
		}
		$reportTitle = str_replace('MMYY','',str_replace('YYYY','',str_replace('MMDDYY','',str_replace('MMYYCAS','',str_replace('MMDDYYCAS','',$line[1])))));
		$reportClass = $exploded[0];
		$relativePath = str_replace('/','\\',str_replace('/YYYY','',str_replace('/YYYY/Month','',str_replace('/YYYY Fiscal','',str_replace('/YYYY Fiscal/Month','',$line[5])))));
		//$relativePath .= "\\";
		$mysql_query = "INSERT INTO rep_rainmaker (reportTitle,accessType,relativePath,reportClass,rights) VALUES('".$reportTitle."','".$accessType."','".mysql_real_escape_string($relativePath)."','".$reportClass."','".$rights."')";
		$mysqli->query($mysql_query);
	}
}


echo "<pre>";
print_r($csv);
echo "</pre>";
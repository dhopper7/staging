<?php
/*
	V4.50 6 July 2004 
	
	Run multiple copies of this php script at the same time
	to test unique generation of id's in multiuser mode
*/
include_once('../../../../jqSuitePHP_Sources_4_4_4_0/php/adodb5/adodb.inc.php');
$testaccess = true;
include_once('../../../../jqSuitePHP_Sources_4_4_4_0/php/adodb5/tests/testdatabases.inc.php');

function testdb(&$db,$createtab="create table ADOXYZ (id int, firstname char(24), lastname char(24), created date)")
{
	$table = 'adodbseq';
	
	$db->Execute("drop table $table");
	//$db->debug=true;
	
	$ctr = 5000;
	$lastnum = 0;
	
	while (--$ctr >= 0) {
		$num = $db->GenID($table);
		if ($num === false) {	
			print "GenID returned false";
			break;
		}
		if ($lastnum + 1 == $num) print " $num ";
		else {
			print " <font color=red>$num</font> ";
			flush();
		}
		$lastnum = $num;
	}
}
?>
<?php
require_once "../../../jqSuitePHP_Sources_4_4_4_0/php/jqUtils.php";
require_once "../../../jqSuitePHP_Sources_4_4_4_0/php/jqScheduler.php";
require_once "../../../jqSuitePHP_Sources_4_4_4_0/php/jqGridPdo.php";
require_once '../../../jqSuitePHP_Sources_4_4_4_0/jq-config.php';
ini_set("display_errors",1);
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
$conn->query("SET NAMES utf8");
$eventcal = new jqScheduler($conn);
$eventcal->setLocale('en_GB');
$eventcal->setUrl('eventcal.php');
$eventcal->setUser(1);
$eventcal->setUserNames(array('1'=>"Calender User 1",'2'=>"Calendar user 2") );
$eventcal->render();
?>

<?php

$success = "Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/success.php";
$loginscreen = "Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?logout=yes";

//header($success);

if(isset($_POST['agree'])){
	header($success);
} else {
	header($loginscreen);
}

?>
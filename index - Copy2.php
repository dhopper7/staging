<?php
if ((isset($_COOKIE['username'])) && (!isset($_GET['logout']))) {
	header('Location: http://10.10.10.199/portaljg/index.php');
}
error_reporting(E_ALL ^ E_NOTICE);
//Check for Logout
$logout = $_GET['logout'];
if ($logout=="yes"){
	$past = time() - 10;
	setcookie(username, date("F jS - g:i a"), $past);
	session_start();
	$_SESSION = array();
	session_destroy();
}

//SSL Redirect
if ($_SERVER["SERVER_PORT"] != 443){
	header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
	exit();
}

$username = strtoupper($_POST["username"]);
$password = $_POST["password"];
$loginName = strtoupper($_POST["username"]).strtoupper($_POST["domain"]);
//echo "DEBUG USERNAME IS " . $username


if ($_POST["oldform"]) {
	
	if($loginName != NULL && $password != NULL){
		require_once('adLDAP/src/adLDAP.php');
		try {
			$adldap = new adLDAP();
		}
		catch (adLDAPException $e) {
			echo $e;
			exit(1);
		}
		
		if ($adldap->authenticate($loginName, $password)){
			
			//establish session and reconnect
			session_start();
			$_SESSION["username"] = $username;
			$day = 43200 + time();
			setcookie(username, $username, $day);
			$redir = "Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/success.php";
			
			//log the login of the user to sql
			$oDate = new DateTime($row->createdate);
			$sDate = $oDate->format("Y-m-d G:i:s");
			$mysqli = new mysqli("localhost", "root", "Dapp3rDan1", "portal");
			if ($mysqli->connect_errno) {
				echo "Connection to portal db failed";
				exit();
			}
			
			//see if user already exists in user account table
			$mysql_query = "SELECT userName, lastLogin from user_acct WHERE userName = \"" . $username . "\"";
			//echo $mysql_query;
			//exit();
			$result = $mysqli->query($mysql_query);
			if ($result->num_rows > 0){
				//echo "DEBUG ready to update";
				//exit();
				//update the record
				
				$mysql_query = "UPDATE user_acct SET lastLogin = \"" . $sDate . "\" WHERE userName = \"" . $username . "\"";
				if ($mysqli->query($mysql_query) === FALSE) {
					echo "Update record of login failed";
					exit();
				}
			} else {
				
				//add the record
				//echo "DEBUG ready to insert";
				//exit();
				$mysql_query = "INSERT INTO user_acct (userName, lastLogin) VALUES (\"" . $username . "\", \"" . $sDate . "\")";
				echo $mysql_query;
				if ($mysqli->query($mysql_query) === FALSE) {
					echo "Insert record of login failed";
					exit();
				}
			}
			
			// get the userid
			
			$mysql_query = "SELECT userID from user_acct WHERE userName = \"" . $username . "\"";
			$result = $mysqli->query($mysql_query);
			$row = mysqli_fetch_object($result);
			$_SESSION['userid'] = $row->userID;
			//echo $_SESSION['userid'];
			//exit();
			header($redir);
			echo "Authenticated!!!";
			exit;
			
		}
	}
	$failed = 1;
}

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <!-- <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css"> -->
        <link rel="stylesheet" href="css/ccm.base.css">
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/ui.core.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <p><div align="center" id="logo_login" > <img src="img/mast1.png" alt="Finley &amp; Cook"></div>
		</p>
		
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    <div align="center" id="welcome"><h3>Welcome to the Portal</h3></div>
        <p></p>
		<div align="center" id="cred">
        <form action='<?php echo $_SERVER["PHP_SELF"]; ?>' method="post" id="Cred_Form" accept-charset=utf-8 name="login">
        <input type='hidden' name='oldform' value='1'>
        Username: <input name="username" type="text" id="username"><p>
        Password: <input name="password" type="password" id="password"><p>
        Domain: <select name="domain">
        	<option value="@extranet.finley-cook.com">EXTRANET</option>
            <option value="@finley-cook.com">FINLEY-COOK</option>
            </select>
        <input name="submit" type="submit" id="submit" value="Submit">
        <?php if ($failed){ echo ("<br>Login Failed!<br><br>\n"); } ?>
        </form>
</div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>

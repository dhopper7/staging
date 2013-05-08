<!DOCTYPE html>
<html>
	<head>
    	<?php
			session_start();
			
			if(isset($_GET['folderpath'])){
				$_SESSION['debug'] = $_GET['folderpath'];
				$_SESSION['path'] = "//enas11/test";
				$_SESSION['startpath'] = $_GET['folderpath'];
			}
			
			if(isset($_SESSION['path'])){
				if((is_null($_SESSION['path'])) || ($_SESSION['path'] == "")){
					$_SESSION['path'] = "//enas11/test";
				}
			} else {
				$_SESSION['path'] = "//enas11/test";
			}
			
			if(isset($_SESSION['startpath'])){
				if((is_null($_SESSION['startpath'])) || ($_SESSION['startpath'] == "")){
					$_SESSION['startpath'] = "//enas11/test";
				}
			} else {
				$_SESSION['startpath'] = "//enas11/test";
			}
			
		?>
		<meta charset="utf-8">
		<title>elFinder 2.0</title>

		<!-- jQuery and jQuery UI (REQUIRED) -->
		<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>

		<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" type="text/css" href="css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" href="css/theme.css">

		<!-- elFinder JS (REQUIRED) -->
		<script src="js/elfinder.min.js"></script>

		<!-- elFinder translation (OPTIONAL) -->
		<script src="js/i18n/elfinder.ru.js"></script>

		<!-- elFinder initialization (REQUIRED) -->
		<script type="text/javascript" charset="utf-8">
			// Documentation for client options:
			// https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
			$().ready(function() {
				$('#elfinder').elfinder({
					url : 'php/connector.php'  // connector URL (REQUIRED)
					//url : "php/connector.php?path='//enas11/test'&startpath='//enas11/test/Rainmaker'"  // connector URL (REQUIRED)
					// lang: 'ru',                     // language (OPTIONAL)
				});
			});
		</script>
	</head>
	<body>

		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>

	</body>
</html>

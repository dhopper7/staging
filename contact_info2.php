<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php
error_reporting(E_ALL ^ E_NOTICE);
//Requires the NuSOAP library
require_once('nusoap-0.9.5/lib/nusoap.php');
 
$username = 'FINLEY-COOK\msshare_admin';
$password = '1mbsatnP';
$rowLimit = '150';
$item = $_GET["contactid"];
 
/* A string that contains either the display name or the GUID for the list.
 * It is recommended that you use the GUID, which must be between curly
 * braces ({}).
 */
$listName = "Portal_Contacts_Demo";
 
/* Local path to the Lists.asmx WSDL file (localhost). You must first download
 * it manually from your SharePoint site (which should be available at
 * yoursharepointsite.com/subsite/_vti_bin/Lists.asmx?WSDL)
 */
$wsdl = "http://10.10.10.199/staging/doc/Lists.wsdl";
 
//Basic authentication. Using UTF-8 to allow special characters.
$client = new nusoap_client($wsdl, true);
$client->setCredentials($username,$password);
$client->soap_defencoding='UTF-8';
 
//XML for the request. Add extra fields as necessary
$xml ='
<GetListItems xmlns="http://schemas.microsoft.com/sharepoint/soap/">
<listName>'.$listName.'</listName>
<rowLimit>'.$rowLimit.'</rowLimit>
<query><Query><Where><Eq><FieldRef Name="ID" /><Value Type="Counter">' . $item .'</Value></Eq></Where></Query></query>
</GetListItems>
';
 
//Invoke the Web Service
$result = $client->call('GetListItems', $xml);
 
//Error check
if(isset($fault)) {
  echo("<h2>Error</h2>". $fault);
}
 
//Extracting and preparing the Web Service response for display
$responseContent = utf8_decode(htmlspecialchars(substr($client->response,strpos($client->response, "<"),strlen($client->response)-1)));
 
//Displaying the request and the response, broken down by header and XML content
//echo "<h2>Request</h2><pre>" . utf8_decode(htmlspecialchars($client->request, ENT_QUOTES)) . "</pre>";
//echo "<h2>Response header</h2><pre>" . utf8_decode(htmlspecialchars(substr($client->response,0,strpos($client->response, "<")))) . "</pre>";
//echo "<h2>Response content</h2><pre>".$responseContent."</pre>";

//$temp = gettype($responseContent);
//echo $temp;

//echo print_r($result) . "<br><br>";

//$temp = $result['GetListItemsResult'];
//$temp = $temp['listitems'];
//$temp = $temp['data'];
//$temp = $temp['row'];
//echo $temp['!ows_Name'];

echo ("<table><tr><td>Transfer file via <a href='https://sft.finley-cook.com'>SecureFT</a></td></tr>");
echo ("<tr><td>Send E-mail to <a href='mailto:". $result['GetListItemsResult']['listitems']['data']['row']['!ows_Email'] . "'>" . $result['GetListItemsResult']['listitems']['data']['row']['!ows_Name'] . "</a></td></tr>");

if($result['GetListItemsResult']['listitems']['data']['row']['!ows_Team_x0020_Email'] == FALSE){
	//echo "<tr><td>FALSE</td></tr>";
	//DO NOTHING
} else {
	$strpostest = strstr($result['GetListItemsResult']['listitems']['data']['row']['!ows_Team_x0020_Email'], ";#");
	//echo ($strpostest);
	if($strpostest == NULL){
		echo ("<tr><td>Send E-mail to <a href='mailto:". $result['GetListItemsResult']['listitems']['data']['row']['!ows_Team_x0020_Email'] . "'>" . $result['GetListItemsResult']['listitems']['data']['row']['!ows_Team_x0020_Email'] . "</a></td></tr>");
	} else {
		$dept_addrs = explode(";#", $result['GetListItemsResult']['listitems']['data']['row']['!ows_Team_x0020_Email']);
		foreach($dept_addrs as $dept_addr){
			if($dept_addr != NULL){
				echo ("<tr><td>Send E-mail to <a href='mailto:". $dept_addr . "'>" . $dept_addr . "</a></td></tr>");
			}
		}
	}
}

//$contains = strpos($result['GetListItemsResult']['listitems']['data']['row']['!ows_Team_x0020_Email'], ";#");
//if($contains == FALSE){
	
//}


//echo ("<tr><td>" . $result['GetListItemsResult']['listitems']['data']['row']['!ows_Team_x0020_Email'] ."</td></tr>");
echo ("</table>");

//echo $result['GetListItemsResult']['listitems']['data']['row']['!ows_Name'];

//echo $result['GetListItemsResult'];
 
//Uncomment for debugging info:
//echo("<h2>Debug</h2><pre>" . htmlspecialchars($client->debug_str, ENT_QUOTES) . "</pre>");
unset($client);

?>

</body>
</html>
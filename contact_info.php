<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="css/thickbox.css">
<link rel="stylesheet" href="css/contactStyle.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
//Requires the NuSOAP library
require_once('nusoap-0.9.5/lib/nusoap.php');
 
$username = 'FINLEY-COOK\msshare_admin';
$password = '1mbsatnP';
$rowLimit = '1';
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
$wsdl = "http://10.10.10.199/portaljg/doc/Lists.wsdl";
 
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

//ATTEMPT TO PULL USER INFO FROM AD

require_once('adLDAP/src/adLDAP.php');
try {
	$adldap = new adLDAP();
}
catch (adLDAPException $e) {
	echo $e;
	exit(1);
}

$userinfo = $adldap->user()->info($_SESSION["username"], array("*"));

?>
<table>
	<!--<tr>
    	<td class="label">TEST</td>
        <td class="contactsPos">
        	<?php echo $userinfo; ?>
        </td>
    </tr>-->
    <tr>
    	<td class="label">Title:</td>
        <td class="contactsPos">
        	<?php echo $result['GetListItemsResult']['listitems']['data']['row']['!ows_Title']; ?>
        </td>
    </tr>
    <tr>
	    <td class="label">Phone:</td>
        <td class="contactsPhone"> 
        	<?php echo $result['GetListItemsResult']['listitems']['data']['row']['!ows_Phone']; ?>
        </td>
    </tr>
    <tr>
	    <td class="label">Fax:</td>
        <td class="contactsFax"> 
        	<?php echo $result['GetListItemsResult']['listitems']['data']['row']['!ows_Extension']; ?>
        </td>
    </tr>
	<tr>
    	<td class="label">Transfer files:</td>
    	<td class="contactsST"> 
        <a href='https://secureft.finley-cook.com/sendrequest.php?toemail=<?php echo $result['GetListItemsResult']['listitems']['data']['row']['!ows_Email']; ?>' target='_blank'>SecureFT</a>
        </td>
    </tr>
    <tr>
	    <td class="label">Email:</td>
    	<td class="contactsEmail">
        	<a class='TB_mailto' href='mailto:<?php echo $result['GetListItemsResult']['listitems']['data']['row']['!ows_Email']; ?>'>
			 <?php echo $result['GetListItemsResult']['listitems']['data']['row']['!ows_Email']; ?>
            </a>
        </td>
    </tr>
<?php
if($result['GetListItemsResult']['listitems']['data']['row']['!ows_Team_x0020_Email'] == FALSE){
	//echo "<tr><td>FALSE</td></tr>";
	//DO NOTHING
} else {
	$strpostest = strstr($result['GetListItemsResult']['listitems']['data']['row']['!ows_Team_x0020_Email'], ";#");
	//echo ($strpostest);
	if($strpostest == NULL){
	?>
		<tr>
	        <td class="label">Alt Email:</td>
        	<td class="contactsEmail">
            <a href='mailto:<?php echo $result['GetListItemsResult']['listitems']['data']['row']['!ows_Team_x0020_Email']; ?>'>
            <?php echo $result['GetListItemsResult']['listitems']['data']['row']['!ows_Team_x0020_Email']; ?>
            </a>
            </td>
        </tr>
    <?php
	} else {
		$dept_addrs = explode(";#", $result['GetListItemsResult']['listitems']['data']['row']['!ows_Team_x0020_Email']);
		foreach($dept_addrs as $dept_addr){
			if($dept_addr != NULL){
			?>
				<tr>
	                <td class="label">Alt Email:</td>
                	<td class='contactsEmail'>
                    <a href='mailto:<?php echo $dept_addr; ?>'><?php echo $dept_addr; ?></a>
                    </td>
                </tr>
            <?php
			}
		}
	}
}

//$contains = strpos($result['GetListItemsResult']['listitems']['data']['row']['!ows_Team_x0020_Email'], ";#");
//if($contains == FALSE){
	
//}


//echo ("<tr><td>" . $result['GetListItemsResult']['listitems']['data']['row']['!ows_Team_x0020_Email'] ."</td></tr>");
?>
</table>
<?php 
//echo $result['GetListItemsResult']['listitems']['data']['row']['!ows_Name'];

//echo $result['GetListItemsResult'];
 
//Uncomment for debugging info:
//echo("<h2>Debug</h2><pre>" . htmlspecialchars($client->debug_str, ENT_QUOTES) . "</pre>");
unset($client);

?>

</body>
</html>
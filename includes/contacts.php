
        <?php
			//Authentication details
			$authParams = array('login' => 'itdev_apache_service@finley-cook.com',
								'password' => 'L@meduck');
			
			/* A string that contains either the display name or the GUID for the list.
			 * It is recommended that you use the GUID, which must be surrounded by curly
			 * braces ({}).
			 */
			$listName = "Portal_Contacts_Demo";
			$rowLimit = '150';
			
			
			/* Local path to the Lists.asmx WSDL file (localhost). You must first download
			 * it manually from your SharePoint site (which should be available at
			 * yoursharepointsite.com/subsite/_vti_bin/Lists.asmx?WSDL)
			 */
			$wsdl = "http://10.10.10.199/portaljg/doc/Lists.wsdl";
			
			//Creating the SOAP client and initializing the GetListItems method parameters
			$soapClient = new SoapClient($wsdl, $authParams);
			$params = array('listName' => $listName,
							'rowLimit' => $rowLimit);
								
			//Calling the GetListItems Web Service
			$rawXMLresponse = null;
			try{
				$rawXMLresponse = $soapClient->GetListItems($params)->GetListItemsResult->any;
			}
			catch(SoapFault $fault){
				echo 'Fault code: '.$fault->faultcode;
				echo 'Fault string: '.$fault->faultstring;
			}
			echo '<pre>' . $rawXMLresponse . '</pre>';
			
			//Loading the XML result into parsable DOM elements
			$dom = new DOMDocument();
			$dom->loadXML($rawXMLresponse);
			$results = $dom->getElementsByTagNameNS("#RowsetSchema", "*");
			
			$myContacts1 = array(array());
			$counter1 = 0;
			$columncounter = 0;
			foreach($results as $result){
				$myContacts1[$counter1][0] = $result->getAttribute("ows_Name");
				$myContacts1[$counter1][1] = $result->getAttribute("ows_Title");
				$myContacts1[$counter1][2] = $result->getAttribute("ows_Phone");
				$myContacts1[$counter1][3] = $result->getAttribute("ows_Extension");
				$myContacts1[$counter1][4] = $result->getAttribute("ows_Email");
				$myContacts1[$counter1][5] = $result->getAttribute("ows_ID");
				$counter1++;
			}
			unset($soapClient);
			
			//
		?>
	<div id="contacts_link1">
        <?php
			if($counter1 != 0){
				foreach($myContacts1 as $result){
				?>				
				<a class="thickbox" title="<?php echo $result[0]; ?>" href="contact_info.php?height=200&width=400&contactid=<?php echo $result[5]; ?>&TB_iframe=true">
				<span class="contactListName"><?php echo $result[0]; ?></span> - <span class="contactListPosition"><?php echo $result[1]; ?></span>
                </a>
                <br/>
                <?php
				}
			}
		?>
	</div>


        <?php
			//Authentication details
			$authParams = array('login' => 'itdev_apache_service@finley-cook.com',
								'password' => 'L@meduck');
			
			/* A string that contains either the display name or the GUID for the list.
			 * It is recommended that you use the GUID, which must be surrounded by curly
			 * braces ({}).
			 */
			$listName = "Portal_Links_Demo";
			$rowLimit = '150';
			
			
			/* Local path to the Lists.asmx WSDL file (localhost). You must first download
			 * it manually from your SharePoint site (which should be available at
			 * yoursharepointsite.com/subsite/_vti_bin/Lists.asmx?WSDL)
			 */
			$wsdl = "http://10.10.10.199/Staging/doc/Lists.wsdl";
			
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
			
			$myLinksFnC = array(array());
			$myLinksReg = array(array());
			$myLinksNews = array(array());
			$myLinksInd = array(array());
			$counter1 = 0;
			$counter2 = 0;
			$counter3 = 0;
			$counter4 = 0;
			foreach($results as $result){
				$temp = $result->getAttribute("ows_Category");
				switch ($temp) {
					case "F&C":
						$myLinksFnC[$counter1][0] = $result->getAttribute("ows_Order");
						$myLinksFnC[$counter1][1] = $result->getAttribute("ows_LinkTitle");
						$myLinksFnC[$counter1][2] = $result->getAttribute("ows_Link");
						$counter1++;
						break;
					case "Regulatory":
						$myLinksReg[$counter2][0] = $result->getAttribute("ows_Order");
						$myLinksReg[$counter2][1] = $result->getAttribute("ows_LinkTitle");
						$myLinksReg[$counter2][2] = $result->getAttribute("ows_Link");
						$counter2++;
						break;
					case "News":
						$myLinksNews[$counter3][0] = $result->getAttribute("ows_Order");
						$myLinksNews[$counter3][1] = $result->getAttribute("ows_LinkTitle");
						$myLinksNews[$counter3][2] = $result->getAttribute("ows_Link");
						$counter3++;
						break;
					case "Industry Groups":
						$myLinksInd[$counter4][0] = $result->getAttribute("ows_Order");
						$myLinksInd[$counter4][1] = $result->getAttribute("ows_LinkTitle");
						$myLinksInd[$counter4][2] = $result->getAttribute("ows_Link");
						$counter4++;
						break;
				}
				array_multisort($myLinksFnC[0]);
				array_multisort($myLinksReg[0]);
				array_multisort($myLinksNews[0]);
				array_multisort($myLinksInd[0]);
			}
			unset($soapClient);
			
			//
		?>
        
        <table align="center" width="100%" class="linksTable">
        	<tr>
        		<th width="25%">F&C</th>
        		<th width="25%">Regulatory</th>
        	</tr>
            <tr>
            	<td>
                	<div id="footer_link1">
			        <?php
						if($counter1 != 0){
						foreach($myLinksFnC as $result){						
						echo "<a href = \"" . $result[2] . "\" target=\"_blank\">" . $result[1] . "</a><br/>";
						}
						}
					?>
                    </div>
                </td>
                <td>
                	<div id="footer_link2">
			        <?php
						if($counter2 != 0){
							foreach($myLinksReg as $result){
							echo "<a href = \"" . $result[2] . "\" target=\"_blank\">" . $result[1] . "</a><br/>";
							}
						}
					?>
					</div>
                </td>
            </tr>
        </table>
        
                <table align="center" width="100%" class="linksTable">
        	<tr>
        		<th width="25%">News</th>
        		<th width="25%">Industry Groups</th>
        	</tr>
            <tr>
        		<td>
                	<div id="footer_link3">
					<?php
                        if($counter3 != 0){
                            foreach($myLinksNews as $result){
                                echo "<a href = \"" . $result[2] . "\" target=\"_blank\">" . $result[1] . "</a><br/>";
                            }
                        }
                    ?>
	                </div>          
                </td>
                <td>
                    <div id="footer_link4">
                    <?php
                        if($counter4 != 0){
                            foreach($myLinksInd as $result){
                                echo "<a href = \"" . $result[2] . "\" target=\"_blank\">" . $result[1] . "</a><br/>";
                            }
                        }
                    ?>
                    </div>              
                </td>
            </tr>
        </table>
        
        
        


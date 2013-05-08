<?php
// Include class 
include_once '../../../../jqSuite/examples/jqform/fileupload/jqformconfig.php'; 
include_once $CODE_PATH.'jqUtils.php'; 
include_once $CODE_PATH.'jqForm.php'; 
// Create instance 
$newForm = new jqForm('newForm',array('method' => 'post', 'id' => 'newForm'));
// Demo Mode creating connection 
include_once $CODE_PATH.'jqGridPdo.php'; 
$conn = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
$newForm->setConnection( $conn );
// Set url
$newForm->setUrl($SERVER_HOST.$SELF_PATH.'fileupload.php');
// Set Form header 
$formhead='Shipping Details';
$newForm->setFormHeader($formhead,'ui-icon-mail-closed');
// Set parameters 
$jqformparams = array();
// Set SQL Command, table, keys 
$newForm->table = 'orders';
$newForm->setPrimaryKeys('OrderID');
$newForm->serialKey = true;
// Set Form layout 
$newForm->setColumnLayout('twocolumn');
$newForm->setTableStyles('width:580px;','','');
// Add elements
$newForm->addElement('OrderID','hidden', array('label' => 'OrderID', 'id' => 'newForm_OrderID'));
$newForm->addElement('ShipName','text', array('label' => 'Name', 'maxlength' => '40', 'style' => 'width:98%;', 'id' => 'newForm_ShipName'));
$newForm->addElement('ShipAddress','text', array('label' => 'Address', 'maxlength' => '60', 'style' => 'width:98%;', 'id' => 'newForm_ShipAddress'));
$newForm->addElement('ShipCity','text', array('label' => 'City', 'maxlength' => '15', 'size' => '20', 'id' => 'newForm_ShipCity'));
$newForm->addElement('ShipPostalCode','text', array('label' => 'PostalCode', 'maxlength' => '10', 'size' => '20', 'id' => 'newForm_ShipPostalCode'));
$newForm->addElement('ShipCountry','text', array('label' => 'Country', 'maxlength' => '15', 'size' => '20', 'id' => 'newForm_ShipCountry'));
$newForm->addElement('Freight','number', array('label' => 'Freight', 'id' => 'newForm_Freight'));
$newForm->addElement('newFile','file', array('label' => 'Attachment', 'id' => 'newForm_newFile'));
$elem_9[]=$newForm->createElement('newSubmit','submit', array('value' => 'Submit'));
$newForm->addGroup("newGroup",$elem_9, array('style' => 'text-align:right;', 'id' => 'newForm_newGroup'));
// automatic file upload options
$newForm->setUploadOptions('newFile', array(
	'dir'=>'./',		// directory to upload
	'filetypes'=>'',	// allowed file types. if empty all
	'filesize'=>1048576,// bytes 1024*1024 = 1Mb
	'fileprefix'=>''	// add a prefix to the file name
));
// Add events
// Add ajax submit events
$success = <<< SU
function( response, status, xhr) {
$("#demo").html(response);
}
SU;
$newForm->setAjaxOptions( array('dataType'=>null,
'resetForm' =>null,
'clearForm' => null,
'success' =>'js:'.$success,
'iframe' => true,
'forceSync' =>false) );
// Demo mode - no input 
$newForm->demo = true;
// Render the form 
echo $newForm->renderForm($jqformparams);
?>
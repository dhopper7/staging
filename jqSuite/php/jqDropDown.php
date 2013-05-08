<?php
/**
 * Description of jqDropDown
 *
 * @author Tony Tomov
 */
class jqDropDown {
	public $version = '4.4.4.0';

	private $doptions = array(
		"width"=>150
	);
	/**
	 * Javascript code to be executed aftere the chart render
	 * @var string
	 */
	private $jscode;
	/**
	 * Stores the connection in case of Db data
	 * @var resource
	 */	
	private $conn;
	private $dbtype;

	private $templates = array();

	function __construct( $db=null )
	{
		if(class_exists('jqGridDB') && $db)
			$interface = jqGridDB::getInterface();
		else
			$interface = 'droparray';
		$this->conn = $db;
		if($interface == 'pdo')
		{
			try {
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->dbtype = $this->conn->getAttribute(PDO::ATTR_DRIVER_NAME);
			} catch (Exception $e) {
				
			}
		} else {
			$this->dbtype = $interface;
		}
	}

	public function getOption($option)
	{
		if(array_key_exists($option, $this->doptions))
			return $this->doptions[$option];
		else
			return false;
	}

	public function setOption($option, $value=null)
	{
		if(isset ($option) ) {
			if(is_array($option)) {
				foreach($option as $key => $value) {
					$this->doptions[$key] = $value;
				}
				return true;
			} else if($value != null) {
				$this->doptions[$option] = $value;
				return true;
			}
		}
		return false;
	}

	public function setEvent($event, $code)
	{
		if(isset ($event) && isset($code) ) {
			$this->doptions[$event] = "js:".$code;
		}
	}
	/**
	 * Put a javascript code after all things are created. The method is executed
	 * only once when the chart is created.
	 * @param string $code - javascript to be executed
	 */
	public function setJSCode($code) {
		if(strlen($code)>0) {
			$this->jscode = 'js:'.$code;
		}
	}

	public function setItems ( $data, $params = null ) {
		if(is_string($data)) {
			//sql
			if($this->dbtype != 'droparray' && $this->conn) {
				$sersql = jqGridDB::prepare($this->conn, $data, $params, true);
				$ret = jqGridDB::execute($sersql, $params);
				if($ret) {
					$this->doptions['items'] = jqGridDB::fetch_object($sersql, true, $this->conn);
				}
			}
			
		} else if(is_array($data)) {
			$this->doptions['items'] = $data;
		}
	}
	
	public function setTemplate ( $id, $code) 
	{
		if($id && strlen($id)>0) {
			$this->templates[$id] = 'js:'.$code;
		}
	}
	
	
	public function renderDropDown($element,  $echo = true)
	{
		$s = "";
		if(count($this->templates)>0) {
			foreach ($this->templates as $key => $value) {
				$s .= "<script id='".$key."'  type='text/x-jquery-tmpl'>";
				$s .= jqGridUtils::encode( $value );
				$s .= "</script>";
			}
		}
		$s .= "<script type='text/javascript'>";
		$s .= "jQuery(document).ready(function() {";
		$tmpel = $element;
		if(strpos($element,"#") === false) {
			$element = "#".$element;
		} else {
			$tmpel = substr($element,1);
		}
		
		$this->doptions['id'] = $tmpel;
		$s .= "jQuery('".$element."').jqDropDownList(".jqGridUtils::encode($this->doptions).");";
		if($this->jscode) {
			$s .= jqGridUtils::encode($this->jscode);
		}
		$s .= " });</script>";
		if($echo) {
			echo $s;
		}  else {
			return $s;
		}
	}
}
?>

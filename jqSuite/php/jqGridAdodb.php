<?php
/**
 * @author  Tony Tomov, Peter Dimitrov
 * @copyright TriRand Ltd 2012
 * @package jqSuite
 * 
 */
class jqGridDB
{
	public static function getInterface()
	{
		return 'adodb';
	}

	public static function prepare ($conn, $sqlElement, $params=null, $bind=true)
	{
		if($conn && strlen($sqlElement)>0) {
			$sql = $conn->Prepare($sqlElement);
			if ($sql === false) {
				throw new Exception("Adodb prepare failed; error = " 	. $conn->ErrorMsg());
			} else {
				//return $conn->Execute($sql, $params);
				return $sql;
			}
		}
		return false;
	}
	public static function limit($conn, $sql,$numrows=-1,$offset=-1,$inputarr=false)
	{
		return $conn->SelectLimit($sql,$numrows,$offset,$inputarr);
	}
	public static function execute($psql, $prm, $conn )
	{
		if(is_array($prm)) {
			return $conn->Execute($psql, $prm); 
		} else {
			return $conn->Execute($psql); 
		}
	}
	public static function query($conn, $sql)
	{
		if($conn && strlen($sql)>0) {
			return $conn->Execute($sql);
		}
		return false;
	}
	public static function bindValues($stmt, $binds, $types)
	{
		return true;
	}
	public static function beginTransaction( $conn )
	{
		return $conn->StartTrans();
	}
	public static function commit( $conn )
	{
		return $conn->CompleteTrans();
	}
	public static function rollBack( $conn )
	{
		return $conn->RollbackTrans();
	}
	public static function lastInsertId($conn, $table, $IdCol, $dbtype)
	{
		return $conn->Insert_ID();
	}
	public static function fetch_object( $psql, $fetchall, $conn=null )
	{
		if($psql) {
			if(!$fetchall)
			{
				return $psql->FetchObject( false );
			} else {
				$ret = array();
				while ($obj = $psql->FetchNextObject( false ))
				{
					$ret[] = $obj;
				}
				return $ret;
			}
		}
		return false;
	}
	public static function fetch_num( $psql, $conn=null )
	{
		if($psql)
		{
			$SAVE = $psql->fetchMode;
			$conn->SetFetchMode(ADODB_FETCH_NUM);
			$ret =  $psql->FetchRow();
			$conn->SetFetchMode($SAVE);
			return $ret;
		}
		return false;
	}
	public static function fetch_assoc( $psql, $conn )
	{
		if($psql)
		{
			$SAVE = $psql->fetchMode;
			$conn->SetFetchMode(ADODB_FETCH_ASSOC);
			$ret =  $psql->FetchRow();
			$conn->SetFetchMode($SAVE);
			return $ret;
		}
		return false;
	}
	public static function closeCursor($sql)
	{
		if($sql) {
			$sql->Close();
		}
	}
	public static function columnCount( $rs )
	{
		if($rs)
			return $rs->FieldCount();
		else
			return 0;
	}
	public static function getColumnMeta($index, $sql)
	{
		if($sql && $index >= 0) {
			$newmeta = array();
			$fld = $sql->FetchField( $index );
			$newmeta["name"]  = $fld->name;
			$newmeta["native_type"]  = $sql->MetaType( $fld->type );
			$newmeta["len"]  = $fld->max_length;
			return $newmeta;
		}
		return false;
	}
	/**
	 *
	 * Return the meta type of the field based on the underlayng db
	 * @param array $t object returned from pdo getColumnMeta
	 * @param string $dbtype the database type
	 * @return string the type of the field can be string, date, datetime, blob, int, numeric
	 */
	public static function MetaType($t,$dbtype)
	{

		if ( is_array($t)) {
			$type = $t["native_type"];
			$len = $t["len"];
			switch(strtoupper($type))
			{
				case 'I':
				case 'R':
				case 'L':
					return 'int';
				case 'C':
				case 'X':
					return 'string';
				case 'B' : 
					return 'blob';
				case 'D' : //date
					return 'date';
				case 'T' :
					return 'datetime';
				case 'N' :
					return 'numeric';
				default : 
					return 'numeric';
			}
		}
		return 'numeric';
	}
	public static function getPrimaryKey($table, $conn, $dbtype)
	{
		/**
		* Discover metadata information about this table.
		*/
		if($conn && $table){
			$p = $conn->MetaPrimaryKeys($table);
			if(isset($p[0]) ){
				return $p[0];
			}
		}
		return false;
	}
	public static function errorMessage ( $conn )
	{
		return $conn->ErrorMsg();
	}
}
?>

<?php
// PDO Driver
class jqGridDB
{
	public static function getInterface()
	{
		return 'odbc';
	}
	public static function prepare ($conn, $sqlElement, $params, $bind=true)
	{
		if($conn && strlen($sqlElement)>0) {
			// Original code
			//$sql = odbc_prepare($conn, (string)$sqlElement);
			//End original code
			// Fixing the odbc bug not allow to execute comples query with params
			$cnt = count($params);
			if($cnt > 0 ) {
				$arr = explode('?', $sqlElement);
				$sqlElement = '';
				for($i=0;$i<$cnt;$i++) {
					$sqlElement .= $arr[$i]."'".str_replace("'","''",$params[$i])."'";
				}
				if(isset ($arr[$i])) {
					$sqlElement .= $arr[$i];
				}
			}
			$sql = odbc_prepare($conn, $sqlElement);
			
			if ($sql === false)
					throw new Exception("odbc_prepare failed; error = " 	. odbc_errormsg( $conn ));
			else
				return $sql;
		}
		return false;
	}
	public static function limit($sqlId, $dbtype, $nrows=-1,$offset=-1,$order='', $sort='' )
	{
		$psql = $sqlId;
		switch ($dbtype) {
			case 'odbcmysql':
				$offsetStr =($offset>=0) ? "$offset, " : '';
				if ($nrows < 0) $nrows = '18446744073709551615';
				$psql .= " LIMIT $offsetStr$nrows";
				break;
			case 'odbcpgsql':
				$offsetStr = ($offset >= 0) ? " OFFSET ".$offset : '';
				$limitStr  = ($nrows >= 0)  ? " LIMIT ".$nrows : '';
				$psql .= "$limitStr$offsetStr";
				break;
			case 'odbcsqlite':
				$offsetStr = ($offset >= 0) ? " OFFSET $offset" : '';
				$limitStr  = ($nrows >= 0)  ? " LIMIT $nrows" : ($offset >= 0 ? ' LIMIT 999999999' : '');
				$psql .= "$limitStr$offsetStr";
				break;
			case 'odbcsqlsrv':
				$psql = $sqlId;
				$nrows = intval($nrows);
				if($nrows < 0)  return false;
				$offset = intval($offset);
				if($offset < 0 ) return false;
				$orderby = $order && strlen($order) > 0;
				////stristr($sqlId, 'ORDER BY');
				if ($orderby !== false) {
					$sort  = (stripos($sort, 'desc') !== false) ? 'desc' : 'asc';
					//$order = " ORDER BY ".$order;
					//str_ireplace('ORDER BY', '', $orderby);
					//$order = trim(preg_replace('/\bASC\b|\bDESC\b/i', '', $order));
				}
				//$sql = preg_replace('/^SELECT\s/i', 'SELECT TOP ' . ($nrows+$offset) . ' ', $sql);

				$psql = preg_replace('/^SELECT\s+(DISTINCT\s)?/i', 'SELECT $1TOP ' . ($nrows+$offset) . ' ', $psql );
				$psql = 'SELECT * FROM (SELECT TOP ' . $nrows . ' * FROM (' . $psql . ') AS inner_tbl';
				if ($orderby !== false) {
					$orderrev = $order;
					$orderrev = trim(preg_replace('/\bASC\b/i', 'DES', $orderrev));
					$orderrev = trim(preg_replace('/\bDESC\b/i', 'ASC', $orderrev));
					$orderrev = trim(preg_replace('/\bDES\b/i', 'DESC', $orderrev));
					$psql .= ' ORDER BY ' . $orderrev . ' ';
					$psql .= (stripos($sort, 'asc') !== false) ? 'DESC' : 'ASC';
				}
				$psql .= ') AS outer_tbl';
				if ($orderby !== false) {
					$psql .= ' ORDER BY ' . $order . ' ' . $sort;
				}
				break;
		}
		return $psql;
	}
	public static function execute($psql, $prm=null)
	{
		$ret = false;
		if($psql) {
			//if(is_array($prm)) {
				//$ret = odbc_execute($psql, $prm);
			//}
			//else {
				$ret = odbc_execute($psql);
			//}
		}
		return $ret;
	}
	public static function query($conn, $sql)
	{
		if($conn && strlen($sql)>0) {
			return odbc_exec($conn, $sql);
		}
		return false;
	}
	public static function bindValues($stmt, $binds, $types)
	{
		return true;
	}
	public static function beginTransaction( $conn )
	{
		return odbc_autocommit($conn, FALSE);
	}
	public static function commit( $conn )
	{
		return odbc_commit($conn);
	}
	public static function rollBack( $conn )
	{
		return odbc_rollback($conn);
	}
	/**
	 *
	 * Return the last inserted id in a table in case when the serialKey is set to true
	 * @return number
	 */
	public static function lastInsertId($conn, $table, $IdCol, $dbtype)
	{
		if($dbtype == 'odbcsqlsrv') {
			$sql = "SELECT SCOPE_IDENTITY()";
			$stmt = odbc_exec( $conn, $sql);
			$idCol = false;
			if( $stmt === false )
			{
				echo "Error in statement preparation/execution.\n";
				die( print_r( odbc_errormsg( $conn ), true));
			}
			if( odbc_fetch_row( $stmt ) === false )
			{
				echo "Error in retrieving row.\n";
				die( print_r(odbc_errormsg( $conn ), true));
			}
			$idCol = odbc_result($stmt,1); 
			return $idCol;			
		}
		return false;
	}
	public static function fetch_object( $psql, $fetchall, $conn )
	{
		if($psql) {
			if(!$fetchall)
			{
				return odbc_fetch_object($psql);
			} else {
				$ret = array();
				while ($obj = odbc_fetch_object($psql))
				{
					$ret[] = $obj;
				}
				return $ret;
			}
		}
		return false;
	}
	public static function fetch_num( $psql )
	{
		if($psql)
		{
			$r = odbc_fetch_array($psql);
			return $r ? array_values($r) : false;
		}
		return false;
	}
	public static function fetch_assoc( $psql, $conn )
	{
		if($psql)
		{
			return odbc_fetch_array($psql);
		}
		return false;
	}
	public static function closeCursor($sql)
	{
		if($sql) odbc_free_result($sql);
	}
	public static function columnCount( $rs )
	{
		if($rs)
			return odbc_num_fields( $rs );
		else
			return 0;
	}
	public static function getColumnMeta($index, $sql)
	{
		if($sql && $index >= 0) {
			$newmeta = array();
			$newmeta["name"]  = odbc_field_name($sql, $index + 1);
			$newmeta["native_type"]  = odbc_field_type($sql, $index + 1);
			$newmeta["len"]  = odbc_field_len($sql, $index + 1);
			return $newmeta;
		}
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

		$meta = "numeric";
		if ( is_array($t)) {
			$len = $t["len"];
			switch ($dbtype)
			{
				case "odbcpgsql" :
					$type = $t["native_type"];
					$meta = self::MetaPgsql($type, $len);
					break;
				case "odbcmysql" :
				// hack for mysql pdo driver it does not recognize tinyint and year
				// we map it to int4
					$type = isset ($t["native_type"]) ? $t["native_type"] : 'int';
					$meta = self::MetaMysql($type, $len);
					break;
				case "odbcsqlite":
				// SQLite need this
					$type = $t["native_type"];
					$meta = self::MetaSqlite($type, $len);
					break;
				case "odbcsqlsrv":
					$type = $t["native_type"];
					$meta = self::MetaSqlsrv($type, $len);
					break;
			}
		}
		return $meta;
	}
	/**
	 *
	 * The meta types for PostgreSQL database
	 * @param string $native_type
	 * @param integer $max_length
	 * @return string
	 */
	protected static function MetaPgsql($native_type, $max_len = -1)
	{
		switch (strtoupper($native_type)) {
			case 'MONEY': //postgres expects money to be a string
			case 'INTERVAL':
			case 'CHAR':
			case 'CHARACTER':
			case 'VARCHAR':
			case 'NAME':
			case 'BPCHAR':
			case '_VARCHAR':
			case 'INET':
			case 'MACADDR':
				return 'string';

			case 'TEXT':
				return 'string';

			case 'IMAGE': // user defined type
			case 'BLOB': // user defined type
			case 'BIT':	// This is a bit string, not a single bit, so don't return 'L'
			case 'VARBIT':
			case 'BYTEA':
				return 'blob';

			case 'BOOL':
			case 'BOOLEAN':
				return 'boolean';

			case 'DATE':
				return 'date';

			case 'TIMESTAMP WITHOUT TIME ZONE':
			case 'TIME':
			case 'DATETIME':
			case 'TIMESTAMP':
			case 'TIMESTAMPTZ':
				return 'datetime';

			case 'SMALLINT':
			case 'BIGINT':
			case 'INTEGER':
			case 'INT8':
			case 'INT4':
			case 'INT2':
                return 'int';

			case 'OID':
			case 'SERIAL':
				return 'int';

			default:
			 	return 'numeric';
		}
	}
	/**
	 *
	 * The meta types for MySQL database
	 * @param string $native_type
	 * @param integer $max_length
	 * @return string
	 */
	protected static function MetaMysql ($native_type, $max_length = -1)
	{
		switch (strtoupper($native_type)) {
		case 'STRING':
		case 'CHAR':
		case 'VARCHAR':
		case 'TINYBLOB':
		case 'TINYTEXT':
		case 'ENUM':
		case 'VAR_STRING':
		case 'SET':
			return 'string';

		case 'TEXT':
		case 'LONGTEXT':
		case 'MEDIUMTEXT':
			return 'string';

		case 'IMAGE':
		case 'LONGBLOB':
		case 'BLOB':
		case 'MEDIUMBLOB':
		case 'BINARY':
			return 'blob';

		case 'YEAR':
		case 'DATE':
			return 'date';

		case 'TIME':
		case 'DATETIME':
		case 'TIMESTAMP':
			return 'datetime';

		case 'INT':
		case 'INTEGER':
		case 'BIGINT':
		case 'TINYINT':
		case 'MEDIUMINT':
		case 'SMALLINT':
		case 'LONG':
			return 'int';

		default: return 'numeric';
		}
	}
	/**
	 *
	 * The meta types for SQLite database
	 * @param string $native_type
	 * @param integer $max_length
	 * @return string
	 */
	protected static function MetaSqlite ($native_type, $max_length = -1)
	{
		switch (strtoupper($native_type)) {
		case 'STRING':
		case 'CHAR':
		case 'CHARACTER':
		case 'VARCHAR':
		case 'NCHAR':
		case 'NVARCHAR':
		case 'TEXT':
		case 'CLOB':
		case 'VARYING CHARACTER':
		case 'NATIVE CHARACTER':
			return 'string';

		case 'BLOB':
			return 'blob';

		case 'DATE':
			return 'date';

		case 'DATETIME':
			return 'datetime';
		case 'INT':
		case 'INTEGER':
		case 'BIGINT':
		case 'TINYINT':
		case 'MEDIUMINT':
		case 'SMALLINT':
		case 'UNSIGNED BIG INT':
		case 'UNSIGNED':
		case 'INT2':
		case 'INT8':
			return 'int';

		default: return 'numeric';
		}
	}
	/**
	 *
	 * The meta types for SQLite database
	 * @param string $native_type
	 * @param integer $max_length
	 * @return string
	 */
	protected static function MetaSqlsrv ($native_type, $max_length = -1)
	{
		switch (strtoupper($native_type)) {
		case 'BITINT':
		case 'CHAR':
		case 'DECIMAL':
		case 'MONEY':
		case 'NCHAR':
		case 'NUMERIC':			
		case 'NVARCHAR':
		case 'NTEXT':
		case 'SMALLMONEY':
		case 'SQL_VARIANT':
		case 'TEXT':
		case 'TIMESTAMP':
		case 'UNIQUEIDENTIFIER':
		case 'VARCHAR':
		case 'XML':
			return 'string';

		case 'BINARY':
		case 'GEOGRAPHY':
		case 'GEOMETRY':
		case 'IMAGE':
		case 'UDT':
		case 'VARBINARY':
			return 'blob';

		//case 'DATE':
			//return 'date';

		case 'DATETIME':
		case 'DATE':
		case 'DATETIME2':
		case 'DATETIMEOFFSET':
		case 'SMALLDATETIME':			
		case 'TIME':
			return 'datetime';
		case 'INT':
		case 'BIT':
		case 'SMALLINT':
		case 'TINYINT':
			return 'int';

		default: return 'numeric';
		}
	}

	/**
	 *
	 * Try to get the primary key of the table automattically
	 * @return mixed the value of the key or false if not presend or not found
	 */
	public static function getPrimaryKey($table, $conn, $dbtype)
	{
		if(strlen($table)>0 && $conn && strlen($dbtype)>0 ) {
			switch ($dbtype)
			{
				case 'odbcpgsql':
					$sql = "select column_name from information_schema.constraint_column_usage where table_name = '".$table."'";
					$rs = self::query($conn, $sql);
					if($rs) {
						$res = self::fetch_num( $rs );
						self::closeCursor($rs);
						if($res) {
							return $res[0];
						}
					}
					return false;
					break;
				case 'odbcmysql':
					$sql = "select column_name from information_schema.statistics where table_name='".$table."'";
					$rs = self::query($conn, $sql);
					if($rs) {
						$res = self::fetch_num( $rs );
						self::closeCursor($rs);
						if($res) {
							return $res[0];
						}
					}
					return false;
					break;
				case 'odbcsqlite':
					$pos = strpos($table, ".");
					if( $pos === false)
						$sql = "PRAGMA table_info($table)";
					else {
						$schemaName = substr($table,0,$pos);
						$table = substr($table,$pos+1);
						$sql = "PRAGMA $schemaName.table_info($table)";
					}
					$res = false;
					$stmt = self::query($conn, $sql);
					if($stmt) {
						while($row = self::fetch_assoc()) {
							if($row['pk']==1) {
								$res = $row['name'];
								break;
							}
						}
						self::closeCursor($stmt);
					}
					return $res;
					break;
				case 'odbcsqlsrv' :
					$sql    = "exec sp_columns @table_name = '".$table."'";
					$stmt   = self::query( $conn, $sql);
					if(!$stmt) {
						return false;
					}
					$result = array();
					while($row = self::fetch_num( $stmt )){
						$result[] = $row;
					}

					$owner           = 1;
					$table_name      = 2;
					$column_name     = 3;
					$type_name       = 5;
					$precision       = 6;
					$length          = 7;
					$scale           = 8;
					$nullable        = 10;
					$column_def      = 12;
					$column_position = 16;
		
					if(count($result)==0) { return false; }
					self::closeCursor($stmt);
					/**
					* Discover primary key column(s) for this table.
					*/
					$tableOwner = $result[0][$owner];
					$sql        = "exec sp_pkeys @table_owner = " . $tableOwner
						. ", @table_name = '".$table."'";
					$stmt       = self::query( $conn, $sql);
					/*
					while($row = self::fetch_num( $stmt )){
						$primaryKeysResult = $row;
					}
					*
					*/
					// Currently we suppose to use only one PK.
					//$primaryKeyColumn  = array();
					if($stmt) {
						$primaryKeysResult = self::fetch_num( $stmt );
						self::closeCursor($stmt);
					} 
					// Per http://msdn.microsoft.com/en-us/library/ms189813.aspx,
					// results from sp_keys stored procedure are:
					// 0=TABLE_QUALIFIER 1=TABLE_OWNER 2=TABLE_NAME 3=COLUMN_NAME 4=KEY_SEQ 5=PK_NAME

					$pkey_column_name = 3;
					$pkey_key_seq     = 4;
					//foreach ($primaryKeysResult as $pkeysRow) {
					//$primaryKeyColumn[$pkeysRow[$pkey_column_name]] = $pkeysRow[$pkey_key_seq];
					//}
					if($primaryKeysResult && $primaryKeysResult[$pkey_column_name]) return $primaryKeysResult[$pkey_column_name];
					return false;
				break;
			}
		}
		return false;
	}
	public static function errorMessage ( $conn )
	{
		return odbc_errormsg($conn );
	}

}
?>

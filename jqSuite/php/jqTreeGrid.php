<?php
/**
 * @author  Tony Tomov, (tony@trirand.com)
 * @copyright TriRand Ltd
 * @version 4.4.4.0
 * @package jqTreeGrid
 *
 * @abstract
 * A PHP class to work with jqGrid Tree module.
 * The main purpose of this class is to provide the data from database to jqGrid,
 * The class requier a jqGrid classes to be loaded first.
 */
include '../../jqSuitePHP_Sources_4_4_4_0/php/jqGrid.php';
class jqTreeGrid extends jqGridRender
{
	/**
	 * Determiones the type of tree model.
	 * Can be adjacency or nested
	 * @var string
	 */
	private $treemodel = 'nested';

	/**
	 * Hold the configuration for the used model
	 *  var array
	 */
	private  $tableconfig = array(
		// common to all models
		"id" => "id",
		// adjacency
		"parent"=>"parent",
		// nested
		"left"=>"lft",
		"right"=>"rgt",
		"level"=>"level",
		"leaf"=>"isLeaf",
		"expanded"=>"expanded",
		"loaded"=>"loaded",
		"icon"=>"icon"
	);
	/**
	 * Stores the result after the re
	 * @var array
	 */
	private $res = array();
	/**
	 * hods the data for future processing of the tree
	 * @var array
	 */
	private $data;
	/**
	 * array for the leaf nodes. Used only in adjacency model
	 *  @var array
	 */
	private $leaf_nodes = array();
	/**
	 * Should be all nodes expanded when loaded at client
	 * @var boolean
	 */
	public $expandAll = false;
	/**
	 * If set to false all data is available at client side
	 * @var boolean
	 */
	public $autoLoadNodes = true;
	/**
	 *
	 * Se the tree data for future processing
	 * @param array $d
	 */
	public function setData($d) {
		$this->data = $d;
	}
	/**
	 * Set a leaf nodes for adjacency model
	 * @param array $d
	 */
	public function setLeafData($d) {
		$this->leaf_nodes = $d;
	}
	/**
	 * Set the tree mode used. Can be adjacency or nested. Deafault is nested
	 * @param string $model
	 */
	public function setTreeModel( $model = 'nested')
	{
		if( strlen($model)>0 ) {
			$this->treemodel = $model;
		}
	}
	/**
	 * Returns the currently used tree model
	 * @return string
	 */
	public function getTreeModel() {
		return $this->treemodel;
	}
	/**
	 * Set the configuration fields for the model used.
	 * For the adjacency model a 'id' and 'parent' should be set
	 * For the nested model 'id', 'left', 'right' and 'level' should be set
	 * Optional fields for all models :
	 * expanded, icon, leaf, loaded
	 *
	 * @param array $aconfig
	 */
	public function setTableConfig( $aconfig )
	{
		if(is_array($aconfig) && count($aconfig)>0 ) {
			$this->tableconfig = jqGridUtils::array_extend($this->tableconfig, $aconfig);
			if(!isset ($aconfig['table'])) {
				$this->tableconfig['table'] = $this->table;
			}
		}
	}
	/**
	 * Return the curent configuration for the model used
	 * @return array
	 */
	public function getTableConfig() {
		return $this->tableconfig;
	}

	/**
	 * Return the leaf nodes when the adjacency model is used.
	 * Note that the table and table configuration should be set
	 * @param integer $node - the id of the node
	 * @return array of the leaf nodes
	 */
	public function getLeafNodes( $node=0 ) {
		//
		$leaf = array();
		if( strlen($this->tableconfig['table']) > 0 ) {
			// buld sql
			if($this->treemodel == 'adjacency')
			{
				if ($node == 0 ) {
					$where = "";
				} else {
					$where = ' AND t1.%parent$s = '.$node;
				}
				// just in case set
				//$SQLL = "SELECT t1.account_id FROM accounts AS t1 LEFT JOIN accounts as t2 "
				//." ON t1.account_id = t2.parent_id WHERE t2.account_id IS NULL";
				$s = jqGridUtils::sprintfn('SELECT t1.%id$s FROM %table$s AS t1 LEFT JOIN %table$s AS t2 ON t1.%id$s = t2.%parent$s WHERE t2.%id$s IS NULL'.$where, $this->tableconfig);
				if($this->debug) {
					$this->logQuery($s);
				}
				$q = jqGridDB::query($this->pdo, $s);
				if($q) {
					while ($row = jqGridDB::fetch_num($q, $this->pdo) ) {
						$leaf[$row[0]] = $row[0];
					}
				}
				jqGridDB::closeCursor($q);
			} elseif( $this->treemodel == 'nested' ) {
				
			}
		} else {
			// trigger own error
			echo "no table set";
		}
		return $leaf;
	}
	/**
	 * Return all Child nodes for both methods. The data is populated in the
	 * protected variable $res.
	 * @param integer $node the id of the node
	 * @param string $order_field - optional order field
	 * @param boolean $id  what to return - only the id of the noes or all the
	 * data of the child nodes. Deafult is false
	 */
	protected function getChildNodes ($node, $order_field='', $id=false)
	{
		if($this->treemodel == 'adjacency') {
			$order = "";
			if($order_field) $order = "ORDER BY ".$order_field;
			$s = jqGridUtils::sprintfn('SELECT * FROM %table$s WHERE %parent$s = '.(int)$node.' '.$order, $this->tableconfig);
			if($this->debug) {
				$this->logQuery($s);
			}
			$q = jqGridDB::query($this->pdo, $s);
			if($q) {
				while ($row = jqGridDB::fetch_assoc($q, $this->pdo) ) {
					$nid = $row[$this->tableconfig['id']];
					$this->res[] = $id ? $nid: $row;
					if( !(isset($this->leaf_nodes[$nid])  && ($nid== $this->leaf_nodes[$nid])) ) {
						$this->getChildNodes($row[$this->tableconfig['id']], $order_field, $id );
					}
				}
			}
			jqGridDB::closeCursor($q);
		} elseif($this->treemodel == 'nested') {
			$s = jqGridUtils::sprintfn('SELECT %left$s, %right$s FROM %table$s WHERE %id$s = '.(int)$node, $this->tableconfig);
			if($this->debug) {
				$this->logQuery($s);
			}
			$q = jqGridDB::query($this->pdo, $s);
			$row = jqGridDB::fetch_num($q, $this->pdo );
			jqGridDB::closeCursor($q);
			if($row) {
				$s = jqGridUtils::sprintfn('SELECT * FROM %table$s WHERE %left$s > '.$row[0].' AND %left$s <'.$row[1], $this->tableconfig);
				if($this->debug) {
					$this->logQuery($s);
				}
				$q1 = jqGridDB::query($this->pdo, $s);
				while($r = jqGridDB::fetch_assoc($q1, $this->pdo))
				{
					$nid = $r[$this->tableconfig['id']];
					$this->res[] = $id ? $nid: $r;
				}
				jqGridDB::closeCursor($q1);
			}
		}
	}
	/**
	 * Return the child nodes of a given node. If the node is not specifies return
	 * the root nodes. Used only in adjacency model. Uses the data array
	 * @param integer $node_id the id of the node
	 * @return array
	 */
	protected function getChildren($node_id = null)
	{
		$children = null;

		if ((int)$node_id > 0 )
		{
			$children = array();
			$parent  = $this->tableconfig['parent'];

			foreach ($this->data as $id => $node) {
				if ( (int)$node->{$parent} == (int)$node_id) {
					$children[] = $node;
				}
			}
		}
		else {
			$children = $this->getRoots();
		}

		return $children;
	}
	/**
	 * Return the root nodes when adjacency model. Uses data array
	 * @return array
	 */
	protected function getRoots()
	{
		$roots = array();
		$parent  = $this->tableconfig['parent'];
		if($this->data) {
			foreach ($this->data as $id => $node) {
				if ($node->{$parent} === null) {
					$roots[] = $node;
				}
			}
		}
		return $roots;
	}
	/**
	 * Build the data for the tree
	 * @param integer $parent parent node
	 * @param ineteger $level the level field
	 * @param array $res the result used only in nested set
	 * @return array
	 */
	private function buildTreeArray($parent, $level , $res=null)
	{
		if($this->treemodel == 'adjacency') {
			$result = $this->getChildren($parent);
			
			$slevel = $this->tableconfig['level'];
			$id = $this->tableconfig['id'];
			$leaf = $this->tableconfig['leaf'];
			$loaded = $this->tableconfig['loaded'];
			$expand = $this->tableconfig['expanded'];
			$expAll = $this->expandAll ? 'true' : 'false';
			$load = $this->autoLoadNodes ? 'false' : 'true';
			foreach($result as $key=>$node)
			{
				$node->{$slevel} = $level;
				$nid = (int)$node->{$id};
				$node->{$leaf} = ( isset($this->leaf_nodes[$nid])  && ($nid== $this->leaf_nodes[$nid]) )  ?  'true' : 'false';
				$node->{$loaded} = $load;
				$node->{$expand} = $expAll;
				$this->res[]=$node;
				$this->buildTreeArray($node->{$id}, $level+1 );
			}
			return $this->res;
		} else if($this->treemodel == 'nested') {
			$loaded = $this->tableconfig['loaded'];
			$expand = $this->tableconfig['expanded'];
			$expAll = $this->expandAll ? 'true' : 'false';
			$load = $this->autoLoadNodes ? 'false' : 'true';
			foreach($res as $key=>$node)
			{
				$node->{$loaded} = $load;
				$node->{$expand} = $expAll;
				$this->res[]=$node;
			}
			return $this->res;
		}
	}
	/**
	 * Set a specifick options for the tree grid according to the model.
	 * @param string $model
	 */
	private function _setTreeGridOptions($model)
	{
		if(!$this->autoLoadNodes) $loadonce = true;
		else $loadonce = false;
		$treereader = array(
			"parent_id_field"=>$this->tableconfig['parent'],
			"left_field"=>$this->tableconfig['left'],
			"right_field"=>$this->tableconfig['right'],
			"level_field"=>$this->tableconfig['level'],
			"leaf_field"=>$this->tableconfig['leaf'],
			"expanded_field"=>$this->tableconfig['expanded'],
			"loaded"=>$this->tableconfig['loaded'],
			"icon_field"=>$this->tableconfig['icon']
		);
		if($model =='adjacency') {
			unset($treereader["left_field"],$treereader["right_field"]);
		} else {
			unset($treereader["parent_id_field"]);
		}
		$this->setGridOptions(array(
			// instruct to load all the records
			"rowTotal"=>-1,
			// treegrid
			"treeGrid"=>true,
			"treedatatype"=>$this->dataType,
			"treeGridModel"=>$this->treemodel,
			// to be changed dynamically
			"loadonce"=>$loadonce,
			"rowNum"=>1000000,
			"scrollrows"=>true,
			"viewrecords"=>false,
			"treeReader"=>$treereader
		));
		if($model =='nested') {
			$this->setGridOptions(array(
				"sortname"=>$this->tableconfig['left'],
				"sortorder"=>'ASC'
			));
		}
	}
	/**
	 * Return the data for the adjacency tree model
	 * @param array $summary the summary array
	 * @param array  $params parameters to the query
	 * @param boolean $echo should we retun or echo the result
	 * @return mixed string or object
	 */
	private function renderAdjacency($summary, $params, $echo)
	{
		$response = null;
		// Get parameters from the grid
		$node = (int)jqGridUtils::GetParam("nodeid", "0");
		$n_lvl = (int)jqGridUtils::GetParam("n_level", "0");
		// set the leaf nodes
		$data1 = $this->getLeafNodes($node);
		$this->setLeafData($data1);
		// build the tree
		if($this->autoLoadNodes) {
			$sql = $this->_setSQL();
			if($node > 0) {
				$s = " ".$this->tableconfig["parent"]." = ".(int)$node;
			} else {
				$s = " ".$this->tableconfig["parent"]." IS NULL ";
			}
			if(preg_match("/WHERE/i",$sql)) // to be refined
				$sql .= " AND ".$s;
			else
				$sql .= " WHERE ".$s;
			// explicit set the where

			$this->readFromXML = false;
			$this->SelectCommand = $sql;
		}
		$this->performcount = false;
		$res = $this->queryGrid($summary, $params, false);
		$this->setData($res->rows);
		$n_lvl = $node==0 ? 0 : $n_lvl+1;
		$data = $this->buildTreeArray($node,  $n_lvl);
		if(!isset ($res->userdata) ) $res->userdata = array();
		$response = array(
			"userdata"=>$res->userdata,
			"rows" =>$data,
			"total"=>count($data),
			"page"=>1
		);
		if($echo) {
			$this->_gridResponse($response);
		} else {
			return $response;
		}

	}
	/**
	 * Return the data for the nested tree model
	 * @param array $summary the summary array
	 * @param array  $params parameters to the query
	 * @param boolean $echo should we retun or echo the result
	 * @return mixed string or object
	 */
	private function renderNested($summary, $params, $echo)
	{
		$response = null;
		// Get parameters from the grid
		$node = (int)jqGridUtils::GetParam("nodeid", "0");
		$n_lvl = (int)jqGridUtils::GetParam("n_level", "0");
		// set the leaf nodes
		if($this->autoLoadNodes) {
			$sql = $this->_setSQL();
			$s="";
			if($node > 0) {
				$n_lft = (int)jqGridUtils::GetParam("n_left");
				$n_rgt = (int)jqGridUtils::GetParam("n_right");
				$s = " ".$this->tableconfig["left"]." > ".$n_lft." AND ".$this->tableconfig["left"]." < ".$n_rgt. " AND ".$this->tableconfig["level"]." = ".($n_lvl+1);
			} elseif($n_lvl == 0) {
				$s = " ".$this->tableconfig["level"]." = 0";
			}
			if(preg_match("/WHERE/i",$sql)) // to be refined
				$sql .= " AND ".$s;
			else
				$sql .= " WHERE ".$s;
			// explicit set the where

			$this->readFromXML = false;
			$this->SelectCommand = $sql;
		}
		$this->performcount = false;
		if(!$this->autoLoadNodes && $this->expandAll) {
			$qwg = $this->queryGrid($summary, $params, false);
			if(!isset ($qwg->userdata) ) $qwg->userdata = array();
			$data = $this->buildTreeArray(0, 0,$qwg->rows);
			$response = array(
				"userdata"=>$qwg->userdata,
				"rows" =>$data,
				"total"=>count($data),
				"page"=>1
			);
			if($echo) {
				$this->_gridResponse($response);
			} else {
				return $response;
			}
		} else {
			return $this->queryGrid($summary, $params, $echo);
		}

	}
	/**
	 * Return the result of the query to jqTreeGrid. Currently does not support searching.
	 * @param array $summary - set which columns should be sumarized in order to be displayed to the grid
	 * By default this parameter uses SQL SUM function: array("colmodelname"=>"sqlname");
	 * It can be set to use the other one this way
	 * array("colmodelname"=>array("sqlname"=>"AVG"));
	 * By default the first field correspond to the name of colModel the second to
	 * the database name
	 * @param array $params - parameter values passed to the sql
	 * @param boolen $echo if set to false return the records as object, otherwiese json encoded or xml string
	 * depending on the dataType variable
	 * @return mixed
	 */

	public function queryTree(array $summary=null, array $params= null, $echo=true) {
		$response = null;
		if($this->treemodel == 'adjacency') {
			$response = $this->renderAdjacency($summary, $params, $echo);
		} elseif ($this->treemodel == 'nested') {
			$response = $this->renderNested($summary, $params, $echo);
		} else {
			$this->queryGrid($summary, $params, $echo);
		}

	}
	/**
	 *
	 * Update the data into the database according the table element
	 * A primaryKey should be set. If the key is not set It can be obtained
	 * from jqGridDB::getPrimaryKey.
	 * Return true on success, false when the operation is not succefull
	 * @param array $data associative array which key values correspond to the
	 * names in the table
	 * @return boolean
	*/

	public function updateTreeNode( $data )
	{
		return $this->update($data);
	}
	/**
	 *
	 * Insert the data array into the database according to the table element and
	 * tree model.
	 * A primaryKey should be set. If the key is not set It can be obtained
	 * from jqGridDB::getPrimaryKey. The table config for the tree should be set.
	 * @see setTableConfig
	 * Return true on succes, false otherwiese.
	 * @param array $data associative array which key values correspond to the
	 * names in the table.
	 * @return boolean
	 */

	public function insertTreeNode( $data )
	{
		$this->getLastInsert = true;
		if($this->treemodel == 'nested') {
			$node = (isset ($data['parent_id']) && (int)$data['parent_id']>0 ) ? $data['parent_id'] : 0;
			if((int)$node > 0 && $node != 'null') {
				$s = jqGridUtils::sprintfn('SELECT %right$s, %level$s FROM %table$s WHERE %id$s = '.(int)$node, $this->tableconfig);
			} else {
				$s = jqGridUtils::sprintfn('SELECT MAX( %right$s), "-1" as level   FROM %table$s', $this->tableconfig);
			}
			if($this->debug) {
				$this->logQuery($s);
			}
			$q = jqGridDB::query($this->pdo, $s);
			if(!$q) {
				$this->errorMesage = jqGridDB::errorMessage($this->pdo);
				if($this->showError) {
					$this->sendErrorHeader();
				} else {
					die($this->errorMesage);
				}
			}
			$row = jqGridDB::fetch_num($q, $this->pdo);
			jqGridDB::closeCursor($q);
			if(!$row) {
				//can not find the node
				$row[0] = 1; $row[1] = -1;
			}
			unset($data['parent_id']);
			//$data[$this->tableconfig['left']] = (int)$row[0];
			//$data[$this->tableconfig['right']] = (int)$row[0]+1;
			$data[$this->tableconfig['level']] = (int)$row[1]+1;
			if((int)$row[1] == -1)
			{
				$data[$this->tableconfig['left']] = (int)$row[0]+1;
				$data[$this->tableconfig['right']] = (int)$row[0]+2;
				$s1 = jqGridUtils::sprintfn('UPDATE %table$s SET %right$s = %right$s + 2 WHERE %right$s > ?', $this->tableconfig);
				$s2 = jqGridUtils::sprintfn('UPDATE %table$s SET %left$s = %left$s + 2 WHERE %left$s > ?', $this->tableconfig);
				$this->setBeforeCrudAction('add', $s1, array((int)$row[0]));
				$this->setBeforeCrudAction('add', $s2, array((int)$row[0]));

			} else {
				$data[$this->tableconfig['left']] = (int)$row[0];
				$data[$this->tableconfig['right']] = (int)$row[0]+1;
				$s1 = jqGridUtils::sprintfn('UPDATE %table$s SET %left$s = CASE WHEN %left$s > ? THEN %left$s + 2 ELSE %left$s END, %right$s = CASE WHEN %right$s >= ? THEN %right$s + 2 ELSE %right$s END WHERE %right$s >= ?', $this->tableconfig);
				//$s2 = jqGridUtils::sprintfn('UPDATE %table$s SET %left$s = %left$s + 2 WHERE %left$s > ?', $this->tableconfig);
				$this->setBeforeCrudAction('add', $s1, array((int)$row[0], (int)$row[0], (int)$row[0]));
				//$this->setBeforeCrudAction('add', $s2, array((int)$row[0]));
			}

		} 
		return $this->insert($data);
	}
	/**
	 *
	 * Delete the data into the database according the table element and tree
	 * grid model.
	 * A primaryKey should be set. If the key is not set It can be obtained
	 * from jqGridDB::getPrimaryKey
	 * Return true on success, false when the operation is not succefull
	 * @param array $data associative array which key values correspond to the
	 * names in the delete command
	 * @return boolean
	 */
	public function deleteTreeNode( $data )
	{
		if(!$this->add) return false;
		$where = '';
		$param = null;
		if($this->treemodel == 'adjacency') {
			$this->setLeafData($this->getLeafNodes($data[$this->primaryKey]));
			$this->getChildNodes($data[$this->primaryKey], '', true);

			if(is_array($this->res) && count($this->res) > 0 ) {
				$data[$this->primaryKey] .= ",".implode(",",$this->res);
			}
			
		} elseif($this->treemodel == 'nested') {
			$node = $data[$this->primaryKey];
			$s = jqGridUtils::sprintfn('SELECT %left$s, %right$s FROM %table$s WHERE %id$s = '.(int)$node, $this->tableconfig);
			if($this->debug) {
				$this->logQuery($s);
			}
			$q = jqGridDB::query($this->pdo, $s);
			if(!$q) {
				$this->errorMesage = jqGridDB::errorMessage($this->pdo);
				if($this->showError) {
					$this->sendErrorHeader();
				} else {
					die($this->errorMesage);
				}
			}
			$row = jqGridDB::fetch_num($q, $this->pdo);
			jqGridDB::closeCursor($q);
			if(!$row) {
				// ????? nothing to delete maybe
				return true;
			}
			$lft = (int)$row[0];
			$rgt = (int)$row[1];
			$width = $rgt - $lft + 1;
			$where = " ".$this->tableconfig['left']." BETWEEN ? AND ?";
			$param = array((int)$lft, (int)$rgt);
			$s1 = jqGridUtils::sprintfn('UPDATE %table$s SET %right$s = %right$s - ? WHERE %right$s > ?', $this->tableconfig);
			$s2 = jqGridUtils::sprintfn('UPDATE %table$s SET %left$s = %left$s - ? WHERE %left$s > ?', $this->tableconfig);
			$this->setAfterCrudAction('del', $s1, array((int)$width, (int)$rgt));
			$this->setAfterCrudAction('del', $s2, array((int)$width, (int)$rgt));
		}
		return $this->delete($data, $where, $param);
	}
	/**
	 * Perform the all CRUD operations depending on the oper param send from the grid,
	 * the table element and the treegrid model
	 * If the primaryKey is not set we try to obtain it using jqGridDB::getPrimaryKey
	 * If the primary key is not set or can not be obtained the operation is aborted.
	 * Also the method call the queryTree to perform the tree ouput
	 * @param array $summary - set which columns should be sumarized in order to be displayed to the grid
	 * By default this parameter uses SQL SUM function: array("colmodelname"=>"sqlname");
	 * It can be set to use the other one this way
	 * array("colmodelname"=>array("sqlname"=>"AVG"));
	 * By default the first field correspond to the name of colModel the second to
	 * the database name
	 * @param array $params additional parameters that can be passed to the query
	 * @param string $oper if set the requested oper operation is performed without to check
	 * the parameter sended from the grid.
	 */

	public function editTree (array $summary=null, array $params=null, $oper=false, $echo = true)
	{
		if(!$oper) {
			$oper = $this->GridParams["oper"];
			$oper = jqGridUtils::GetParam($oper,"grid");
		}
		$okmsg = "success##Operation performed succefully";
		switch ($oper)
		{
			case $this->GridParams["editoper"] :
				$this->checkPrimary();
				$data = strtolower($this->mtype)=="post" ? jqGridUtils::Strip($_POST) : jqGridUtils::Strip($_GET);
				if( $this->updateTreeNode($data) )
				{
					$this->setSuccessMsg($okmsg."##none");
					if($this->successmsg) {
						echo $this->successmsg;
					}
				}
				break;
			case $this->GridParams["addoper"] :
				$this->checkPrimary();
				$data = strtolower($this->mtype)=="post" ? jqGridUtils::Strip($_POST) : jqGridUtils::Strip($_GET);
				$this->getLastInsert = true;
				if($this->insertTreeNode($data) ) {
					$this->setSuccessMsg($okmsg."##".$this->lastId);
					if($this->successmsg) {
						echo $this->successmsg;
					}
				}
				break;
			case $this->GridParams["deloper"] :
				$this->checkPrimary();
				$data = strtolower($this->mtype)=="post" ? jqGridUtils::Strip($_POST) : jqGridUtils::Strip($_GET);
				if($this->deleteTreeNode($data))
				{
					$this->setSuccessMsg($okmsg);
					if($this->successmsg) {
						echo $this->successmsg;
					}
				}
				break;
			default :
				$this->queryTree($summary, $params, $echo);
		}
	}
	/**
	 * Main method which do allmost everthing for the tree grid.
	 * Construct the tree grid, perform CRUD operations, perform Query
	 * set a jqGrid method, and javascript code.
	 * @param string $tblelement the id of the table element to costrict the grid
	 * @param string $pager the id for the pager element
	 * @param boolean $script if set to true add a script tag before constructin the grid.
	 * @param array $summary - set which columns should be sumarized in order to be displayed to the grid
	 * By default this parameter uses SQL SUM function: array("colmodelname"=>"sqlname");
	 * It can be set to use other one this way :
	 * array("colmodelname"=>array("sqlname"=>"AVG"));
	 * By default the first field correspond to the name of colModel the second to
	 * the database name
	 * @param array $params parameters passed to the query
	 * @param boolean $createtbl if set to true the table element is created automatically
	 * from this method. Default is false
	 * @param boolean $createpg if set to true the pager element is created automatically
	 * from this script. Default false.
	 * @param boolean $echo if set to false the function return the string representing
	 * the grid
	 * @return mixed.
	 */

	public function renderTree($tblelement='', $pager='', $script=true, array $summary=null, array $params=null, $createtbl=false, $createpg=false, $echo=true)
	{
		$oper = jqGridUtils::GetParam('oper','nooper');
		$oper = $this->GridParams["oper"];
		$goper = jqGridUtils::GetParam($oper,'nooper');
		if($goper == $this->GridParams["autocomplete"]) {
			return false;
		} else if($goper == $this->GridParams["excel"]) {
			if(!$this->export) return false;
			$this->exportToExcel($summary, $params, $this->colModel, true, $this->exportfile);
		} else if($goper == "pdf") {
			if(!$this->export) return false;
			$this->exportToPdf($summary, $params, $this->colModel, $this->pdffile);
		} else if($goper == "csv") {
			if(!$this->export) return false;
			$this->exportToCsv($summary, $params, $this->colModel, true, $this->csvfile, $this->csvsep, $this->csvsepreplace);
		} else if(in_array($goper, array_values($this->GridParams)) ) {
			$this->editTree( $summary, $params, $goper);
		} else {
			$this->_setTreeGridOptions($this->treemodel);
			return $this->renderGrid($tblelement, $pager, $script, $summary, $params, $createtbl, $createpg, $echo);
		}
	}
}
?>

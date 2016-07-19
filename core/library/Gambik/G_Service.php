<?php
//define("DEFAULT_LIMIT",1000);
class G_Service {

	public $commit = true;
	public $sql;
	protected $name;
	protected $_primary = 'id';

	public $insert_id;
	public $rows_affected;
	private $_data = array();

	private $_select = "";
	private $_from = "";
	private $_where = array();
	private $_orderBy = "";
	private $_limit = "";
	private $_groupBy = "";

	function __construct($name)
	{
		$this->sql = Sql::instance();
	//	print $name;

		if (!empty($name)) {
			//$this->sql->setTableName($name);
			$this->name = $name;
		}

	}
	public function escape($string)
	{
		return $this->sql->escape($string);
		//return $this->sql->getGroupBy();
	}
	public function getTablename()
	{
		//$this->sql->setTableName($name);
		/*
		if (!empty($this->name)) {
			$this->sql->setTableName($this->name);
		}
		*/
		return $this->name;
		//return $this->sql->getTableName();
	}

	public function addWhere($where)
	{
		if (!empty($where)) {
			$this->_where[] = $where;
		}

		//	$this->sql->addWhere($where);
	}

	public function getWhere()
	{
		//return $this->sql->getWhere();
		$whr = "";
		if (is_array($this->_where) && count($this->_where) > 0) {
			foreach ($this->_where as $key => $value) {
				$whr .="(" . $value . ") AND";
			}
			if (substr($whr, -3) =="AND"){
				$whr = substr($whr,0,strLen($whr)-3);
			}
			return " WHERE " . $whr;
		}
		return $whr;
	}
	public function getGroupBy()
	{
		return $this->_groupBy;
		//return $this->sql->getGroupBy();
	}




	public function getRows(){

		$sql = ""
			. $this->getSelectWithRowId() . " "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy() . " "
			. $this->getOrderBy() . " "
			. $this->getLimit();
		//	print $sql . "<br />";

		$this->sql->query("set @row_num=0");
		$list = $this->sql->get_results($sql);
/*
		if ($this->sql->benchmark) {
			$end_sql = explode(" ", microtime());
			$end_sql = $end_sql[1] + $end_sql[0];
			$rd = "10000"; // zaokrouhlování
			print "=== Start BenchMark ===<br />";
			print "Duration: " . ((round((($end_sql) - $start_sql) * $rd)) / $rd) . "sec<br />";
			print $this->sql->getLastQuery() . "<br />=== End BenchMark ===<br />";
		}
*/

		$this->clearWhere();
		$this->clearGroupBy();
		return $list;
	}
	public function getRow($select)
	{
		if (is_numeric($select)) {
			$query = "select * from " . $this->name . " where " . $this->_primary . " = " . $select . " LIMIT 1";
		}else {
			$query = $select;
		}

		//print $query;
		return $this->sql->get_row($query);
	}

	public function clearWhere()
	{
		//$this->sql->clearWhere();
		$this->_where = array();
	}

	public function clearGroupBy()
	{
		//$this->sql->clearWhere();
		$this->_groupBy = "";
	}
	public function get_var($sql)
	{
		return $this->sql->get_var($sql);
	}

	public function setSelect($select)
	{
		//$this->sql->setSelect($select);
		$this->_select = $select;
	}


	public function getSelectWithRowId()
	{
		if (!strpos(strtolower($this->getSelect()),"rowid")) {
			//	return " FROM " . $this->_from . " ";

		//	$select = "set @row_num=0;";
		//	$query .= "SELECT  @row_num := @row_num+1 as rowid";
		}

		$query = "";
		$query .= "SELECT @row_num := @row_num+1 as rowid,";

		return $query . " " . $this->_select;
	}



	public function getSelect()
	{
		return "SELECT " . $this->_select;
	}
	public function setLimit($page = 1, $limit = DEFAULT_LIMIT)
	{

		// FIX page musí být vždy větší 1
		$page = $page * 1;
		if ($page < 1) {
			$page = 1;
		}

		$limit = $limit * 1;
		// FIX Limit musí být vždy větší 1
		if ($limit < 1) {
			$limit = 1;
		}
		$offset = ($page -1 ) * $limit;
		$this->_limit = "LIMIT " . $offset . ", " . $limit;
	}
	public function getLimit()
	{
		return $this->_limit;
	}

	public function getLimitQuery()
	{
		if (!empty($this->_limit)) {
			$aaa = explode(",",$this->_limit);
			return trim($aaa[1]);
		}
		return DEFAULT_LIMIT;
	}


	public function setFrom($from)
	{
		//$this->sql->setFrom($from);
		$this->_from = $from;
	}

	public function getFrom()
	{
	//	return $this->_from;
		if (!strpos(strtolower($this->_from),"from")) {
		//	return " FROM " . $this->_from . " ";
		}
		//return " " . $this->_from . " ";

		//print substr(trim(strtolower($this->_from)),0,4) . "<br />";

		if (substr(trim(strtolower($this->_from)),0,4) !== "from") {
			return " FROM " . $this->_from . " ";
		}
		return " " . $this->_from . " ";

	}

	public function setOrderBy($order,$default='')
	{
		//$this->sql->setOrderBy($order,$default);
		$order2 = "";
		if (!empty($order)) {
			$ordersArray = explode(",",$order);

			foreach ($ordersArray as $key => $orderValue) {

				$sort = "ASC";
				if (strpos(strtoupper($orderValue), " ")) {
					$orderArray = explode(" ",$orderValue);

					$orderValue = $orderArray[0];
					$sort = $orderArray[1];
				}
			//	print $orderValue . "<br />";
				if (strpos(strtoupper($orderValue), ".")) {
					// obsahuje Alias tabulky, neřeším dál

				} else {

					$selectArray = explode(",",$this->_select);

					//print_r($selectArray);
					foreach ($selectArray as $keySelect => $valueSelect) {

						$aliasSelectArray = explode("as",$valueSelect);
						if (strpos($aliasSelectArray[0], $orderValue)) {
							$orderValue = $aliasSelectArray[0];
							break;
						}

					}

				}

			//	PRINT $orderValue;
				if (strpos(strtoupper($orderValue), " ASC") || strpos(strtoupper($orderValue), " DESC")) {
					$order2 .= $orderValue; // . " " . $sort;
				} else {
					$order2 .= $orderValue .  " " . $sort;
				}
				$order2 .= ",";
				// pokusím se dohledat tříděný attribut v enttiách!

			//	print $value;



			}
			$order = substr($order2, 0, -1);
		//	$order = $order2;
		} else {
			$order = $default;
		}
		//$order = !empty($order) ?  $order : $default;

		$this->_orderBy = !empty($order) ?  "ORDER BY " . $order : "";
	}

	public function getOrderBy()
	{
		//return $this->sql->getOrderBy();
		return $this->_orderBy;
	}

	public function get_row($sql)
	{
		return $this->sql->get_row($sql);
	}

	public function getTotalRows()
	{
		return $this->sql->total;
	}



	public function updateEntity($entita, $condition)
	{




	//	$entita->nastav($propertyChanged);

		$changeEntityProperty = $entita->getChangedData();
		/*
		$entita->getAttrib();



		foreach( $entita->getAttrib() as $property => $value )
		{
			if (isset($propertyChanged[$property])) {
				$changeEntityProperty[$property] = $propertyChanged[$property];
			}
		}*/
		return updateRecords( $entita->getTablename, $changeEntityProperty, $condition );

	}
	public function updateRecords( $table, $changes, $condition )
	{
		$result = $this->sql->updateRecords( $table, $changes, $condition );
		$this->commit = $this->sql->getCommit();
		$rows_affected = $this->sql->getRowsAffected();
		return $result;

	}

	public function insertRecords( $table, $data )
	{
		$result = $this->sql->insertRecords( $table, $data );
		$this->commit = $this->sql->getCommit();
	//	print $this->sql->getLastQuery() . "<br />";
	//	print $result;
	//	print $this->sql->insert_id;
		$this->insert_id = $result;
		return $result;

	}

	public function deleteRecords( $table, $condition )
	{
		$result = $this->sql->deleteRecords( $table, $condition );
		$this->commit = $this->sql->getCommit();
		//	print $result;
		//	print $this->sql->insert_id;
		//$this->insert_id = $result;
		return $result;

	}

	public function start_transakce($auto=false)
	{
		$this->sql->start_transakce($auto);
	}


	public function konec_transakce($all_query_ok=true)
	{
		return $this->sql->konec_transakce($all_query_ok);
	}

	/*public function getRow($select)
	{
		return $this->getRow($select);
	}*/

	public function delete($id=null)
	{
		//return $this->sql->delete($id);
		return $this->sql->deleteRecords( $this->name, $this->_primary . "=" . $id);
	}

	public function insert($data = null)
	{
		//$this->insert_id = $this->sql->insert($data);

		if (!is_array($data)) {
			$data = $this->_data;
		}

		$result = $this->sql->insertRecords( $this->name, $data );

		$this->insert_id = $result;
		return $result;

		//return $this->insert_id;
	}
	public function update()
	{
		return $this->sql->update();
	}

	public function get_results($query=null, $output = "OBJECT")
	{
		$result = $this->sql->get_results( $query, $output );
		return $result;
	}

	public function setData($data)
	{
		//$this->sql->setData( $data );
		$this->_data = $data;
	}
	public function addData($key, $value)
	{
		//$this->sql->addData($key, $value);

		$this->_data[$key] = $value;

	}

	public function getLastQuery()
	{
		return $this->sql->getLastQuery();
	}

	public function getValue()
	{
		//return $this->sql->getValue();
		$sql = "SELECT "
			. $this->getSelect() . " FROM "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy() . " "
			. $this->getOrderBy() . " "
			. $this->getLimit();

		$value = $this->sql->get_var($sql);
		$this->clearWhere();

		return $value;
	}

	public function setGroupBy($group)
	{
		//return $this->sql->setGroupBy($group);
		$this->_groupBy = !empty($group) ?  "GROUP BY " . $group : "";
	}

	public function setWhere($where)
	{
		$this->_where = $where;
		//return $this->sql->setWhere($group);
	}

	public function query($group)
	{
		return $this->sql->query($group);
	}


}
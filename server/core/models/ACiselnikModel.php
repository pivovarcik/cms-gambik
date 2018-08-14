<?php

/**
 * Obecnı pøedek pro èíselníkové entity
 *
 * @version $Id$
 * @copyright 2011
 */

abstract class ACiselnikModel extends G_Service{

	function __construct($TEntity)
	{
		parent::__construct($TEntity);
	//	print $this->name;
	}

	public function getDetailByName($name)
	{
		$params = new ListArgs();
		$params->name = (string) $name;

		$params->page = 1;
		$params->limit = 1;
		return $this->getDetail($params);
	}
	public function getDetailById($id)
	{
		$params = new ListArgs();
		$params->id = (int) $id;

		$params->page = 1;
		$params->limit = 1;
		return $this->getDetail($params);
	}
	private function getDetail($params=array())
	{
		$obj = new stdClass();

		$list = $this->getList($params);

		if (count($list) == 1) {
			return $list[0];
		}
		return false;
	}

	public function getList(IListArgs $params=null)
	{

		//$this->clearWhere();

		if (is_null($params)) {
			$params = new ListArgs();
		}

		$this->addWhere("t1.isDeleted=0");
		if (isset($params->id) && isInt($params->id)) {
			$this->addWhere("t1.id=" . $params->id);
		}

		if(isset($params->parent) && isInt($params->parent))
		{
			$this->addWhere("t1.parent=".$params->parent);
		}

		if(isset($params->name) && !empty($params->name))
		{
			$this->addWhere("t1.name = '" . $params->name . "'");
		}

		if(isset($params->fulltext) && !empty($params->fulltext))
		{
			$this->addWhere("t1.name like '%" . $params->fulltext . "%'");
		}

		$this->setLimit($params->getPage(), $params->getLimit());

		$this->setOrderBy($params->getOrderBy(), 't1.parent ASC, t1.order DESC, t1.name ASC');

		$this->setSelect("t1.*,

	    	concat(
	    	ifnull(t10.name,''),'|',
	    	ifnull(t9.name,''),'|',
	    	ifnull(t8.name,''),'|',
	    	ifnull(t7.name,''),'|',
	    ifnull(t6.name,''),'|',
	    ifnull(t5.name,''),'|',
	    ifnull(t4.name,''),'|',
	    ifnull(t3.name,''),'|',
	    ifnull(t2.name,''),'|',
	    ifnull(t1.name,'')
	    ) as serial_name,
	    concat(
	    	    ifnull(t10.id,''),'|',
	    ifnull(t9.id,''),'|',
	    ifnull(t8.id,''),'|',
	    ifnull(t7.id,''),'|',
	    ifnull(t6.id,''),'|',
	    ifnull(t5.id,''),'|',
	    ifnull(t4.id,''),'|',
	    ifnull(t3.id,''),'|',
	    ifnull(t2.id,''),'|',
	    ifnull(t1.id,'')
	    ) as serial_id,t2.name as parent_name
");
		$this->setFrom($this->getTableName() . " AS t1
		LEFT JOIN " . $this->getTableName() . " AS t2 ON t1.parent = t2.id
		LEFT JOIN " . $this->getTableName() . " AS t3 ON t2.parent = t3.id
		LEFT JOIN " . $this->getTableName() . " AS t4 ON t3.parent = t4.id
		LEFT JOIN " . $this->getTableName() . " AS t5 ON t4.parent = t5.id
		LEFT JOIN " . $this->getTableName() . " AS t6 ON t5.parent = t6.id
		LEFT JOIN " . $this->getTableName() . " AS t7 ON t6.parent = t7.id
		LEFT JOIN " . $this->getTableName() . " AS t8 ON t7.parent = t8.id
		LEFT JOIN " . $this->getTableName() . " AS t9 ON t8.parent = t9.id
		LEFT JOIN " . $this->getTableName() . " AS t10 ON t9.parent = t10.id
");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		$this->total = $this->get_var($query);

		$list = $this->getRows();



		return $list;
	}


	public function levelUp($page_id)
	{
		$page = $this->getDetailById($page_id);

		if ($page) {
			//print_r($page);
			$data = array();
			//print "level:".$page->level;
			$level = (int) $page->order;
			$level = $level + 1;
			$data["order"] = $level;

			$this->updateRecords($this->getTableName(),$data ,"id={$page_id}");
			return $level;
		}

	}
	public function levelDown($page_id)
	{
		$page = $this->getDetailById($page_id);

		if ($page) {
			$data = array();
			$data["order"] = $page->level-1;

			$this->updateRecords($this->getTableName(),$data ,"id={$page_id}");
			return $data["order"];
		}
	}
}
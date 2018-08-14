<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_SmsGate extends G_Service{

	function __construct()
	{
		parent::__construct(T_SMS);
	}

	public function getPrichoziSmsList($params = array())
	{

		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		//print $limit;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'], 't1.TimeStamp DESC');

		$this->setSelect("t1.*");

		$this->setFrom($this->getTablename() . " t1");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();

		//print $query;
		$this->total = $this->get_var($query);

		$list = $this->getRows();
		return $list;

	}
	public function getPrichoziSms($id)
	{

		$this->setSelect("t1.*");
		$this->setFrom($this->getTablename(). " t1");
		$this->addWhere("t1.id=" . $id);
		//$this->setOrderBy("t1.caszapsani desc");
		$sql = "select " . $this->getSelect() . " from " . $this->getFrom() . " " . $this->getWhere();
		//print $sql;
		$row = $this->get_row($sql);
		return $row;
	}
	public function getOdchoziSmsList($params = array())
	{
/*
		$this->setSelect("t1.*");
		$this->setFrom("mm_odchozi_sms t1");
		//$this->setOrderBy("t1.caszapsani desc");
		$sql = $this->getSelect() . " " . $this->getFrom() . " order by t1.caszapsani desc";
		//print $sql;
		$list = $this->get_results($sql);
		return $list;
		*/
		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		//print $limit;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'], 't1.TimeStamp DESC');

		$this->setSelect("t1.*");

		$this->setFrom("mm_odchozi_sms t1");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();

		//print $query;
		$this->total = $this->get_var($query);

		$list = $this->getRows();
		return $list;

	}
	public function log_sms($number, $message, $price = 1)
	{
		$data = array();
		$data["TimeStamp"] = date('Y-m-d H:i:s');
		$data["phone"] 	= $number;
		$data["message"] 	= $message;
		$data["price"] 	= $price;
		$this->insertRecords($this->getTableName(), $data);
	}


	public function getList(IListArgs $params=null)
	{
		$this->clearWhere();
		if (is_null($params)) {
			$params = new ListArgs();
		}

		if (isset($params->id) && isInt($params->id)) {
			$this->addWhere("t1.id = " . $params->id);
		}

		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getOrderBy(), 't1.TimeStamp DESC');

		$this->setSelect("t1.*");
		$this->setFrom($this->getTablename() . " AS t1");


		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();

		//print $query;
		$this->total = $this->get_var($query);

		$list = $this->getRows();
		return $list;



	}

}
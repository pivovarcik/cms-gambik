<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_Sms extends G_Service{

	function __construct()
	{
		parent::__construct(T_SMS);
	}

	public function getPrichoziSmsList($params = array())
	{
/*
		$this->setSelect("t1.*");
		$this->setFrom($this->getTablename(). " t1");
		//$this->setOrderBy("t1.caszapsani desc");
		$sql = $this->getSelect() . " from " . $this->getFrom() . " order by t1.caszapsani desc";
			print $sql;
		$list = $this->get_results($sql);
		return $list;
		*/
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
}
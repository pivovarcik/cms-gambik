<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_HeurekaReport extends G_Service{

	function __construct()
	{
		parent::__construct(T_HEUREKA_REPORT);
	}

	public $total = 0;
	public function getDetailByOrder($order_code)
	{
		$params = array();
		$params["order_code"] = $order_code;

		$params['page'] = 1;
		$params['limit'] = 1;

		//print_r($params);
		return $this->getDetail($params);
	}
	public function getDetailById($id)
	{
		$params = array();
		$params["id"] = (int) $id;

		$params['page'] = 1;
		$params['limit'] = 1;

		//print_r($params);
		return $this->getDetail($params);
	}

	private function getDetail($params=array())
	{
		$entita = new HeurekaReportEntity();

		$list = $this->getList($params);
		//print_r($list);
		if (count($list) > 0) {
			$entita->naplnEntitu($list[0]);
		}
		return $entita->vratEntitu();
	}

	public function getList($params=array())
	{


		$this->clearWhere();
		if (isset($params['rating_id']) && is_numeric($params['rating_id'])) {
			$basket_id = (int) $params['rating_id'];
			$this->addWhere("t1.rating_id = " . $basket_id);
		}
		if (isset($params['id']) && is_numeric($params['id'])) {
			$basket_id = (int) $params['id'];
			$this->addWhere("t1.id = " . $basket_id);
		}

		if (isset($params['order_code']) && !empty($params['order_code'])) {
			$basket_id = $params['order_code'];
			$this->addWhere("t1.id = '" . $basket_id . "'");
		}

		if(isset($params['isDeleted']) && is_numeric($params['isDeleted']))
		{
			$this->addWhere("t1.isDeleted=" . $params['isDeleted']);
		} else {
			$this->addWhere("t1.isDeleted=0");
		}
		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;

		//	print "limit:" . $limit;
		$this->setLimit($page, $limit);
		$this->setOrderBy('t1.TimeStamp ASC');

		$this->setSelect("t1.*");


		$this->setFrom($this->getTableName() . " AS t1");
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
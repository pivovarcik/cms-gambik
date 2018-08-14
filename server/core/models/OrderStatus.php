<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_OrderStatus extends G_Service{

	function __construct()
	{
		parent::__construct(T_ORDER_STATUS);
	}
	public $total = 0;

	public function getList($params=array())
	{

		$limit = (int) isset($params['limit']) ? $params['limit'] : 1000;
		$page = (int) isset($params['page']) ? $params['page'] : 1;

		//	print "limit:" . $limit;
		$this->setLimit($page, $limit);
		$this->setOrderBy('t1.order DESC,t1.name ASC');

		$this->setSelect("t1.*");
		$this->setFrom(T_ORDER_STATUS . " AS t1");

		$list = $this->getRows();
		$this->total = count($list);
		return $list;

	}

}
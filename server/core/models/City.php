<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_City extends G_Service{

	function __construct()
	{
		parent::__construct(T_MESTA);
	}

	public $total = 0;

	public function getList($params=array())
	{

		$znak = "cs";

		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;

	//	print "limit:" . $limit;
		$this->setLimit($page, $limit);
		$this->setOrderBy('t1.poradi ASC');

		$this->setSelect("t1.*");
		$this->setFrom(T_SHOP_ZPUSOB_DOPRAVY . " AS t1");

		$list = $this->getRows();
		$this->total = count($list);
		return $list;

	}

}
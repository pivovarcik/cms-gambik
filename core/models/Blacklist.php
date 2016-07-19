<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_Blacklist extends G_Service{

	function __construct()
	{
		parent::__construct(T_BLACKLISTIP);
	}

	public $total = 0;

	public function getList($params=array())
	{



		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;

	//	print "limit:" . $limit;
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'], 't1.TimeStamp ASC');

		$this->setSelect("t1.*");
		$this->setFrom($this->getTablename() . " AS t1");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		$this->total = $this->get_var($query);

		$list = $this->getRows();

		return $list;

	}

}
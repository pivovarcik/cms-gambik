<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_Ceniky extends G_Service{

	function __construct()
	{
		parent::__construct(T_CENIKY);
	}
	public function getList($params=array())
	{

		//$addWhere();
		//$this->where = "";
		$this->setLimit($params['page'], $params['limit']);
		$this->setOrderBy($params['order'], 't1.oznaceni ASC');

		$this->setSelect("t1.*");
		$this->setFrom(T_CENIKY . " AS t1");

		$list = $this->getRows();

		return $list;

	}
}
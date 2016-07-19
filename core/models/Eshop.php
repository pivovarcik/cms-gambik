<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_Eshop extends G_Service{

	function __construct()
	{
		parent::__construct(T_SHOP_SETTINGS);
	}
	public function getList($params=array())
	{

		//$addWhere();
		//$this->where = "";
		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'], 't1.mj ASC');

		$this->setSelect("t1.*");
		$this->setFrom(T_MJ . " AS t1");

		$list = $this->getRows();

		return $list;

	}

	public function getSettingsList()
	{
		$sql = "SELECT * FROM " . T_SHOP_SETTINGS;
		return $this->get_results($sql);

	}
}
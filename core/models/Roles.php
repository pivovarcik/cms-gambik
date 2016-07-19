<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_Roles extends G_Service{

	function __construct()
	{
		parent::__construct(T_ROLES);
	}
	public $total = 0;

	public function getDetailById($id)
	{
		$params = new ListArgs();
		$params->id = (int) $id;

		//$params['status'] = 1;
		$list = $this->getList($params);
		if (count($list) > 0) {
			return $list[0];
		}
		return false;
	}
	public function getList(IListArgs $params=null)
	{
		if (is_null($params)) {
			$params = new ListArgs();
		}
		$this->clearWhere();

		$this->setLimit($params->getPage(), $params->getLimit());

		if(isset($params->id) && isInt($params->id))
		{
			$this->addWhere("t1.id=".$params->id);
		}

		$this->setSelect("t1.*");
		$this->setFrom($this->getTableName() . " as t1");
		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);

		$list = $this->getRows();

		for ($i=0;$i < count($list);$i++)
		{
			//$list[$i]->link = $list[$i]->url;
			$list[$i]->link_edit = "role_detail?id=" . $list[$i]->id;

		}
		return $list;

	}

}
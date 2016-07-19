<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_Comments extends G_Service{

	function __construct()
	{
		parent::__construct(T_COMMENTS);
	}



	public function getDetailById($id)
	{
		$params = new ListArgs();
		$params->id = (int) $id;
		$params->page = 1;
		$params->limit = 1;

		$list = $this->getList($params);
		//print_r($list);
		if (count($list) > 0) {
			return $list[0];
		}

		return false;
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

		if (isset($params->category_id) && isInt($params->category_id)) {
			$this->addWhere("t1.parent_id = " . $params->category_id);
		}

		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getOrderBy(),'t1.TimeStamp DESC');
		$this->addWhere('t1.isDeleted=0');
		$this->setSelect("t1.*,
	t3.nick AS regnick,t3.sex,t3.prihlasen,UNIX_TIMESTAMP(t3.naposledy) as casnaposledy");
		$this->setFrom($this->getTablename() . " AS t1
		LEFT JOIN " . T_USERS . " t3 ON (t1.user_id = t3.id)
		");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();

		$this->total = $this->get_var($query);
		$list = $this->getRows();
		return $list;

	}

}
<?php

class models_FilterView extends G_Service{

	function __construct()
	{
		parent::__construct(T_FILTERVIEW);
	}

	public $total = 0;

	public function getDetailById($id)
	{
		$params = new ListArgs();
		$params->id = (int) $id;
		//	$params['lang'] = $lang;
		$params->page = 1;
		$params->limit = 1;

		$obj = new stdClass();

		$list = $this->getList($params);

		if (count($list) == 1) {
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

		if (isset($params->modelName) && !empty($params->modelName)) {
			$this->addWhere("t1.modelname = '" . $params->modelName . "'");
		}


		if (isset($params->user_id) && isInt($params->user_id)) {
			$this->addWhere("t1.user_id is null or t1.user_id = " . $params->user_id);
		}


		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getOrderBy(),'t1.selected DESC, t1.isDefault DESC');

		$this->setSelect("t1.*");
		$this->setFrom($this->getTablename() . " AS t1");


		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();

		$this->total = $this->get_var($query);



		$list = $this->getRows();
		//print $this->last_query;
		return $list;

	}

}
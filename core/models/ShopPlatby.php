<?php

class models_ShopPlatby extends G_Service{

	function __construct()
	{
		parent::__construct(T_SHOP_PLATBY);
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

		$this->setFrom($this->getTableName() . " AS t1");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);

		$list = $this->getRows();

		for ($i=0;$i < count($list);$i++)
		{
			//	$list[$i]->link_edit = '/admin/edit_attrib.php?id='.$list[$i]->id;
		}
		return $list;
	}



}
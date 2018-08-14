<?php

require_once("ACiselnikModel.php");
class models_Kurz extends ACiselnikModel{

	public $formNameEdit = "KurzEdit";
	function __construct()
	{
		parent::__construct(T_KURZY);
	}


	public function getList(IListArgs $params = null)
	{

		if(isset($params->date_presne) && !empty($params->date_presne))
		{
			$this->addWhere("t1.datum=".$params->date_presne . "");

		}
		if(isset($params->date) && !empty($params->date))
		{
			//$this->addWhere("t1.datum>=".$params->date . "");


			$this->addWhere("t1.id in (select k1.id from ea_kurzy k1 inner join (SELECT max(t1.datum) datum,t1.kod
 FROM ea_kurzy AS t1
  WHERE (t1.datum<=".$params->date . ") AND(t1.isDeleted=0) GROUP BY t1.kod) k2 on k1.datum=k2.datum and k1.kod=k2.kod)");

			//$params->setOrderBy("t1.datum desc");
			//$this->setGroupBy("t1.kod,t1.datum");
		}

		if(isset($params->kod) && !empty($params->kod))
		{
			$this->addWhere("t1.kod='".$params->kod . "'");
		}

		$list = parent::getList($params);

	//	print $this->getLastQuery();
		for ($i=0;$i < count($list);$i++)
		{
			//$list[$i]->link_edit = '/admin/kurz_edit?id='.$list[$i]->id;
			$list[$i]->link_edit = '/admin/options/kurzy?do=edit&id='.$list[$i]->id;
		}
		return $list;
	}
}

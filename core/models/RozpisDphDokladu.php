<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

abstract class models_RozpisDphDokladu extends G_Service{

	function __construct($table)
	{
		parent::__construct($table);
	}



	public function getList(IListArgs $args=null)
	{


		if (is_null($args)) {
			$args = new ListArgs();
		}
		$this->clearWhere();
		$this->setLimit($args->getPage(), $args->getLimit());


		if(isset($args->isDeleted) && isInt($args->isDeleted))
		{
			$this->addWhere("p.isDeleted=" . $args->isDeleted);
		} else {
			$this->addWhere("p.isDeleted=0");
		}


		if(isset($args->doklad_id) && isInt($args->doklad_id))
		{
			$this->addWhere("p.doklad_id=" . $args->doklad_id);
		}

		$this->setOrderBy('dph.name ASC');

		$this->setSelect("p.*,dph.name,dph.value as sazba");

	//	$ProductVersionEntity = new ProductVersionEntity();

		$this->setFrom($this->getTableName() . " AS p
LEFT JOIN " . T_DPH . " AS dph ON p.tax_id = dph.id");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();
	//	print $this->getLastQuery();
		for ($i=0;$i < count($list);$i++)
		{
			$list[$i]->zaklad_dph_label = numberFormat($list[$i]->zaklad_dph);
			$list[$i]->vyse_dph_label = numberFormat($list[$i]->vyse_dph);
		}
		return $list;

	}

}
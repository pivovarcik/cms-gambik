<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
//define("T_ULICE","ulice");
class models_Svatky extends G_Service{

	function __construct()
	{
		parent::__construct(T_SVATKY);
	}
	public $total = 0;

	public function getList(IListArgs $params = null)
	{

		if (isset($params->den) && isInt($params->den)) {
			$this->addWhere("t1.dd =" . $params->den . "");
		}
    
    if (isset($params->mesic) && isInt($params->mesic)) {
			$this->addWhere("t1.mm =" . $params->mesic . "");
		}
    
		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getOrderBy(),'t1.mm ASC,t1.dd ASC');

		//print $this->getOrderBy();
		$this->setSelect("t1.*");

		$this->setFrom($this->getTableName() . " AS t1");
		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();
		//return $list;

		return $list;

	}


	public function getSvatek($den,$mesic)
	{

    $args = new ListArgs();
    $args->den = $den;
    $args->mesic = $mesic;
    
		$list = $this->getList($args);

    if (count($list) == 1)
    {
       return $list[0];
    }
      return false;
    //print_r($list);

	}

}
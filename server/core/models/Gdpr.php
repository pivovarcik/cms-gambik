<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_Gdpr extends G_Service{

	function __construct()
	{
		parent::__construct(T_GDPR);
	}


	public $total = 0;

	public function getDetailById($id,$lang=null)
	{
		$params = new ListArgs();
		$params->page_id = (int) $id;
		//	$params['lang'] = $lang;
		if ($lang != null) {
			$params->lang = $lang;
		}


		$params->page = 1;
		$params->limit = 1000;

		//print_r($params);
		return $this->getDetail($params);
	}

	private function getDetail(IListArgs $params)
	{
	


		if (count($list) == 1) {
			return $list[0];
		}
		return false;
	}


	public function getList(IListArgs $params= null)
	{
		$this->clearWhere();
		if (is_null($params)) {
			$params = new ListArgs();
		}

		$this->addWhere("p.isDeleted=0");
		if (isset($params->id) && isInt($params->id)) {
			$this->addWhere("p.id=" . $params->id);
		}

    if (isset($params->aktivni) && isInt($params->aktivni)) {
			$this->addWhere("p.aktivni=" . $params->aktivni);
		}




		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getOrderBy(), 'p.TimeStamp DESC');

		$this->setSelect("p.*");
		$this->setFrom($this->getTablename() . " AS p
		");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();


      		$this->total = $this->get_var($query);

		$list = $this->getRows();
	//	print $this->getLastQuery();
		return $list;

	}

}
<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_Protokol extends G_Service{

	function __construct()
	{
		parent::__construct(T_PROTOKOL);
	}

	public function getList($params=array())
	{



		$this->setLimit($params['page'], $params['limit']);


		if (isset($params['user']) && is_numeric($params['user'])) {
			$this->addWhere("t1.user_id=" . $params['user']);
		}

		if (isset($params['fulltext']) && !empty($params['fulltext'])) {
			$this->addWhere("t1.protokol like '%" . $params['fulltext'] . "%' ");
		}

		if (isset($params["date_from"]) && !empty($params["date_from"])) {
			//	$comapany = " AND company=". $params["company"];
			$this->addWhere("t1.TimeStamp>='". $params["date_from"]."'");
		}
		if (isset($params["date_to"]) && !empty($params["date_to"])) {
			//	$comapany = " AND company=". $params["company"];
			$this->addWhere("t1.TimeStamp<='". $params["date_to"]."'");
		}

		/*
		//	$this->setOrderBy($params['order'], 't1.cislo_mat ASC');
		if (isset($params['id']) && is_numeric($params['id'])) {
			$this->addWhere("t1.uid_faktury='" . $params['id'] . "' ");
		}
		if (isset($params['uid_zadanky']) && is_numeric($params['uid_zadanky'])) {
			$this->addWhere("t1.uid_zadanky='" . $params['uid_zadanky'] . "' ");
		}

		if (isset($params['company']) && is_numeric($params['company'])) {
			$this->addWhere("t2.company=" . $params['company']);
		}

		if (isset($params['zadatel']) && is_numeric($params['zadatel'])) {
			$this->addWhere("t2.uid_komu=" . $params['zadatel']);
		}
		if (isset($params["stredisko"]) && !empty($params["stredisko"])) {
			//	$comapany = " AND company=". $params["company"];
			$this->addWhere("t2.stredisko='". $params["stredisko"]."'");
		}
		if (isset($params["stav"]) && !empty($params["stav"])) {
			//	$comapany = " AND company=". $params["company"];
			$this->addWhere("t1.stav=". $params["stav"]);
		}
		if (isset($params["date_from"]) && !empty($params["date_from"])) {
			//	$comapany = " AND company=". $params["company"];
			$this->addWhere("t1.caszapsani>='". $params["date_from"]."'");
		}
		if (isset($params["date_to"]) && !empty($params["date_to"])) {
			//	$comapany = " AND company=". $params["company"];
			$this->addWhere("t1.caszapsani<='". $params["date_to"]."'");
		}
		*/
		//print $params['order'];
		if (isset($params['order']) && !empty($params['order'])) {
			$this->setOrderBy($params['order'] . " ");
		}
		$this->setSelect("t1.*,t2.nick");
		$this->setFrom($this->getTableName() . " AS t1 left join " . T_USERS . " t2 on t1.user_id = t2.id");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();
		return $list;

	}

}
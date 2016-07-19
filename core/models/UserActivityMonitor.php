<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_UserActivityMonitor extends G_Service{

	function __construct()
	{
		parent::__construct(T_USER_ACTIVITY_MONITOR);
	}

	public function getDetailById($id)
	{
		return $this->getUser("t1.id=" . $id);
	}
	private function getDetail($where)
	{
		$sql = "SELECT UNIX_TIMESTAMP(t1.naposledy) as casnaposledy,f.file,
                 t1.*,
                 t2.p1 as role_p1,
				 t2.p2 as role_p2,
				 t2.p3 as role_p3,
				 t2.p4 as role_p4,
				 t2.p5 as role_p5,
				 t2.p6 as role_p6,
				 t2.p7 as role_p7,
				 t2.p8 as role_p8,
				 t2.p9 as role_p9,
				 t2.p10 as role_p10
				 FROM " . $this->getTablename() . " t1
				 left join " . T_ROLES . " as t2 on t1.role=t2.id
				 left join " . T_FOTO . " as f on t1.foto_id=f.id
				WHERE " . $where . " LIMIT 1";
		//print $sql;
		$obj = $this->get_row($sql);
		//print_r($obj);
		//var_dump($obj);
		return $obj;
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

		if(isset($params->aktivni) && isInt($params->aktivni))
		{
			$this->addWhere("t1.aktivni=".$params->aktivni);
		}

		if(isset($params->aktivni_od) && !empty($params->aktivni_od))
		{
			$this->addWhere("t1.naposledy >= '".$params->aktivni_od . "'");
		}

		if(isset($params->aktivni_do) && !empty($params->aktivni_do))
		{
			$this->addWhere("t1.naposledy <= '".$params->aktivni_do . "'");
		}

		if(isset($params->novy_od) && !empty($params->novy_od))
		{
			$this->addWhere("t1.TimeStamp >= '".$params->novy_od . "'");
		}

		if(isset($params->novy_do) && !empty($params->novy_do))
		{
			$this->addWhere("t1.TimeStamp <= '".$params->novy_do . "'");
		}

		$this->addWhere("t1.isDeleted=0");







		if (!empty($params->fulltext)) {
			$this->addWhere("( " .
			 		"LCASE(t1.nick) like '%" . ltrim(strToLower($params->fulltext))."%'" .
                      " OR LCASE(t1.jmeno) like '%" . ltrim(strToLower($params->fulltext))."%'" .
                      " OR LCASE(t1.prijmeni) like '%" . ltrim(strToLower($params->fulltext))."%'" .
                      " OR LCASE(t2.title) like '%" . ltrim(strToLower($params->fulltext))."%'" .
											" ) ");
		}





		$this->setOrderBy($this->getOrderBy(), 't1.TimeStamp DESC');

		if(isset($params->activity_monitor))
		{
			$this->addWhere("t1.id in (select max(id) from " . $this->getTableName() . " group by ip_adresa )");
		}

		$this->setSelect("t1.*,t2.nick");
		$this->setFrom($this->getTableName() . " as t1
		left join " . T_USERS . " as t2 on t1.user_id=t2.id");
		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		//print $this->getLimit();
		$this->total = $this->get_var($query);

		$list = $this->getRows();

	/*	for ($i=0;$i < count($list);$i++)
		{
			$list[$i]->link_edit = '/admin/user_detail?id=' .$list[$i]->id;
		}*/
		//print $this->last_query;
		return $list;

	}

	public function getStats($params = array())
	{
		$stats = new UserActivityMonitorComposite();


		$this->setLimit(1, 10);
		$this->setSelect("max(t2.nick),");
		$params["select"] = "count(*)  as count,sum(t1.cost_total) as cost_total,t1.stav";

		$this->setGroupBy("t1.ip_adresa");
		$this->setFrom($this->getTableName() . " as t1
		left join " . T_USERS . " as t2 on t1.user_id=t2.id");

		$this->setWhere("t1.id in (select max(id) from " . $this->getTableName() . " group by ip_adresa ");

		$list = $this->getList($params);

		$list2 = array();
		for ($i=0;$i < count($list);$i++)
		{
			$list2[$i]->count = $list[$i]->count;
			$list2[$i]->cost_total = $list[$i]->cost_total;
			$list2[$i]->stav = $list[$i]->stav;


			$count += $list[$i]->count;
			$cost_total += $list[$i]->cost_total;
		}
		$stats->cost_total = $cost_total;
		$stats->count_total = $count;

		return $stats;
		$list2[($i+1)]->cost_total = $cost_total;
		$list2[($i+1)]->count = $count;
		return $list2;
	}

}

class UserActivityMonitorComposite {

	public $cost_total = 0;

	public $count_total = 0;

	public $interval = "month";


}
<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_Mailing extends G_Service{

	function __construct()
	{
		parent::__construct(T_EMAIL);
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


		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getOrderBy(),'t1.TimeStamp DESC');

		$this->setSelect("t1.*,u.nick,adresati.adresat_pocet,adresati.email,adresati.ReadTimeStamp");
		$this->setFrom($this->getTablename() . " AS t1
			left join (select mailing_id,count(*) as adresat_pocet,max(email) as email,ReadTimeStamp from " . T_NEWSLETTER_STATUS ." ms
			group by mailing_id) adresati on adresati.mailing_id = t1.id
			left join " . T_USERS . " u on t1.user_id = u.id");


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
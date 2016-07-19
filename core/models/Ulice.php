<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
define("T_ULICE","ulice");
class models_Ulice extends G_Service{

	function __construct()
	{
		parent::__construct(T_ULICE);
	}
	public $total = 0;

	public function getList($params=array())
	{

		$znak = "cs";

		$limit = (int) isset($params['limit']) ? $params['limit'] : 10000;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		//$this->addWhere("t1.stat<>'' and t1.stat is not null ");
		//	print "limit:" . $limit;

		if (isset($params['bezsouradnic']) && is_numeric($params['bezsouradnic']) && $params['bezsouradnic']== 1) {
			$this->addWhere("(t1.latitude is null or t1.longitude is null) and t1.lastupdated is null");
		}
		if (isset($params['kraj']) && is_numeric($params['kraj']) && $params['kraj']>0) {
			$this->addWhere("t1.okres=" . $params['kraj']);
		}
		if (isset($params['fulltext']) && !empty($params['fulltext'])) {
			$this->addWhere("t1.mesto like '" . $params['fulltext'] . "%'");
		}
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'],'t1.ulice ASC,t1.id ASC');

		//print $this->getOrderBy();
		$this->setSelect("t1.*");
		//	$this->setFrom($this->getTableName() . " AS t1 LEFT JOIN mm_kraje t2 on t1.okres=t2.uid");
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
		/*
		   $list = $this->getRows();
		   $this->total = count($list);
		   return $list;
		*/

	}
	public function get_categoryFromCitylist($params=array())
	{

		$znak = "cs";
		$znak = "cs";
		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR ;
		}
		$limit = (int) isset($params['limit']) ? $params['limit'] : 10000;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		//$this->addWhere("t1.stat<>'' and t1.stat is not null ");
		//	print "limit:" . $limit;

		if (isset($params['city']) && is_numeric($params['city']) && $params['city']>0) {
			$this->addWhere("c.mesto=" . $params['city']);
		}
		$this->addWhere("c.category > 0");

		$this->setLimit($page, $limit);
		$order = isset($params['order']) ? $params['order'] : "";
		$this->setOrderBy($order,'m.nazev_cs');
		$this->setGroupBy('c.category');
		//print $this->getOrderBy();
		//	$this->setSelect("m.*");


		$this->setSelect("m.*,
		concat(
		(case when sql11.nazev_" . $znak . " is null then '' else sql11.nazev_" . $znak . " end),'|',
		(case when sql10.nazev_" . $znak . " is null then '' else sql10.nazev_" . $znak . " end),'|',
		(case when sql9.nazev_" . $znak . " is null then '' else sql9.nazev_" . $znak . " end),'|',
		(case when sql8.nazev_" . $znak . " is null then '' else sql8.nazev_" . $znak . " end),'|',
		(case when sql7.nazev_" . $znak . " is null then '' else sql7.nazev_" . $znak . " end),'|',
		(case when sql6.nazev_" . $znak . " is null then '' else sql6.nazev_" . $znak . " end),'|',
		(case when sql5.nazev_" . $znak . " is null then '' else sql5.nazev_" . $znak . " end),'|',
		(case when sql4.nazev_" . $znak . " is null then '' else sql4.nazev_" . $znak . " end),'|',
		(case when sql3.nazev_" . $znak . " is null then '' else sql3.nazev_" . $znak . " end),'|',
		(case when sql2.nazev_" . $znak . " is null then '' else sql2.nazev_" . $znak . " end),'|',
		m.nazev_" . $znak . "
		) as serial_cat_nazev,
		concat(
		(case when sql11.url_friendly_" . $znak . " is null then '' else sql11.url_friendly_" . $znak . " end),'|',
		(case when sql10.url_friendly_" . $znak . " is null then '' else sql10.url_friendly_" . $znak . " end),'|',
		(case when sql9.url_friendly_" . $znak . " is null then '' else sql9.url_friendly_" . $znak . " end),'|',
		(case when sql8.url_friendly_" . $znak . " is null then '' else sql8.url_friendly_" . $znak . " end),'|',
		(case when sql7.url_friendly_" . $znak . " is null then '' else sql7.url_friendly_" . $znak . " end),'|',
		(case when sql6.url_friendly_" . $znak . " is null then '' else sql6.url_friendly_" . $znak . " end),'|',
		(case when sql5.url_friendly_" . $znak . " is null then '' else sql5.url_friendly_" . $znak . " end),'|',
		(case when sql4.url_friendly_" . $znak . " is null then '' else sql4.url_friendly_" . $znak . " end),'|',
		(case when sql3.url_friendly_" . $znak . " is null then '' else sql3.url_friendly_" . $znak . " end),'|',
		(case when sql2.url_friendly_" . $znak . " is null then '' else sql2.url_friendly_" . $znak . " end),'|',
		m.url_friendly_" . $znak . "
		) as serial_cat_url,
		concat(
		(case when sql11.url_friendly_cs is null then '' else sql11.url_friendly_cs end),'|',
		(case when sql10.url_friendly_cs is null then '' else sql10.url_friendly_cs end),'|',
		(case when sql9.url_friendly_cs is null then '' else sql9.url_friendly_cs end),'|',
		(case when sql8.url_friendly_cs is null then '' else sql8.url_friendly_cs end),'|',
		(case when sql7.url_friendly_cs is null then '' else sql7.url_friendly_cs end),'|',
		(case when sql6.url_friendly_cs is null then '' else sql6.url_friendly_cs end),'|',
		(case when sql5.url_friendly_cs is null then '' else sql5.url_friendly_cs end),'|',
		(case when sql4.url_friendly_cs is null then '' else sql4.url_friendly_cs end),'|',
		(case when sql3.url_friendly_cs is null then '' else sql3.url_friendly_cs end),'|',
		(case when sql2.url_friendly_cs is null then '' else sql2.url_friendly_cs end),'|',
		m.url_friendly_cs
		) as serial_cat_url_cs,
		concat(
		(case when sql11.url_friendly_en is null then '' else sql11.url_friendly_en end),'|',
		(case when sql10.url_friendly_en is null then '' else sql10.url_friendly_en end),'|',
		(case when sql9.url_friendly_en is null then '' else sql9.url_friendly_en end),'|',
		(case when sql8.url_friendly_en is null then '' else sql8.url_friendly_en end),'|',
		(case when sql7.url_friendly_en is null then '' else sql7.url_friendly_en end),'|',
		(case when sql6.url_friendly_en is null then '' else sql6.url_friendly_en end),'|',
		(case when sql5.url_friendly_en is null then '' else sql5.url_friendly_en end),'|',
		(case when sql4.url_friendly_en is null then '' else sql4.url_friendly_en end),'|',
		(case when sql3.url_friendly_en is null then '' else sql3.url_friendly_en end),'|',
		(case when sql2.url_friendly_en is null then '' else sql2.url_friendly_en end),'|',
		m.url_friendly_en
		) as serial_cat_url_en,
		concat(
		(case when sql11.url_friendly_de is null then '' else sql11.url_friendly_de end),'|',
		(case when sql10.url_friendly_de is null then '' else sql10.url_friendly_de end),'|',
		(case when sql9.url_friendly_de is null then '' else sql9.url_friendly_de end),'|',
		(case when sql8.url_friendly_de is null then '' else sql8.url_friendly_de end),'|',
		(case when sql7.url_friendly_de is null then '' else sql7.url_friendly_de end),'|',
		(case when sql6.url_friendly_de is null then '' else sql6.url_friendly_de end),'|',
		(case when sql5.url_friendly_de is null then '' else sql5.url_friendly_de end),'|',
		(case when sql4.url_friendly_de is null then '' else sql4.url_friendly_de end),'|',
		(case when sql3.url_friendly_de is null then '' else sql3.url_friendly_de end),'|',
		(case when sql2.url_friendly_de is null then '' else sql2.url_friendly_de end),'|',
		m.url_friendly_de
		) as serial_cat_url_de,
		concat(
		(case when sql11.url_friendly_ru is null then '' else sql11.url_friendly_ru end),'|',
		(case when sql10.url_friendly_ru is null then '' else sql10.url_friendly_ru end),'|',
		(case when sql9.url_friendly_ru is null then '' else sql9.url_friendly_ru end),'|',
		(case when sql8.url_friendly_ru is null then '' else sql8.url_friendly_ru end),'|',
		(case when sql7.url_friendly_ru is null then '' else sql7.url_friendly_ru end),'|',
		(case when sql6.url_friendly_ru is null then '' else sql6.url_friendly_ru end),'|',
		(case when sql5.url_friendly_ru is null then '' else sql5.url_friendly_ru end),'|',
		(case when sql4.url_friendly_ru is null then '' else sql4.url_friendly_ru end),'|',
		(case when sql3.url_friendly_ru is null then '' else sql3.url_friendly_ru end),'|',
		(case when sql2.url_friendly_ru is null then '' else sql2.url_friendly_ru end),'|',
		m.url_friendly_ru
		) as serial_cat_url_ru,
		concat(
		(case when sql11.uid is null then '' else sql11.uid end),'|',
		(case when sql10.uid is null then '' else sql10.uid end),'|',
		(case when sql9.uid is null then '' else sql9.uid end),'|',
		(case when sql8.uid is null then '' else sql8.uid end),'|',
		(case when sql7.uid is null then '' else sql7.uid end),'|',
		(case when sql6.uid is null then '' else sql6.uid end),'|',
		(case when sql5.uid is null then '' else sql5.uid end),'|',
		(case when sql4.uid is null then '' else sql4.uid end),'|',
		(case when sql3.uid is null then '' else sql3.uid end),'|',
		(case when sql2.uid is null then '' else sql2.uid end),'|',
			m.uid
			) as serial_cat_id");

		//	$this->setFrom("`mm_catalog` c LEFT JOIN " . T_CATEGORY . " m on c.CATEGORY=m.uid");

		$this->setFrom("`mm_catalog` c
						LEFT JOIN " . T_CATEGORY . " m on c.CATEGORY=m.uid
						LEFT JOIN " . T_CATEGORY . " sql2 on m.parent_uid=sql2.uid
						left join " . T_CATEGORY . " sql3 on sql2.parent_uid=sql3.uid
						left join " . T_CATEGORY . " sql4 on sql3.parent_uid=sql4.uid
						left join " . T_CATEGORY . " sql5 on sql4.parent_uid=sql5.uid
						left join " . T_CATEGORY . " sql6 on sql5.parent_uid=sql6.uid
						left join " . T_CATEGORY . " sql7 on sql6.parent_uid=sql7.uid
						left join " . T_CATEGORY . " sql8 on sql7.parent_uid=sql8.uid
						left join " . T_CATEGORY . " sql9 on sql8.parent_uid=sql9.uid
						left join " . T_CATEGORY . " sql10 on sql9.parent_uid=sql10.uid
						left join " . T_CATEGORY . " sql11 on sql10.parent_uid=sql11.uid");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//	print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();
		//return $list;

		return $list;
		/*
		   $list = $this->getRows();
		   $this->total = count($list);
		   return $list;
		*/

	}
	public function get_categoryFromKrajlist($params=array())
	{

		$znak = "cs";
		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR ;
		}
		$limit = (int) isset($params['limit']) ? $params['limit'] : 10000;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		//$this->addWhere("t1.stat<>'' and t1.stat is not null ");
		//	print "limit:" . $limit;

		if (isset($params['kr']) && is_numeric($params['kr']) && $params['kr']>0) {
			$this->addWhere("k.okres=" . $params['kr']);
		}
		$this->addWhere("k.okres is not null");
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'],'m.nazev_cs');
		$this->setGroupBy('c.category');
		//print $this->getOrderBy();



		//	$this->setSelect("m.*");
		/*			*/
		$this->setSelect("m.*,
		concat(
		(case when sql11.nazev_" . $znak . " is null then '' else sql11.nazev_" . $znak . " end),'|',
		(case when sql10.nazev_" . $znak . " is null then '' else sql10.nazev_" . $znak . " end),'|',
		(case when sql9.nazev_" . $znak . " is null then '' else sql9.nazev_" . $znak . " end),'|',
		(case when sql8.nazev_" . $znak . " is null then '' else sql8.nazev_" . $znak . " end),'|',
		(case when sql7.nazev_" . $znak . " is null then '' else sql7.nazev_" . $znak . " end),'|',
		(case when sql6.nazev_" . $znak . " is null then '' else sql6.nazev_" . $znak . " end),'|',
		(case when sql5.nazev_" . $znak . " is null then '' else sql5.nazev_" . $znak . " end),'|',
		(case when sql4.nazev_" . $znak . " is null then '' else sql4.nazev_" . $znak . " end),'|',
		(case when sql3.nazev_" . $znak . " is null then '' else sql3.nazev_" . $znak . " end),'|',
		(case when sql2.nazev_" . $znak . " is null then '' else sql2.nazev_" . $znak . " end),'|',
		m.nazev_" . $znak . "
		) as serial_cat_nazev,
		concat(
		(case when sql11.url_friendly_" . $znak . " is null then '' else sql11.url_friendly_" . $znak . " end),'|',
		(case when sql10.url_friendly_" . $znak . " is null then '' else sql10.url_friendly_" . $znak . " end),'|',
		(case when sql9.url_friendly_" . $znak . " is null then '' else sql9.url_friendly_" . $znak . " end),'|',
		(case when sql8.url_friendly_" . $znak . " is null then '' else sql8.url_friendly_" . $znak . " end),'|',
		(case when sql7.url_friendly_" . $znak . " is null then '' else sql7.url_friendly_" . $znak . " end),'|',
		(case when sql6.url_friendly_" . $znak . " is null then '' else sql6.url_friendly_" . $znak . " end),'|',
		(case when sql5.url_friendly_" . $znak . " is null then '' else sql5.url_friendly_" . $znak . " end),'|',
		(case when sql4.url_friendly_" . $znak . " is null then '' else sql4.url_friendly_" . $znak . " end),'|',
		(case when sql3.url_friendly_" . $znak . " is null then '' else sql3.url_friendly_" . $znak . " end),'|',
		(case when sql2.url_friendly_" . $znak . " is null then '' else sql2.url_friendly_" . $znak . " end),'|',
		m.url_friendly_" . $znak . "
		) as serial_cat_url,
		concat(
		(case when sql11.url_friendly_cs is null then '' else sql11.url_friendly_cs end),'|',
		(case when sql10.url_friendly_cs is null then '' else sql10.url_friendly_cs end),'|',
		(case when sql9.url_friendly_cs is null then '' else sql9.url_friendly_cs end),'|',
		(case when sql8.url_friendly_cs is null then '' else sql8.url_friendly_cs end),'|',
		(case when sql7.url_friendly_cs is null then '' else sql7.url_friendly_cs end),'|',
		(case when sql6.url_friendly_cs is null then '' else sql6.url_friendly_cs end),'|',
		(case when sql5.url_friendly_cs is null then '' else sql5.url_friendly_cs end),'|',
		(case when sql4.url_friendly_cs is null then '' else sql4.url_friendly_cs end),'|',
		(case when sql3.url_friendly_cs is null then '' else sql3.url_friendly_cs end),'|',
		(case when sql2.url_friendly_cs is null then '' else sql2.url_friendly_cs end),'|',
		m.url_friendly_cs
		) as serial_cat_url_cs,
		concat(
		(case when sql11.url_friendly_en is null then '' else sql11.url_friendly_en end),'|',
		(case when sql10.url_friendly_en is null then '' else sql10.url_friendly_en end),'|',
		(case when sql9.url_friendly_en is null then '' else sql9.url_friendly_en end),'|',
		(case when sql8.url_friendly_en is null then '' else sql8.url_friendly_en end),'|',
		(case when sql7.url_friendly_en is null then '' else sql7.url_friendly_en end),'|',
		(case when sql6.url_friendly_en is null then '' else sql6.url_friendly_en end),'|',
		(case when sql5.url_friendly_en is null then '' else sql5.url_friendly_en end),'|',
		(case when sql4.url_friendly_en is null then '' else sql4.url_friendly_en end),'|',
		(case when sql3.url_friendly_en is null then '' else sql3.url_friendly_en end),'|',
		(case when sql2.url_friendly_en is null then '' else sql2.url_friendly_en end),'|',
		m.url_friendly_en
		) as serial_cat_url_en,
		concat(
		(case when sql11.url_friendly_de is null then '' else sql11.url_friendly_de end),'|',
		(case when sql10.url_friendly_de is null then '' else sql10.url_friendly_de end),'|',
		(case when sql9.url_friendly_de is null then '' else sql9.url_friendly_de end),'|',
		(case when sql8.url_friendly_de is null then '' else sql8.url_friendly_de end),'|',
		(case when sql7.url_friendly_de is null then '' else sql7.url_friendly_de end),'|',
		(case when sql6.url_friendly_de is null then '' else sql6.url_friendly_de end),'|',
		(case when sql5.url_friendly_de is null then '' else sql5.url_friendly_de end),'|',
		(case when sql4.url_friendly_de is null then '' else sql4.url_friendly_de end),'|',
		(case when sql3.url_friendly_de is null then '' else sql3.url_friendly_de end),'|',
		(case when sql2.url_friendly_de is null then '' else sql2.url_friendly_de end),'|',
		m.url_friendly_de
		) as serial_cat_url_de,
		concat(
		(case when sql11.url_friendly_ru is null then '' else sql11.url_friendly_ru end),'|',
		(case when sql10.url_friendly_ru is null then '' else sql10.url_friendly_ru end),'|',
		(case when sql9.url_friendly_ru is null then '' else sql9.url_friendly_ru end),'|',
		(case when sql8.url_friendly_ru is null then '' else sql8.url_friendly_ru end),'|',
		(case when sql7.url_friendly_ru is null then '' else sql7.url_friendly_ru end),'|',
		(case when sql6.url_friendly_ru is null then '' else sql6.url_friendly_ru end),'|',
		(case when sql5.url_friendly_ru is null then '' else sql5.url_friendly_ru end),'|',
		(case when sql4.url_friendly_ru is null then '' else sql4.url_friendly_ru end),'|',
		(case when sql3.url_friendly_ru is null then '' else sql3.url_friendly_ru end),'|',
		(case when sql2.url_friendly_ru is null then '' else sql2.url_friendly_ru end),'|',
		m.url_friendly_ru
		) as serial_cat_url_ru,
		concat(
		(case when sql11.uid is null then '' else sql11.uid end),'|',
		(case when sql10.uid is null then '' else sql10.uid end),'|',
		(case when sql9.uid is null then '' else sql9.uid end),'|',
		(case when sql8.uid is null then '' else sql8.uid end),'|',
		(case when sql7.uid is null then '' else sql7.uid end),'|',
		(case when sql6.uid is null then '' else sql6.uid end),'|',
		(case when sql5.uid is null then '' else sql5.uid end),'|',
		(case when sql4.uid is null then '' else sql4.uid end),'|',
		(case when sql3.uid is null then '' else sql3.uid end),'|',
		(case when sql2.uid is null then '' else sql2.uid end),'|',
			m.uid
			) as serial_cat_id");

		/*
		   $this->setFrom("`mm_catalog` c LEFT JOIN " . T_MESTA . " k on k.uid=c.mesto
		   LEFT JOIN " . T_CATEGORY . " m on c.CATEGORY=m.uid");
		*/
		$this->setFrom("`mm_catalog` c LEFT JOIN " . T_MESTA . " k on k.uid=c.mesto
						LEFT JOIN " . T_CATEGORY . " m on c.CATEGORY=m.uid
						LEFT JOIN " . T_CATEGORY . " sql2 on m.parent_uid=sql2.uid
						left join " . T_CATEGORY . " sql3 on sql2.parent_uid=sql3.uid
						left join " . T_CATEGORY . " sql4 on sql3.parent_uid=sql4.uid
						left join " . T_CATEGORY . " sql5 on sql4.parent_uid=sql5.uid
						left join " . T_CATEGORY . " sql6 on sql5.parent_uid=sql6.uid
						left join " . T_CATEGORY . " sql7 on sql6.parent_uid=sql7.uid
						left join " . T_CATEGORY . " sql8 on sql7.parent_uid=sql8.uid
						left join " . T_CATEGORY . " sql9 on sql8.parent_uid=sql9.uid
						left join " . T_CATEGORY . " sql10 on sql9.parent_uid=sql10.uid
						left join " . T_CATEGORY . " sql11 on sql10.parent_uid=sql11.uid");



		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//	print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();
		//return $list;

		return $list;
		/*
		   $list = $this->getRows();
		   $this->total = count($list);
		   return $list;
		*/

	}
	public function get_mestaCaloglist($params=array())
	{

		$znak = "cs";

		$limit = (int) isset($params['limit']) ? $params['limit'] : 10000;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		//$this->addWhere("t1.stat<>'' and t1.stat is not null ");
		//	print "limit:" . $limit;

		if (isset($params['kraj']) && is_numeric($params['kraj']) && $params['kraj']>0) {
			$this->addWhere("m.okres=" . $params['kraj']);
		}
		$this->addWhere("m.okres is not null");

		$this->setLimit($page, $limit);
		$order = isset($params['order']) ? $params['order'] : "";
		$this->setOrderBy($order,'c.mesto');
		$this->setGroupBy('c.mesto');
		//print $this->getOrderBy();
		$this->setSelect("m.*,o.kraj");
		$this->setFrom(" `mm_catalog` c LEFT JOIN " . $this->getTableName() . " m on c.mesto=m.uid LEFT JOIN mm_kraje o on m.okres=o.uid");



		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();
		//return $list;

		return $list;
		/*
		   $list = $this->getRows();
		   $this->total = count($list);
		   return $list;
		*/

	}
	public function get_krajeList($params=array())
	{

		$znak = "cs";

		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		//$this->addWhere("t1.stat<>''");
		//	print "limit:" . $limit;
		$this->setLimit($page, $limit);
		$this->setOrderBy('t1.kraj ASC,t1.poradi ASC');

		$this->setSelect("t1.*");
		$this->setFrom("mm_kraje t1");

		$list = $this->getRows();
		$this->total = count($list);
		return $list;

	}

}
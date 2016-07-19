<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_Platba extends G_Service{

	function __construct()
	{
		parent::__construct(T_SHOP_ZPUSOB_PLATBY);
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
		$obj = new stdClass();

		$list = $this->getList($params);
		//	print_r($list);
		if (count($list) > 0) {
			$obj->id = $list[0]->id;
			$obj->TimeStamp = $list[0]->TimeStamp;
			$obj->ChangeTimeStamp = $list[0]->ChangeTimeStamp;
			$obj->isDeleted = $list[0]->isDeleted;


			$obj->keyword = $list[0]->keyword;
			$obj->order = $list[0]->order;
			$obj->price = $list[0]->price;
			$obj->brana = $list[0]->brana;
			//$obj->public_date = $list[0]->public_date;
			//$obj->poradi = $list[0]->poradi;
			for($i=0;$i<count($list);$i++)
			{
				$title = "name_" . $list[$i]->code;
				$obj->$title = $list[$i]->name;
				$title = "description_" . $list[$i]->code;
				$obj->$title = $list[$i]->description;

				$title = "price_" . $list[$i]->code;
				$obj->$title = $list[$i]->price;

				if ($list[$i]->code == LANG_TRANSLATOR) {

					$obj->name = $list[$i]->name;

				}


			}
			return $obj;
		}


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

		$where2 = "";
		if(isset($params->lang) && !empty($params->lang))
		{
			$this->addWhere("l.code='" . $params->lang . "'");

			//$where2 = " and l.code='" . $params->lang . "'";
		}

		if(isset($params->page_id) && isInt($params->page_id))
		{
			$this->addWhere("p.id=" . $params->page_id);
		}


		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getOrderBy(), 'p.order ASC');



		$plus_select =  ",0 as isAllowed";
		$plus_join =  "";
		if(isset($params->doprava_id) && isInt($params->doprava_id))
		{
			//	$this->addWhere("a.doprava_id=" . $params['doprava_id']);

			$plus_select =  ",case when doprava.platba_id is null then 0 else 1 end as isAllowed
								,case when doprava.platba_id is null then 0 else doprava.price end as price
								,case when doprava.platba_id is null then 0 else doprava.dph_value end as dph_value
				,case when doprava.platba_id is null then 0 else doprava.price_value end as price_value";
			$plus_join = " left join (select platba_id,p.price,p.price_value,h.value as dph_value from " . T_SHOP_PLATBY_DOPRAVY . " p

						LEFT JOIN " . T_SHOP_ZPUSOB_DOPRAVY . " AS d ON d.id=p.doprava_id
			LEFT JOIN " . T_SHOP_ZPUSOB_DOPRAVY_VERSION . " v ON d.id=v.page_id
			LEFT JOIN " . T_DPH . " h ON h.id=v.tax_id
			LEFT JOIN " . T_LANGUAGE . " l ON l.id=v.lang_id

											where doprava_id=" . $params->doprava_id . " AND(l.code='" . LANG_TRANSLATOR. "') and l.id=v.lang_id) as doprava on doprava.platba_id=p.id";

		}

		$this->setSelect("p.*,v.name,v.description,l.code,v.price" . $plus_select);
		$this->setFrom(T_SHOP_ZPUSOB_PLATBY . " AS p
		LEFT JOIN " . T_SHOP_ZPUSOB_PLATBY_VERSION . " v ON p.id=v.page_id
		LEFT JOIN " . T_LANGUAGE . " l ON l.id=v.lang_id" . $plus_join);

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();

/*
		SELECT @row_num := @row_num+1 as rowid, p.*,v.name,v.description,l.code,v.price,case when doprava.platba_id is null then 0 else 1 end as isAllowed
		,case when doprava.platba_id is null then 0 else doprava.price end as price
		,case when doprava.platba_id is null then 0 else doprava.dph_value end as dph_value
		,case when doprava.platba_id is null then 0 else doprava.price_value end as price_value FROM mm_zpusob_platby AS p
		LEFT JOIN mm_shop_zpusob_platby_version v ON p.id=v.page_id
		LEFT JOIN mm_language l ON l.id=v.lang_id left join

        (select platba_id,p.price,p.price_value,h.value as dph_value from mm_platby_dopravy p

						LEFT JOIN mm_zpusob_dopravy AS d ON d.id=p.doprava_id
			LEFT JOIN mm_shop_zpusob_dopravy_version v ON d.id=v.page_id
			LEFT JOIN mm_dph h ON h.id=v.tax_id
			LEFT JOIN mm_language l ON l.id=v.lang_id

											where doprava_id=11 AND(l.code='cs') and l.id=v.lang_id) as doprava on doprava.platba_id=p.id  WHERE (p.isDeleted=0) AND(l.code='cs') and l.id=v.lang_id  ORDER BY p.order ASC LIMIT 0, 100
										*/
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();

		for($i=0;$i<count($list);$i++)
		{
			$list[$i]->link_edit = "edit_shop_payment?id=" . $list[$i]->id;
		}

	//		print $this->getLastQuery();
		return $list;

	}

	public function getPlatbaDopravyList($params=array())
	{

		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR ;
		}





			//$where2 = " and l.code='" . $params->lang . "'";

		$this->clearWhere();

		$this->addWhere("l.code='" . LANG_TRANSLATOR . "'");

		$this->addWhere("zpv.lang_id=l.id");
		$this->addWhere("v.lang_id=l.id");


		if(isset($params['page_id']) && is_int($params['page_id']))
		{
			$this->addWhere("p.id=" . $params['page_id']);
		}

		if(isset($params['doprava_id']) && is_int($params['doprava_id']))
		{
				$this->addWhere("p.doprava_id=" . $params['doprava_id']);
		}

		if(isset($params['platba_id']) && is_int($params['platba_id']))
		{
			$this->addWhere("p.platba_id=" . $params['platba_id']);
		}
		//	print_r($params);
		$this->addWhere("p.isDeleted=0");

		$page = 1;
		if(isset($params['page']))
		{
			$page = $params['page'];
		}

		$limit = 100;
		if(isset($params['limit']))
		{
			$limit = $params['limit'];
		}



		$this->setLimit($page, $limit);
		//$this->setOrderBy($params['order'], 'p.order ASC');

		$this->setSelect("p.*,v.tax_id,h.value as dph_value,v.name as doprava_name, zpv.name as platba_name");
		$this->setFrom(T_SHOP_PLATBY_DOPRAVY . " AS p

		LEFT JOIN " . T_SHOP_ZPUSOB_DOPRAVY . " AS d ON d.id=p.doprava_id
		LEFT JOIN " . T_SHOP_ZPUSOB_DOPRAVY_VERSION . " v ON d.id=v.page_id

		LEFT JOIN " . T_SHOP_ZPUSOB_PLATBY . " AS zp ON zp.id=p.platba_id
		LEFT JOIN " . T_SHOP_ZPUSOB_PLATBY_VERSION . " zpv ON zp.id=zpv.page_id


		LEFT JOIN " . T_DPH . " h ON h.id=v.tax_id
		LEFT JOIN " . T_LANGUAGE . " l ON l.id=v.lang_id");


		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();

		//	print $this->getFrom() ;
		//		exit;

		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();
	//	print $this->getLastQuery();
		return $list;

	}

}
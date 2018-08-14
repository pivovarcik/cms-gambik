<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_PlatbaDopravy extends G_Service{

	function __construct()
	{
		parent::__construct(T_SHOP_PLATBY_DOPRAVY);
	}


	public $total = 0;

	public function getDetailById($id,$lang=null)
	{
		$params = array();
		$params["page_id"] = (int) $id;
		//	$params['lang'] = $lang;
		if ($lang != null) {
			$params['lang'] = $lang;
		}


		$params['page'] = 1;
		$params['limit'] = 1000;

		//print_r($params);
		return $this->getDetail($params);
	}

	private function getDetail($params=array())
	{
		$obj = new stdClass();

		$list = $this->getList($params);
		//	print_r($list);
		if (count($list) > 0) {
			$obj->id = $list[0]->id;
			$obj->TimeStamp = $list[0]->TimeStamp;
			$obj->ChangeTimeStamp = $list[0]->ChangeTimeStamp;
			$obj->isDeleted = $list[0]->isDeleted;

			$obj->price = $list[0]->price;

			$obj->price_value = $list[0]->price_value;
			$obj->order = $list[0]->order;

		//	$obj->keyword = $list[0]->keyword;



			//$obj->public_date = $list[0]->public_date;
			//$obj->poradi = $list[0]->poradi;
			for($i=0;$i<count($list);$i++)
			{
				$title = "name_" . $list[$i]->code;
				$obj->$title = $list[$i]->name;
				$title = "description_" . $list[$i]->code;
				$obj->$title = $list[$i]->description;

				$title = "tax_id_" . $list[$i]->code;
				$obj->$title = $list[$i]->tax_id;


				$title = "mj_id_" . $list[$i]->code;
				$obj->$title = $list[$i]->mj_id;

				$title = "price_" . $list[$i]->code;
				$obj->$title = $list[$i]->price;


				$title = "price_value_" . $list[$i]->code;
				$obj->$title = $list[$i]->price_value;

				if ($list[$i]->code == LANG_TRANSLATOR) {

					$obj->name = $list[$i]->name;


					$title = "tax_id";
					$obj->$title = $list[$i]->$title;


					$title = "mj_id";
					$obj->$title = $list[$i]->$title;

				}


			}
			//print_r($obj);
			return $obj;
		}


		if (count($list) == 1) {
			return $list[0];
		}
		return false;
	}


	public function getList($params=array())
	{



		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR ;
		}
		$this->clearWhere();

		if(isset($params['lang']) && !empty($params['lang']))
		{
			$this->addWhere("l.code='" . $params['lang'] . "'");

		}
		if(isset($params['doprava_id']) && is_int($params['doprava_id']))
		{
			$this->addWhere("a.doprava_id=" . $params['doprava_id']);
		}

		if(isset($params['platba_id']) && is_int($params['platba_id']))
		{
			$this->addWhere("a.platba_id=" . $params['platba_id']);
		}

		if(isset($params['page_id']) && is_int($params['page_id']))
		{
			$this->addWhere("p.id=" . $params['page_id']);
		}
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
		$this->setOrderBy($params['order'], 'p.order ASC');

		$this->setSelect("p.*,pv.name as platba_name,pv.description as platba_description,l.code,dv.price, dv.price_value,dv.mj_id,dv.tax_id,p.order");
		$this->setFrom($this->getTableName() . " AS a
		LEFT JOIN " . T_SHOP_ZPUSOB_DOPRAVY . " AS d ON a.doprava_id=d.id
		LEFT JOIN " . T_SHOP_ZPUSOB_DOPRAVY_VERSION . " dv ON d.id=dv.page_id
		LEFT JOIN " . T_LANGUAGE . " l ON l.id=dv.lang_id
		LEFT JOIN " . T_SHOP_ZPUSOB_PLATBY . " AS p ON a.platba_id=p.id
		LEFT JOIN " . T_SHOP_ZPUSOB_PLATBY_VERSION . " pv ON p.id=pv.page_id
		");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();


		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();
	//	print $this->getLastQuery();
		return $list;

	}

}
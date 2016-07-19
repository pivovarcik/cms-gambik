<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_Doprava extends G_Service{

	function __construct()
	{
		parent::__construct(T_SHOP_ZPUSOB_DOPRAVY);
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

			$obj->price = $list[0]->price;

			$obj->price_value = $list[0]->price_value;
			$obj->order = $list[0]->order;

			$obj->osobni_odber = $list[0]->osobni_odber;
			$obj->odberne_misto = $list[0]->odberne_misto;
			$obj->address1 = $list[0]->address1;
			$obj->city = $list[0]->city;
			$obj->zip_code = $list[0]->zip_code;



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

		if(isset($params->lang) && !empty($params->lang))
		{
			$this->addWhere("l.code='" . $params->lang . "'");
		}

		if(isset($params->page_id) && isInt($params->page_id))
		{
			$this->addWhere("p.id=" . $params->page_id);
		}


		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getOrderBy(), 'p.order ASC');

		$this->setSelect("p.*,v.name,v.description,l.code,v.price, v.price_value,v.mj_id,v.tax_id,p.order,dph.value as value_dph");
		$this->setFrom(T_SHOP_ZPUSOB_DOPRAVY . " AS p
		LEFT JOIN " . T_SHOP_ZPUSOB_DOPRAVY_VERSION . " v ON p.id=v.page_id
		LEFT JOIN " . T_LANGUAGE . " l ON l.id=v.lang_id
		LEFT JOIN " . T_DPH . " AS dph ON v.tax_id = dph.id
		");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();


		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();

		for($i=0;$i<count($list);$i++)
		{
			$list[$i]->link_edit = "edit_shop_transfer?id=" . $list[$i]->id;
		}

	//	print $this->getLastQuery();
		return $list;

	}

}
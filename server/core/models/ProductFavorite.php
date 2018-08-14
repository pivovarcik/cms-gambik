<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_ProductFavorite extends G_Service{

	function __construct()
	{
		parent::__construct("mm_shop_favorite");
	}

	public $total = 0;

	public function isProductFavorite($product_id, $basket_id)
	{
		$params = array();
		$params["product_id"] = $product_id;
		$params["basket_id"] = $basket_id;
		$list = $this->getList($params);

		if (count($list) > 0) {
			return $list[0];
		}
		return false;
	}

	public function addProduct($product_id, $basket_id)
	{
		$data = array();
		$data["product_id"] = $product_id;
		$data["basket_id"] = $basket_id;

		if (defined("USER_ID")) {
			$data["user_id"] = USER_ID;
		}
		$data["ip_adresa"] = $_SERVER["REMOTE_ADDR"];
		return $this->insertRecords($this->getTableName(), $data);
	}

	public function removeProduct($product_id, $basket_id)
	{
		$data = array();
		$data["isDeleted"] = 1;
		return $this->updateRecords($this->getTableName(), $data,
			"product_id=" . $product_id . " and basket_id='" . $basket_id . "'");
	}

	public function clear($basket_id)
	{
		$data = array();
		$data["isDeleted"] = 1;
		return $this->updateRecords($this->getTableName(), $data,
			"basket_id='" . $basket_id . "'");
	}

	public function getList($params=array())
	{


		$this->clearWhere();
		if (isset($params['basket_id']) && is_numeric($params['basket_id'])) {
			$basket_id = (int) $params['basket_id'];
			$this->addWhere("t1.basket_id = " . $basket_id);
		}

		if (isset($params['user_id']) && is_numeric($params['user_id'])) {
			$basket_id = (int) $params['user_id'];
			$this->addWhere("t1.user_id = " . $basket_id);
		}
		if(isset($params['product_id']) && !empty($params['product_id']))
		{
			$this->addWhere("t1.product_id='" . $params['product_id'] . "'");
		}
		if(isset($params['lang']) && !empty($params['lang']))
		{
			$this->addWhere("l.code='" . $params['lang'] . "'");
		}

		if(isset($params['deleted']) && is_int($params['deleted']))
		{
			$this->addWhere("l.isDeleted='" . $params['deleted'] . "'");
		} else {
			$this->addWhere("t1.isDeleted=0");
		}



		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$page = (int) isset($params['page']) ? $params['page'] : 1;

		//	print "limit:" . $limit;
		$this->setLimit($page, $limit);
		$this->setOrderBy('t1.TimeStamp DESC,t1.id ASC');

		$version = "and v.version=p.version";
		$language1 = " and cv.lang_id=v.lang_id";
		$version1 = "and cv.version=c.version";

		$this->setSelect("t1.*,p.*,
		p.TimeStamp as PageTimeStamp,t1.TimeStamp as BasketTimeStamp,
		p.ChangeTimeStamp as PageChangeTimeStamp,
		v.*,l.code,cv.title as nazev_category,
		t2.name AS nazev_skupina,
		dph.name as nazev_dph,
		dph.value as value_dph,
		mv.name as nazev_mj,
		t4.file,
		t4.description as popis_foto,
		vc.serial_cat_id,
		vc.serial_cat_title,
		vc.serial_cat_url,
		vb.name as nazev_vyrobce,
				dv.name as nazev_dostupnost
		");

		$ProductVersionEntity = new ProductVersionEntity();

		$this->setFrom($this->getTableName() . " AS t1
		left join " . T_SHOP_PRODUCT . " p on t1.product_id = p.id
		left join " . $ProductVersionEntity->getTableName() . " v on p.id = v.page_id " . $version . "

		left join " . T_LANGUAGE . " l on v.lang_id=l.id
		LEFT JOIN " . T_SHOP_PRODUCT_CATEGORY . " AS t2 ON v.skupina_id = t2.id
		left join " . T_SHOP_PRODUCT_VYROBCE . " vb ON v.vyrobce_id = vb.id
		LEFT JOIN " . T_CATEGORY . " c ON (v.category_id = c.id)
		left join " . T_CATEGORY_VERSION . " cv on c.id = cv.page_id " . $version1 . $language1 . "
		left join view_category vc on vc.category_id=v.category_id and vc.lang_id=l.id

    
    		LEFT JOIN " . T_PRODUCT_DOSTUPNOST . " AS d ON d.id = p.dostupnost_id
		LEFT JOIN " . T_PRODUCT_DOSTUPNOST_VERSION . " dv ON d.id=dv.dostupnost_id and dv.lang_id=l.id 
    
    
    LEFT JOIN " . T_MJ . " AS t3 ON v.hl_mj_id = t3.id
    LEFT JOIN " . T_MJ_VERSION . " mv ON t3.id=mv.mj_id and mv.lang_id=l.id  
		LEFT JOIN " . T_DPH . " AS dph ON p.dph_id = dph.id
		LEFT JOIN " . T_FOTO . " AS t4 ON p.foto_id = t4.id");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();


		$attributes = array();
		$attributesList = array();






		// zapamtuju si klíèe
		$key_list = array();
		for ($i=0;$i < count($list);$i++)
		{
			array_push($key_list, $list[$i]->page_id);
		}


	/*	if(isset($params->withAttribs))
		{*/
			if (count($key_list) > 0) {
				$attributes = new models_Attributes();
				$attributesList = $attributes->get_attribute_value_association2($key_list);
			}
	//	}
	//	print_r($attributesList);
		for ($i=0;$i < count($list);$i++)
		{
			//$list[$i]->link = $list[$i]->url;

			$castka_dph = ($list[$i]->value_dph>0) ? $list[$i]->value_dph/100 : $list[$i]->value_dph * 1;

			$vyse_slevy = 0;
			$znak_slevy = " Kè";
			if ($list[$i]->sleva <> 0) {
				// vıpoèet slevy
				if ($list[$i]->druh_slevy == "%" && $list[$i]->prodcena <> 0) {
					$vyse_slevy = $list[$i]->prodcena * $list[$i]->sleva / 100;
					$znak_slevy = "%";
				} else {
					$vyse_slevy = $list[$i]->sleva;
				}
			}
			$zaklad = $list[$i]->prodcena + $vyse_slevy;
			$list[$i]->castka_dph = $castka_dph * $zaklad;
			$list[$i]->cena_sdph = $zaklad + $list[$i]->castka_dph;
			$list[$i]->cena_bezdph = $zaklad;

			$list[$i]->sleva_label = round($list[$i]->sleva) . $znak_slevy;

			$list[$i]->link = URL_HOME . get_categorytourl($list[$i]->serial_cat_url) . '/'. $list[$i]->page_id . '-' . strToUrl($list[$i]->title) . '.html';


			$list[$i]->attributes = array();
			foreach ($attributesList as $key => $val) {

				if ($val->product_id == $list[$i]->page_id) {
					array_push($list[$i]->attributes, $val);
				}
			}

		}

		//print $this->getLastQuery();
		//print $this->last_query;
		return $list;

	}

}
<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_Basket extends G_Service{

	function __construct()
	{
		parent::__construct(T_SHOP_TEMP_CART);
	}

	public $total = 0;

	public function isProductBasket($product_id, $basket_id, $varianty_id = null)
	{
		$variantyWhere = "";
		if (!is_null($varianty_id) && $varianty_id>0) {
			$variantyWhere = " and  varianty_id=" . $varianty_id;
		}

		$whereUser = "";
		if (defined("USER_ID")) {
			$whereUser = " and user_id=" .USER_ID;
		} else {
			$whereUser = " and user_id is null";
		}

		$sql = "SELECT * FROM `" . $this->getTablename() . "` WHERE product_id=" . $product_id .
		$variantyWhere . $whereUser . "
		and basket_id='" . $basket_id . "' and isDeleted=0 LIMIT 1";

		$res = $this->get_row($sql);
		//	print $sql;

		//print_r($res);
		if ($res && $res->product_id > 0) {
			return $res;
		}
		return false;
	}

	public function addProduct($product_id, $basket_id, $qty, $price = null, $tandem_id = null, $varianty_id = null)
	{
		$data = array();
		$data["product_id"] = $product_id;
		$data["basket_id"] = $basket_id;
		if ($tandem_id > 0) {
			$data["tandem_id"] = $tandem_id;
		}
		if ($varianty_id > 0) {
			$data["varianty_id"] = $varianty_id;
		}
		if ($price > 0) {
			$data["price"] = $price;
		}

		$data["mnozstvi"] = $qty;
		//	$data["price"] = $price;
		$data["ip_adresa"] = $_SERVER["REMOTE_ADDR"];

		if (defined("USER_ID")) {
			$data["user_id"] = USER_ID;
		}
		//	$data["caszapsani"] = date('Y-m-d H:i:s');
		return $this->insertRecords($this->getTableName(), $data);
	}


	public function addProduct2(ProductBasketEntity $basketEntity)
	{
		$basketEntity->ip_adresa =  $_SERVER["REMOTE_ADDR"];

		if (defined("USER_ID")) {
			$basketEntity->user_id = USER_ID;
		}
		$saveEntity = new SaveEntity();

		$saveEntity->addSaveEntity($basketEntity);

		if ($saveEntity->save()) {
			return true;
		}
		return false;
	}

	public function updateProduct($product_id, $basket_id, $qty){


		$whereUser = "";
		if (defined("USER_ID")) {
			$whereUser = " and user_id=" .USER_ID;
		} else {
			$whereUser = " and user_id is null";
		}


		$data = array();
		$data["mnozstvi"] = $qty;
		$where = '(product_id=' . $product_id . ' or tandem_id=' . $product_id . ') and isDeleted=0 and basket_id=' . $basket_id . $whereUser;
		return $this->updateRecords($this->getTableName(), $data, $where);
	}
	public function removeProduct($product_id, $basket_id)
	{
		$data = array();
		$data["isDeleted"] = 1;

		$whereUser = "";
		if (defined("USER_ID")) {
			$whereUser = " and user_id=" .USER_ID;
		} else {
			$whereUser = " and user_id is null";
		}

	return	$this->updateRecords($this->getTableName(),$data,"(product_id=" . $product_id . " or tandem_id=" . $product_id . ")
and basket_id='" . $basket_id . "' and isDeleted=0" . $whereUser);

		//return $this->query($sql);
	}

	public function clearBasket($basket_id)
	{
		if (!empty($basket_id)) {
			$data = array();
			$data["isDeleted"] = 1;
			$whereUser = "";
			if (defined("USER_ID")) {
				$whereUser = " and user_id=" .USER_ID;
			} else {
				$whereUser = " and user_id is null";
			}
		return	$this->updateRecords($this->getTableName(),$data,"basket_id='" . $basket_id . "' and isDeleted=0" . $whereUser);
		//	print $this->getLastQuery();
		}

		//$sql = "DELETE FROM `" . T_SHOP_TEMP_CART . "` WHERE basket_id='" . $basket_id . "'";

		//return $this->query($sql);
	}

	public function getDetailById($id)
	{
		$args = new PageListArgs();
		$args->id = (int) $id;

		$list = $this->getList($args);

		if (count($list) > 0) {
			return $list[0];
		}
		return false;
	}

	public function getList(IListArgs $args=null)
	{


		if (is_null($args)) {
			$args = new PageListArgs();
		}
		$this->clearWhere();
		$this->setLimit($args->getPage(), $args->getLimit());


		if (isset($args->basket_id) && is_numeric($args->basket_id)) {
			$basket_id = (int) $args->basket_id;
			$this->addWhere("t1.basket_id = " . $basket_id);
		}


		if (isset($args->id) && isInt($args->id)) {
			$basket_id = (int) $args->id;
			$this->addWhere("t1.id = " . $basket_id);
		}

		if (isset($args->user_id) && isInt($args->user_id)) {
			$user_id= (int) $args->user_id;
			$this->addWhere("t1.user_id = " . $user_id);
		} else {
      if (!defined("ADMIN"))
      {
          $this->addWhere("t1.user_id is null");
      }
			
		}

		if (isset($args->fulltext) && !empty($args->fulltext)) {
			$this->addWhere("(p.cislo like '%" . $args->fulltext . "%' or
			t1.ip_adresa like '%" . $args->fulltext . "%' or
v.title like '%" . $args->fulltext . "%' or
			t1.basket_id like '%" . $args->fulltext . "%' or u.nick like '%" . $args->fulltext . "%') ");
		}

		if(isset($args->lang) && !empty($args->lang))
		{
			$this->addWhere("l.code='" .$args->lang . "'");

		}
		if(isset($args->isDeleted) && isInt($args->isDeleted))
		{
			$this->addWhere("t1.isDeleted=" . $args->isDeleted);
		} else {
			$this->addWhere("t1.isDeleted=0");
		}
    $this->addWhere("p.isDeleted=0");
    $this->addWhere("p.aktivni=1");
		$this->setOrderBy($args->getOrderBy(),'t1.TimeStamp ASC');

		$version = "and v.version=p.version";
		$language1 = " and cv.lang_id=v.lang_id";
		$version1 = "and cv.version=c.version";

		$this->setSelect("v.*,p.*,t1.*,t1.sleva as basket_sleva,t1.typ_slevy as basket_typ_slevy,
		p.TimeStamp as PageTimeStamp,t1.TimeStamp as BasketTimeStamp,
		pv.name as varianty_name,pv.code as varianty_code,
		p.ChangeTimeStamp as PageChangeTimeStamp,
		l.code,cv.title as nazev_category,1 as radek_added,
		t2.name AS nazev_skupina,v.title as product_name,p.cislo as product_code,
		dph.name as nazev_dph,p.dph_id as tax_id,t1.mnozstvi as qty,vb.name as nazev_vyrobce,
		dph.value as value_dph,
    p.qty as qty_min,
		mv.name as nazev_mj,
    		dv.name as nazev_dostupnost,
		d.hodiny as hodiny_dostupnost,
		t4.file,t4.dir,
		t4.description as popis_foto,
		vc.serial_cat_id,
		vc.serial_cat_title,u.nick,u.email,
		vc.serial_cat_url
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
		LEFT JOIN " . T_USERS . " AS u ON t1.user_id = u.id
		LEFT JOIN " . T_FOTO . " AS t4 ON p.foto_id = t4.id
		LEFT JOIN " . T_SHOP_PRODUCT_VARIANTY . " AS pv ON t1.varianty_id = pv.id

"


		);

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();

	//	print_r($list);
		for ($i=0;$i < count($list);$i++)
		{
			//$list[$i]->link = $list[$i]->url;

			$castka_dph = ($list[$i]->value_dph>0) ? $list[$i]->value_dph/100 : $list[$i]->value_dph * 1;

			$list[$i]->cena_po_sleve = $list[$i]->price;
			$list[$i]->cena_sdph_po_sleve = $list[$i]->price_sdani;


			$vyse_slevy = 0;
			$znak_slevy = " Kč";
			if ($list[$i]->basket_sleva <> 0) {
				// výpočet slevy
				if ($list[$i]->typ_slevy == "%" && $list[$i]->price <> 0) {
					$vyse_slevy = $list[$i]->price * $list[$i]->basket_sleva / 100;
					$znak_slevy = "%";
					$list[$i]->cena_po_sleve = $list[$i]->price + ($list[$i]->price * $list[$i]->basket_sleva / 100);
					$list[$i]->cena_sdph_po_sleve = $list[$i]->price_sdani + ($list[$i]->price_sdani * $list[$i]->basket_sleva / 100);
				} else {
					$vyse_slevy = $list[$i]->sleva;
					$list[$i]->cena_po_sleve = $list[$i]->price + $list[$i]->basket_sleva;
					$list[$i]->cena_sdph_po_sleve = $list[$i]->price_sdani + $list[$i]->basket_sleva;
				}
			}

			$list[$i]->cenacelkem_sdph =  $list[$i]->cena_sdph_po_sleve * $list[$i]->mnozstvi;
			$list[$i]->cenacelkem =  $list[$i]->cena_po_sleve * $list[$i]->mnozstvi;

		//	$list[$i]->price
		//	$list[$i]->price_sdani



			$zaklad = $list[$i]->price + $vyse_slevy;

			$list[$i]->castka_dph = $list[$i]->cenacelkem_sdph - $list[$i]->cenacelkem;
		//	$list[$i]->castka_dph = $castka_dph * $zaklad;



			$list[$i]->cena_sdph = $zaklad + $list[$i]->castka_dph;

		//	$list[$i]->cenacelkem_sdph = $list[$i]->cena_sdph * $list[$i]->qty;
			//$list[$i]->cenacelkem_sdph_label = $list[$i]->cena_sdph * $list[$i]->qty;
			$list[$i]->cena_bezdph = $zaklad;

		//	$list[$i]->cenacelkem = $list[$i]->price * $list[$i]->qty;
			$list[$i]->sleva_label = round($list[$i]->sleva) . $znak_slevy;



		//	$list[$i]->cena_sdph_po_sleve = $list[$i]->cena_sdph * $list[$i]->mnozstvi;

			// částka s DPH
			//	$this->total_price_sdph += ($l[$i]->cena_sdph * $l[$i]->mnozstvi);

		//	$list[$i]->cena_po_sleve = $list[$i]->cena_bezdph *  $list[$i]->mnozstvi;



			if (defined("URL_HOME")) {
				$list[$i]->link = URL_HOME;
			}
			$list[$i]->link .= get_categorytourl($list[$i]->serial_cat_url) . '/'. $list[$i]->page_id . '-' . strToUrl($list[$i]->title) . '.html';


		}

		//print $this->getLastQuery();
		//print $this->last_query;
		return $list;

	}

}
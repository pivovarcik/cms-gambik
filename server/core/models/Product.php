<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("Pages.php");
class models_Product extends models_Pages{

	function __construct()
	{
		parent::__construct(T_SHOP_PRODUCT);
	}
//	private $photos = array();
	private $prices = array();
	private $attributes = array();
		public $total = 0;
	public function getAttributes($name=null)
	{
	//	print_r($this->attributes);
		if ($name === null) {
			return $this->attributes;
		}
		foreach ($this->attributes as $key => $value){
			if ($value["attrname"] == $name) {
				return $value["attrvalue"];
			}
		}
		return false;

	}

	public function getPhotos($id=null)
	{
		if ($id === null) {
			return $this->photos;
		}
		return false;

	}
	public function getPrices($id=null)
	{
		if ($id === null) {
			return $this->prices;
		}
		return false;

	}
	public function getProduct($product_id)
	{


		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR ;
		}
		//	, a.description
		$productQuery = "
		SELECT p.*,c.nazev_cs AS skupina_cs, m.mj,t2.hodnota as nazev_vyrobce,
		(
		SELECT GROUP_CONCAT( a.ID, '--AV--', a.name,'--AV--',  av.ID, '--AV--', av.name,'--AV--' SEPARATOR '---ATTR---' ) FROM mm_product_attribute_values av,
		mm_product_attribute_value_association ava, mm_product_attributes a
		WHERE a.ID = av.attribute_id AND av.ID=ava.attribute_id AND ava.product_id=p.klic_ma ORDER BY ava.order
		) AS attributes,

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
    (case when sql2.nazev_" . $znak . " is null then '' else sql2.nazev_" . $znak . " end)
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
    (case when sql2.url_friendly_" . $znak . " is null then '' else sql2.url_friendly_" . $znak . " end)
    ) as serial_cat_url
		FROM " . T_SHOP_PRODUCT." p
		left join " . T_SHOP_PRODUCT_CATEGORY." c ON p.skupina = c.uid
		left join " . T_MJ." m ON p.hl_mj = m.uid
		left join " . T_SHOP_PRODUCT_VYROBCE . " t2 ON p.vyrobce = t2.uid
		left join " . T_CATEGORY . " sql2 on p.category = sql2.uid
	    left join " . T_CATEGORY . " sql3 on sql2.parent_uid=sql3.uid
	    left join " . T_CATEGORY . " sql4 on sql3.parent_uid=sql4.uid
	    left join " . T_CATEGORY . " sql5 on sql4.parent_uid=sql5.uid
	    left join " . T_CATEGORY . " sql6 on sql5.parent_uid=sql6.uid
	    left join " . T_CATEGORY . " sql7 on sql6.parent_uid=sql7.uid
	    left join " . T_CATEGORY . " sql8 on sql7.parent_uid=sql8.uid
	    left join " . T_CATEGORY . " sql9 on sql8.parent_uid=sql9.uid
	    left join " . T_CATEGORY . " sql10 on sql9.parent_uid=sql10.uid
	    left join " . T_CATEGORY . " sql11 on sql10.parent_uid=sql11.uid
		 WHERE p.klic_ma=" . $product_id;
		//print $productQuery;
		$data = $this->get_row($productQuery);
		if( $data->attributes != '' )
		{
			$this->hasAttributes = true;
			$attrs = explode('---ATTR---', $data->attributes );

			//	echo '<pre>' . print_r( $attrs, true ) . '</pre>';

			foreach( $attrs as $atr )
			{
				$value = explode( '--AV--', $atr );

				$value_id = (int) str_replace("-","", $value[0]);
				//$this->attributes[ $value[0] ][] = array( 'attrid' => $value[1], 'attrvalue' => $value[2] );
				$this->attributes[ $value_id ]= array( 'attrname' => $value[1], 'attrid' => $value[2], 'attrvalue' => $value[3], 'attrdesc' => $value[4] );

			}
			//	echo '<pre>' . print_r( $this->attributes, true ) . '</pre>';

		}
		/**
		 * Photo Gallery
		 * */

		$this->clearWhere();
		$this->addWhere("t2.table='" . T_SHOP_PRODUCT . "'");
		$this->addWhere("t2.uid_target=" . $product_id);
		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$aktPage = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($aktPage, $limit);
		$this->setOrderBy($params['order'], 'caszapsani ASC');

		$this->setSelect("t1.*");
		$this->setFrom(T_FOTO. " AS t1
		LEFT JOIN " . T_FOTO_PLACES . " t2 ON t1.uid = t2.uid_source");
		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();

		//print $query;
		$this->totalPhotos = $this->get_var($query);
		$this->photos = $this->getRows();

		/**
		 * Ceny
		 * */

		$this->clearWhere();
		$this->addWhere("t1.product_id=" . $product_id);
		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		$aktPage = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($aktPage, $limit);
		$this->setOrderBy($params['order'], 'caszapsani ASC');

		$this->setSelect("t1.*,t2.platnost_od,t2.oznaceni,t2.popis,t2.platnost_do,t2.marze as marze_cenik");
		$this->setFrom(T_CENY. " AS t1
		LEFT JOIN " . T_CENIKY . " t2 ON t1.cenik_id = t2.uid");
		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();

		//print $query;
		$this->totalPrices = $this->get_var($query);
		$this->prices = $this->getRows();

		/*	*/
		//print_r($this->attributes);
		return $data;
	}



	public function getDetailByReference($reference)
	{

		$params = new ListArgs();
		$params->reference =  (string) $reference;
		//	$params['lang'] = $lang;
/*		if ($lang != null) {
			$params->lang = $lang;
		}
*/

		$params->page = 1;
		$params->limit = 1000;

		//print_r($params);
		return $this->getDetail($params);
	}

	public function getDetailByCislo($cislo,$lang=null)
	{
		$params = new ListArgs();
		$params->cislo =  (string) $cislo;
		//	$params['lang'] = $lang;
		if ($lang != null) {
			$params->lang = $lang;
		}


		$params->page = 1;
		$params->limit = 1000;

		//print_r($params);
		return $this->getDetail($params);
	}

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

	protected function getDetail(IListArgs $args)
	{
	//	$obj = new stdClass();

		$list = $this->getList($args);

		$obj = $this->getPage($list);
		//print_r($list);
		if (count($list) > 0) {

		//	print_r($list[0]);
		//	$obj->id = $list[0]->page_id;
		//	$obj->version_id = $list[0]->version_id;
		//	$obj->version = $list[0]->version;
		//	$obj->level = $list[0]->level;
		//	$obj->TimeStamp = $list[0]->TimeStamp;
		//	$obj->ChangeTimeStamp = $list[0]->ChangeTimeStamp;
		//	$obj->category_id = $list[0]->category_id;
			$obj->nazev_category = $list[0]->nazev_category;

			$obj->dph_id = $list[0]->dph_id;
			$obj->neprodejne = $list[0]->neprodejne;
			$obj->qty_nasobek = $list[0]->qty_nasobek;
			$obj->nazev_dph = $list[0]->nazev_dph;
			$obj->value_dph = $list[0]->value_dph;
			$obj->nakupni_cena = $list[0]->nakupni_cena;
			$obj->rozmer = $list[0]->rozmer;
			$obj->objem = $list[0]->objem;

			$obj->sleva = $list[0]->sleva;
			//$obj->sleva_label = $list[0]->sleva_label;
			$obj->druh_slevy = $list[0]->druh_slevy;

		//	$obj->castka_dph = $list[0]->castka_dph;
		//	$obj->cena_sdph = $list[0]->cena_sdph;
		//	$obj->cena_bezdph =$list[0]->cena_bezdph;

			$obj->skupina_id = $list[0]->skupina_id;
			$obj->nazev_skupina = $list[0]->nazev_skupina;
			$obj->vyrobce_id = $list[0]->vyrobce_id;
			$obj->nazev_vyrobce = $list[0]->nazev_vyrobce;
			$obj->dostupnost = $list[0]->dostupnost;
			$obj->views = $list[0]->views;
			$obj->cislo = $list[0]->cislo;
			$obj->user_id = $list[0]->user_id;
			$obj->isDeleted = $list[0]->isDeleted;

			$obj->prodcena = $list[0]->prodcena;
			$obj->bezna_cena = $list[0]->bezna_cena;
			$obj->hl_mj_id = $list[0]->hl_mj_id;
	//		$obj->nazev_mj = $list[0]->nazev_mj;
			$obj->mj_id = $list[0]->mj_id;
			$obj->aktivni = $list[0]->aktivni;
			$obj->qty = $list[0]->qty;
			$obj->netto = $list[0]->netto;
			$obj->foto_id = $list[0]->foto_id;

			$obj->dostupnost_id = $list[0]->dostupnost_id;
			$obj->nazev_dostupnost = $list[0]->nazev_dostupnost;
      $obj->hodiny_dostupnost = $list[0]->hodiny_dostupnost;


			$obj->zaruka_id = $list[0]->zaruka_id;
			$obj->nazev_zaruka = $list[0]->nazev_zaruka;

			$obj->bazar = $list[0]->bazar;
			$obj->neexportovat = $list[0]->neexportovat;
/*
			$obj->title = $list[0]->title;
			$obj->description = $list[0]->description;
			$obj->pagetitle = !empty($list[0]->pagetitle) ? $list[0]->pagetitle : $list[0]->title;
			$obj->pagekeywords = $list[0]->pagekeywords;
			$obj->pagedescription = $list[0]->pagedescription;
*/
			$obj->code01 = $list[0]->code01;
			$obj->code02 = $list[0]->code02;
			$obj->code03 = $list[0]->code03;

			$obj->cislo1 = $list[0]->cislo1;
			$obj->cislo2 = $list[0]->cislo2;
			$obj->cislo3 = $list[0]->cislo3;
			$obj->cislo4 = $list[0]->cislo4;
			$obj->cislo5 = $list[0]->cislo5;

			$obj->polozka1 = $list[0]->polozka1;
			$obj->polozka2 = $list[0]->polozka2;
			$obj->polozka3 = $list[0]->polozka3;
			$obj->polozka4 = $list[0]->polozka4;
			$obj->polozka5 = $list[0]->polozka5;

			if (!defined('ADMIN')) {
				$obj->link = URL_HOME . get_categorytourl($list[0]->serial_cat_url) . '/'. $list[0]->page_id . '-' . strToUrl($list[0]->title) . '.html';
			} else {
				$obj->link = "/" . get_categorytourl($list[0]->serial_cat_url) . '/'. $list[0]->page_id . '-' . strToUrl($list[0]->title) . '.html';
				$obj->link = "/p". $list[0]->page_id . '-' . strToUrl($list[0]->title) . '.html';
			}
			//$obj->link = URL_HOME . get_categorytourl($list[0]->serial_cat_url) . '/'. $list[0]->page_id . '-' . strToUrl($list[0]->title) . '.html';


			$obj->serial_cat_url = $list[0]->serial_cat_url;
			$obj->serial_cat_title = $list[0]->serial_cat_title;
			$obj->serial_cat_id = $list[0]->serial_cat_id;


			//$obj->public_date = $list[0]->public_date;
			//$obj->poradi = $list[0]->poradi;
			for($i=0;$i<count($list);$i++)
			{



				// aktuální jazyk
				if ($list[$i]->code == LANG_TRANSLATOR) {
          			$obj->nazev_mj = $list[0]->nazev_mj;
					$obj->title = $list[$i]->title;
					$obj->description = $list[$i]->description;
					//$obj->pagetitle = $list[$i]->pagetitle;
					$obj->pagetitle = !empty($list[$i]->pagetitle) ? $list[$i]->pagetitle : $list[$i]->title;
					//	$obj->pagekeywords = $list[$i]->pagekeywords;
					$obj->pagekeywords = !empty($list[$i]->pagekeywords) ? $list[$i]->pagekeywords : $list[$i]->nazev_category;
					$obj->pagedescription = $list[$i]->pagedescription;

					$obj->serial_cat_url = $list[$i]->serial_cat_url;
					$obj->serial_cat_title = $list[$i]->serial_cat_title;


					$obj->polozka1 = $list[$i]->polozka1;
					$obj->polozka2 = $list[$i]->polozka2;
					$obj->polozka3 = $list[$i]->polozka3;
					$obj->polozka4 = $list[$i]->polozka4;
					$obj->polozka5 = $list[$i]->polozka5;

					$obj->polozka6 = $list[$i]->polozka6;
					$obj->polozka7 = $list[$i]->polozka7;
					$obj->polozka8 = $list[$i]->polozka8;
					$obj->polozka9 = $list[$i]->polozka9;
					$obj->polozka10 = $list[$i]->polozka10;


					$obj->cislo1 = $list[$i]->cislo1;
					$obj->cislo2 = $list[$i]->cislo2;
					$obj->cislo3 = $list[$i]->cislo3;
					$obj->cislo4 = $list[$i]->cislo4;
					$obj->cislo5 = $list[$i]->cislo5;

					$obj->cislo6 = $list[$i]->cislo6;
					$obj->cislo7 = $list[$i]->cislo7;
					$obj->cislo8 = $list[$i]->cislo8;
					$obj->cislo9 = $list[$i]->cislo9;
					$obj->cislo10 = $list[$i]->cislo10;

					$obj->perex 	= $list[$i]->perex;

				}

		/*		$title = "title_" . $list[$i]->code;
				$obj->$title = $list[$i]->title;

				$name = "perex_" . $list[$i]->code;
				$obj->$name = $list[$i]->perex;

				$description = "description_" . $list[$i]->code;
				$obj->$description = $list[$i]->description;

				$name = "pagetitle_" . $list[$i]->code;
				$obj->$name = $list[$i]->pagetitle;

			//	$name = "pagekeywords_" . $list[$i]->code;
			//	$obj->$name = $list[$i]->pagekeywords;

			//	$pagedescription = "pagedescription_" . $list[$i]->code;
			//	$obj->$pagedescription = $list[$i]->pagedescription;
*/
				$name = "link_" . $list[$i]->code;
				$obj->$name = URL_HOME2 . $list[$i]->code . "/p" . $list[$i]->page_id . '-' . strToUrl($list[$i]->title) . '.html';
/*
				$name = "serial_cat_url_" . $list[$i]->code;
				$obj->$name = $list[$i]->serial_cat_url;

				$name = "serial_cat_title_" . $list[$i]->code;
				$obj->$name = $list[$i]->serial_cat_title;
*/
				$name = "polozka1_" . $list[$i]->code;
				$obj->$name = $list[$i]->polozka1;

				$name = "polozka2_" . $list[$i]->code;
				$obj->$name = $list[$i]->polozka2;

				$name = "polozka3_" . $list[$i]->code;
				$obj->$name = $list[$i]->polozka3;

				$name = "polozka4_" . $list[$i]->code;
				$obj->$name = $list[$i]->polozka4;

				$name = "polozka5_" . $list[$i]->code;
				$obj->$name = $list[$i]->polozka5;


				$name = "polozka6_" . $list[$i]->code;
				$obj->$name = $list[$i]->polozka6;

				$name = "polozka7_" . $list[$i]->code;
				$obj->$name = $list[$i]->polozka7;

				$name = "polozka8_" . $list[$i]->code;
				$obj->$name = $list[$i]->polozka8;

				$name = "polozka9_" . $list[$i]->code;
				$obj->$name = $list[$i]->polozka9;

				$name = "polozka10_" . $list[$i]->code;
				$obj->$name = $list[$i]->polozka10;



				$name = "cislo1_" . $list[$i]->code;
				$obj->$name = $list[$i]->cislo1;

				$name = "cislo2_" . $list[$i]->code;
				$obj->$name = $list[$i]->cislo2;

				$name = "cislo3_" . $list[$i]->code;
				$obj->$name = $list[$i]->cislo3;

				$name = "cislo4_" . $list[$i]->code;
				$obj->$name = $list[$i]->cislo4;

				$name = "cislo5_" . $list[$i]->code;
				$obj->$name = $list[$i]->cislo5;


				$name = "cislo6_" . $list[$i]->code;
				$obj->$name = $list[$i]->cislo6;

				$name = "cislo7_" . $list[$i]->code;
				$obj->$name = $list[$i]->cislo7;

				$name = "cislo8_" . $list[$i]->code;
				$obj->$name = $list[$i]->cislo8;

				$name = "cislo9_" . $list[$i]->code;
				$obj->$name = $list[$i]->cislo9;

				$name = "cislo10_" . $list[$i]->code;
				$obj->$name = $list[$i]->cislo10;


				$name = "version_id_" . $list[$i]->code;
				$obj->$name = $list[$i]->version_id;


			}

		//	print_r($obj);
			return $obj;
		}


		if (count($list) == 1) {
			return $list[0];
		}
		return false;
	}


	/**
	 * Hlavní pohled na data produktů
	 * */
	public function getList(IListArgs $params = null)
	{


		$eshopSettings = G_EshopSetting::instance();
		$params = parent::getListArgs($params);

		$this->addWhere("p.isDeleted=" . $params->isDeleted);


		if (isset($params->fulltext) && !empty($params->fulltext)) {
    
    
      $params->fulltext = $this->escape($params->fulltext);
			$this->addWhere("(p.cislo like '%" . $params->fulltext . "%' or
			cv.title like '%" . $params->fulltext . "%' or
      v.title like '%" . $params->fulltext . "%' or
			v.perex like '%" . $params->fulltext . "%' or
			p.code01 like '%" . $params->fulltext . "%' or
			p.code02 like '%" . $params->fulltext . "%' or
			p.code03 like '%" . $params->fulltext . "%' or
      vb.name like '%" . $params->fulltext . "%') ");
		}

		$language1 = "";

		if(isset($params->lang) && !empty($params->lang))
		{
			$this->addWhere("l.code='" . $params->lang . "'");
		}

		if(isset($params->bazar) && isInt($params->bazar))
		{
			$this->addWhere("p.bazar=" . $params->bazar );
		}
		if(isset($params->novinka) && isInt($params->novinka))
		{
			$this->addWhere("p.novinka=" . $params->novinka );
		}

		if(isset($params->dodavatel_id) && isInt($params->dodavatel_id))
		{
			$this->addWhere("p.dodavatel_id=" . $params->dodavatel_id );
		}
		if(isset($params->dostupnost_id) && isInt($params->dostupnost_id))
		{
			$this->addWhere("p.dostupnost_id=" . $params->dostupnost_id );
		}

		if(isset($params->skladem) && isInt($params->skladem))
		{
			$this->addWhere("(d.hodiny=0 or p.stav_qty > 0)");
		}
        
		if(isset($params->title) && !empty($params->title))
		{
			$params->title = $this->escape($params->title);
      $this->addWhere("v.title like '%" . $params->title . "%'");
		}

		if(isset($params->reference) && !empty($params->reference))
		{
			$params->reference = $this->escape($params->reference);
      $this->addWhere("p.reference='" . $params->reference . "'");
		}

		$language1 = " and cv.lang_id=v.lang_id";


		if (isset($params->attributes) && is_array($params->attributes)) {
       // TODO Musí se ředeělat na left join !!! 
			foreach ($params->attributes as $key){

				if ($key > 0) {
					$this->addWhere("p.id in
						(select product_id from mm_product_attribute_value_association ava where ava.attribute_id=" . $key . ")");

				}
			}
		}

		if (isset($params->not_product_id) && isInt($params->not_product_id)) {
			$this->addWhere(" p.id<> " . $params->not_product_id);
		}

		if (isset($params->aktivni) && isInt($params->aktivni) && $params->aktivni < 2) {
			$this->addWhere(" p.aktivni=" . $params->aktivni);
		}

		if (isset($params->status) && isInt($params->status)) {

			switch($params->status)
			{
      	case 0:
					$this->addWhere("p.aktivni=0");
					$this->addWhere("p.isDeleted=0");
					break;
          
				case 1:
					$this->addWhere("p.aktivni=1");
					$this->addWhere("p.isDeleted=0");
					break;
				case 2:
					//$this->addWhere("p.aktivni=0");
					$this->addWhere("p.isDeleted=0");
					break;
				case 3:
					$this->addWhere("p.isDeleted=0");
					break;
			}

		}
		if (isset($params->neexportovat) && isInt($params->neexportovat)) {
			$this->addWhere(" p.neexportovat=" . $params->neexportovat);
		}

		if (isset($params->typ_sort) && !empty($params->typ_sort)) {
			$this->addWhere(" p.typ_sort='" . $params->typ_sort . "' ");
		}

      
    //  print_R($params->skupina);
    $skupinaList = "";
    if (isset($params->skupina) && is_array($params->skupina) && count($params->skupina) > 0) 
		{


      $vyrobceA = array();
			foreach ($params->skupina as $key =>$val) {
				array_push($vyrobceA,$key);
			}
      
    //  print_r($vyrobceA);
			if ( implode(",", $vyrobceA) == 0) {
				$skupinaList = $params->skupina;
			}
      
			$skupinaList = implode(",", $vyrobceA);
			if (!empty($skupinaList)) {
				$this->addWhere("t4.product_id is not null ");
			}
		}
    
    if (isset($params->skupina) && isInt($params->skupina) && ($params->skupina) > 0) {
		//	$this->addWhere(" p.skupina_id=" . $params->skupina);
    		$skupinaList = $params->skupina;
			$this->addWhere("t4.product_id is not null ");
		}
    
    

		if (isset($params->vyr) && !isset($params->vyrobce)) {
			$params['vyrobce'] = $params->vyr;
		}
		if (isset($params->vyrobce) && isInt($params->vyrobce) && ($params->vyrobce) > 0) {
			$this->addWhere(" p.vyrobce_id=" . $params->vyrobce);
		}

		if (isset($params->vyrobce) && is_array($params->vyrobce) && count($params->vyrobce) > 0) {
			$vyrobceA = array();
			foreach ($params->vyrobce as $key =>$val) {
				array_push($vyrobceA,$key);
			}
			$this->addWhere("p.vyrobce_id in (". implode(",", $vyrobceA) . ")");
		//	print_r();
		}

		if (isset($params->kategorie) && isInt($params->kategorie) && ($params->kategorie) > 0) {
			$this->addWhere(" p.category_id=" . $params->kategorie);
		}
    $cenikList = "";
		if (isset($params->cenik_id) && isInt($params->cenik_id) && ($params->cenik_id) > 0) {
		//	$this->addWhere(" p.cenik_id=" . $params->cenik_id);
      
      $cenikList = $params->cenik_id;
			$this->addWhere("pc.product_id is not null ");
      
		}

	//	print_r($params);
		if (isset($params->lowestPrice) && isInt($params->lowestPrice)) {
			$price = (int) $params->lowestPrice;

			if (defined("LANG_KURZ")) {
				$price  = $price  * (LANG_KURZ*1);
			}


			if ($eshopSettings->get("PRICE_TAX") == 0) {
				//$this->addWhere("ifnull(v.prodcena,0)>=" . $price);
				$this->addWhere("ifnull(p.min_prodcena,0)>=" . $price);
			} else {
			//	$this->addWhere("ifnull(v.prodcena_sdph,0)>=" . $price);
				$this->addWhere("ifnull(p.min_prodcena_sdph,0)>=" . $price);
			}
		}
		if (isset($params->highestPrice) && isInt($params->highestPrice)) {
			$price = (int) $params->highestPrice;

			if (defined("LANG_KURZ")) {
				$price  = $price  * (LANG_KURZ*1);
			}
			if ($eshopSettings->get("PRICE_TAX") == 0) {
				//$this->addWhere("ifnull(v.prodcena,0)<=" . $price);
				$this->addWhere("ifnull(p.max_prodcena,0)<=" . $price);
			} else {
				//$this->addWhere("ifnull(v.prodcena_sdph,0)<=" . $price);
				$this->addWhere("ifnull(p.max_prodcena_sdph,0)<=" . $price);
			}

		//	$this->addWhere("ifnull(v.prodcena,0)<=" . $price);
		}

	/*	if (isset($params->fulltext) && !empty($params->fulltext)) {
			$this->addWhere("(p.cislo like '%" . $params->fulltext . "%' or v.title like '%" . $params->fulltext . "%') ");
		}*/

		if (isset($params->child) && isInt($params->child))
		{
			if ($params->child == -1)
      {
         $this->addWhere("c.category_id is null");
      } else {
          $this->addWhere("concat(vc.serial_cat_id,'|') like '%|" . $params->child . "|%'");
      }
      
		}


		if(isset($params->page_id) && isInt($params->page_id))
		{
			$this->addWhere("v.page_id=" . $params->page_id);
		}

		if(isset($params->cislo) && !empty($params->cislo))
		{
			$this->addWhere("p.cislo='" . $params->cislo . "'");
		}

		if(isset($params->fulltext_cislo) && !empty($params->fulltext_cislo))
		{
			$this->addWhere("p.cislo like '%" . $params->fulltext_cislo . "%'");
		}

		if(isset($params->code01) && !empty($params->code01))
		{
			$this->addWhere("p.code01='" . $params->code01 . "'");
		}

		if(isset($params->code03) && !empty($params->code03))
		{
			$this->addWhere("p.code03='" . $params->code03 . "'");
		}

		if(isset($params->code02) && !empty($params->code02))
		{
			$this->addWhere("p.code02='" . $params->code02 . "'");
		}

		if (isset($params->df) && !empty($params->df)) {

			$date = date("Ymd",strtotime($params->df));
			$this->addWhere("p.TimeStamp >= '" .$date . "'");
		}

		if (isset($params->dt) && !empty($params->dt)) {
			$date = date("Ymd",strtotime($params->dt));
			$this->addWhere("p.TimeStamp <= '" . $date . "'");
		}

		// moznost vytažení konkrétní verze stránky
		if(isset($params->version) && isInt($params->version))
		{
			$this->addWhere("v.version=" . $params->version);
			$version = "and v.version=" . $params->version;
		} else {
			$version = "and v.version=p.version";
			$version1 = "and cv.version=c.version";
		}


		$this->setGroupBy($params->getGroupBy());
		$this->setOrderBy($params->getOrderBy(), 'v.title ASC');

		if (!empty($params->select)) {
			$this->setSelect($params->getSelect());
		} else {
			$this->setSelect("p.*,
		p.TimeStamp as PageTimeStamp,
		p.ChangeTimeStamp as PageChangeTimeStamp,
		v.*,l.code,cv.title as nazev_category,
		t2.name AS nazev_skupina,
		vb.name as nazev_vyrobce,
		dph.name as nazev_dph,
		dph.value as value_dph,
		mv.name as nazev_mj,
		f.file,f.dir,
		f.description as popis_foto,
		vc.serial_cat_id,
		vc.serial_cat_title,
		vc.serial_cat_url,p.id,
		dv.name as nazev_dostupnost,
		d.hodiny as hodiny_dostupnost,
		v.id as version_id,
    vz.name as nazev_zaruka,v.id,
		dod.name as dodavatel_name
		");
		}




		$ProductVersionEntity = new ProductVersionEntity();

     $from = $ProductVersionEntity->getTableName() . " AS v
		 left join " . $this->getTableName() . " p on v.page_id = p.id " . $version . "
		left join " . T_LANGUAGE . " l on v.lang_id=l.id
		LEFT JOIN " . T_SHOP_PRODUCT_CATEGORY . " AS t2 ON v.skupina_id = t2.id
		left join " . T_SHOP_PRODUCT_VYROBCE . " vb ON v.vyrobce_id = vb.id
		left join " . T_PRODUCT_ZARUKA . " vz ON p.zaruka_id = vz.id
		left join " . T_IMPORT_PRODUCT_SET . " dod ON p.dodavatel_id =dod.id

		LEFT JOIN " . T_CATEGORY . " c ON (v.category_id = c.id)
		left join " . T_CATEGORY_VERSION . " cv on c.id = cv.page_id " . $version1 . $language1 . "
	   	left join view_category vc on vc.category_id=v.category_id and vc.lang_id=l.id
		LEFT JOIN " . T_PRODUCT_DOSTUPNOST . " AS d ON d.id = p.dostupnost_id
		LEFT JOIN " . T_PRODUCT_DOSTUPNOST_VERSION . " dv ON d.id=dv.dostupnost_id and dv.lang_id=l.id 
		LEFT JOIN " . T_MJ . " AS t3 ON v.hl_mj_id = t3.id
    LEFT JOIN " . T_MJ_VERSION . " mv ON t3.id=mv.mj_id and mv.lang_id=l.id 
		LEFT JOIN " . T_DPH . " AS dph ON p.dph_id = dph.id
		LEFT JOIN " . T_FOTO . " AS f ON p.foto_id = f.id";


     // print $skupinaList;
  	if (!empty($skupinaList)) {
			$from .=" left join (select DISTINCT  t1.group_id, t1.product_id,t2.name from " . T_PRODUCT_GROUP_ASSOC . " t1
      left join " . T_SHOP_PRODUCT_CATEGORY . " t2 ON t1.group_id = t2.id where t1.isDeleted=0  and t2.isDeleted=0 
      and group_id in (" . $skupinaList . ")  ) as t4 on t4.product_id=p.id ";
		}

  	if (!empty($cenikList)) {
			$from .=" left join (select DISTINCT  t1.cenik_id, t1.product_id from " . T_PRODUCT_CENA . " t1
      where t1.isDeleted=0 
      and cenik_id in (" . $cenikList . ")  ) as pc on pc.product_id=p.id ";
		}
        
    


		$this->setFrom($from);




		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
//		print $query;

	 	/*print $this->getWhere();
	exit;*/
  	$this->total = $this->get_var($query);
		$list = $this->getRows();

    if (isset($params->isLite) && $params->isLite)
    {
        return $list;
    }
    $this->last_query_products =$this->getLastQuery();
	//	print $this->getWhere();
  //	print $this->getLastQuery();

		$attributes = array();
		$attributesList = array();

		$varintyList = array();



//print_r($list);
		// zapamtuju si klíče
		$key_list = array();
		for ($i=0;$i < count($list);$i++)
		{
		//	print $list[$i]->page_id;
			if (isset($list[$i]->page_id)) {
				array_push($key_list, $list[$i]->page_id);
			} else {
				break;
			}
		}

		if(isset($params->withAttribs))
		{
			if (count($key_list) > 0) {
				$attributes = new models_Attributes();
				$attributesList = $attributes->get_attribute_value_association2($key_list, LANG_TRANSLATOR);
        
        
        $attributesMultiValuesList = $attributes->get_attribute_multi_values($key_list);
       // print $attributes->getLastQuery();
        //print_r($attributesMultiValuesList);
			}
		}
		$params->withVarianty = true;
		if(isset($params->withVarianty))
		{
			if (count($key_list) > 0) {
				$productVarianty = new models_ProductVarianty();

				$args = new ListArgs();
				$args->doklad_id = $key_list;
				$args->limit = 10000;
				$args->orderBy = 't1.product_id ASC, t1.order ASC, t1.code ASC, t1.name ASC';
				$variantyList = $productVarianty->getList($args);


			}
		}

		$cenyList = array();
		if(defined("USER_ID"))
		{
			// musím se zpat na cenu

			$modelCatalog = new models_CatalogFirem();
			$catalog = $modelCatalog->getDetailByVlastnikId(USER_ID);

			$cenik_id = (int) $eshopSettings->get("CENIK_ID");
			if (isset($catalog->cenik_id) && $catalog->cenik_id > 0) {
				$cenik_id = (int) $catalog->cenik_id;
			}



			if (isset($catalog) && $cenik_id > 0) {


				if (count($key_list) > 0) {
					$model = new models_ProductCena();

					$args = new ListArgs();
					$args->product_id = $key_list;
					$args->cenik_id = $catalog->cenik_id;
					$args->platne = date("Ymd");
          $args->limit = 10000000;
					$cenyList = $model->getList($args);
				}
			}

		} else {
			// veřejná cena
			$cenik_id = (int) $eshopSettings->get("CENIK_ID");

		//	print $cenik_id;

			if (count($key_list) > 0 && $cenik_id > 0) {
				$model = new models_ProductCena();

				$args = new ListArgs();
				$args->product_id = $key_list;
				$args->cenik_id = $cenik_id;
        $args->limit = 10000000;
				$args->platne = date("Ymd");
				$cenyList = $model->getList($args);

			//	print_r($cenyList);
			}



		}





		if(isset($params->thumb_width) && !empty($params->thumb_height))
		{
			$imageController = new ImageController();
		}

		//print_r($key_list);
		for ($i=0;$i < count($list);$i++)
		{
			//$list[$i]->link = $list[$i]->url;
			$list[$i]->link_edit = URL_HOME . "sortiment/edit_product?id=" . $list[$i]->page_id;

			$list[$i]->pricelist = array();
			foreach ($cenyList as $key => $val) {

				if ($val->product_id == $list[$i]->page_id) {
					array_push($list[$i]->pricelist, $val);
					break;
				}
			}
			// v adminu nesmím přepisovat ceny!
			if (!defined('ADMIN') || $params->vypocetCeny) {
				$this->vypocetCenyNaRadku($list[$i]);
			}
			$list[$i]->attributes = array();
      if (is_array($attributesList))
      {
  			foreach ($attributesList as $key => $val) {
  
  				if ($val->product_id == $list[$i]->page_id) {
          
          
          
          if ($val->multi_select == 1)
          {
             $val->attribute_id = array();
             $val->value_name = array();
            foreach ($attributesMultiValuesList as $key2 => $value2){
              if ($value2->id == $val->id)
              {
                 array_push($val->value_name,$value2->value_name);
                 array_push($val->attribute_id,$value2->attribute_id);
              } 
            }
          }
          
          
          
  					array_push($list[$i]->attributes, $val);
  				}
  			}      
      }

			$list[$i]->variantyList = array();

			$minPriceVarianty = 0;
			$maxPriceVarianty = 0;

			if (isset($variantyList) && is_array($variantyList)) {


			foreach ($variantyList as $key => $val) {

				if ($val->product_id == $list[$i]->page_id) {

					if ($val->price > $minPriceVarianty) {
						$minPriceVarianty = $val->price;
					}

					if ($val->price < $maxPriceVarianty) {
						$maxPriceVarianty = $val->price;
					}

					array_push($list[$i]->variantyList, $val);
				}
			}
							}

			$list[$i]->variantyPrice = false;
			if ($minPriceVarianty <> $maxPriceVarianty) {
				$list[$i]->variantyPrice = true;
			}

			$list[$i]->variantyPriceMin = $minPriceVarianty;
			$list[$i]->variantyPriceMax = $maxPriceVarianty;

/*
			if (!empty($list[$i]->file) && isset($params->thumb_width) && isset($params->thumb_height)) {

				if (isset($params->thumb_width)) {
					$thumb_width = $params->thumb_width;
				}

				if (isset($params->thumb_height)) {
					$thumb_height = $params->thumb_height;
				}

				$list[$i]->thumb = '<img src="' . $imageController->get_thumb($list[$i]->file,$thumb_width,$thumb_height,null,false,true) . '" class="imgobal" />';
			} else {
				$list[$i]->thumb = '';
			}*/



		}
	//	print_r($list);
		return $list;

	}

	private function vypocetCenyNaRadku($radek)
	{
    /* print "castka_dph:" . $radek->castka_dph."<br />";
     print "cena_sdph:" . $radek->cena_sdph."<br />";   */
		$eshopSettings = G_EshopSetting::instance();
	//	$eshopSettings = G_Setting::instance();
		if ($eshopSettings->get("PRICE_TAX") == HlavniCena::BezDane) {
			$radek->puvodni_cena = $radek->prodcena;
			$radek->puvodni_cena_sdph = $radek->prodcena_sdph;
		} else {
			$radek->puvodni_cena = $radek->prodcena_sdph;
		}

		if (isset($radek->pricelist) && count($radek->pricelist) > 0) {
			$cenik = $radek->pricelist[0];

		//			print_r($cenik);
			//		print_r($cenik);
			$radek->sleva = $cenik->sleva;
			$radek->druh_slevy = $cenik->typ_slevy;

			if ($cenik->cenik_cena > 0) {
				$radek->prodcena = $cenik->cenik_cena;
			}
			$radek->bezna_cena = $radek->prodcena_sdph;
			if ($eshopSettings->get("PRICE_TAX") == HlavniCena::BezDane) {
				$radek->bezna_cena = $radek->prodcena;
			}
		//	print $radek->bezna_cena . ">" . $eshopSettings->get("PRICE_TAX");
		}

   // print_R($radek);
    // sazba dph
		$sazba_dph = ($radek->value_dph>0) ? $radek->value_dph/100 : $radek->value_dph * 1;
 //    print "sazba_dph:" . $sazba_dph . "<br>";
		$vyse_slevy = 0;
		$znak_slevy = "&nbsp;Kč";
		if ($radek->sleva <> 0) {
    
    			$radek->bezna_cena = $radek->prodcena_sdph;
			if ($eshopSettings->get("PRICE_TAX") == HlavniCena::BezDane) {
				$radek->bezna_cena = $radek->prodcena;
			}
      
			// výpočet slevy
			if ($radek->druh_slevy == "%" && $radek->prodcena <> 0) {
				$vyse_slevy = $radek->prodcena * $radek->sleva / 100;
				$znak_slevy = "%";
			} else {
				$vyse_slevy = $radek->sleva;
			}
		}
    
  

    if ($eshopSettings->get("PLATCE_DPH") == PlatceDane::Ano) {
				$zaklad = $radek->prodcena + $vyse_slevy;
    		$radek->castka_dph = $sazba_dph * $zaklad;
    		$radek->cena_sdph = $zaklad + $radek->castka_dph;
    		$radek->cena_bezdph = $zaklad;		
    
    }  else {
				$zaklad = $radek->prodcena_sdph + $vyse_slevy;
    		$radek->castka_dph = $sazba_dph * $zaklad;
    		$radek->cena_sdph = $zaklad + $radek->castka_dph;
            		$radek->cena_bezdph = $zaklad + $radek->castka_dph;
    	//	$radek->cena_bezdph = $zaklad;    
    
    }
    
		


		$radek->sleva_label = round($radek->sleva) . $znak_slevy;
  //  print $radek->sleva_label;
		$radek->sleva_bc = 0;
		$radek->sleva_bc_label = "";
    
    if ($eshopSettings->get("PRICE_TAX") == HlavniCena::BezDane) {
  		if ($radek->bezna_cena > $radek->cena_bezdph) {
  			$radek->sleva_bc = $radek->bezna_cena - $radek->cena_bezdph;
  			$radek->sleva_bc_label = round($radek->bezna_cena - $radek->cena_bezdph) . "&nbsp;Kč";
  		}   
    } else {
    
        		if ($radek->bezna_cena > $radek->cena_sdph) {
  			$radek->sleva_bc = $radek->bezna_cena - $radek->cena_sdph;
  			$radek->sleva_bc_label = round($radek->bezna_cena - $radek->cena_sdph) . "&nbsp;Kč";
  		}   
    }
      
     /* 
      if ($radek->bezna_cena > $radek->cena_sdph) {
			$radek->sleva_bc = $radek->bezna_cena - $radek->cena_sdph;
			$radek->sleva_bc_label = round($radek->cena_sdph - $radek->bezna_cena) . " Kč";
		} */
    
    /*   
    print "castka_dph:" . $radek->castka_dph."<br />";
    print "cena_sdph:" . $radek->cena_sdph."<br />";
     */

	}
	public function convertProductToPages()
	{

		$this->start_transakce();
		//$query = "select * from mm_sklad order by klic_ma limit 1900, 100";
		$query = "select * from mm_sklad order by klic_ma limit 2000, 500";
		$clanky = $this->get_results($query);
		$all_query_ok = true;

		for ($i = 0; $i < count($clanky);$i++)
		{
			$data = array();
			$version = 0;
			$data["id"] = $clanky[$i]->klic_ma;
			$data["cislo"] = $clanky[$i]->cislo_mat;
			$data["user_id"] = $clanky[$i]->uid_user;

			$data["TimeStamp"] = $clanky[$i]->caszapsani;
			$data["ChangeTimeStamp"] = $clanky[$i]->caszapsani;

			//$data["prodcena"] = $clanky[$i]->prodcena;

			$data["skupina_id"] = $clanky[$i]->skupina;
			$data["code01"] = $clanky[$i]->code01;
			$data["code02"] = $clanky[$i]->code02;
			$data["code03"] = $clanky[$i]->code03;

			$data["hl_mj_id"] = $clanky[$i]->hl_mj;
			$data["mj_id"] = $clanky[$i]->mj;

			$data["foto_id"] = $clanky[$i]->uid_foto;
			$data["aktivni"] = $clanky[$i]->aktivni;
			$data["vyrobce_id"] = $clanky[$i]->vyrobce;
			$data["qty"] = $clanky[$i]->qty;

			//$data["user_id"] = 3; // admin
			$data["version"] = $version;
			//$data["level"] = $clanky[$i]->poradi;
			$data["category_id"] = ($clanky[$i]->category == 0) ? "NULL" : $clanky[$i]->category;
			//	$data["last_modified_date"] = $clanky[$i]->caszapsani;
			//$data["status"] = ($clanky[$i]->kos == 1) ? 0 : 1;
			//$data["type_id"] = 1;

			if ($this->insertRecords($this->getTableName(),$data)) {
				$this->commit ? null : $all_query_ok = false;
				$page_id = $this->insert_id;
				$versionData = array();
				$versionData["page_id"] = $page_id;
				$versionData["version"] = $version;
				$versionData["user_id"] = $clanky[$i]->uid_user;; // admin
				//	$versionData["caszapsani"] = $clanky[$i]->caszapsani;

				$versionData["category_id"] = ($clanky[$i]->category == 0) ? "NULL" : $clanky[$i]->category;
				$versionData["vyrobce_id"] = $clanky[$i]->vyrobce;
				$versionData["skupina_id"] = $clanky[$i]->skupina;
				$versionData["hl_mj_id"] = $clanky[$i]->hl_mj;
				$versionData["mj_id"] = $clanky[$i]->mj;

				// CZ version
				$versionData["lang_id"] = 6;
				$versionData["title"] = $clanky[$i]->nazev_mat_cs;
				$versionData["description"] = $clanky[$i]->popis;
				$versionData["pagetitle"] = $clanky[$i]->nazev_mat_cs;
				$versionData["pagedescription"] = $clanky[$i]->popis;
				//$versionData["pagekeywords"] = $clanky[$i]->keywords_cs;
				$versionData["url"] = strToUrl($clanky[$i]->nazev_mat_cs);

				$versionData["prodcena"] = $clanky[$i]->prodcena;
				$versionData["bezna_cena"] = $clanky[$i]->bezna_cena;

				$versionData["cislo1"] = $clanky[$i]->cislo1;
				$versionData["cislo2"] = $clanky[$i]->cislo2;
				$versionData["cislo3"] = $clanky[$i]->cislo3;
				$versionData["cislo4"] = $clanky[$i]->cislo4;
				$versionData["cislo5"] = $clanky[$i]->cislo5;

				$versionData["polozka1"] = $clanky[$i]->polozka1;
				$versionData["polozka2"] = $clanky[$i]->polozka2;
				$versionData["polozka3"] = $clanky[$i]->polozka3;
				$versionData["polozka4"] = $clanky[$i]->polozka4;
				$versionData["polozka5"] = $clanky[$i]->polozka5;

				$versionData["TimeStamp"] = $clanky[$i]->caszapsani;
				$versionData["ChangeTimeStamp"] = $clanky[$i]->caszapsani;

				$this->insertRecords("mm_products_version",$versionData);
				$this->commit ? null : $all_query_ok = false;
/*
   // EN version
   $versionData["lang_id"] = 4;
   $versionData["title"] = $clanky[$i]->nazev_en;
   $versionData["description"] = $clanky[$i]->text_en;
   $versionData["pagetitle"] = $clanky[$i]->nazev_en;
   $versionData["pagedescription"] = $clanky[$i]->description_en;
   $versionData["pagekeywords"] = $clanky[$i]->keywords_en;
   $versionData["url"] = $clanky[$i]->url_friendly_en;
   $this->insertRecords("mm_category_version",$versionData);
*/
/*
   // DE version
   $versionData["lang_id"] = 3;
   $versionData["title"] = $clanky[$i]->nazev_de;
   $versionData["description"] = $clanky[$i]->text_de;
   $versionData["pagetitle"] = $clanky[$i]->nazev_de;
   $versionData["pagedescription"] = $clanky[$i]->description_de;
   $versionData["pagekeywords"] = $clanky[$i]->keywords_de;
   $versionData["url"] = $clanky[$i]->url_friendly_de;

   $this->insertRecords("mm_category_version",$versionData);

   // RU version
   $versionData["lang_id"] = 5;
   $versionData["title"] = $clanky[$i]->nazev_ru;
   $versionData["description"] = $clanky[$i]->text_ru;
   $versionData["pagetitle"] = $clanky[$i]->nazev_ru;
   $versionData["pagedescription"] = $clanky[$i]->description_ru;
   $versionData["pagekeywords"] = $clanky[$i]->keywords_ru;
   $versionData["url"] = $clanky[$i]->url_friendly_ru;
   $this->insertRecords("mm_version",$versionData);
*/
			}
		}
		$this->konec_transakce($all_query_ok);
	}


	public function getObratyList($params=array())
	{

		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR ;
		}
		$this->clearWhere();

		$language1 = "";
		$language2 = "";
		$language3 = "";
		$language4 = "";
		$language5 = "";
		$language6 = "";
		$language7 = "";
		$language8 = "";
		$language9 = "";
		$language10 = "";
		$language11 = "";
		if(isset($params['lang']) && !empty($params['lang']))
		{
			$this->addWhere("l.code='" . $params['lang'] . "'");

		}
		$language1 = " and cv.lang_id=v.lang_id";
		if (isset($params['attributes']) && is_array($params['attributes'])) {

			foreach ($params['attributes'] as $key){
				$this->addWhere("p.id in
					(select product_id from mm_product_attribute_value_association ava where ava.attribute_id=" . $key . ")");
			}
		}


		if (isset($params['aktivni']) && is_numeric($params['aktivni'])) {
			$this->addWhere(" p.aktivni='" . $params['aktivni'] . "' ");
		}

		if (isset($params['status']) && is_numeric($params['status'])) {

			switch($params['status'])
			{
				case 1:
					$this->addWhere("p.aktivni=1");
					$this->addWhere("p.isDeleted=0");
					break;
				case 2:
					$this->addWhere("p.aktivni=0");
					$this->addWhere("p.isDeleted=0");
					break;
				case 3:
					$this->addWhere("p.isDeleted=1");
					break;
			}

		}

		if (isset($params['deleted']) && is_numeric($params['deleted'])) {
			$this->addWhere(" p.isDeleted=" . $params['deleted']);
		} else {
			$this->addWhere(" p.isDeleted=0");
		}

		if (isset($params['typ_sort']) && !empty($params['typ_sort'])) {
			$this->addWhere(" p.typ_sort='" . $params['typ_sort'] . "' ");
		}

		if (isset($params['skupina']) && is_int($params['skupina']) && ($params['skupina']) > 0) {
			$this->addWhere(" p.skupina_id=" . $params['skupina'] . " ");
		}
		if (isset($params['vyrobce']) && is_int($params['vyrobce']) && ($params['vyrobce']) > 0) {
			$this->addWhere(" p.vyrobce_id=" . $params['vyrobce'] . " ");
		}
		//print $params['kategorie'];
		if (isset($params['kategorie']) && is_int($params['kategorie'])&& ($params['kategorie']) > 0) {
			//print $params['kategorie'];
			$this->addWhere(" p.category_id=" . $params['kategorie'] . "");
		}

		if (isset($params['from_price']) && is_numeric($params['from_price'])) {
			$price = (int) $params['from_price'];
			$this->addWhere("v.prodcena>=" . $price);
		}
		if (isset($params['to_price']) && is_numeric($params['to_price'])) {
			$price = (int) $params['to_price'];
			$this->addWhere("v.prodcena<=" . $price);
		}

		if (isset($params['fulltext']) && !empty($params['fulltext'])) {
			$this->addWhere("(p.cislo like '%" . $params['fulltext'] . "%' or v.title like '%" . $params['fulltext'] . "%') ");
		}

		if (isset($params['child']) && is_numeric($params['child']))
		{
			$this->addWhere("concat(
	    ifnull(c11.id,''),'|',
	    ifnull(c10.id,''),'|',
	    ifnull(c9.id,''),'|',
	    ifnull(c8.id,''),'|',
	    ifnull(c7.id,''),'|',
	    ifnull(c6.id,''),'|',
	    ifnull(c5.id,''),'|',
	    ifnull(c4.id,''),'|',
	    ifnull(c3.id,''),'|',
	    ifnull(c2.id,''),'|'
		    ) like '%|" . $params['child'] . "|%'");
		}

		if(isset($params['date_from']) && !empty($params['date_from']))
		{
			$this->addWhere("oh.order_date >= '" . $params['date_from'] . "'");
		}

		if(isset($params['date_to']) && !empty($params['date_to']))
		{
			$this->addWhere("oh.order_date <= '" . $params['date_to'] . "'");
		}
		if(isset($params['page_id']) && is_int($params['page_id']))
		{
			$this->addWhere("v.page_id=" . $params['page_id']);
		}

		if(isset($params['cislo']) && is_int($params['cislo']))
		{
			$this->addWhere("p.cislo='" . $params['cislo'] . "'");
		}

		// moznost vytažení konkrétní verze stránky
		if(isset($params['version']) && is_int($params['version']))
		{
			$this->addWhere("v.version=" . $params['version']);
			$version = "and v.version=" . $params['version'];
			$version1 = "and cv.version=" . $params['version'];
		} else {
			$version = "and v.version=p.version";
			$version1 = "and cv.version=c2.version";
		}

		$this->addWhere("od.qty>0");

		if (!isset($params['page'])) {
			$params['page'] = 1;
		}
		if (!isset($params['limit'])) {
			$params['limit'] = 100;
		}
		$this->setLimit($params['page'], $params['limit']);
		$this->setOrderBy($params['order'], 'obrat_qty DESC');

		$this->setSelect("p.*,sum(od.qty) as obrat_qty,sum(od.qty*od.price) as obrat_price,
		sum(od.qty*(od.price-v.bezna_cena)) as zisk,avg(od.price) price_avg,
		p.TimeStamp as PageTimeStamp,
		p.ChangeTimeStamp as PageChangeTimeStamp,
		v.*,l.code,cv.title as nazev_category,
		t2.name AS nazev_skupina,
		vb.name as nazev_vyrobce,
		t3.name as nazev_mj,
		t4.file,
		t4.description as popis_foto
		");



		$ProductVersionEntity = new ProductVersionEntity();

		$this->setFrom($ProductVersionEntity->getTableName() . " AS v
		 left join " . $this->getTableName() . " p on v.page_id = p.id " . $version . "
		left join " . T_LANGUAGE . " l on v.lang_id=l.id
		LEFT JOIN " . T_SHOP_PRODUCT_CATEGORY . " AS t2 ON v.skupina_id = t2.id
		LEFT JOIN " . T_SHOP_ORDER_DETAILS . " AS od ON od.product_id = p.id
		LEFT JOIN " . T_SHOP_ORDERS . " AS oh ON oh.id = od.doklad_id
		left join " . T_SHOP_PRODUCT_VYROBCE . " vb ON v.vyrobce_id = vb.id
	   	left join " . T_CATEGORY . " c2 on v.category_id=c2.id
		left join " . T_CATEGORY_VERSION . " cv on c2.id = cv.page_id " . $version1 . $language1 . "
		LEFT JOIN " . T_MJ . " AS t3 ON v.hl_mj_id = t3.id
		LEFT JOIN " . T_FOTO . " AS t4 ON p.foto_id = t4.id");

		$this->setGroupBy('od.product_id');

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$this->limit = $this->getLimitQuery();
		$list = $this->getRows();

		//	print $this->getWhere();
		//	print $this->getLastQuery();
		return $list;

	}


	/**
	 * Výrobci uvedení v produktech
	 * **/
	public function getVyrobciProductList(IListArgs $args = null)
	{

		if (is_null($args)) {
			$args = new ListArgs();
		}
		$args->orderBy = 'vb.name ASC';
		$args->groupBy = 'vb.id';
		$args->select = "vb.id,vb.name,count(p.id) as pocet,min(p.min_prodcena) as cena_od,max(p.max_prodcena) as cena_do,
  min(p.min_prodcena_sdph)  as cenasdph_od,
 max(p.max_prodcena_sdph)  as cenasdph_do ";

		/*
		$args->select = "vb.id,vb.name,count(p.id) as pocet,min(v.prodcena) as cena_od,max(v.prodcena) as cena_do,
  min(case when dph.value <> 0 then v.prodcena*dph.value/100+v.prodcena else v.prodcena end)  as cenasdph_od,
  max(case when dph.value <> 0 then v.prodcena*dph.value/100+v.prodcena else v.prodcena end)  as cenasdph_do ";
		*/
		$list = $this->getList($args);
	//	print $this->getLastQuery();
		return $list;
	}

	/**
	 * Skupiny uvedené v produktech
	 * **/
	public function getSkupinyProductList(IListArgs $args = null)
	{


  $ProductCategory = new models_ProductCategory();
  
  $groupList = $ProductCategory->getList();
 
  $groups = array(); 
  foreach ($groupList as $key => $group)
  {
  
      $groups[$group->id] = $group->id;
  }
  if (count($groups) == 0)
  {
     $groups = 9999999;
  }

 // print_R($groups);
		if (is_null($args)) {
			$args = new ListArgs();
		}
		$args->skupina	 = $groups;
		$args->orderBy	 = 't4.name ASC';
		$args->isLite	 = true;
		$args->groupBy = 't4.group_id';
		$args->select = "t4.group_id,t4.name,count(p.id) as pocet,min(v.prodcena) as cena_od,max(v.prodcena) as cena_do";
		$list = $this->getList($args);
    //print $this->getLastQuery();
		return $list;
	}
}


<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_ProductAudit extends G_Service{

	function __construct()
	{
		parent::__construct(T_PRODUCT_AUDIT);
	}
	private $photos = array();
	private $prices = array();
	private $attributes = array();
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
		//print_r($list);
		if (count($list) > 0) {

		//	print_r($list[0]);
			$obj->id = $list[0]->page_id;
			$obj->version = $list[0]->version;
			$obj->level = $list[0]->level;
			$obj->TimeStamp = $list[0]->TimeStamp;
			$obj->ChangeTimeStamp = $list[0]->ChangeTimeStamp;
			$obj->category_id = $list[0]->category_id;
			$obj->nazev_category = $list[0]->nazev_category;

			$obj->dph_id = $list[0]->dph_id;
			$obj->nazev_dph = $list[0]->nazev_dph;
			$obj->value_dph = $list[0]->value_dph;

			$obj->sleva = $list[0]->sleva;
			$obj->sleva_label = $list[0]->sleva_label;
			$obj->druh_slevy = $list[0]->druh_slevy;

			$obj->castka_dph = $list[0]->castka_dph;
			$obj->cena_sdph = $list[0]->cena_sdph;
			$obj->cena_bezdph =$list[0]->cena_bezdph;

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
			$obj->nazev_mj = $list[0]->nazev_mj;
			$obj->mj_id = $list[0]->mj_id;
			$obj->aktivni = $list[0]->aktivni;
			$obj->qty = $list[0]->qty;
			$obj->foto_id = $list[0]->foto_id;


			$obj->title = $list[0]->title;
			$obj->description = $list[0]->description;
			$obj->pagetitle = !empty($list[0]->pagetitle) ? $list[0]->pagetitle : $list[0]->title;
			$obj->pagekeywords = $list[0]->pagekeywords;
			$obj->pagedescription = $list[0]->pagedescription;

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

			$obj->link = URL_HOME . get_categorytourl($list[0]->serial_cat_url) . '/'. $list[0]->page_id . '-' . strToUrl($list[0]->title) . '.html';


			$obj->serial_cat_url = $list[0]->serial_cat_url;
			$obj->serial_cat_title = $list[0]->serial_cat_title;
			$obj->serial_cat_id = $list[0]->serial_cat_id;


			//$obj->public_date = $list[0]->public_date;
			//$obj->poradi = $list[0]->poradi;
			for($i=0;$i<count($list);$i++)
			{
				$title = "title_" . $list[$i]->code;
				$obj->$title = $list[$i]->title;

				$name = "perex_" . $list[$i]->code;
				$obj->$name = $list[$i]->perex;

				$description = "description_" . $list[$i]->code;
				$obj->$description = $list[$i]->description;

				$name = "pagetitle_" . $list[$i]->code;
				$obj->$name = $list[$i]->pagetitle;

				$name = "pagekeywords_" . $list[$i]->code;
				$obj->$name = $list[$i]->pagekeywords;

				$pagedescription = "pagedescription_" . $list[$i]->code;
				$obj->$pagedescription = $list[$i]->pagedescription;

				$name = "link_" . $list[$i]->code;
				$obj->$name = URL_HOME2 . $list[$i]->code . "/" . get_categorytourl($list[$i]->serial_cat_url) . '/'. $list[$i]->page_id . '-' . strToUrl($list[$i]->title) . '.html';

				$name = "serial_cat_url_" . $list[$i]->code;
				$obj->$name = $list[$i]->serial_cat_url;

				$name = "serial_cat_title_" . $list[$i]->code;
				$obj->$name = $list[$i]->serial_cat_title;

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


				if ($list[$i]->code == LANG_TRANSLATOR) {

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
					$obj->perex 	= $list[$i]->perex;

				}


			}
			return $obj;
		}


		if (count($list) == 1) {
			return $list[0];
		}
		return false;
	}
	public function getDetailByCislo($cislo,$lang=null)
	{
		$params = array();
		$params["cislo"] = $cislo;
		//	$params['lang'] = $lang;
		if ($lang != null) {
			$params['lang'] = $lang;
		}


		$params['page'] = 1;
		$params['limit'] = 1000;

		//print_r($params);
		return $this->getDetail($params);
	}
	public function getList($params=array())
	{

		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR ;
		}
		$this->clearWhere();

		$language1 = "";

		if(isset($params['lang']) && !empty($params['lang']))
		{
			$this->addWhere("l.code='" . $params['lang'] . "'");

		}

		$language1 = " and cv.lang_id=v.lang_id";


		if (isset($params['ip_adresa']) && !empty($params['ip_adresa'])) {
			$basket_id = $params['ip_adresa'];
			$this->addWhere("a.ip_adresa = '" . $basket_id . "'");
		}

		if (isset($params['user_id']) && is_numeric($params['user_id'])) {
			$basket_id = (int) $params['user_id'];
			$this->addWhere("a.user_id = " . $basket_id);
		}


		if (isset($params['attributes']) && is_array($params['attributes'])) {

			foreach ($params['attributes'] as $key){
				$this->addWhere("p.id in
					(select product_id from mm_product_attribute_value_association ava where ava.attribute_id=" . $key . ")");
			}
		}

		if (isset($params['not_product_id']) && is_int($params['not_product_id'])) {
			$this->addWhere(" p.id<> " . $params['not_product_id']);
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
			$this->addWhere("concat(vc.serial_cat_id,'|') like '%|" . $params['child'] . "|%'");
		}


		if(isset($params['page_id']) && is_int($params['page_id']))
		{
			$this->addWhere("v.page_id=" . $params['page_id']);
		}

		if(isset($params['user_id']) && is_int($params['user_id']))
		{
			$this->addWhere("a.user_id='" . $params['user_id'] . "'");
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
		} else {
			$version = "and v.version=p.version";
			$version1 = "and cv.version=c.version";
		}

		$limit = 100;
		if(isset($params['limit']) && is_int($params['limit']))
		{
			$limit = $params['limit'];
		}
		$page = 1;
		if(isset($params['page']) && is_int($params['page']))
		{
			$page = $params['page'];
		}
		$this->setLimit($page, $limit);

		$order = "";
		if(isset($params['order']))
		{
			$order = $params['order'];
		}

		$this->setOrderBy($order, 'v.title ASC');

		$this->setSelect("p.*,
		max(a.TimeStamp) as TimeStampMax,
		p.TimeStamp as PageTimeStamp,
		p.ChangeTimeStamp as PageChangeTimeStamp,
		v.*,l.code,cv.title as nazev_category,
		t2.name AS nazev_skupina,
		vb.name as nazev_vyrobce,
		dph.name as nazev_dph,
		dph.value as value_dph,
		t3.name as nazev_mj,
		t4.file,
		t4.description as popis_foto,
		vc.serial_cat_id,
		vc.serial_cat_title,
		vc.serial_cat_url
		");

		$this->setGroupBy("a.product_id,a.user_id");
		$ProductEntity = new ProductEntity();
		$ProductVersionEntity = new ProductVersionEntity();

		$this->setFrom($this->getTableName() . " a

		left join " .  $ProductVersionEntity->getTableName() . " AS v on v.page_id = a.product_id
		left join " . $ProductEntity->getTableName() . " p on v.page_id = p.id " . $version .
		" left join " . T_LANGUAGE . " l on v.lang_id=l.id
		LEFT JOIN " . T_SHOP_PRODUCT_CATEGORY . " AS t2 ON v.skupina_id = t2.id
		left join " . T_SHOP_PRODUCT_VYROBCE . " vb ON v.vyrobce_id = vb.id
		LEFT JOIN " . T_CATEGORY . " c ON (v.category_id = c.id)
		left join " . T_CATEGORY_VERSION . " cv on c.id = cv.page_id " . $version1 . $language1 . "

	   	left join view_category vc on vc.category_id=v.category_id and vc.lang_id=l.id

		LEFT JOIN " . T_MJ . " AS t3 ON v.hl_mj_id = t3.id
		LEFT JOIN " . T_DPH . " AS dph ON p.dph_id = dph.id
		LEFT JOIN " . T_FOTO . " AS t4 ON p.foto_id = t4.id");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();

	//	print $this->getWhere();
	//print $this->getLastQuery();


		for ($i=0;$i < count($list);$i++)
		{
			//$list[$i]->link = $list[$i]->url;

			$castka_dph = ($list[$i]->value_dph>0) ? $list[$i]->value_dph/100 : $list[$i]->value_dph * 1;

			$vyse_slevy = 0;
			$znak_slevy = " Kč";
			if ($list[$i]->sleva <> 0) {
				// výpočet slevy
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

		}
		//print_r($list);
		return $list;

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

		$this->addWhere("order_qty>0");

		if (!isset($params['page'])) {
			$params['page'] = 1;
		}
		if (!isset($params['limit'])) {
			$params['limit'] = 100;
		}
		$this->setLimit($params['page'], $params['limit']);
		$this->setOrderBy($params['order'], 'obrat_qty DESC');

		$this->setSelect("p.*,sum(od.order_qty) as obrat_qty,sum(od.order_qty*od.price) as obrat_price,
		sum(od.order_qty*(od.price-v.bezna_cena)) as zisk,avg(od.price) price_avg,
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
		$list = $this->getRows();

		//	print $this->getWhere();
		//	print $this->getLastQuery();
		return $list;

	}
}
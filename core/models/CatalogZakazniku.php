<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once(PATH_ROOT . "core/models/Catalog.php");
class models_CatalogZakazniku extends models_Catalog{

	function __construct()
	{
		parent::__construct(T_CATALOG_FIREM);
	}




	public function getList(IListArgs $args = null)
	{
		$args = $this->getListArgs($args);

		$language1 = " and cv.lang_id=v.lang_id";
		$language2 = " and clgv.lang_id=v.lang_id";

		// moznost vytažení konkrétní verze stránky
		if(isset($args->version) && isInt($args->version))
		{
			$this->addWhere("v.version=" . $args->version);
			$version = "and v.version=" . $args->version;
		} else {
			$version = "and v.version=p.version";
			$version1 = "and cv.version=c.version";
		}



		if(isset($args->title) && !empty($args->title))
		{
			$this->addWhere("v.title like '" . $args->title . "%'");
		}



	//	print_r($args);

		$this->setSelect("v.*,p.id,p.vlastnik_id,p.status_id,
		u1.nick as user_add,
		u2.nick as user_edit,
		u3.nick as user_vlastnik,
		l.code,cv.title as nazev_category,
		t4.file,t4.description as popis_foto,
		logo.file as logo_file,
		p.foto_id,
    		vc.serial_cat_id,
		vc.serial_cat_title,
		vc.serial_cat_url,
		pc.name as cenik_name
		");

		$CategoryVersionEntity = new CatalogFiremVersionEntity();

		$this->setFrom($CategoryVersionEntity->getTableName() . " v
		inner join " . $this->getTableName() . " p on v.page_id = p.id " . $version . "
		LEFT JOIN " . T_USERS . " AS u1 ON p.user_id = u1.id
		LEFT JOIN " . T_USERS . " AS u2 ON p.user_edit_id = u2.id
		LEFT JOIN " . T_USERS . " AS u3 ON p.vlastnik_id = u3.id
		left join " . T_LANGUAGE . " l on v.lang_id=l.id
		LEFT JOIN " . T_CATEGORY . " c ON (v.category_id = c.id)
		left join " . T_CATEGORY_VERSION . " cv on c.id = cv.page_id " . $version1 . $language1 . "

	   	left join view_category vc on vc.category_id=v.category_id and vc.lang_id=l.id
		LEFT JOIN " . T_FOTO . " AS t4 ON p.foto_id = t4.id
	    LEFT JOIN " . T_FOTO . " AS logo ON p.logo_id = logo.id
		LEFT JOIN " . T_PRODUCT_CENIK . " AS pc ON p.cenik_id = pc.id
");


		//	$this->setFrom($this->getTableName() . " AS t1");

		//$list = $this->getRows();

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//	print $this->getWhere();


		$this->total = $this->get_var($query);
		$list = $this->getRows();
		//	print $this->getLastQuery();
		//return $list;
		for ($i=0;$i < count($list);$i++)
		{

			if (strtotime($list[$i]->cms_expired) <=time()) {
				$list[$i]->status = 'storno';
			}

			$date_diff = diff(date("Y-m-d H:i:s"), date("Y-m-d H:i:s",strtotime($list[$i]->cms_expired)+(24*3600)) );


			if ($date_diff["day"] <= 30  && $date_diff["day"] > 0) {
				$list[$i]->status = 'kvyrizeni';
			}

			$list[$i]->link = URL_HOME2 . "web/" . $list[$i]->page_id; // . "-" . strToUrl($list[$i]->title) . ".html";

			$list[$i]->link_edit =  URL_HOME . "edit_catalog?id=" . $list[$i]->page_id;


		}
		//	print_r($list);
		return $list;

	}

}
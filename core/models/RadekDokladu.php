<?php

/**
 * Předek pro Model entit tipu ŘÁDEKDOKLADU
 *
 * @version $Id$
 * @copyright 2011
 */

require_once("Radek.php");
abstract class models_RadekDokladu extends models_Radek {

	public static $entitaDoklad;
	public static $entitaRadky;

	function __construct($TDokladEntita, $TRadkyEntita)
	{


		if (empty($TDokladEntita)) {

			trigger_error(get_parent_class($this) . " - chybí parametry v konstruktoru!", E_USER_ERROR);
			return false;
		}




		$name = $TDokladEntita . "Entity";
		self::$entitaDoklad = $name;

		if (!is_subclass_of(self::$entitaDoklad,"DokladEntity")) {
			trigger_error(self::$entitaDoklad . " není typu DokladEntity!", E_USER_ERROR);
		}
		parent::__construct($TRadkyEntita);

	}



	public function getEntityList(IListArgs $params = null)
	{
		if (is_null($params)) {
			$params = new ListArgs();
		}
		if(isset($params->lang) && !empty($params->lang))
		{
			$this->addWhere("(l.code='" . $params->lang . "' or l.code is null)");
			//	$this->addWhere("(l.code='" . $params['lang'] . "')");
			$this->addWhere("(l.id=pv.lang_id or pv.lang_id is null)");

		} else {
			$this->addWhere("(l.code='" . LANG_TRANSLATOR . "' or l.code is null)");
		}


		if(isset($params->stav) && isInt($params->stav) && $params->stav > 0)
		{
			$this->addWhere("o.stav=" . $params->stav);
		}



		if (isset($params->fulltext) && !empty($params->fulltext)) {
			//	$this->addWhere("MATCH(o.code, o.shipping_first_name, o.shipping_last_name) AGAINST ('" . $params['fulltext'] . "' IN BOOLEAN MODE)");
			$this->addWhere("(o.code like '%" . $params->fulltext . "%' or
					o.shipping_first_name like '%" . $params->fulltext . "%' or
					t1.product_name like '%" . $params->fulltext . "%' or
					t1.product_code like '%" . $params->fulltext . "%' or
 					o.shipping_last_name like '%" . $params->fulltext . "%'
			)");
		}

		if(isset($params->id) && isInt($params->id))
		{
			$this->addWhere("t1.id=" . $params->id);
		}

		if(isset($params->isDeleted) && isInt($params->isDeleted))
		{
			$this->addWhere("t1.isDeleted=" . $params->isDeleted);
		} else {
			$this->addWhere("t1.isDeleted=0");
			$this->addWhere("o.isDeleted=0");
		}

		if(isset($params->doklad_id) && isInt($params->doklad_id))
		{
			$this->addWhere("t1.doklad_id=" . $params->doklad_id);
		}
		/*if (!isset($params['limit'])) {
		   $params['limit'] = 10000000000;
		   $params['page'] = 1;
		   }*/
		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getOrderBy(), 't1.doklad_id ASC,t1.order ASC ');

		$this->setSelect("t1.*");


		$doklad = new self::$entitaDoklad();

		//	$radek = new self::$entitaRadky();

		$this->setFrom($this->getTableName() . " AS t1

		LEFT JOIN " . $doklad->getTableName() . " AS o ON t1.doklad_id = o.id

		LEFT JOIN " . T_SHOP_PRODUCT . " AS p ON p.id = t1.product_id
		LEFT JOIN " . T_SHOP_PRODUCT_VERSION . " AS pv ON p.id = pv.page_id and p.version = pv.version
		left join " . T_LANGUAGE . " l on pv.lang_id=l.id
		LEFT JOIN ". T_DPH ." tax ON (t1.tax_id = tax.id)
		LEFT JOIN " . T_MJ . " AS t3 ON t1.mj_id = t3.id
		LEFT JOIN " . T_MJ . " AS t5 ON pv.hl_mj_id = t5.id
		LEFT JOIN " . T_FOTO . " AS t4 ON p.foto_id = t4.id

");


		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();

		$entityList = array();
		for ($i=0;$i<count($list);$i++)
		{
			$entityList[$i] = new parent::$entitaRadky($list[$i]);
		}
		return $entityList;


	}
	public function getList(IListArgs $params = null)
	{

		if (is_null($params)) {
			$params = new ListArgs();
		}
		if(isset($params->lang) && !empty($params->lang))
		{
			$this->addWhere("(l.code='" . $params->lang . "' or l.code is null)");
		//	$this->addWhere("(l.code='" . $params['lang'] . "')");
			$this->addWhere("(l.id=pv.lang_id or pv.lang_id is null)");

		} else {
			$this->addWhere("(l.code='" . LANG_TRANSLATOR . "' or l.code is null)");
		}


		if(isset($params->stav) && isInt($params->stav) && $params->stav > 0)
		{
			$this->addWhere("o.stav=" . $params->stav);
		}

		if(isset($params->storno) && isInt($params->storno))
		{
			$this->addWhere("o.storno=" . $params->storno);
		}

		if (isset($params->fulltext) && !empty($params->fulltext)) {
			//	$this->addWhere("MATCH(o.code, o.shipping_first_name, o.shipping_last_name) AGAINST ('" . $params['fulltext'] . "' IN BOOLEAN MODE)");
			$this->addWhere("(o.code like '%" . $params->fulltext . "%' or
					o.shipping_first_name like '%" . $params->fulltext . "%' or
					t1.product_name like '%" . $params->fulltext . "%' or
					t1.product_code like '%" . $params->fulltext . "%' or
 					o.shipping_last_name like '%" . $params->fulltext . "%'
			)");
		}

		if (isset($params->product_code) && !empty($params->product_code)) {
			$this->addWhere("t1.product_code = '" . $params->product_code . "'");
		}

		if(isset($params->id) && isInt($params->id))
		{
			$this->addWhere("t1.id=" . $params->id);
		}

		if(isset($params->isDeleted) && isInt($params->isDeleted))
		{
			$this->addWhere("t1.isDeleted=" . $params->isDeleted);
		} else {
			$this->addWhere("t1.isDeleted=0");
			$this->addWhere("o.isDeleted=0");
		}

		if(isset($params->doklad_id) && isInt($params->doklad_id))
		{
			$this->addWhere("t1.doklad_id=" . $params->doklad_id);
		}
		/*if (!isset($params['limit'])) {
			$params['limit'] = 10000000000;
			$params['page'] = 1;
		}*/
		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getOrderBy(), 't1.doklad_id ASC,t1.order ASC ');

		$this->setSelect("o.code as order_code,o.order_date,o.stav,o.storno,
		p.cislo,tax.name as tax_name,tax.value as tax_value,p.code01,
				t1.*,
		case when p.id is null then t1.mj_id else pv.hl_mj_id end as mj_id,

		case when p.id is null then t3.name else t5.name end as nazev_mj,
		case when p.id is not null then pv.title else t1.product_name end as product_name,
		case when p.id is not null then p.cislo else t1.product_code end as product_code,
		t4.file,pv.hl_mj_id,
		t4.description as popis_foto");


		$doklad = new self::$entitaDoklad();

	//	$radek = new self::$entitaRadky();

		$this->setFrom($this->getTableName() . " AS t1

		LEFT JOIN " . $doklad->getTableName() . " AS o ON t1.doklad_id = o.id

		LEFT JOIN " . T_SHOP_PRODUCT . " AS p ON p.id = t1.product_id
		LEFT JOIN " . T_SHOP_PRODUCT_VERSION . " AS pv ON p.id = pv.page_id and p.version = pv.version
		left join " . T_LANGUAGE . " l on pv.lang_id=l.id
		LEFT JOIN ". T_DPH ." tax ON (t1.tax_id = tax.id)
		LEFT JOIN " . T_MJ . " AS t3 ON t1.mj_id = t3.id
		LEFT JOIN " . T_MJ . " AS t5 ON pv.hl_mj_id = t5.id
		LEFT JOIN " . T_FOTO . " AS t4 ON p.foto_id = t4.id

");


		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();

		for ($i=0;$i<count($list);$i++)
		{

			$list[$i]->entity = new parent::$entitaRadky($list[$i]);

			$list[$i]->price_total = $list[$i]->price * $list[$i]->qty;
		}
	//		print $this->getLastQuery();
		return $list;

	}
}
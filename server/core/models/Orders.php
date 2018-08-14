<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */




class StatistikaObjednavek {

	public $cost_total = 0;

	public $count_total = 0;

	public $interval = "month";


}
require_once("Pages.php");
class models_Orders extends models_Pages{

	function __construct()
	{
		parent::__construct(T_SHOP_ORDERS);
	}

	public function getStats(IListArgs $params)
	{
		$stats = new StatistikaObjednavek();

		$params->groupBy = "t1.stav";
		$params->limit = "1000";
		$params->select = "count(*)  as count,sum(t1.cost_total) as cost_total,t1.stav";
		$list = $this->getList($params);

		$count = 0;
		$cost_total = 0;
		$list2 = array();
		for ($i=0;$i < count($list);$i++)
		{
			$list2[$i]->count = $list[$i]->count;
			$list2[$i]->cost_total = $list[$i]->cost_total;
			$list2[$i]->stav = $list[$i]->stav;


			$count += $list[$i]->count;
			$cost_total += $list[$i]->cost_total;
		}
		$stats->cost_total = $cost_total;
		$stats->count_total = $count;

		return $stats;
		$list2[($i+1)]->cost_total = $cost_total;
		$list2[($i+1)]->count = $count;
		return $list2;
	}

	public function getStatsPerDay(IListArgs $params)
	{
		$stats = new StatistikaObjednavek();

		$params->groupBy = " date(t1.TimeStamp)";
		$params->limit = "1000";
		$params->select = "count(*)  as count,sum(t1.cost_total) as cost_total,date(t1.TimeStamp) as date";
		$list = $this->getList($params);

		return $list;
		$list2 = array();
		for ($i=0;$i < count($list);$i++)
		{
			$list2[$i]->count = $list[$i]->count;
			$list2[$i]->cost_total = $list[$i]->cost_total;
			$list2[$i]->stav = $list[$i]->stav;


			$count += $list[$i]->count;
			$cost_total += $list[$i]->cost_total;
		}
		$stats->cost_total = $cost_total;
		$stats->count_total = $count;

		return $stats;
		$list2[($i+1)]->cost_total = $cost_total;
		$list2[($i+1)]->count = $count;
		return $list2;
	}

	public function getList(IListArgs $params = null)
	{

		$params = parent::getListArgs($params);


	//	print_r($params);
		$this->addWhere("t1.isDeleted=" . $params->isDeleted);
		if (isset($params->fulltext) && !empty($params->fulltext)) {
			$this->addWhere("(t1.code like '%" . $params->fulltext . "%' or
			t1.shipping_first_name like '%" . $params->fulltext . "%' or
			t1.shipping_email like '%" . $params->fulltext . "%' or
			t1.shipping_city like '%" . $params->fulltext . "%' or
			t1.shipping_last_name like '%" . $params->fulltext . "%') ");
		}

	//	$this->addWhere("t1.isDeleted=0");

		if(isset($params->id) && isInt($params->id))
		{
			$this->addWhere("t1.id=" . $params->id);
		}
		if(isset($params->code) && !empty($params->code))
		{
			$this->addWhere("t1.code='" .  $params->code . "'");
		}

		if(isset($params->transId) && !empty($params->transId))
		{
			$this->addWhere("t1.transId='" .  $params->transId . "'");
		}
    
    
		if(isset($params->shipping_ico) && !empty($params->shipping_ico))
		{
			$this->addWhere("t1.shipping_ico like '%" .  $params->shipping_ico . "%'");
		}

		if(isset($params->shipping_email) && !empty($params->shipping_email))
		{
			$this->addWhere("t1.shipping_email like '%" .  $params->shipping_email . "%'");
		}

		if(isset($params->shipping_first_name) && !empty($params->shipping_first_name))
		{
			$this->addWhere("t1.shipping_first_name like '%" .  $params->shipping_first_name . "%'");
		}

		if (isset($params->TimeStampFrom) && !empty($params->TimeStampFrom)) {
			$this->addWhere("t1.TimeStamp >= '" . $params->TimeStampFrom . "'");
		}

		if (isset($params->TimeStampTo) && !empty($params->TimeStampTo)) {
			$this->addWhere("t1.TimeStamp <= '" . $params->TimeStampTo . "'");
		}

    $code_from = trim($params->code_from);
		if (isset($params->code_from) && !empty($code_from)) {


			$this->addWhere("t1.code >= '" .$code_from . "'");
		}
    $code_to = trim($params->code_to);
		if (isset($params->code_to) && !empty($code_to)) {
		
			$this->addWhere("t1.code <= '" . $code_to . "'");
		}

		if (isset($params->df) && !empty($params->df)) {

			$date = date("Ymd",strtotime($params->df));
			$this->addWhere("t1.TimeStamp >= '" .$date . "'");
		}

		if (isset($params->dt) && !empty($params->dt)) {
			$date = date("Ymd",strtotime($params->dt));
			$this->addWhere("t1.TimeStamp <= '" . $date . "'");
		}
    
    
		if (isset($params->lowestPrice) && is_numeric($params->lowestPrice)) {
			$price = (int) $params->lowestPrice;
			$this->addWhere("ifnull(t1.cost_total,0)>=" . $price);
		}
		if (isset($params->highestPrice) && is_numeric($params->highestPrice)) {
			$price = (int) $params->highestPrice;
			$this->addWhere("ifnull(t1.cost_total,0)<=" . $price);
		}

    if(isset($params->download_hash) && !empty($params->download_hash))
		{
			$this->addWhere("t1.download_hash='" .  $params->download_hash . "'");
		}
    
    
		if(isset($params->storno) && isInt($params->storno))
		{
			$this->addWhere("t1.storno=" . $params->storno);
		}    
    
		if(isset($params->stav) && isInt($params->stav) && $params->stav > 0)
		{
			$this->addWhere("t1.stav=" . $params->stav);
		}
		if(isset($params->user_id) && isInt($params->user_id))
		{
			$this->addWhere("t1.customer_id=" . $params->user_id);
		}


		if(isset($params->groupBy) && !empty($params->groupBy))
		{
			$this->setGroupBy($params->groupBy);
		}


		$this->setOrderBy($params->getOrderBy(), 't1.TimeStamp DESC,t1.code ASC');

		if(isset($params->select) && !empty($params->select))
		{
			$this->setSelect($params->select);
		} else {
			$this->setSelect("t1.*,dv.name as nazev_dopravy,pv.name as nazev_platby,t4.name as nazev_stav,
case when h.id is not null then 1 else 0 end as isHeureka, u.nick,f.code as faktura_code,t2.kod_dopravce,
h.summary as h_summary,h.total_rating as h_total_rating,h.summary as h_summary, h.plus as h_plus, h.minus as h_minus,
h.communication as h_communication,h.delivery_time as h_delivery_time,h.transport_quality as h_transport_quality,h.web_usability as h_web_usability

");
		}
		$this->setFrom($this->getTableName() . " as t1
		left join " . T_LANGUAGE . " l on '" . LANG_TRANSLATOR . "'=l.code
		left join " . T_SHOP_ZPUSOB_DOPRAVY . " t2 on t1.shipping_transfer=t2.id
		left join " . T_SHOP_ZPUSOB_DOPRAVY_VERSION . " dv on dv.page_id=t2.id and dv.lang_id=l.id

		left join " . T_SHOP_ZPUSOB_PLATBY . " t3 on t1.shipping_pay=t3.id
		left join " . T_SHOP_ZPUSOB_PLATBY_VERSION . " pv on pv.page_id=t3.id and pv.lang_id=l.id
		left join " . T_ORDER_STATUS . " t4 on t4.id= t1.stav
		left join " . T_USERS . " u on u.id= t1.user_id
		left join " . T_FAKTURY . " f on f.id= t1.faktura_id
		left join " . T_HEUREKA_REPORT . " h on h.order_id= t1.id
		left join " . T_SHOP_PLATBY . " pl on pl.transId= t1.transId
");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
	//	print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();

	//	print $this->getLastQuery();

		for ($i=0;$i < count($list);$i++)
		{

			$list[$i]->status = '';
			if (isset($list[$i]->stav)) {
				switch($list[$i]->stav)
				{
					case 1:
						$list[$i]->status = 'prijata';
						break;
					case 2:
						//	$stav = "Vyexpedovaná";
						$list[$i]->status = 'expedice';
						break;
					case 3:
						$list[$i]->status = 'kvyrizeni';
						break;
					case 4:
						$list[$i]->status = 'vyrizena';
						break;
					default:
						break;
				}
			}
			if (isset($list[$i]->storno) && $list[$i]->storno == 1) {
				$list[$i]->status = 'storno';
			}

			if (isset($list[$i]->id)) {
				$list[$i]->link_edit = '/admin/objednavky/objednavka_detail?id=' .$list[$i]->id;
				$list[$i]->link_print = URL_HOME2 . 'admin/orders_pdf.php?id=' . $list[$i]->id;
			}



		}
		return $list;

	}
/*
	public function getDetailById($id,$lang=LANG_TRANSLATOR)
	{
		$params = new ListArgs();
		$params->limit = 1;
		$params->id = (int) $id;
		return $this->getDetail($params);
	}*/

	public function getDetailByCode($cislo)
	{
		$params = new ListArgs();
		$params->limit = 1;
		$params->code = $cislo;
	//	$params["code"] = $cislo;
		return $this->getDetail($params);
	}
  
	public function getDetailByTransId($transId)
	{
		$params = new ListArgs();
		$params->limit = 1;
		$params->transId = $transId;
	//	$params["code"] = $cislo;
		return $this->getDetail($params);
	}
    
  public function getDetailByDownloadHash($id,$lang=LANG_TRANSLATOR)
	{
		$args = new ListArgs();
		$args->download_hash = (string) $id;
		$args->limit = 1;

		$obj = new stdClass();

		$list = $this->getList($args);
		//print_r($list);
		if (count($list) > 0) {

			$obj = $list[0];
			return $obj;
		}
		//print_r($obj);


		if (count($list) == 1) {
			return $list[0];
		}
		return false;
	}
  

/*	public function getDetail($params = array())
	{

		$params['page'] = 1;
		$params['limit'] = 1000;

		$obj = new stdClass();

		$list = $this->getList($params);
		//print_r($list);
		if (count($list) > 0) {

			$obj = $list[0];
			return $obj;
		}
		//print_r($obj);


		if (count($list) == 1) {
			return $list[0];
		}
		return false;
	}*/
	public function getOrder($id)
	{
		$sql = "SELECT t1.*,dv.name as nazev_dopravy,pv.name as nazev_platby FROM " . T_SHOP_ORDERS . " t1
		left join " . T_SHOP_ZPUSOB_DOPRAVY . " t2 on t1.shipping_transfer=t2.id
		left join " . T_SHOP_ZPUSOB_DOPRAVY_VERSION . " dv on dv.page_id=t2.id

		left join " . T_SHOP_ZPUSOB_PLATBY . " t3 on t1.shipping_pay=t3.id
		left join " . T_SHOP_ZPUSOB_PLATBY_VERSION . " pv on pv.page_id=t3.id
		WHERE id=" . $id;
		return $this->get_row($sql);
	}
	public function getOrderDetail($id)
	{
		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR;
		}
		$this->addWhere("t1.doklad_id=" . $id);

		$this->setLimit(1,10000);
		$this->setOrderBy('t2.nazev_mat_' . $znak .' ASC');

		$this->setSelect("t2.nazev_mat_" . $znak ." AS nazev_mat,t1.*, t2.*, t3.mj,t4.file,t4.popis as popis_foto");
		$this->setFrom(T_SHOP_ORDER_DETAILS . " AS t1
				LEFT JOIN " . T_SHOP_PRODUCT . " AS t2 ON t2.klic_ma = t1.product_id
				LEFT JOIN " . T_MJ . " AS t3 ON t2.hl_mj = t3.uid
				LEFT JOIN " . T_FOTO . " AS t4 ON t2.uid_foto = t4.uid");

		$sql = "SELECT " . $this->getSelect() . " FROM " . $this->getFrom() . " " . $this->getWhere() ." "	. $this->getOrderBy() . " " . $this->getLimit();

		return $this->get_results($sql);
	}
}
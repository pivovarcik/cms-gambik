<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("Pages.php");


class models_Faktury extends models_Pages{

	function __construct()
	{
		parent::__construct(T_FAKTURY);
	}
	public function getDetailById($id,$lang=LANG_TRANSLATOR)
	{
		$args = new ListArgs();
		$args->id = (int) $id;
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



	public function getList(IListArgs $params = null)
	{

		$params = parent::getListArgs($params);

		$this->addWhere("t1.isDeleted=" . $params->isDeleted);
		if (isset($params->fulltext) && !empty($params->fulltext)) {
			$this->addWhere("(t1.code like '%" . $params->fulltext . "%' or
			t1.shipping_first_name like '%" . $params->fulltext . "%' or
			t1.shipping_email like '%" . $params->fulltext . "%' or
			t1.shipping_city like '%" . $params->fulltext . "%' or
			t1.shipping_last_name like '%" . $params->fulltext . "%') ");
		}

		if(isset($params->id) && isInt($params->id))
		{
			$this->addWhere("t1.id=" . $params->id);
		}

		if(isset($params->code) && !empty($params->code))
		{
			$this->addWhere("t1.code='" .  $params->code . "'");
		}
		if(isset($params->order_code) && !empty($params->order_code))
		{
			$this->addWhere("t1.order_code='" .  $params->order_code . "'");
		}

		if(isset($params->shipping_email) && !empty($params->shipping_email))
		{
			$this->addWhere("t1.shipping_email like '%" .  $params->shipping_email . "%'");
		}

		if(isset($params->shipping_ico) && !empty($params->shipping_ico))
		{
			$this->addWhere("t1.shipping_ico like '%" .  $params->shipping_ico . "%'");
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

		if(isset($params->user_id) && isInt($params->user_id))
		{
			$this->addWhere("t1.customer_id=" . $params->user_id);
		}


		$this->setOrderBy($params->getOrderBy(), 't1.TimeStamp DESC, t1.code DESC');

		$this->setSelect("t1.*,dv.name as nazev_dopravy,pv.name as nazev_platby,tf.name as typ_faktury_name");
		$this->setFrom($this->getTableName() . " as t1

		left join " . T_TYPY_FAKTUR . " tf on t1.faktura_type_id=tf.id
		left join " . T_SHOP_ZPUSOB_DOPRAVY . " t2 on t1.shipping_transfer=t2.id
		left join " . T_SHOP_ZPUSOB_DOPRAVY_VERSION . " dv on dv.page_id=t2.id

		left join " . T_SHOP_ZPUSOB_PLATBY . " t3 on t1.shipping_pay=t3.id
		left join " . T_SHOP_ZPUSOB_PLATBY_VERSION . " pv on pv.page_id=t3.id

");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();

		for ($i=0;$i < count($list);$i++)
		{
			$list[$i]->status = "";


			$rozdilDnu = '';
			//$stav_nazev = 'uhrazená';
			if (!empty($list[$i]->maturity_date) && ($list[$i]->cost_total - $list[$i]->amount_paid) > 0 ) {
				$rozdilA = diff(date("Y-m-d"),$list[$i]->maturity_date);
				$rozdilDnu = ' (' . ($rozdilA["day"]) . ')';
			//	$stav_nazev = 'neuhrazená';
				$list[$i]->status = 'posplatnosti';

			} else {
				$list[$i]->status = 'vyrizena';
			}


			if ($list[$i]->storno == 1) {
				$list[$i]->status = 'storno';
			}

			$list[$i]->link_edit = '/admin/faktura_detail?id=' .$list[$i]->id;

			$list[$i]->link_print = URL_HOME2 . 'admin/faktura_pdf.php?id=' . $list[$i]->id;

		}

		return $list;

	}


	public function getFaktura($id)
	{
		$sql = "SELECT t1.*,t2.nazev_dopravy,t3.nazev_platby FROM " . $this->getTablename() . " t1
		left join " . T_SHOP_ZPUSOB_DOPRAVY . " t2 on t1.shipping_transfer=t2.id
		left join " . T_SHOP_ZPUSOB_PLATBY . " t3 on t1.shipping_pay=t3.id
		WHERE order_id=" . $id;
		return $this->get_row($sql);
	}
	// stará metoda - vyhodit !!!!
	public function getFakturaDetail($id)
	{
		if (!empty($params['lang'])){
			$znak = $params['lang'] ;
		} else {
			$znak = LANG_TRANSLATOR;
		}
		$this->addWhere("t1.faktura_id=" . $id);

		$this->setLimit(1,10000);
		$this->setOrderBy('t2.nazev_mat_' . $znak .' ASC');

		$this->setSelect("t2.nazev_mat_" . $znak ." AS nazev_mat,t1.*, t2.*, t3.mj,t4.file,t4.popis as popis_foto");
		$this->setFrom(T_SHOP_FAKTURA_DETAIL . " AS t1
				LEFT JOIN " . T_SHOP_PRODUCT . " AS t2 ON t2.klic_ma = t1.product_id
				LEFT JOIN " . T_MJ . " AS t3 ON t2.hl_mj = t3.uid
				LEFT JOIN " . T_FOTO . " AS t4 ON t2.uid_foto = t4.uid");

		$sql = "SELECT " . $this->getSelect() . " FROM " . $this->getFrom() . " " . $this->getWhere() ." "	. $this->getOrderBy() . " " . $this->getLimit();

		return $this->get_results($sql);
	}
}

// kvuli shode názvu
/**/
class models_Faktura extends models_Faktury {

}
<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
define("T_AD_AUDIT","mm_ads_audit");
class models_Ads extends G_Service{

	function __construct()
	{
		parent::__construct('mm_catalog_banners');
	}
	public $total = 0;
	public function getAd($ad)
	{
		$ad = (int) $ad;
		$productQuery = "
		SELECT t1.*
		FROM " . $this->getTableName() . " t1
		 WHERE t1.uid=" . $ad . " LIMIT 1";
		//print $productQuery;
		$data = $this->get_row($productQuery);
		$data->code_url = URL_HOME . 'ads.php?c=' .gCode($data->uid . '|' . $data->url);
		return $data;
	}

	/*
	* Počítadlo Clicků na reklamu
	*/
	public function adAudit($ad)
	{
		$insertData = array();
		$insertData["ip"] = $_SERVER["REMOTE_ADDR"];
		$insertData["caszapsani"] = date('Y-m-d H:i:s');
		$insertData["uid_ad"] = $ad;
		if ($this->insertData(T_AD_AUDIT, $insertData)) {
			$updateData = array();
			$updateData["counter"] = "counter+1";
			$where = "uid=" . $ad;
			return $this->updateRecords($this->getTableName(), $updateData, $where);
		}
		return false;

	}
	public function getList($params=array())
	{


		$limit = (int) isset($params['limit']) ? $params['limit'] : 100;
		//print $limit;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($page, $limit);
		$this->setOrderBy($params['order'], 't1.titulek_cs ASC');


		//$this->setSelect("t1.*");

		$this->setSelect("t1.*");

		$this->setFrom($this->getTableName() . " AS t1");

	//	$this->setFrom($this->getTableName() . " AS t1");

		//$list = $this->getRows();

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
	//	print $this->getOrderBy();
		$this->total = $this->get_var($query);
		$list = $this->getRows();
		//return $list;

		return $list;

	}

}
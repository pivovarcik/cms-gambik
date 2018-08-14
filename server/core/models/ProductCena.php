<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */


class models_ProductCena extends G_Service{


	public $formNameEdit = "ProductCenaEdit";
	function __construct()
	{
		parent::__construct(T_PRODUCT_CENA);
	}


	public function getDetailById($id)
	{
		$params = new ListArgs();
		$params->id = (int) $id;

		$params->page = 1;
		$params->limit = 1;
		return $this->getDetail($params);
	}

	private function getDetail(IListArgs $params)
	{
		$obj = new stdClass();

		$list = $this->getList($params);

		if (count($list) == 1) {
			return $list[0];
		}
		return false;
	}


	public function generatorCen($params)
	{

	//	print_r($params);
		$where ="WHERE isDeleted=0 ";
		if (isInt($params->vyrobce_id) && $params->vyrobce_id > 0) {
			$where .=" and vyrobce_id=" . $params->vyrobce_id;
		}


		$vyrobce_or = "";
		$vyrobce_klauzule = "in";
		if (!empty($params->vyrobce) && in_array($params->vyrobce, array("in", "not in"))) {

			$vyrobce_klauzule = $params->vyrobce;

			if ($vyrobce_klauzule == "not in") {
				$vyrobce_or = "skupina_id is null or ";
			}

		}
		if (is_array($params->vyrobce_id) && count($params->vyrobce_id) > 0 && $params->vyrobce_id[0] !=0) {
			$where .=" and (" . $vyrobce_or . " vyrobce_id " . $vyrobce_klauzule . " (" .implode(",", $params->vyrobce_id) . "))";
		}


		if (isInt($params->skupina_id) && $params->skupina_id > 0) {
			$where .=" and skupina_id=" . $params->skupina_id;
		}


		$skupina_klauzule = "in";
		$skupina_or = "";
		if (!empty($params->skupina) && in_array($params->skupina, array("in", "not in"))) {

			$skupina_klauzule = $params->skupina;
			if ($skupina_klauzule == "not in") {
				$skupina_or = "skupina_id is null or ";
			}
		}


		if (is_array($params->skupina_id) && count($params->skupina_id) > 0 && $params->skupina_id[0] !=0) {
			$where .=" and (" . $skupina_or . " skupina_id " . $skupina_klauzule . " (" .implode(",", $params->skupina_id) . "))";
		}


		if (!is_null($params->platnost_od)) {
			$params->platnost_od = "'" . $params->platnost_od  . "'";
		} else {
			$params->platnost_od = "NULL";
		}

		if (!is_null($params->platnost_do)) {
			$params->platnost_do = "'" . $params->platnost_do  . "'";
		} else {
			$params->platnost_do = "NULL";
		}

		if (is_null($params->cenik_cena)) {
			$params->cenik_cena = "NULL";
		}

		$query = "update  " . T_PRODUCT_CENA . " set isDeleted =1 where cenik_id = " . $params->cenik_id;
		//		print $query;
		$this->query($query);

		$query = "insert into " . T_PRODUCT_CENA . " (cenik_id,product_id,cenik_cena, sleva,typ_slevy,
		platnost_od,platnost_do,TimeStamp,ChangeTimeStamp)
		select " . $params->cenik_id . ", id, " . $params->cenik_cena . ", " . strToNumeric($params->sleva) . ", '" . $params->typ_slevy . "',
		" . $params->platnost_od . "," . $params->platnost_do . ",now(),now()
		from " . T_SHOP_PRODUCT . " " . $where;

		//	print $query;
		//exit;
		return	$this->query($query);
	}

	public function getList(IListArgs $params=null)
	{

		//$this->clearWhere();

		if (is_null($params)) {
			$params = new ListArgs();
		}

		$this->addWhere("t1.isDeleted=0");
		$this->addWhere("p.isDeleted=0");
		if (isset($params->id) && isInt($params->id)) {
			$this->addWhere("t1.id=" . $params->id);
		}

		if (isset($params->platne) && !empty($params->platne)) {


			$this->addWhere("(t1.platnost_od <= '" . $params->platne . "' or t1.platnost_od is null)");
			$this->addWhere("(t1.platnost_do >= '" . $params->platne . "' or t1.platnost_do is null)");
		}

		if (isset($params->product_cislo) && !empty($params->product_cislo)) {
			$this->addWhere("p.cislo like '" . $params->product_cislo . "%'");
		}

		if (isset($params->product_name) && !empty($params->product_name)) {
			$this->addWhere("pv.title like '" . $params->product_name . "%'");
		}

		if (isset($params->cenik_name) && !empty($params->cenik_name)) {
			$this->addWhere("pc.name like '" . $params->cenik_name . "%'");
		}


		if (isset($params->prodcena) && isInt($params->prodcena)) {
			$this->addWhere("pv.prodcena = " . $params->prodcena . "");
		}

		if (isset($params->cenik_cena) && isInt($params->cenik_cena)) {
			$this->addWhere("t1.cenik_cena = " . $params->cenik_cena . "");
		}

		if (isset($params->sleva) && isInt($params->sleva)) {
			$this->addWhere("t1.sleva = " . $params->sleva . "");
		}

		if (isset($params->cenik_id) && isInt($params->cenik_id)) {
			$this->addWhere("t1.cenik_id = " . $params->cenik_id);
		}

		if (isset($params->product_id) && isInt($params->product_id)) {
			$this->addWhere("t1.product_id = " . $params->product_id);
		}

		if (isset($params->product_id) && is_array($params->product_id) && count($params->product_id) > 0) {
			//	$this->addWhere("t1.product_id = " . $params->product_id);


			$key_list = "";
			foreach ($params->product_id as $key => $val) {
				$key_list .= $val . ",";
			}

			//	print $key_list;
			if (!empty($key_list)) {
				$key_list = substr($key_list,0,-1);
				if (!empty($key_list)) {
					$this->addWhere("t1.product_id in (" . $key_list . ")");
				}

			}


		}




		/*	if(isset($params->parent) && isInt($params->parent))
		   {
		   $this->addWhere("t1.parent=".$params->parent);
		   }

		   if(isset($params->name) && !empty($params->name))
		   {
		   $this->addWhere("t1.name = '" . $params->name . "'");
		   }

		   if(isset($params->fulltext) && !empty($params->fulltext))
		   {
		   $this->addWhere("t1.name like '%" . $params->fulltext . "%'");
		   }*/

		$this->setLimit($params->getPage(), $params->getLimit());

		$this->setOrderBy($params->getOrderBy(), 'product_name ASC, cenik_name ASC');

		$this->setSelect("t1.*,pv.title as product_name,p.cislo as product_cislo,pc.name as cenik_name,
    p.min_prodcena as prodcena,p.min_prodcena_sdph as prodcena_sdph,
    p.min_prodcena, p.min_prodcena_sdph, p.max_prodcena, p.max_prodcena_sdph,
    p.isVarianty,p.nakupni_cena,		dph.name as nazev_dph,
		dph.value as value_dph

    
    ");
		$this->setFrom($this->getTableName() . " AS t1
		LEFT JOIN " . T_SHOP_PRODUCT . " AS p ON t1.product_id = p.id
		LEFT JOIN " . T_PRODUCT_CENIK . " AS pc ON t1.cenik_id = pc.id
		LEFT JOIN " . T_SHOP_PRODUCT_VERSION . " AS pv ON p.id = pv.page_id and p.version=pv.version and pv.lang_id= " . LANG_TRANSLATOR_ID . "
    LEFT JOIN " . T_DPH . " AS dph ON p.dph_id = dph.id
    ");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		$this->total = $this->get_var($query);

		$list = $this->getRows();

		//	print $this->getLastQuery();
		/*	for ($i=0;$i < count($list);$i++)
		   {
		   //	$list[$i]->link_edit = '/admin/product_cena_edit?id='.$list[$i]->id;
		   }*/
		//	return $list;

		return $list;
	}


	public function getProduktyList($cenik_id)
	{
		$model = new models_Products();

		$args = new ListArgs();
		$args->cenik_id = (int) $cenik_id;
		$list = $model->getList($args);
		return $list;
	}

	public function getSkupinyProduktuList($cenik_id)
	{
		$model = new models_ProductCategory();

		$args = new ListArgs();
		$args->cenik_id = (int) $cenik_id;
		$list = $model->getList($args);
		return $list;
	}

}
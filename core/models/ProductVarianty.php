<?php
require_once(PATH_ROOT . "core/form/RadekForm.php");
class models_ProductVarianty extends G_Service{

	function __construct()
	{
		parent::__construct(T_SHOP_PRODUCT_VARIANTY);
	}

	// Výčet atributů ve vztahu k Variantě
	public function get_attribute_value_association($varianty_id)
	{

	//	if ($product_id > 0) {


		//	$this->addWhere("t1.attribute_id=" . $id);
		//	$this->addWhere("ava.product_id is not null");
		//$this->setLimit($params['page'], $params['limit']);
			$this->setOrderBy('a.name ASC', 'a.name ASC');

			$this->setSelect("a.id,a.name,max(ava.attribute_id) as attribute_id,a.description,min(av.id) as value,max(case when ava.varianty_id is null then 0 else 1 end) as has_attribute");
			$this->setFrom("mm_product_attributes a
								left join mm_product_attribute_values av on av.attribute_id = a.id
								left join mm_product_varianty_value_association ava on av.id=ava.attribute_id and ava.varianty_id = " . $varianty_id
			);
			$this->setGroupBy('a.id');
			$list = $this->getRows();
			//	print $this->last_query;

			/*
			   print "<pre>";
			   print_r($list);
			   print "</pre>";
			*/
			return $list;
		//			}
	}

	public function getVariantyByAttributeId($attribute_id,$product_id)
	{

	}
	public function getVariantyValueList($params=array())
	{

		$this->addWhere("pv.isDeleted=0");

		if (isset($params["id"]) && is_int($params["id"])) {
			$this->addWhere("ava.id=" . $params["id"]);
		}
		if (isset($params["product_id"]) && is_int($params["product_id"])) {
			$this->addWhere("pv.product_id=".$params["product_id"]);
		}
		if (isset($params["varianty_id"]) && is_int($params["varianty_id"])) {
			$this->addWhere("pv.id=".$params["varianty_id"]);
		}
		if (isset($params["attribute_id"]) && is_int($params["attribute_id"])) {
			$this->addWhere("av.id=".$params["attribute_id"]);
		}
		$limit = (int) isset($params['limit']) ? $params['limit'] : 10000;
		$page = (int) isset($params['page']) ? $params['page'] : 1;
		$this->setLimit($page, $limit);


		//$this->setLimit($params['page'], $params['limit']);
		$this->setOrderBy($params['order'], 'pv.product_id,a.name ASC');

		$this->setSelect("pv.id as varianty_id, pv.product_id,pv.code as varianty_code, pv.name as varianty_name,av.name as value_name, a.name as attribute_name,av.id as attribute_id");

		$this->setFrom("mm_product_varianty pv
			left join mm_product_varianty_value_association ava on pv.id=ava.varianty_id
			left join mm_product_attribute_values av on av.id = ava.attribute_id
			left join mm_product_attributes a on av.attribute_id = a.id
			");

		//$query = "select count(*) from " . $this->getFrom() . " ". $this->getWhere() . " " . $this->getGroupBy();
		//$this->total = $this->get_var($query);

		$list = $this->getRows();
	//	print $this->getLastQuery();
	//	print_r($list);
		return $list;
	}



	public function getHasAttributeValue($product_id){
		if (is_array($product_id)) {
			$key_list = "";
			foreach ($product_id as $key => $val) {
				$key_list .= $val . ",";
			}

			if (!empty($key_list)) {
				$key_list = substr($key_list,0,-1);
			}

			$this->addWhere("ava.varianty_id in (" . $key_list . ")");
		} else {
			//	$where = "pv.product_id =" . $product_id . "";
			$this->addWhere("ava.varianty_id=".$product_id);
		}

		$this->addWhere("pv.isDeleted=0");

			$this->setOrderBy('pv.product_id,pv.id, a.name ASC', 'pv.product_id,a.name ASC');

		$this->setSelect("pv.id as varianty_id, pv.product_id, pv.name as varianty_name,pv.code as varianty_code,
pv.price as varianty_price,price_sdani as varianty_price_sdani,
av.name as value_name, a.name as attribute_name,av.id as attribute_id");

		$this->setFrom("mm_product_varianty_value_association ava
			left join mm_product_varianty pv on pv.id=ava.varianty_id
			left join mm_product_attribute_values av on av.id = ava.attribute_id
			left join mm_product_attributes a on av.attribute_id = a.id
			");

		$list = $this->getRows();
		//		print $this->getLastQuery();

		/*
		   print "<pre>";
		   print_r($list);
		   print "</pre>";
		*/
		return $list;
	}
	public function get_attribute_value_association2($product_id)
	{

		if (is_array($product_id)) {
			$key_list = "";
			foreach ($product_id as $key => $val) {
				$key_list .= $val . ",";
			}

			if (!empty($key_list)) {
				$key_list = substr($key_list,0,-1);
			}

		//	$where = "pv.product_id in (" . $key_list . ")";
			$this->addWhere("pv.product_id in (" . $key_list . ")");
		} else {
		//	$where = "pv.product_id =" . $product_id . "";
			$this->addWhere("pv.product_id=".$product_id);
		}
		//	$this->addWhere("t1.attribute_id=" . $id);
		//$this->addWhere("ava.product_id is not null");
		$this->addWhere("pv.isDeleted=0");
	//	$this->addWhere("pv.product_id=".$product_id);
		//$this->setLimit($params['page'], $params['limit']);
		$this->setOrderBy('pv.product_id, pv.code ASC, pv.name ASC', 'pv.product_id,a.name ASC');

		$this->setSelect("pv.id as varianty_id, pv.product_id, pv.name as varianty_name,pv.code as varianty_code,
pv.price as varianty_price,price_sdani as varianty_price_sdani,
av.name as value_name, a.name as attribute_name,av.id as attribute_id");



		$this->setFrom("mm_product_varianty pv
					left join mm_product_varianty_value_association ava on pv.id=ava.varianty_id
					left join mm_product_attribute_values av on av.id = ava.attribute_id
					left join mm_product_attributes a on av.attribute_id = a.id
					");


	//	$this->setGroupBy('a.id,ava.product_id');
		$list = $this->getRows();
		//		print $this->getLastQuery();

		/*
		   print "<pre>";
		   print_r($list);
		   print "</pre>";
		*/
		return $list;
	}

	public function getDetailById($id)
	{
		/*
		$args = new ListArgs();
		$args->id = (int) $id;
		*/
		$args = new ListArgs();
		$args->id = (int) $id;
		$list = $this->getList($args);

		if (count($list) == 1) {
			return $list[0];
		}
		return false;
	}
	public function getList(IListArgs $args= null)
	{

		if (is_null($args)) {
			$args = new ListArgs();
		}
		$this->addWhere("t1.isDeleted=0");
		if (isset($args->id) && isInt($args->id)) {
			$this->addWhere("t1.id=" . $args->id);
		}


		if (isset($args->doklad_id) && is_array($args->doklad_id)) {

			$key_list = implode(",", $args->doklad_id);
			$this->addWhere("t1.product_id in (" . $key_list . ")");
		}

		if (isset($args->doklad_id) && isInt($args->doklad_id)) {
			$this->addWhere("t1.product_id=" . $args->doklad_id);
		}

		$this->setLimit($args->getPage(), $args->getLimit());


		$this->setOrderBy($args->getOrderBy(), 't1.product_id ASC, t1.order DESC, t1.name ASC');

		$this->setSelect("t1.*,d.name as dostupnost_nazev,
		d.hodiny as dostupnost_hodiny,null as params");
		$this->setFrom($this->getTableName() . " AS t1 left join " . T_PRODUCT_DOSTUPNOST . " AS d ON d.id = t1.dostupnost_id");

		$query = "select count(*) from " . $this->getFrom() . " ". $this->getWhere() . " " . $this->getGroupBy();
		$this->total = $this->get_var($query);

		$list = $this->getRows();

		//		print $this->getLastQuery();
		$key_list = array();
		for ($i=0;$i < count($list);$i++)
		{
			//	print $list[$i]->page_id;
			if (isset($list[$i]->id)) {
				array_push($key_list, $list[$i]->id);
			} else {
				break;
			}
		}

		$attributesLiteList = array();
		if (count($key_list) > 0) {
		//	$attributes = new models_Attributes();
			$attributesList = $this->getHasAttributeValue($key_list);



		//	print_r($attributesList);
		}



		for ($i=0;$i < count($list);$i++)
		{

			$list[$i]->attributes = array();
			$list[$i]->params = "";
			foreach ($attributesList as $key => $val) {

				if ($val->varianty_id == $list[$i]->id) {
					array_push($list[$i]->attributes, $val);
					$list[$i]->params .= $val->attribute_name . ": " . $val->value_name . " ";
				}
			}


			//$list[$i]->link_edit = '/admin/edit_attrib.php?id='.$list[$i]->id;
			$list[$i]->link_edit = '/admin/sortiment?do=variantyEdit&id='.$list[$i]->id;
		}
		return $list;
	}



}
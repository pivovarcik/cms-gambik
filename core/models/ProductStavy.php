<?php

class models_ProductStavy extends G_Service{

	public $formNameEdit = "ProductStavyEdit";
	function __construct()
	{
		parent::__construct(T_SHOP_PRODUCT_STAVY);
	}


	public function getDetailById($id)
	{
		$params = new ListArgs();
		$params->id = (int) $id;

		$params->page = 1;
		$params->limit = 1;
		return $this->getDetail($params);
	}

	public function getDetailByProductId($id)
	{
		$params = new ListArgs();
		$params->product_id = (int) $id;

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

	public function getList(IListArgs $params=null)
	{

		if (is_null($params)) {
			$params = new ListArgs();
		}
		$this->clearWhere();

		$this->addWhere("t1.isDeleted=0");
		if (isset($params->id) && isInt($params->id)) {
			$this->addWhere("t1.id=" . $params->id);
		}

		if (isset($params->product_id) && isInt($params->product_id)) {
			$this->addWhere("t1.product_id=" . $params->product_id);
		}
		$this->setLimit($params->getPage(), $params->getLimit());
		$ProductEntity = new ProductEntity();
		$ProductVersionEntity = new ProductVersionEntity();


		// moznost vytažení konkrétní verze stránky
		if(isset($params->version) && isInt($params->version))
		{
			$this->addWhere("v.version=" . $params->version);
			$version = "and v.version=" . $params->version;
		} else {
			$version = "and v.version=p.version";
		}


		$this->setSelect("t1.*,v.title,p.cislo");

			$this->setFrom($this->getTableName() . " AS t1
			LEFT JOIN " . $ProductEntity->getTableName() . " p ON p.id=t1.product_id
			left join " . $ProductVersionEntity->getTableName() . " v on v.page_id = p.id " . $version . "
			LEFT JOIN " . T_PRODUCT_DOSTUPNOST . " AS d ON d.id = p.dostupnost_id
			LEFT JOIN " . T_MJ . " AS t3 ON v.hl_mj_id = t3.id");



		$this->setOrderBy($params->getOrderBy(), 't1.TimeStamp ASC');

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;

		//	print $this->getWhere();
		$this->total = $this->get_var($query);



		$list = $this->getRows();

		for ($i=0;$i < count($list);$i++)
		{
			//$list[$i]->link_edit = '/admin/edit_attrib.php?id='.$list[$i]->id;
		}
		return $list;
	}



}
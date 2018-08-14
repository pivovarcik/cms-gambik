<?php


class models_ProductPohyb extends G_Service{

	function __construct()
	{
		parent::__construct(T_PRODUCT_POHYB);
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
			$args = new ProductPohybListArgs();
		}
		$this->addWhere("t1.isDeleted=0");
		if (isset($args->id) && isInt($args->id)) {
			$this->addWhere("t1.id=" . $args->id);
		}


		if (isset($args->doklad_id) && is_array($args->doklad_id)) {

			$key_list = implode(",", $args->doklad_id);
			$this->addWhere("t1.product_id in (" . $key_list . ")");
		}

		if (isset($args->product_id) && isInt($args->product_id)) {
			$this->addWhere("t1.product_id=" . $args->product_id);
		}

   		$language1 = "";

		if(isset($params->lang) && !empty($params->lang))
		{
			$this->addWhere("l.code='" . $params->lang . "'");
		}
    
		if (isset($args->code) && !empty($args->code)) {
			$this->addWhere("t1.code='" . $args->code . "'");
		}
    
    if(isset($params->version) && isInt($params->version))
		{
			$this->addWhere("pv.version=" . $params->version);
			$version = "and pv.version=" . $params->version;
		} else {
			$version = "and pv.version=p.version";

		}
    

		$this->setLimit($args->getPage(), $args->getLimit());


		$this->setOrderBy($args->getOrderBy(), 't1.id DESC, t1.datum DESC');

		$this->setSelect("t1.*,case when t1.varianty_id is null then pv.title else concat(pv.title,' #',t1.varianty_id) end as title,o.code as objednavka_code");
		$this->setFrom($this->getTableName() . " AS t1
     
		left join " . T_SHOP_PRODUCT . " AS p ON p.id = t1.product_id
    
    left join " . T_SHOP_PRODUCT_VERSION . " pv on pv.page_id = p.id " . $version . "  and pv.lang_id= " . LANG_TRANSLATOR_ID . "
    left join " . T_LANGUAGE . " l on pv.lang_id=l.id
		left join " . T_SHOP_ORDERS . " AS o ON o.id = t1.doklad_id
		left join " . T_SHOP_PRODUCT_VARIANTY . " AS v ON v.id = t1.varianty_id
		left join " . T_DPH . " AS dph ON dph.id = t1.tax_id
");

		$query = "select count(*) from " . $this->getFrom() . " ". $this->getWhere() . " " . $this->getGroupBy();
		$this->total = $this->get_var($query);

		$list = $this->getRows();
    //print $this->getLastQuery();

		return $list;
	}
}
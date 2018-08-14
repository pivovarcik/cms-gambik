<?php

class models_ProductGroupAssoc extends G_Service {

	function __construct()
	{
		parent::__construct(T_PRODUCT_GROUP_ASSOC);
	}
	public function getList(IListArgs $params= null)
	{

		if (is_null($params)) {
			$params = new ListArgs();
		}
    $this->addWhere("t1.isDeleted=0 and t2.isDeleted=0  and ifnull(t3.isDeleted,1)=0 ");
		if (isset($params->product_id) && isInt($params->product_id)) {
			$this->addWhere("t1.product_id=" . $params->product_id);
		}



		$this->setOrderBy($params->getOrderby(),"t2.name ASC");

		$this->setSelect("t1.*,count(*) as pocet,t2.name");
		$this->setFrom($this->getTablename() . " t1 
    left join " . T_SHOP_PRODUCT_CATEGORY . " t2 ON t1.group_id = t2.id
    left join " . T_SHOP_PRODUCT . " t3 ON t1.product_id = t3.id
    ");
    $this->setGroupby("group_id") ;
		$list = $this->getRows();
	//		print $this->getLastQuery();
		return $list;
	}






	public function getAssociationList($product_id)
	{
		$pageId = "";

		if (isInt($product_id)) {
			$pageId = " and t2.product_id=" . $product_id. " ";
		}
		//	$this->addWhere("t1.second_service=1");

		//	$this->setOrderBy("selected DESC,t2.order,t1.name ASC");
		$this->setOrderBy("selected DESC,t1.name ASC");


		$this->setSelect("t1.*,case when t2.product_id is not null then 1 else 0 end selected");
		$this->setFrom( T_SHOP_PRODUCT_CATEGORY . " t1
		left join (select * from " . $this->getTablename() . " where isDeleted=0  group by product_id,group_id) t2 ON (t2.group_id = t1.id)" . $pageId);

		$list = $this->getRows();

		//	print $this->getLastQuery();
		return $list;
	}
}

<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("ACiselnikModel.php");
class models_ProductCategory extends ACiselnikModel{

	function __construct()
	{
		parent::__construct(T_SHOP_PRODUCT_CATEGORY);
	}

	public function getList(IListArgs $params = null)
	{
		if(isset($params->cenik_id) && isInt($params->cenik_id))
		{
			$this->addWhere("t1.cenik_id=".$params->cenik_id);
		}

		$list = parent::getList($params);
		for ($i=0;$i < count($list);$i++)
		{
		//	$list[$i]->link_edit = URL_HOME . 'eshop/eshop_cat/ProductCategoryEdit?id='.$list[$i]->id;
			$list[$i]->link_edit = '/admin/eshop/eshop_cat?do=edit&id='.$list[$i]->id;
		}
		return $list;
	}

}
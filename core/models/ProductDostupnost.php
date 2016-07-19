<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("ACiselnikModel.php");
class models_ProductDostupnost extends ACiselnikModel{

	public $formNameEdit = "ProductDostupnostEdit";
	function __construct()
	{
		parent::__construct(T_PRODUCT_DOSTUPNOST);
	}

	public function getList(IListArgs $params = NULL)
	{
		$list = parent::getList($params);
		for ($i=0;$i < count($list);$i++)
		{
		//	$list[$i]->link_edit = '/admin/product_dostupnost_edit?id='.$list[$i]->id;

			$list[$i]->link_edit = '/admin/eshop/product_dostupnost?do=edit&id='.$list[$i]->id;
		}
		return $list;
	}

}
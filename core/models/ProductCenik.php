<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("ACiselnikModel.php");
class models_ProductCenik extends ACiselnikModel{

	public $formNameEdit = "ProductCenikEdit";
	function __construct()
	{
		parent::__construct(T_PRODUCT_CENIK);
	}

	public function getList(IListArgs $params = NULL)
	{
		$list = parent::getList($params);
		for ($i=0;$i < count($list);$i++)
		{
			$list[$i]->link_edit = '/admin/product_cenik_edit?id='.$list[$i]->id;
		}
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
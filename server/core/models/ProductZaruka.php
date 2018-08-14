<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("ACiselnikModel.php");
class models_ProductZaruka extends ACiselnikModel{

	function __construct()
	{
		parent::__construct(T_PRODUCT_ZARUKA);
	}

	public function get_value_from_parent($parent_value)
	{
		$this->clearWhere();
		$this->addWhere("t1.category_id=" . $parent_value);
		$this->addWhere("t1.aktivni=1");
		$this->addWhere("t2.id is not null");
		/*
		   $this->addWhere("t1.klic_ma in (select ava.product_id from mm_product_attribute_value_association ava
		   left join mm_product_attribute_values av on ava.attribute_id=av.ID
		   left join mm_product_attributes a on av.attribute_id=a.ID
		   where av.ID=" . $parent_attribute_value . "
		   group by ava.product_id)"
		   );
		*/
		$this->setSelect("t2.*");
		$this->setFrom(T_SHOP_PRODUCT . " t1 left join " . T_PRODUCT_ZARUKA . " t2 on t1.zaruka_id=t2.id");
		$this->setOrderBy('t2.name ASC', 't2.name ASC');
		$this->setGroupBy('t2.name');
		$list = $this->getRows();
		//print $this->getLastQuery();
		return $list;
	}

	public function getList(IListArgs $params = NULL)
	{
		$list = parent::getList($params);
		for ($i=0;$i < count($list);$i++)
		{

			$list[$i]->link_edit = '/admin/eshop/product_zaruka?do=edit&id='.$list[$i]->id;
			//$list[$i]->link_edit = URL_HOME . 'eshop/eshop_zaruka/ProductZarukaEdit?id='.$list[$i]->id;
		}
		return $list;
	}
}
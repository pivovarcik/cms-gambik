<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once(PATH_ROOT . "core/models/ACiselnikModel.php");
class models_ImportProductSetting extends ACiselnikModel{

	function __construct()
	{
		parent::__construct(T_IMPORT_PRODUCT_SET);
	}

	public function getList(IListArgs $params = NULL)
	{
		$list = parent::getList($params);
		for ($i=0;$i < count($list);$i++)
		{
			$list[$i]->link_edit = URL_HOME . "import_product_setting_edit?id=" . $list[$i]->id;
		}
		return $list;
	}
}
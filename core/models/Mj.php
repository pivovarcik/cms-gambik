<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

require_once("ACiselnikModel.php");
class models_Mj extends ACiselnikModel{

	function __construct()
	{
		parent::__construct(T_MJ);
	}


	public function getList(IListArgs $params = null)
	{
		$list = parent::getList($params);
		for ($i=0;$i < count($list);$i++)
		{
			//$list[$i]->link_edit = '/admin/mj_edit?id='.$list[$i]->id;
			$list[$i]->link_edit = '/admin/options/mj?do=edit&id='.$list[$i]->id;
		}
		return $list;
	}
}
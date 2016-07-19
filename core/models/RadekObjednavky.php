<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("RadekDokladu.php");
class models_RadekObjednavky extends models_RadekDokladu {

	function __construct()
	{
		parent::__construct("Orders", "RadekObjednavky");
	}


	public function getList(IListArgs $params = null)
	{
		$list = parent::getList($params);

		for ($i=0;$i<count($list);$i++)
		{
			$list[$i]->status = '';
			switch($list[$i]->stav)
			{
				case 1:
					$list[$i]->status = 'prijata';
					break;
				case 2:
					//	$stav = "Vyexpedovaná";
					$list[$i]->status = 'expedice';
					break;
				case 3:
					$list[$i]->status = 'kvyrizeni';
					break;
				case 4:
					$list[$i]->status = 'vyrizena';
					break;
				default:
					break;
			}

			if ($list[$i]->storno == 1) {
				$list[$i]->status = 'storno';
			}

			$list[$i]->link_edit = '/admin/objednavka_detail?id=' .$list[$i]->doklad_id;
		}

		return $list;
	}

}
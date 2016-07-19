<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("ACiselnikModel.php");
class models_Dph extends ACiselnikModel{

	function __construct()
	{
		parent::__construct(T_DPH);
	}

	public function getList(IListArgs $params = null)
	{

		if(isset($params->platne) && !empty($params->platne))
		{
			$this->addWhere("t1.platnost_od<=".$params->platne . " or t1.platnost_od is null");
			$this->addWhere("t1.platnost_do>=".$params->platne . " or t1.platnost_do is null");
		}
		return parent::getList($params);
	}

}
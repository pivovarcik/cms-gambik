<?php

/**
 * Předek pro Model entit tipu ŘÁDEKDOKLADU
 *
 * @version $Id$
 * @copyright 2011
 */


abstract class models_Radek extends G_Service {

	public static $entitaRadky;

	function __construct($TRadkyEntita)
	{


		if (empty($TRadkyEntita)) {

			trigger_error(get_parent_class($this) . " - chybí parametry v konstruktoru!", E_USER_ERROR);
			return false;
		}


		$name = $TRadkyEntita . "Entity";
		self::$entitaRadky = $name;

		if (!is_subclass_of(self::$entitaRadky,"RadekEntity")) {
			trigger_error(self::$entitaRadky . " není typu RadekEntity!", E_USER_ERROR);
		}

		$entita = new self::$entitaRadky();
		parent::__construct($entita->getTableName());

	}

	public function getList(IListArgs $params = NULL)
	{

		if(isset($params->id) && isInt($params->id))
		{
			$this->addWhere("t1.id=" . $params->id);
		}

		if(isset($params->isDeleted) && isInt($params->isDeleted))
		{
			$this->addWhere("t1.isDeleted=" . $params->isDeleted);
		} else {
			$this->addWhere("t1.isDeleted=0");
			$this->addWhere("o.isDeleted=0");
		}

		if(isset($params->doklad_id) && isInt($params->doklad_id))
		{
			$this->addWhere("t1.doklad_id=" . $params->doklad_id);
		}
		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getOrderBy(), 't1.doklad_id ASC,t1.order ASC ');

		$this->setSelect("t1.*");



	//	$radek = new self::$entitaRadky();

		$this->setFrom($this->getTableName() . " AS t1
			");


		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();

	//		print $this->getLastQuery();
		return $list;

	}
}
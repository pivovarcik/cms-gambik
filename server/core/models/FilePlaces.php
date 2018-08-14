<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_FilePlaces extends G_Service{

	function __construct()
	{
		parent::__construct(T_FILE_PLACES);
	}


  	public function getList(FotoPlacesListArgs $args)
	{
		$this->clearWhere();
		// univerzální

		if (!empty($args->gallery_type)) {
			$this->addWhere("t2.table='" . $args->gallery_type . "'");
		}

		if (isInt($args->gallery_id)) {
			$this->addWhere("t2.target_id=" . $args->gallery_id);
		}

		if (isset($args->gallery_id) && is_array($args->gallery_id) && count($args->gallery_id) > 0) {
			$where = "t2.target_id in (" . implode(",",$args->gallery_id) . ")";
			$this->addWhere($where);
		}






		$this->setSelect("t1.*,t2.id as place_id,t2.target_id");
		$this->setFrom(T_DATA. " AS t1
				LEFT JOIN " . T_FILE_PLACES . " t2 ON t1.id = t2.source_id");
		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//	print $this->getWhere();
		$this->total = $this->get_var($query);
		$list = $this->getRows();

		//Print $this->getLastQuery();
		return $list;
	}
  

}
<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */


class FotoPlacesListArgs extends ListArgs
{
	public $gallery_id;
	public $gallery_type;
	public $width = 180;
	public $height = 180;


}
class models_FotoPlaces extends G_Service{

	function __construct()
	{
		parent::__construct(T_FOTO_PLACES);
	}

	public function getList(FotoPlacesListArgs $args)
	{
		$this->clearWhere();
		// univerzální

		if (!empty($args->gallery_type)) {
			$this->addWhere("t2.table='" . $args->gallery_type . "'");
		}

		if (isInt($args->gallery_id)) {
			$this->addWhere("t2.uid_target=" . $args->gallery_id);
		}

		if (isset($args->gallery_id) && is_array($args->gallery_id) && count($args->gallery_id) > 0) {
			$where = "t2.uid_target in (" . implode(",",$args->gallery_id) . ")";
			$this->addWhere($where);
		}


		$this->setLimit($args->getPage(), $args->getLimit());
		$this->setOrderBy($args->getOrderBy(), 't2.order ASC, t1.TimeStamp DESC');

		$this->setSelect("t1.*,t2.id as place_id,t2.uid_target");
		$this->setFrom(T_FOTO. " AS t1
				LEFT JOIN " . T_FOTO_PLACES . " t2 ON t1.id = t2.uid_source");
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
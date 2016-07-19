<?php



require_once("ACiselnikModel.php");
class models_Tags extends ACiselnikModel{

	function __construct()
	{
		parent::__construct(T_TAGS);
	}


	public function getList(IListArgs $params = null)
	{
		$list = parent::getList($params);
		return $list;
	}
}
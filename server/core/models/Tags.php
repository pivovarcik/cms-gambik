<?php



require_once("ACiselnikModel.php");
class models_Tags extends ACiselnikModel{

	function __construct()
	{
		parent::__construct(T_TAGS);
	}

	public function getDetailbyUrl($url){

		$params = new ListArgs();
		$params->page = 1;
		$params->limit = 1;
		$params->url = $url;
		$list = $this->getList($params);

		if (count($list) == 1) {
			return $list[0];

		}
		return false;
	}

	public function getList(IListArgs $params = null)
	{

		if(isset($params->url) && !empty($params->url))
		{
			$this->addWhere("t1.url='".$params->url . "'");
		}

		$list = parent::getList($params);
		return $list;
	}
}
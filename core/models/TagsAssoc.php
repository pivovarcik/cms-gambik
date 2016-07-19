<?php




class models_TagsAssoc extends G_Service{

	function __construct()
	{
		parent::__construct(T_TAGS_ASSOC);
	}


	public $total = 0;

	public function getDetailById($id,$lang=null)
	{
		$params = new ListArgs();
		$params->id = (int) $id;


		$params->page = 1;
		$params->limit = 1;

		//print_r($params);
		return $this->getList($params);
	}

	public function getListTagsId($page_id,$page_type)
	{
		$params = new ListArgs();
		$params->page_id = (int) $page_id;
		$params->page_type =  $page_type;


		$params->page = 1;
		$params->limit = 1000;

		//print_r($params);
		$keys = array();
		$list =  $this->getList($params);
		for ($i=0;$i<count($list);$i++)
		{
		//	$keys[$list[$i]->tag_id] = "";

			array_push($keys, $list[$i]->tag_id);
		}

		return $keys;
	}


	public function getList(IListArgs $params=null)
	{

		//$this->clearWhere();

		if (is_null($params)) {
			$params = new ListArgs();
		}

		$this->addWhere("t1.isDeleted=0");
		if (isset($params->id) && isInt($params->id)) {
			$this->addWhere("t1.id=" . $params->id);
		}

		if (isset($params->page_id) && isInt($params->page_id)) {
			$this->addWhere("t1.page_id=" . $params->page_id);
		}
		if (isset($params->page_type) && !empty($params->page_type)) {
			$this->addWhere("t1.page_type='" . $params->page_type . "'");
		}

		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getorderBy(), 't1.id ASC');

		$this->setSelect("t1.*");
		$this->setFrom($this->getTableName() . " AS t1");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();


		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();
		//	print $this->getLastQuery();
		return $list;

	}

}
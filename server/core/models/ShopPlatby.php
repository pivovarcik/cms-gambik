<?php

class models_ShopPlatby extends G_Service{

	function __construct()
	{
		parent::__construct(T_SHOP_PLATBY);
	}

  public function getDetailByTransId($transId)
	{
		$params = new ListArgs();
		$params->limit = 1;
		$params->transId = $transId;
	//	$params["code"] = $cislo;
		return $this->getDetail($params);
	}
    
  public function getDetail($params)
	{

		$list =  $this->getList($params);
    if (count($list) == 1)
    {
      return   $list[0];
    }
    return false;
	}    
	public function getList(IListArgs $params=null)
	{
		if (is_null($params)) {
			$params = new ListArgs();
		}
		$this->clearWhere();

		$this->setLimit($params->getPage(), $params->getLimit());
     		if(isset($params->fulltext) && !empty($params->fulltext))
		{
			$this->addWhere("t1.transId like '%" . $params->fulltext . "%'");
		}
		if(isset($params->id) && isInt($params->id))
		{
			$this->addWhere("t1.id=".$params->id);
		}

    if(!empty($params->transId))
		{
			$this->addWhere("t1.transId='" . $params->transId . "'");
		}
    
     $this->setOrderBy($params->getOrderBy(), 't1.TimeStamp DESC');

		$this->setSelect("t1.*");

		$this->setFrom($this->getTableName() . " AS t1");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);

		$list = $this->getRows();

		for ($i=0;$i < count($list);$i++)
		{
			//	$list[$i]->link_edit = '/admin/edit_attrib.php?id='.$list[$i]->id;
		}
		return $list;
	}



}
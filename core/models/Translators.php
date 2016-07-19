<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_Translator extends G_Service{

	public $total = 0;
	function __construct()
	{
		parent::__construct(T_SLOVNIK);
	}

	public function getPreklad($fraze, $lang = "cs")
	{
		$query = "select " . $lang . " from " . $this->getTableName() . " where keyid='"	. $fraze . "' LIMIT 1";
		return $this->get_var($query);
	}

	public function getDetailById($id,$lang=null)
	{
		$params = new ListArgs();
		$params->page_id = (int) $id;
		//	$params['lang'] = $lang;
		if ($lang != null) {
			$params->lang = $lang;
		} else {
			$params->lang = "";
		}


		$params->page = 1;
		$params->limit = 1000;

		//print_r($params);
		return $this->getDetail($params);
	}

	private function getDetail(IListArgs $params)
	{
		$obj = new stdClass();

		$list = $this->getList($params);
		//	print_r($list);
		if (count($list) > 0) {
			$obj->id = $list[0]->id;
			$obj->TimeStamp = $list[0]->TimeStamp;
			$obj->ChangeTimeStamp = $list[0]->ChangeTimeStamp;
			$obj->isDeleted = $list[0]->isDeleted;


			$obj->keyword = $list[0]->keyword;



			//$obj->public_date = $list[0]->public_date;
			//$obj->poradi = $list[0]->poradi;
			for($i=0;$i<count($list);$i++)
			{
				$title = "name_" . $list[$i]->code;
				$obj->$title = $list[$i]->name;


				if ($list[$i]->code == LANG_TRANSLATOR) {

					$obj->name = $list[$i]->name;
				}


			}
			return $obj;
		}


		if (count($list) == 1) {
			return $list[0];
		}
		return false;
	}

	public function getList(IListArgs $params=null)
	{

		$this->clearWhere();
		if (is_null($params)) {
			$params = new ListArgs();
		}

		$this->addWhere("p.isDeleted=0");
		if (isset($params->page_id) && isInt($params->page_id)) {
			$this->addWhere("p.id=" . $params->page_id);
		}

		if(isset($params->fulltext) && !empty($params->fulltext))
		{
			$this->addWhere("p.keyword like '%" . $params->fulltext . "%' or v.name like '%" . $params->fulltext . "%'");
		}
		if(isset($params->lang) && !empty($params->lang))
		{
			$this->addWhere("l.code='" . $params->lang . "'");
		}

		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getOrderBy(), 'p.keyword ASC');


		$this->setSelect("p.*,v.name,l.code");
		$this->setFrom(T_SLOVNIK . " AS p
		LEFT JOIN " . T_SLOVNIK_VERSION . " v ON p.id=v.keyword_id
		LEFT JOIN " . T_LANGUAGE . " l ON l.id=v.lang_id
		");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		$this->total = $this->get_var($query);
		$list = $this->getRows();

	//	print  $this->getLastQuery();
		for ($i=0;$i < count($list);$i++)
		{
		//	$list[$i]->link_edit = 'edit_key?id='.$list[$i]->id;
			$list[$i]->link_edit = '/admin/options/translator?do=edit&id='.$list[$i]->id;
		}
		return $list;

	}

}
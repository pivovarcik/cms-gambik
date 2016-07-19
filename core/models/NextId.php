<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("ACiselnikModel.php");
class models_NextId extends ACiselnikModel{

	function __construct()
	{
		parent::__construct(T_NEXTID);
	}

	public function getDetailById($id)
	{
		$params= new ListArgs();
		$params->id = $id;
		$params->limit = 1;
		$params->page = 1;

		$l = $this->getList($params);

		if (count($l) == 1) {
			return $l[0];
		}
		return false;
	}
	public function getDetailByRada($rada)
	{
		$params= new ListArgs();
		$params->rada = $rada;
		//$params["company"] = $company;
		$params->limit = 1;
		$params->page = 1;
		$l = $this->getList($params);

		if (count($l) == 1) {
			return $l[0];
		}
		return false;
	}

	public function getList(IListArgs $params=null)
	{
		if (is_null($params)) {
			$params = new ListArgs();
		}
		$this->setLimit($params->getPage(), $params->getLimit());

		$this->clearWhere();
		if(isset($params->tabulka) && !empty($params->tabulka))
		{
			$this->addWhere("t1.tabulka='". $params->tabulka. "'");
		}

		if(isset($params->rada) && !empty($params->rada))
		{
			$this->addWhere("t1.rada='". $params->rada. "'");
		}
		if(isset($params->id) && isInt($params->id))
		{
			$this->addWhere("t1.id=". $params->id);
		}
		$this->addWhere("t1.isDeleted=0");
		$this->setSelect("t1.*");
		$this->setFrom(T_NEXTID . " AS t1");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		$this->total = $this->get_var($query);

		$list = $this->getRows();



		for ($i=0;$i < count($list);$i++)
		{
			//$list[$i]->link_edit = '/admin/nextid_detail?id='.$list[$i]->id;
			$list[$i]->link_edit = '/admin/options/nextid?do=edit&id='.$list[$i]->id;
		}
		return $list;

	}

	// Načtu si záznamy z tabulky dokladů
	private function getLastValueTable($table, $column, $rada = "")
	{
		$this->clearWhere();
		if(!empty($rada))
		{
			$this->addWhere("t1." . $column . " like '" . $rada . "%'");
		}

		$this->setSelect("t1." . $column);
		$this->setFrom($table . " AS t1");

		$this->setLimit(1, 1);
		$this->setOrderBy(' LENGTH( t1.' . $column . ' ) DESC, t1.' . $column . ' DESC',' LENGTH( t1.' . $column . ' ) DESC, t1.' . $column . ' DESC');

		$cislo_dokladu = $this->getValue();

	//	print $this->getLastQuery();
		return $cislo_dokladu;

	}
	public function vrat_nextid($params = array())
	{
		$this->clearWhere();

//print $this->getLastQuery();
//		print $cislo_dokladu;
		if(isset($params['tabulka']) && !empty($params['tabulka']))
		{
			$this->addWhere("t1.tabulka = '".strToUpper($params['tabulka']). "'");
		}

		if(isset($params['rada']) && !empty($params['rada']))
		{
			$this->addWhere("t1.rada = '" . $params['rada'] . "'");
		}

		if(isset($params['rada_id']) && is_numeric($params['rada_id']) && $params['rada_id'] > 0)
		{
			$this->addWhere("t1.id=" . $params['rada_id']);
			//$this->where = $this->where . " t1.id" . $params['rada_id'];
		}

		//$obj = $this->getList($params);

		$select = "t1.*";
		$from = T_NEXTID . " AS t1";
		$limit = "LIMIT 1";

		$sql = "SELECT " . $select . " FROM " . $from . " " . $this->getWhere() . " " . $limit;
	//	echo   $sql;
		$obj = $this->get_row($sql);
		if($obj->nejvyssi>0){
			$nejvyssi = $obj->nejvyssi  + 1;
		} else {
			$nejvyssi = 1;
		}


		$cislo_dokladu = $this->getLastValueTable($params['tabulka'], $params['polozka'], $obj->rada);

	//	print $nejvyssi;
		//print_r($obj);

		$rada_delka = strLen($obj->rada);


		// TODO  Nevím na co jsou tyto 2 řádky
		//$new_cislo = $obj->rada . str_pad($nejvyssi,$obj->delka - $rada_delka,"0",STR_PAD_LEFT);
//		echo $cislo_dokladu ."<br />" . $rada_delka;
		$cislo_dokladu = substr($cislo_dokladu,$rada_delka,$obj->delka);
		$num = (int) $cislo_dokladu;
	//	print $num;
		if($num>0){
			$nejvyssi = $num  + 1;
		} else {
			$nejvyssi = 1;
		}
		$rada_delka = strLen($obj->rada);
		$new_cislo = $obj->rada . str_pad($nejvyssi,$obj->delka - $rada_delka,"0",STR_PAD_LEFT);

	//	print $new_cislo;
		return  $new_cislo;

	}

}
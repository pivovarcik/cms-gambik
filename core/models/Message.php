<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
//require_once("Pages.php");
class models_Message extends G_Service{

	function __construct()
	{
		parent::__construct(T_MESSAGE);
	}

	public function setMessage($autor,$adresat,$message)
	{
		$data = array();

		if ($autor > 0) {
			$data["autor_id"] = (int) $autor;
		}
		if ($adresat > 0) {
			$data["adresat_id"] = (int) $adresat;
		}

		$data["message"] = $message;

		return $this->insertRecords($this->getTablename(),$data);
	}
	public function getDetailById($id,$lang=LANG_TRANSLATOR)
	{
		$params = new ListArgs();
		$params->id = (int) $id;
	//	$params['lang'] = $lang;
		$params->page = 1;
		$params->limit = 1000;

		$obj = new stdClass();

		$list = $this->getList($params);

		if (count($list) == 1) {
			return $list[0];
		}
		return false;
	}

	public function getList(IListArgs $params=null)
	{

		if (is_null($params)) {
			$params = new ListArgs();
		}
		$this->clearWhere();

		//print_r($params);
		if(isset($params->new) && $params->new==1)
		{
			$this->addWhere("m.ReadTimeStamp is null");
		}

		if(isset($params->send_info_mail))
		{
			$this->addWhere("m.email = " . $params->send_info_mail);
		}

		$this->addWhere("m.isDeleted=" . $params->isDeleted);


		if(isset($params->adresat_autor) && isInt($params->adresat_autor))
		{
			$this->addWhere("(m.autor_id=" . $params->adresat_autor. " or m.adresat_id=" . $params->adresat_autor  . ")");
		}

		if(isset($params->autor) && isInt($params->autor))
		{
			$this->addWhere("m.autor_id=" . $params->autor);
		}

		if(isset($params->adresat) && isInt($params->adresat))
		{
			$this->addWhere("m.adresat_id=" . $params->adresat);
		}

		if(isset($params->id) && isInt($params->id))
		{
			$this->addWhere("m.id=" . $params->id);
		}

		$this->setLimit($params->getPage(), $params->getLimit());
		$this->setOrderBy($params->getOrderBy(), 'm.TimeStamp DESC');

		$this->setSelect("case when m.autor_id <> " . USER_ID . " and m.ReadTimeStamp is null then 1 else 0 end as isNewMessage,
			case when m.ReadTimeStamp is null then 0 else 1 end as precteno,
			m.*,ad.nick as adresat, ad.jmeno as adresat_jmeno, ad.prihlasen as adresat_prihlasen,
			UNIX_TIMESTAMP(ad.naposledy) as adresat_casnaposledy,
		au.nick as autor,au.jmeno as autor_jmeno,au.prihlasen as autor_prihlasen,
		UNIX_TIMESTAMP(au.naposledy) as autor_casnaposledy");

		$this->setFrom($this->getTableName() . " m
		   left join " . T_USERS . " au on m.autor_id=au.id
			left join " . T_USERS . " ad on m.adresat_id=ad.id
		   ");

		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();

		$this->total = $this->get_var($query);

		$list = $this->getRows();
		//print $this->getLastQuery();

		for ($i=0;$i < count($list);$i++)
		{
			$list[$i]->link_edit = '/admin/message/message_detail?id='.$list[$i]->id;
		}
		return $list;
	}

	public function setReader($id)
	{
		$data = array();
		$data["ReadTimeStamp"] = date("Y-m-d H:i:s");
		return $this->updateRecords($this->getTablename(),$data, "id=".$id);
	}
}
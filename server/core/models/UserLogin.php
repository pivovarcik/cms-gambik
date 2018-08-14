<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_UserLogin extends G_Service{

	function __construct()
	{
		parent::__construct(T_USER_LOGIN);
	}

	public $total = 0;



	public function getUserLoginByToken($token)
	{

		return $this->geDetail("t1.token='" . $token . "'");
	}

	public function getUserLoginByUserToken($user_id, $token)
	{

		return $this->geDetail("user_id=" . $user_id . " AND t1.token='" . $token . "'");
	}

	public function getUserLoginByUserId($user_id)
	{

		return $this->geDetail("user_id=" . $user_id . " and t1.isDeleted=0");
	}

	private function geDetail($where)
	{

		$where .= " and t1.isDeleted=0 and t2.isDeleted=0 and t2.aktivni=1";

		$sql = "SELECT
                 t1.*
				 FROM " . $this->getTablename() . " t1
				 left join " . T_USERS . " as t2 on t1.user_id=t2.id
				WHERE " . $where . " LIMIT 1";
		//print $sql;
		$obj = $this->get_row($sql);
		//print_r($obj);
		//var_dump($obj);
		return $obj;
	}
	public function setLoginPermanent($user_id, $ip, $token)
	{


		$detail = $this->getUserLoginByUserToken($user_id, $token);

		$updateData = array();
		$updateData["token"] = $token;
		$updateData["LastLogin"] = date("Y-m-d H:i:s");
		$updateData["ip_adresa"] = $ip;
		$updateData["user_agent"] = $_SERVER['HTTP_USER_AGENT'];

		if ($detail) {
			 $this->updateRecords($this->getTablename(),$updateData,"user_id=" . $user_id . " AND token='" . $token . "'");
			return true;
		}
		$updateData["user_id"] = $user_id;
		$updateData["token"] = $token;

		return $this->insertRecords($this->getTablename(),$updateData);
	}

	public function removeToken($token){
		$updateData = array();
		$updateData["isDeleted"] = 1;

		$this->updateRecords($this->getTablename(),$updateData,"token='" . $token . "'");
		return true;
	}
	public function getList(IListArgs $params = null)
	{

	//	$params = parent::getListArgs($params);

		if (isset($params->user_id) && isInt($params->user_id)) {
			$this->addWhere("t1.user_id=" . $params->user_id);

		}

		$this->addWhere("t1.isDeleted=0");

		$this->setOrderBy($params->getOrderBy(),'t1.LastLogin DESC');



		$this->setSelect("t1.*");
		$this->setFrom($this->getTableName() . " as t1
		left join " . T_USERS . " as t2 on t1.user_id=t2.id");
		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		//print $this->getLimit();
		$this->total = $this->get_var($query);

		$list = $this->getRows();

		return $list;

	}

}

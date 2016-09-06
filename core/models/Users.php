<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
require_once("Pages.php");
class models_Users extends models_Pages{

	function __construct()
	{
		parent::__construct(T_USERS);
	}

	public $total = 0;

	public function getUserByLogin($username, $password)
	{
		$password = MD5($password);
		return $this->getUser("nick='" . $username . "' AND password='" . $password . "' and t1.isDeleted=0");
	}

	public function getUserByNick($username)
	{
		return $this->getUser("nick='" . $username . "'");
	}


	public function getUserByEmailPwd($email, $password)
	{
		$password = MD5($password);
		return $this->getUser("t1.email='" . $email . "' AND t1.password='" . $password . "' and t1.isDeleted=0");
	}
	public function getUserByEmail($email)
	{
		return $this->getUser("t1.email='" . $email . "' and t1.isDeleted=0");
	}

	public function getUserById($id)
	{
		return $this->getUser("t1.id=" . $id);
	}

	public function getUserByKeyLostPassword($key)
	{
		return $this->getUser("t1.lost_pwd='" . $key . "' and t1.isDeleted=0");
	}

	public function setUserById($data, $id)
	{

		return $this->updateRecords($this->getTablename(), $data, "id='" . $id . "' AND aktivni=1");
	}

	public function setUserByLogin($data, $username, $password)
	{

		return $this->updateRecords($this->getTablename(), $data, "nick='" . $username . "' AND password='" . $password . "' AND aktivni=1");
	}
	public function getUserByToken($token)
	{
		return $this->getUser("t1.token='" . $token . "' and t1.isDeleted=0");
	}

	public function checkEmail($email)
	{
		$user = $this->getUser("t1.email='" . $email . "' and t1.isDeleted=0");
		if ($user) {
			return false;
		}
		return true;
	}
	public function checkNick($nick)
	{
		$user = $this->getUser("t1.nick='" . $nick . "' and t1.isDeleted=0");
		if ($user) {
			return false;
		}
		return true;
	}
	public function setUserByToken($data, $token)
	{
		//print_r($data);
		return $this->updateRecords($this->getTablename(), $data, "token='" . $token . "' AND aktivni=1");
	}

	private function getUser($where)
	{
		$sql = "SELECT UNIX_TIMESTAMP(t1.naposledy) as casnaposledy,f.file,
                 t1.*,
                 t2.title as role_nazev,
                 t2.p1 as role_p1,
				 t2.p2 as role_p2,
				 t2.p3 as role_p3,
				 t2.p4 as role_p4,
				 t2.p5 as role_p5,
				 t2.p6 as role_p6,
				 t2.p7 as role_p7,
				 t2.p8 as role_p8,
				 t2.p9 as role_p9,
				 t2.p10 as role_p10
				 FROM " . $this->getTablename() . " t1
				 left join " . T_ROLES . " as t2 on t1.role=t2.id
				 left join " . T_FOTO . " as f on t1.foto_id=f.id
				WHERE " . $where . " LIMIT 1";
		//print $sql;
		$obj = $this->get_row($sql);
		//print_r($obj);
		//var_dump($obj);
		return $obj;
	}
	public function setLoginStatus($token,$stillIn=0)
	{
		$updateData = array();
		$updateData["token"] = $token;
		$updateData["naposledy"] = date("Y-m-d H:i:s");
		$updateData["ip_adresa"] = $ip;
		$updateData["prihlasen"] = 1;
		$updateData["stillin"] = $stillIn;

		return $this->updateRecords($this->getTablename(),$updateData,"nick='" . $this->nick . "' AND password='" . $this->passMd5 . "' AND aktivni=1");
	}

	public function getList(IListArgs $params = null)
	{

		$params = parent::getListArgs($params);


		$this->addWhere("t1.isDeleted=0");
		if(isset($params->role) && isInt($params->role))
		{
			$this->addWhere("t1.role=".$params->role);
		}

		if(isset($params->aktivni) && isInt($params->aktivni))
		{
			$this->addWhere("t1.aktivni=".$params->aktivni);
		}

		if(isset($params->aktivni_od) && !empty($params->aktivni_od))
		{
			$this->addWhere("t1.naposledy >= '" . $params->aktivni_od . "'");
		}

		if(isset($params->aktivni_do) && !empty($params->aktivni_do))
		{
			$this->addWhere("t1.naposledy <= '" . $params->aktivni_do . "'");
		}
		if(isset($params->novy_od) && !empty($params->novy_od))
		{
			$this->addWhere("t1.TimeStamp >= '" . $params->novy_od . "'");
		}

		if(isset($params->novy_do) && !empty($params->novy_do))
		{
			$this->addWhere("t1.TimeStamp <= '" . $params->novy_do . "'");
		}

		if(isset($params->newsletter) && isInt($params->newsletter))
		{
			$this->addWhere("t1.newsletter=".$params->newsletter);
		}


		if (!empty($params->fulltext)) {
			$this->addWhere("( " .
			 		"LCASE(t1.nick) like '%" . ltrim(strToLower($params->fulltext))."%'" .
                      " OR LCASE(t1.jmeno) like '%" . ltrim(strToLower($params->fulltext))."%'" .
                      " OR LCASE(t1.prijmeni) like '%" . ltrim(strToLower($params->fulltext))."%'" .
                      " OR LCASE(t2.title) like '%" . ltrim(strToLower($params->fulltext))."%'" .
											" ) ");
		}

		if(isset($params->nick) && !empty($params->nick))
		{
			$this->addWhere("t1.nick = '" . $params->nick . "'");
		}

		if(isset($params->jmeno) && !empty($params->jmeno))
		{
			$this->addWhere("t1.jmeno = '" . $params->jmeno . "'");
		}

		if(isset($params->prijmeni) && !empty($params->prijmeni))
		{
			$this->addWhere("t1.prijmeni = '" . $params->prijmeni . "'");
		}

		if(isset($params->email) && !empty($params->email))
		{
			$this->addWhere("t1.email = '" . $params->email . "'");
		}

		$this->setLimit($params->getPage(), $params->getLimit());
/*
		if(isset($params['group']) && !empty($params['group']))
		{
			$this->setGroupBy($params['group']);
		}
		*/



		if(isset($params->like_email) && !empty($params->like_email))
		{
			$this->addWhere("t1.email like '" . $params->like_email . "%'");
		}

		$this->setOrderBy($params->getOrderBy(),'t1.naposledy DESC');



		$this->setSelect("UNIX_TIMESTAMP(t1.naposledy) as casnaposledy,t1.*,t2.title as nazev_role");
		$this->setFrom($this->getTableName() . " as t1
		left join " . T_ROLES . " as t2 on t1.role=t2.id");
		$query = "select count(*) from "
			. $this->getFrom() . " "
			. $this->getWhere() . " "
			. $this->getGroupBy();
		//print $query;
		//print $this->getLimit();
		$this->total = $this->get_var($query);

		$list = $this->getRows();

		for ($i=0;$i < count($list);$i++)
		{
			$list[$i]->link_edit = URL_HOME . 'user_detail?id=' .$list[$i]->id;
		}
		//print $this->last_query;
		return $list;

	}

}


class models_User extends models_Users{}

<?php
/*************
* Třída UserLoginEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class UserLoginEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_user_login";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_user_login";
		$this->metadata["token"] = array("type" => "varchar(100)");
		$this->metadata["ip_adresa"] = array("type" => "varchar(50)","default" => "NULL");
		$this->metadata["user_agent"] = array("type" => "varchar(150)","default" => "NULL");
		$this->metadata["LastLogin"] = array("type" => "datetime","default" => "NULL");
		$this->metadata["user_id"] = array("type" => "int(11)","default" => "NOT NULL","reference" => "User");
	}
	#endregion

	#region Property
	// varchar(100)
	protected $token;

	protected $tokenOriginal;
	// varchar(50)
	protected $ip_adresa = NULL;
	protected $ip_adresaOriginal = NULL;

	// varchar(150)
	protected $user_agent = NULL;
	protected $user_agentOriginal = NULL;

	// datetime
	protected $LastLogin = NULL;
	protected $LastLoginOriginal = NULL;

	// int(11)
	protected $user_id;

	protected $user_idOriginal;
	protected $userUserEntity;

	#endregion

	#region Method
	// Setter token
	protected function setToken($value)
	{
		$this->token = $value;
	}
	// Getter token
	public function getToken()
	{
		return $this->token;
	}
	// Getter tokenOriginal
	public function getTokenOriginal()
	{
		return $this->tokenOriginal;
	}
	// Setter ip_adresa
	protected function setIp_adresa($value)
	{
		$this->ip_adresa = $value;
	}
	// Getter ip_adresa
	public function getIp_adresa()
	{
		return $this->ip_adresa;
	}
	// Getter ip_adresaOriginal
	public function getIp_adresaOriginal()
	{
		return $this->ip_adresaOriginal;
	}
	// Setter user_agent
	protected function setUser_agent($value)
	{
		$this->user_agent = $value;
	}
	// Getter user_agent
	public function getUser_agent()
	{
		return $this->user_agent;
	}
	// Getter user_agentOriginal
	public function getUser_agentOriginal()
	{
		return $this->user_agentOriginal;
	}
	// Setter LastLogin
	protected function setLastLogin($value)
	{
		$this->LastLogin = strToDatetime($value);
	}
	// Getter LastLogin
	public function getLastLogin()
	{
		return $this->LastLogin;
	}
	// Getter LastLoginOriginal
	public function getLastLoginOriginal()
	{
		return $this->LastLoginOriginal;
	}
	// Setter user_id
	protected function setUser_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->user_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->userUserEntity = new UserEntity($value,false);
		} else {
			$this->userUserEntity = null;
		}
	}
	// Getter user_id
	public function getUser_id()
	{
		return $this->user_id;
	}
	// Getter user_idOriginal
	public function getUser_idOriginal()
	{
		return $this->user_idOriginal;
	}
	#endregion

}

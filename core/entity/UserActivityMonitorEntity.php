<?php
/*************
* Třída UserActivityMonitorEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class UserActivityMonitorEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_user_activity_monitor";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_user_activity_monitor";
		$this->metadata["user_id"] = array("type" => "int(11)","reference" => "User");
		$this->metadata["ip_adresa"] = array("type" => "varchar(50)");
		$this->metadata["from_url"] = array("type" => "varchar(255)");
		$this->metadata["to_url"] = array("type" => "varchar(255)");
	}
	#endregion

	#region Property
	// int(11)
	protected $user_id;

	protected $user_idOriginal;
	protected $userUserEntity;

	// varchar(50)
	protected $ip_adresa;

	protected $ip_adresaOriginal;
	// varchar(255)
	protected $from_url;

	protected $from_urlOriginal;
	// varchar(255)
	protected $to_url;

	protected $to_urlOriginal;
	#endregion

	#region Method
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
	// Setter from_url
	protected function setFrom_url($value)
	{
		$this->from_url = $value;
	}
	// Getter from_url
	public function getFrom_url()
	{
		return $this->from_url;
	}
	// Getter from_urlOriginal
	public function getFrom_urlOriginal()
	{
		return $this->from_urlOriginal;
	}
	// Setter to_url
	protected function setTo_url($value)
	{
		$this->to_url = $value;
	}
	// Getter to_url
	public function getTo_url()
	{
		return $this->to_url;
	}
	// Getter to_urlOriginal
	public function getTo_urlOriginal()
	{
		return $this->to_urlOriginal;
	}
	#endregion

}

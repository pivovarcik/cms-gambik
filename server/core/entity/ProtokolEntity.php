<?php
/*************
* Třída ProtokolEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class ProtokolEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_protokol";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_protokol";
		$this->metadata["akce"] = array("type" => "varchar(255)");
		$this->metadata["protokol"] = array("type" => "longtext");
		$this->metadata["user_id"] = array("type" => "int","default" => "null");
		$this->metadata["ip"] = array("type" => "varchar(50)","default" => "null");
		$this->metadata["url"] = array("type" => "varchar(255)");
	}
	#endregion

	#region Property
	// varchar(255)
	protected $akce;

	protected $akceOriginal;
	// longtext
	protected $protokol;

	protected $protokolOriginal;
	// int
	protected $user_id = null;
	protected $user_idOriginal = null;

	// varchar(50)
	protected $ip = null;
	protected $ipOriginal = null;

	// varchar(255)
	protected $url;

	protected $urlOriginal;
	#endregion

	#region Method
	// Setter akce
	protected function setAkce($value)
	{
		$this->akce = $value;
	}
	// Getter akce
	public function getAkce()
	{
		return $this->akce;
	}
	// Getter akceOriginal
	public function getAkceOriginal()
	{
		return $this->akceOriginal;
	}
	// Setter protokol
	protected function setProtokol($value)
	{
		$this->protokol = $value;
	}
	// Getter protokol
	public function getProtokol()
	{
		return $this->protokol;
	}
	// Getter protokolOriginal
	public function getProtokolOriginal()
	{
		return $this->protokolOriginal;
	}
	// Setter user_id
	protected function setUser_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->user_id = $value; }
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
	// Setter ip
	protected function setIp($value)
	{
		$this->ip = $value;
	}
	// Getter ip
	public function getIp()
	{
		return $this->ip;
	}
	// Getter ipOriginal
	public function getIpOriginal()
	{
		return $this->ipOriginal;
	}
	// Setter url
	protected function setUrl($value)
	{
		$this->url = $value;
	}
	// Getter url
	public function getUrl()
	{
		return $this->url;
	}
	// Getter urlOriginal
	public function getUrlOriginal()
	{
		return $this->urlOriginal;
	}
	#endregion

}

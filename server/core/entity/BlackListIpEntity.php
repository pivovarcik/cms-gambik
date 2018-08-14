<?php
/*************
* Třída BlackListIpEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class BlackListIpEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_blacklistip";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_blacklistip";
		$this->metadata["pokusy"] = array("type" => "int","default" => "0");
		$this->metadata["ip"] = array("type" => "varchar(30)");
		$this->metadata["description"] = array("type" => "varchar(255)");
		$this->metadata["active"] = array("type" => "tinyint(1)","default" => "0");
	}
	#endregion

	#region Property
	// int
	protected $pokusy = 0;
	protected $pokusyOriginal = 0;

	// varchar(30)
	protected $ip;

	protected $ipOriginal;
	// varchar(255)
	protected $description;

	protected $descriptionOriginal;
	// tinyint(1)
	protected $active = 0;
	protected $activeOriginal = 0;

	#endregion

	#region Method
	// Setter pokusy
	protected function setPokusy($value)
	{
		if (isInt($value) || is_null($value)) { $this->pokusy = $value; }
	}
	// Getter pokusy
	public function getPokusy()
	{
		return $this->pokusy;
	}
	// Getter pokusyOriginal
	public function getPokusyOriginal()
	{
		return $this->pokusyOriginal;
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
	// Setter description
	protected function setDescription($value)
	{
		$this->description = $value;
	}
	// Getter description
	public function getDescription()
	{
		return $this->description;
	}
	// Getter descriptionOriginal
	public function getDescriptionOriginal()
	{
		return $this->descriptionOriginal;
	}
	// Setter active
	protected function setActive($value)
	{
		$this->active = $value;
	}
	// Getter active
	public function getActive()
	{
		return $this->active;
	}
	// Getter activeOriginal
	public function getActiveOriginal()
	{
		return $this->activeOriginal;
	}
	#endregion

}

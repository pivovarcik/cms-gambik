<?php
/*************
* Třída SettingsEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class SettingsEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_options";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_options";
		$this->metadata["key"] = array("type" => "varchar(100)");
		$this->metadata["value"] = array("type" => "longtext");
	}
	#endregion

	#region Property
	// varchar(100)
	protected $key;

	protected $keyOriginal;
	// longtext
	protected $value;

	protected $valueOriginal;
	#endregion

	#region Method
	// Setter key
	protected function setKey($value)
	{
		$this->key = $value;
	}
	// Getter key
	public function getKey()
	{
		return $this->key;
	}
	// Getter keyOriginal
	public function getKeyOriginal()
	{
		return $this->keyOriginal;
	}
	// Setter value
	protected function setValue($value)
	{
		$this->value = $value;
	}
	// Getter value
	public function getValue()
	{
		return $this->value;
	}
	// Getter valueOriginal
	public function getValueOriginal()
	{
		return $this->valueOriginal;
	}
	#endregion

}

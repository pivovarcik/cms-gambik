<?php
/*************
* Třída MjVersionEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class MjVersionEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_mj_version";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_mj_version";
		$this->metadata["name"] = array("type" => "longtext");
		$this->metadata["lang_id"] = array("type" => "int(11)");
		$this->metadata["mj_id"] = array("type" => "int(11)","default" => "NOT NULL","reference" => "Mj");
	}
	#endregion

	#region Property
	// longtext
	protected $name;

	protected $nameOriginal;
	// int(11)
	protected $lang_id;

	protected $lang_idOriginal;
	// int(11)
	protected $mj_id;

	protected $mj_idOriginal;
	protected $mjMjEntity;

	#endregion

	#region Method
	// Setter name
	protected function setName($value)
	{
		$this->name = $value;
	}
	// Getter name
	public function getName()
	{
		return $this->name;
	}
	// Getter nameOriginal
	public function getNameOriginal()
	{
		return $this->nameOriginal;
	}
	// Setter lang_id
	protected function setLang_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->lang_id = $value; }
	}
	// Getter lang_id
	public function getLang_id()
	{
		return $this->lang_id;
	}
	// Getter lang_idOriginal
	public function getLang_idOriginal()
	{
		return $this->lang_idOriginal;
	}
	// Setter mj_id
	protected function setMj_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->mj_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->mjMjEntity = new MjEntity($value,false);
		} else {
			$this->mjMjEntity = null;
		}
	}
	// Getter mj_id
	public function getMj_id()
	{
		return $this->mj_id;
	}
	// Getter mj_idOriginal
	public function getMj_idOriginal()
	{
		return $this->mj_idOriginal;
	}
	#endregion

}

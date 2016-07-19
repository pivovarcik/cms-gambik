<?php
/*************
* Třída TranslatorVersionEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class TranslatorVersionEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_slovnik_version";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_slovnik_version";
		$this->metadata["name"] = array("type" => "longtext");
		$this->metadata["lang_id"] = array("type" => "int(11)");
		$this->metadata["keyword_id"] = array("type" => "int(11)");
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
	protected $keyword_id;

	protected $keyword_idOriginal;
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
	// Setter keyword_id
	protected function setKeyword_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->keyword_id = $value; }
	}
	// Getter keyword_id
	public function getKeyword_id()
	{
		return $this->keyword_id;
	}
	// Getter keyword_idOriginal
	public function getKeyword_idOriginal()
	{
		return $this->keyword_idOriginal;
	}
	#endregion

}

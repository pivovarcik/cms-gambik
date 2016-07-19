<?php
/*************
* Třída TranslatorEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class TranslatorEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_slovnik";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_slovnik";
		$this->metadata["keyword"] = array("type" => "varchar(50)");
	}
	#endregion

	#region Property
	// varchar(50)
	protected $keyword;

	protected $keywordOriginal;
	#endregion

	#region Method
	// Setter keyword
	protected function setKeyword($value)
	{
		$this->keyword = $value;
	}
	// Getter keyword
	public function getKeyword()
	{
		return $this->keyword;
	}
	// Getter keywordOriginal
	public function getKeywordOriginal()
	{
		return $this->keywordOriginal;
	}
	#endregion

}

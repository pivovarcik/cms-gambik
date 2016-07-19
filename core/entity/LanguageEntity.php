<?php
/*************
* Třída LanguageEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("CiselnikEntity.php");
class LanguageEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_language";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_language";
		$this->metadata["code"] = array("type" => "varchar(2)");
		$this->metadata["active"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["content_language"] = array("type" => "varchar(10)");
	}
	#endregion

	#region Property
	// varchar(2)
	protected $code;

	protected $codeOriginal;
	// tinyint(1)
	protected $active = 0;
	protected $activeOriginal = 0;

	// varchar(10)
	protected $content_language;

	protected $content_languageOriginal;
	#endregion

	#region Method
	// Setter code
	protected function setCode($value)
	{
		$this->code = $value;
	}
	// Getter code
	public function getCode()
	{
		return $this->code;
	}
	// Getter codeOriginal
	public function getCodeOriginal()
	{
		return $this->codeOriginal;
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
	// Setter content_language
	protected function setContent_language($value)
	{
		$this->content_language = $value;
	}
	// Getter content_language
	public function getContent_language()
	{
		return $this->content_language;
	}
	// Getter content_languageOriginal
	public function getContent_languageOriginal()
	{
		return $this->content_languageOriginal;
	}
	#endregion

}

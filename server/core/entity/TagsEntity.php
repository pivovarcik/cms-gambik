<?php
/*************
* Třída TagsEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("CiselnikEntity.php");
class TagsEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_tagy";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_tagy";
		$this->metadata["lang_id"] = array("type" => "int(11)");
		$this->metadata["url"] = array("type" => "varchar(100)");
	}
	#endregion

	#region Property
	// int(11)
	protected $lang_id;

	protected $lang_idOriginal;
	// varchar(100)
	protected $url;

	protected $urlOriginal;
	#endregion

	#region Method
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

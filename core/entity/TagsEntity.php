<?php
/*************
* Třída TagsEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
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
	}
	#endregion

	#region Property
	// int(11)
	protected $lang_id;

	protected $lang_idOriginal;
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
	#endregion

}

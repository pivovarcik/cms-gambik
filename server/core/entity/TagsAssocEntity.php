<?php
/*************
* Třída TagsAssocEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class TagsAssocEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_tagy_assoc";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_tagy_assoc";
		$this->metadata["page_id"] = array("type" => "int(11)");
		$this->metadata["tag_id"] = array("type" => "int(11)","reference" => "Tags");
		$this->metadata["page_type"] = array("type" => "varchar(50)");
	}
	#endregion

	#region Property
	// int(11)
	protected $page_id;

	protected $page_idOriginal;
	// int(11)
	protected $tag_id;

	protected $tag_idOriginal;
	protected $tagTagsEntity;

	// varchar(50)
	protected $page_type;

	protected $page_typeOriginal;
	#endregion

	#region Method
	// Setter page_id
	protected function setPage_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->page_id = $value; }
	}
	// Getter page_id
	public function getPage_id()
	{
		return $this->page_id;
	}
	// Getter page_idOriginal
	public function getPage_idOriginal()
	{
		return $this->page_idOriginal;
	}
	// Setter tag_id
	protected function setTag_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->tag_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->tagTagsEntity = new TagsEntity($value,false);
		} else {
			$this->tagTagsEntity = null;
		}
	}
	// Getter tag_id
	public function getTag_id()
	{
		return $this->tag_id;
	}
	// Getter tag_idOriginal
	public function getTag_idOriginal()
	{
		return $this->tag_idOriginal;
	}
	// Setter page_type
	protected function setPage_type($value)
	{
		$this->page_type = $value;
	}
	// Getter page_type
	public function getPage_type()
	{
		return $this->page_type;
	}
	// Getter page_typeOriginal
	public function getPage_typeOriginal()
	{
		return $this->page_typeOriginal;
	}
	#endregion

}

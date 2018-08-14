<?php
/*************
* Třída PageStatusEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class PageStatusEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_page_status";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_page_status";
		$this->metadata["type"] = array("type" => "varchar(25)");
		$this->metadata["description"] = array("type" => "varchar(255)");
	}
	#endregion

	#region Property
	// varchar(25)
	protected $type;

	protected $typeOriginal;
	// varchar(255)
	protected $description;

	protected $descriptionOriginal;
	#endregion

	#region Method
	// Setter type
	protected function setType($value)
	{
		$this->type = $value;
	}
	// Getter type
	public function getType()
	{
		return $this->type;
	}
	// Getter typeOriginal
	public function getTypeOriginal()
	{
		return $this->typeOriginal;
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
	#endregion

}

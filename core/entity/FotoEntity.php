<?php
/*************
* Třída FotoEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class FotoEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_foto";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_foto";
		$this->metadata["file"] = array("type" => "varchar(150)");
		$this->metadata["description"] = array("type" => "varchar(255)");
		$this->metadata["size"] = array("type" => "int","default" => "0");
		$this->metadata["type"] = array("type" => "varchar(10)","default" => "null");
		$this->metadata["user_id"] = array("type" => "int","default" => "0");
	}
	#endregion

	#region Property
	// varchar(150)
	protected $file;

	protected $fileOriginal;
	// varchar(255)
	protected $description;

	protected $descriptionOriginal;
	// int
	protected $size = 0;
	protected $sizeOriginal = 0;

	// varchar(10)
	protected $type = null;
	protected $typeOriginal = null;

	// int
	protected $user_id = 0;
	protected $user_idOriginal = 0;

	#endregion

	#region Method
	// Setter file
	protected function setFile($value)
	{
		$this->file = $value;
	}
	// Getter file
	public function getFile()
	{
		return $this->file;
	}
	// Getter fileOriginal
	public function getFileOriginal()
	{
		return $this->fileOriginal;
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
	// Setter size
	protected function setSize($value)
	{
		if (isInt($value) || is_null($value)) { $this->size = $value; }
	}
	// Getter size
	public function getSize()
	{
		return $this->size;
	}
	// Getter sizeOriginal
	public function getSizeOriginal()
	{
		return $this->sizeOriginal;
	}
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
	// Setter user_id
	protected function setUser_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->user_id = $value; }
	}
	// Getter user_id
	public function getUser_id()
	{
		return $this->user_id;
	}
	// Getter user_idOriginal
	public function getUser_idOriginal()
	{
		return $this->user_idOriginal;
	}
	#endregion

}

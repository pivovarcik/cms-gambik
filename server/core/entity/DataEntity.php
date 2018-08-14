<?php
/*************
* Třída DataEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class DataEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_data";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_data";
		$this->metadata["file"] = array("type" => "varchar(150)");
		$this->metadata["filename_original"] = array("type" => "varchar(150)");
		$this->metadata["description"] = array("type" => "varchar(255)");
		$this->metadata["size"] = array("type" => "int","default" => "0");
		$this->metadata["type"] = array("type" => "varchar(10)","default" => "null");
		$this->metadata["user_id"] = array("type" => "int","default" => "0");
		$this->metadata["tabulka"] = array("type" => "varchar(50)");
		$this->metadata["dir"] = array("type" => "varchar(100)");
	}
	#endregion

	#region Property
	// varchar(150)
	protected $file;

	protected $fileOriginal;
	// varchar(150)
	protected $filename_original;

	protected $filename_originalOriginal;
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

	// varchar(50)
	protected $tabulka;

	protected $tabulkaOriginal;
	// varchar(100)
	protected $dir;

	protected $dirOriginal;
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
	// Setter filename_original
	protected function setFilename_original($value)
	{
		$this->filename_original = $value;
	}
	// Getter filename_original
	public function getFilename_original()
	{
		return $this->filename_original;
	}
	// Getter filename_originalOriginal
	public function getFilename_originalOriginal()
	{
		return $this->filename_originalOriginal;
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
	// Setter tabulka
	protected function setTabulka($value)
	{
		$this->tabulka = $value;
	}
	// Getter tabulka
	public function getTabulka()
	{
		return $this->tabulka;
	}
	// Getter tabulkaOriginal
	public function getTabulkaOriginal()
	{
		return $this->tabulkaOriginal;
	}
	// Setter dir
	protected function setDir($value)
	{
		$this->dir = $value;
	}
	// Getter dir
	public function getDir()
	{
		return $this->dir;
	}
	// Getter dirOriginal
	public function getDirOriginal()
	{
		return $this->dirOriginal;
	}
	#endregion

}

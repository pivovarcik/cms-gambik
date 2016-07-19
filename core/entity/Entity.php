<?php
/*************
* Třída Entity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("AEntity.php");
abstract class Entity extends AEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		parent::__construct($entity, $lazyLoad);
		$this->metadata["id"] = array("type" => "int(11)","scope" => "public");
		$this->metadata["isDeleted"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["TimeStamp"] = array("type" => "datetime","default" => "NULL","scope" => "private");
		$this->metadata["ChangeTimeStamp"] = array("type" => "datetime","default" => "NULL","scope" => "private");
	}
	#endregion

	#region Property
	// int(11)
	protected $id;

	protected $idOriginal;
	// tinyint(1)
	protected $isDeleted = 0;
	protected $isDeletedOriginal = 0;

	// datetime
	protected $TimeStamp = NULL;
	protected $TimeStampOriginal = NULL;

	// datetime
	protected $ChangeTimeStamp = NULL;
	protected $ChangeTimeStampOriginal = NULL;

	#endregion

	#region Method
	// Setter id
	protected function setId($value)
	{
		if (isInt($value) || is_null($value)) { $this->id = $value; }
	}
	// Getter id
	public function getId()
	{
		return $this->id;
	}
	// Getter idOriginal
	public function getIdOriginal()
	{
		return $this->idOriginal;
	}
	// Setter isDeleted
	protected function setIsDeleted($value)
	{
		$this->isDeleted = $value;
	}
	// Getter isDeleted
	public function getIsDeleted()
	{
		return $this->isDeleted;
	}
	// Getter isDeletedOriginal
	public function getIsDeletedOriginal()
	{
		return $this->isDeletedOriginal;
	}
	// Getter TimeStamp
	public function getTimeStamp()
	{
		return $this->TimeStamp;
	}
	// Getter TimeStampOriginal
	public function getTimeStampOriginal()
	{
		return $this->TimeStampOriginal;
	}
	// Getter ChangeTimeStamp
	public function getChangeTimeStamp()
	{
		return $this->ChangeTimeStamp;
	}
	// Getter ChangeTimeStampOriginal
	public function getChangeTimeStampOriginal()
	{
		return $this->ChangeTimeStampOriginal;
	}
	#endregion

}

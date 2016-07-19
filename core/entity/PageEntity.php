<?php
/*************
* Třída PageEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
abstract class PageEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		parent::__construct($entity, $lazyLoad);
		$this->metadata["status_id"] = array("type" => "int(11)","default" => "0","index" => "1");
		$this->metadata["user_id"] = array("type" => "int(11)","default" => "NULL","reference" => "User");
		$this->metadata["category_id"] = array("type" => "int(11)","default" => "NULL","reference" => "Category");
		$this->metadata["level"] = array("type" => "int(11)","default" => "0","index" => "1");
		$this->metadata["views"] = array("type" => "int(11)","default" => "0");
		$this->metadata["version"] = array("type" => "int(11)","default" => "0","index" => "1");
		$this->metadata["file_id"] = array("type" => "int(11)","default" => "NULL","reference" => "Data");
		$this->metadata["foto_id"] = array("type" => "int(11)","default" => "NULL","reference" => "Foto");
		$this->metadata["reference"] = array("type" => "varchar(150)","default" => "NULL");
		$this->metadata["pristup"] = array("type" => "tinyint(1)","default" => "1");
	}
	#endregion

	#region Property
	// int(11)
	protected $status_id = 0;
	protected $status_idOriginal = 0;

	// int(11)
	protected $user_id = NULL;
	protected $user_idOriginal = NULL;

	protected $userUserEntity;

	// int(11)
	protected $category_id = NULL;
	protected $category_idOriginal = NULL;

	protected $categoryCategoryEntity;

	// int(11)
	protected $level = 0;
	protected $levelOriginal = 0;

	// int(11)
	protected $views = 0;
	protected $viewsOriginal = 0;

	// int(11)
	protected $version = 0;
	protected $versionOriginal = 0;

	// int(11)
	protected $file_id = NULL;
	protected $file_idOriginal = NULL;

	protected $fileDataEntity;

	// int(11)
	protected $foto_id = NULL;
	protected $foto_idOriginal = NULL;

	protected $fotoFotoEntity;

	// varchar(150)
	protected $reference = NULL;
	protected $referenceOriginal = NULL;

	// tinyint(1)
	protected $pristup = 1;
	protected $pristupOriginal = 1;

	#endregion

	#region Method
	// Setter status_id
	protected function setStatus_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->status_id = $value; }
	}
	// Getter status_id
	public function getStatus_id()
	{
		return $this->status_id;
	}
	// Getter status_idOriginal
	public function getStatus_idOriginal()
	{
		return $this->status_idOriginal;
	}
	// Setter user_id
	protected function setUser_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->user_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->userUserEntity = new UserEntity($value,false);
		} else {
			$this->userUserEntity = null;
		}
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
	// Setter category_id
	protected function setCategory_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->category_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->categoryCategoryEntity = new CategoryEntity($value,false);
		} else {
			$this->categoryCategoryEntity = null;
		}
	}
	// Getter category_id
	public function getCategory_id()
	{
		return $this->category_id;
	}
	// Getter category_idOriginal
	public function getCategory_idOriginal()
	{
		return $this->category_idOriginal;
	}
	// Setter level
	protected function setLevel($value)
	{
		if (isInt($value) || is_null($value)) { $this->level = $value; }
	}
	// Getter level
	public function getLevel()
	{
		return $this->level;
	}
	// Getter levelOriginal
	public function getLevelOriginal()
	{
		return $this->levelOriginal;
	}
	// Setter views
	protected function setViews($value)
	{
		if (isInt($value) || is_null($value)) { $this->views = $value; }
	}
	// Getter views
	public function getViews()
	{
		return $this->views;
	}
	// Getter viewsOriginal
	public function getViewsOriginal()
	{
		return $this->viewsOriginal;
	}
	// Setter version
	protected function setVersion($value)
	{
		if (isInt($value) || is_null($value)) { $this->version = $value; }
	}
	// Getter version
	public function getVersion()
	{
		return $this->version;
	}
	// Getter versionOriginal
	public function getVersionOriginal()
	{
		return $this->versionOriginal;
	}
	// Setter file_id
	protected function setFile_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->file_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->fileDataEntity = new DataEntity($value,false);
		} else {
			$this->fileDataEntity = null;
		}
	}
	// Getter file_id
	public function getFile_id()
	{
		return $this->file_id;
	}
	// Getter file_idOriginal
	public function getFile_idOriginal()
	{
		return $this->file_idOriginal;
	}
	// Setter foto_id
	protected function setFoto_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->foto_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->fotoFotoEntity = new FotoEntity($value,false);
		} else {
			$this->fotoFotoEntity = null;
		}
	}
	// Getter foto_id
	public function getFoto_id()
	{
		return $this->foto_id;
	}
	// Getter foto_idOriginal
	public function getFoto_idOriginal()
	{
		return $this->foto_idOriginal;
	}
	// Setter reference
	protected function setReference($value)
	{
		$this->reference = $value;
	}
	// Getter reference
	public function getReference()
	{
		return $this->reference;
	}
	// Getter referenceOriginal
	public function getReferenceOriginal()
	{
		return $this->referenceOriginal;
	}
	// Setter pristup
	protected function setPristup($value)
	{
		$this->pristup = $value;
	}
	// Getter pristup
	public function getPristup()
	{
		return $this->pristup;
	}
	// Getter pristupOriginal
	public function getPristupOriginal()
	{
		return $this->pristupOriginal;
	}
	#endregion

}

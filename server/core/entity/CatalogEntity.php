<?php
/*************
* Třída CatalogEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("PageEntity.php");
class CatalogEntity extends PageEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_catalog";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_catalog";
		$this->metadata["showPosted"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["vlastnik_id"] = array("type" => "int","reference" => "User");
		$this->metadata["user_edit_id"] = array("type" => "int","reference" => "User");
		$this->metadata["counter"] = array("type" => "int","default" => "0");
		$this->metadata["foto_id"] = array("type" => "int","default" => "null","reference" => "Foto");
		$this->metadata["logo_id"] = array("type" => "int","default" => "null","reference" => "Foto");
		$this->metadata["catalog_group_id"] = array("type" => "int","default" => "null","reference" => "CatalogGroup");
	}
	#endregion

	#region Property
	// tinyint(1)
	protected $showPosted = 0;
	protected $showPostedOriginal = 0;

	// int
	protected $vlastnik_id;

	protected $vlastnik_idOriginal;
	protected $vlastnikUserEntity;

	// int
	protected $user_edit_id;

	protected $user_edit_idOriginal;
	protected $user_editUserEntity;

	// int
	protected $counter = 0;
	protected $counterOriginal = 0;

	// int
	protected $foto_id = null;
	protected $foto_idOriginal = null;

	protected $fotoFotoEntity;

	// int
	protected $logo_id = null;
	protected $logo_idOriginal = null;

	protected $logoFotoEntity;

	// int
	protected $catalog_group_id = null;
	protected $catalog_group_idOriginal = null;

	protected $catalog_groupCatalogGroupEntity;

	#endregion

	#region Method
	// Setter showPosted
	protected function setShowPosted($value)
	{
		$this->showPosted = $value;
	}
	// Getter showPosted
	public function getShowPosted()
	{
		return $this->showPosted;
	}
	// Getter showPostedOriginal
	public function getShowPostedOriginal()
	{
		return $this->showPostedOriginal;
	}
	// Setter vlastnik_id
	protected function setVlastnik_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->vlastnik_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->vlastnikUserEntity = new UserEntity($value,false);
		} else {
			$this->vlastnikUserEntity = null;
		}
	}
	// Getter vlastnik_id
	public function getVlastnik_id()
	{
		return $this->vlastnik_id;
	}
	// Getter vlastnik_idOriginal
	public function getVlastnik_idOriginal()
	{
		return $this->vlastnik_idOriginal;
	}
	// Setter user_edit_id
	protected function setUser_edit_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->user_edit_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->user_editUserEntity = new UserEntity($value,false);
		} else {
			$this->user_editUserEntity = null;
		}
	}
	// Getter user_edit_id
	public function getUser_edit_id()
	{
		return $this->user_edit_id;
	}
	// Getter user_edit_idOriginal
	public function getUser_edit_idOriginal()
	{
		return $this->user_edit_idOriginal;
	}
	// Setter counter
	protected function setCounter($value)
	{
		if (isInt($value) || is_null($value)) { $this->counter = $value; }
	}
	// Getter counter
	public function getCounter()
	{
		return $this->counter;
	}
	// Getter counterOriginal
	public function getCounterOriginal()
	{
		return $this->counterOriginal;
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
	// Setter logo_id
	protected function setLogo_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->logo_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->logoFotoEntity = new FotoEntity($value,false);
		} else {
			$this->logoFotoEntity = null;
		}
	}
	// Getter logo_id
	public function getLogo_id()
	{
		return $this->logo_id;
	}
	// Getter logo_idOriginal
	public function getLogo_idOriginal()
	{
		return $this->logo_idOriginal;
	}
	// Setter catalog_group_id
	protected function setCatalog_group_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->catalog_group_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->catalog_groupCatalogGroupEntity = new CatalogGroupEntity($value,false);
		} else {
			$this->catalog_groupCatalogGroupEntity = null;
		}
	}
	// Getter catalog_group_id
	public function getCatalog_group_id()
	{
		return $this->catalog_group_id;
	}
	// Getter catalog_group_idOriginal
	public function getCatalog_group_idOriginal()
	{
		return $this->catalog_group_idOriginal;
	}
	#endregion

}

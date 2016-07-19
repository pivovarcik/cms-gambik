<?php
/*************
* Třída CatalogVersionEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("PageVersionEntity.php");
class CatalogVersionEntity extends PageVersionEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_catalog_version";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_catalog_version";
		$this->metadata["foto_id"] = array("type" => "int","default" => "null","reference" => "Foto");
		$this->metadata["status_id"] = array("type" => "int","default" => "0");
		$this->metadata["poradi"] = array("type" => "int","default" => "0");
		$this->metadata["interni_poznamka"] = array("type" => "longtext","default" => "null");
		$this->metadata["email"] = array("type" => "varchar(150)","default" => "null");
	}
	#endregion

	#region Property
	// int
	protected $foto_id = null;
	protected $foto_idOriginal = null;

	protected $fotoFotoEntity;

	// int
	protected $status_id = 0;
	protected $status_idOriginal = 0;

	// int
	protected $poradi = 0;
	protected $poradiOriginal = 0;

	// longtext
	protected $interni_poznamka = null;
	protected $interni_poznamkaOriginal = null;

	// varchar(150)
	protected $email = null;
	protected $emailOriginal = null;

	#endregion

	#region Method
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
	// Setter poradi
	protected function setPoradi($value)
	{
		if (isInt($value) || is_null($value)) { $this->poradi = $value; }
	}
	// Getter poradi
	public function getPoradi()
	{
		return $this->poradi;
	}
	// Getter poradiOriginal
	public function getPoradiOriginal()
	{
		return $this->poradiOriginal;
	}
	// Setter interni_poznamka
	protected function setInterni_poznamka($value)
	{
		$this->interni_poznamka = $value;
	}
	// Getter interni_poznamka
	public function getInterni_poznamka()
	{
		return $this->interni_poznamka;
	}
	// Getter interni_poznamkaOriginal
	public function getInterni_poznamkaOriginal()
	{
		return $this->interni_poznamkaOriginal;
	}
	// Setter email
	protected function setEmail($value)
	{
		$this->email = $value;
	}
	// Getter email
	public function getEmail()
	{
		return $this->email;
	}
	// Getter emailOriginal
	public function getEmailOriginal()
	{
		return $this->emailOriginal;
	}
	#endregion

}

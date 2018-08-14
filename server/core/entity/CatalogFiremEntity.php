<?php
/*************
* Třída CatalogFiremEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("CatalogEntity.php");
class CatalogFiremEntity extends CatalogEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_catalog_firem";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_catalog_firem";
		$this->metadata["mesto_id"] = array("type" => "int","default" => "0");
		$this->metadata["vip"] = array("type" => "int","default" => "0");
		$this->metadata["cenik_id"] = array("type" => "int","default" => "NULL","reference" => "ProductCenik");
	}
	#endregion

	#region Property
	// int
	protected $mesto_id = 0;
	protected $mesto_idOriginal = 0;

	// int
	protected $vip = 0;
	protected $vipOriginal = 0;

	// int
	protected $cenik_id = NULL;
	protected $cenik_idOriginal = NULL;

	protected $cenikProductCenikEntity;

	#endregion

	#region Method
	// Setter mesto_id
	protected function setMesto_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->mesto_id = $value; }
	}
	// Getter mesto_id
	public function getMesto_id()
	{
		return $this->mesto_id;
	}
	// Getter mesto_idOriginal
	public function getMesto_idOriginal()
	{
		return $this->mesto_idOriginal;
	}
	// Setter vip
	protected function setVip($value)
	{
		if (isInt($value) || is_null($value)) { $this->vip = $value; }
	}
	// Getter vip
	public function getVip()
	{
		return $this->vip;
	}
	// Getter vipOriginal
	public function getVipOriginal()
	{
		return $this->vipOriginal;
	}
	// Setter cenik_id
	protected function setCenik_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->cenik_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->cenikProductCenikEntity = new ProductCenikEntity($value,false);
		} else {
			$this->cenikProductCenikEntity = null;
		}
	}
	// Getter cenik_id
	public function getCenik_id()
	{
		return $this->cenik_id;
	}
	// Getter cenik_idOriginal
	public function getCenik_idOriginal()
	{
		return $this->cenik_idOriginal;
	}
	#endregion

}

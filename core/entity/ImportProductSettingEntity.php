<?php
/*************
* Třída ImportProductSettingEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once(PATH_ROOT . 'core/entity/' . "CiselnikEntity.php");
class ImportProductSettingEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_import_product_setting";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_import_product_setting";
		$this->metadata["deactive_product"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["import_product_is_active"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["import_images"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["url"] = array("type" => "varchar(255)");
		$this->metadata["nextid_product"] = array("type" => "int","default" => "NULL");
		$this->metadata["block_size"] = array("type" => "int","default" => "0");
	}
	#endregion

	#region Property
	// tinyint(1)
	protected $deactive_product = 0;
	protected $deactive_productOriginal = 0;

	// tinyint(1)
	protected $import_product_is_active = 0;
	protected $import_product_is_activeOriginal = 0;

	// tinyint(1)
	protected $import_images = 0;
	protected $import_imagesOriginal = 0;

	// varchar(255)
	protected $url;

	protected $urlOriginal;
	// int
	protected $nextid_product = NULL;
	protected $nextid_productOriginal = NULL;

	// int
	protected $block_size = 0;
	protected $block_sizeOriginal = 0;

	#endregion

	#region Method
	// Setter deactive_product
	protected function setDeactive_product($value)
	{
		$this->deactive_product = $value;
	}
	// Getter deactive_product
	public function getDeactive_product()
	{
		return $this->deactive_product;
	}
	// Getter deactive_productOriginal
	public function getDeactive_productOriginal()
	{
		return $this->deactive_productOriginal;
	}
	// Setter import_product_is_active
	protected function setImport_product_is_active($value)
	{
		$this->import_product_is_active = $value;
	}
	// Getter import_product_is_active
	public function getImport_product_is_active()
	{
		return $this->import_product_is_active;
	}
	// Getter import_product_is_activeOriginal
	public function getImport_product_is_activeOriginal()
	{
		return $this->import_product_is_activeOriginal;
	}
	// Setter import_images
	protected function setImport_images($value)
	{
		$this->import_images = $value;
	}
	// Getter import_images
	public function getImport_images()
	{
		return $this->import_images;
	}
	// Getter import_imagesOriginal
	public function getImport_imagesOriginal()
	{
		return $this->import_imagesOriginal;
	}
	// Setter url
	protected function setUrl($value)
	{
		$this->url = $value;
	}
	// Getter url
	public function getUrl()
	{
		return $this->url;
	}
	// Getter urlOriginal
	public function getUrlOriginal()
	{
		return $this->urlOriginal;
	}
	// Setter nextid_product
	protected function setNextid_product($value)
	{
		if (isInt($value) || is_null($value)) { $this->nextid_product = $value; }
	}
	// Getter nextid_product
	public function getNextid_product()
	{
		return $this->nextid_product;
	}
	// Getter nextid_productOriginal
	public function getNextid_productOriginal()
	{
		return $this->nextid_productOriginal;
	}
	// Setter block_size
	protected function setBlock_size($value)
	{
		if (isInt($value) || is_null($value)) { $this->block_size = $value; }
	}
	// Getter block_size
	public function getBlock_size()
	{
		return $this->block_size;
	}
	// Getter block_sizeOriginal
	public function getBlock_sizeOriginal()
	{
		return $this->block_sizeOriginal;
	}
	#endregion

}

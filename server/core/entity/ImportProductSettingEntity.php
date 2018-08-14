<?php
/*************
* Třída ImportProductSettingEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once(PATH_ROOT2 . 'core/entity/' . "CiselnikEntity.php");
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
		$this->metadata["import_reference"] = array("type" => "varchar(25)","default" => "NULL");
		$this->metadata["shop_items"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["sync_price"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["sync_stav"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["sync_aktivni"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["create_category"] = array("type" => "tinyint(1)","default" => "0");
		$this->metadata["cron_hodina"] = array("type" => "int","default" => "99");
		$this->metadata["syncLastId"] = array("type" => "int","default" => "0");
		$this->metadata["syncStatus"] = array("type" => "int","default" => "0");
		$this->metadata["syncLastTimeStamp"] = array("type" => "datetime","default" => "null");
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

	// varchar(25)
	protected $import_reference = NULL;
	protected $import_referenceOriginal = NULL;

	// varchar(255)
	protected $shop_items = NULL;
	protected $shop_itemsOriginal = NULL;

	// tinyint(1)
	protected $sync_price = 0;
	protected $sync_priceOriginal = 0;

	// tinyint(1)
	protected $sync_stav = 0;
	protected $sync_stavOriginal = 0;

	// tinyint(1)
	protected $sync_aktivni = 0;
	protected $sync_aktivniOriginal = 0;

	// tinyint(1)
	protected $create_category = 0;
	protected $create_categoryOriginal = 0;

	// int
	protected $cron_hodina = 99;
	protected $cron_hodinaOriginal = 99;

	// int
	protected $syncLastId = 0;
	protected $syncLastIdOriginal = 0;

	// int
	protected $syncStatus = 0;
	protected $syncStatusOriginal = 0;

	// datetime
	protected $syncLastTimeStamp = null;
	protected $syncLastTimeStampOriginal = null;

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
	// Setter import_reference
	protected function setImport_reference($value)
	{
		$this->import_reference = $value;
	}
	// Getter import_reference
	public function getImport_reference()
	{
		return $this->import_reference;
	}
	// Getter import_referenceOriginal
	public function getImport_referenceOriginal()
	{
		return $this->import_referenceOriginal;
	}
	// Setter shop_items
	protected function setShop_items($value)
	{
		$this->shop_items = $value;
	}
	// Getter shop_items
	public function getShop_items()
	{
		return $this->shop_items;
	}
	// Getter shop_itemsOriginal
	public function getShop_itemsOriginal()
	{
		return $this->shop_itemsOriginal;
	}
	// Setter sync_price
	protected function setSync_price($value)
	{
		$this->sync_price = $value;
	}
	// Getter sync_price
	public function getSync_price()
	{
		return $this->sync_price;
	}
	// Getter sync_priceOriginal
	public function getSync_priceOriginal()
	{
		return $this->sync_priceOriginal;
	}
	// Setter sync_stav
	protected function setSync_stav($value)
	{
		$this->sync_stav = $value;
	}
	// Getter sync_stav
	public function getSync_stav()
	{
		return $this->sync_stav;
	}
	// Getter sync_stavOriginal
	public function getSync_stavOriginal()
	{
		return $this->sync_stavOriginal;
	}
	// Setter sync_aktivni
	protected function setSync_aktivni($value)
	{
		$this->sync_aktivni = $value;
	}
	// Getter sync_aktivni
	public function getSync_aktivni()
	{
		return $this->sync_aktivni;
	}
	// Getter sync_aktivniOriginal
	public function getSync_aktivniOriginal()
	{
		return $this->sync_aktivniOriginal;
	}
	// Setter create_category
	protected function setCreate_category($value)
	{
		$this->create_category = $value;
	}
	// Getter create_category
	public function getCreate_category()
	{
		return $this->create_category;
	}
	// Getter create_categoryOriginal
	public function getCreate_categoryOriginal()
	{
		return $this->create_categoryOriginal;
	}
	// Setter cron_hodina
	protected function setCron_hodina($value)
	{
		if (isInt($value) || is_null($value)) { $this->cron_hodina = $value; }
	}
	// Getter cron_hodina
	public function getCron_hodina()
	{
		return $this->cron_hodina;
	}
	// Getter cron_hodinaOriginal
	public function getCron_hodinaOriginal()
	{
		return $this->cron_hodinaOriginal;
	}
	// Setter syncLastId
	protected function setSyncLastId($value)
	{
		if (isInt($value) || is_null($value)) { $this->syncLastId = $value; }
	}
	// Getter syncLastId
	public function getSyncLastId()
	{
		return $this->syncLastId;
	}
	// Getter syncLastIdOriginal
	public function getSyncLastIdOriginal()
	{
		return $this->syncLastIdOriginal;
	}
	// Setter syncStatus
	protected function setSyncStatus($value)
	{
		if (isInt($value) || is_null($value)) { $this->syncStatus = $value; }
	}
	// Getter syncStatus
	public function getSyncStatus()
	{
		return $this->syncStatus;
	}
	// Getter syncStatusOriginal
	public function getSyncStatusOriginal()
	{
		return $this->syncStatusOriginal;
	}
	// Setter syncLastTimeStamp
	protected function setSyncLastTimeStamp($value)
	{
		$this->syncLastTimeStamp = strToDatetime($value);
	}
	// Getter syncLastTimeStamp
	public function getSyncLastTimeStamp()
	{
		return $this->syncLastTimeStamp;
	}
	// Getter syncLastTimeStampOriginal
	public function getSyncLastTimeStampOriginal()
	{
		return $this->syncLastTimeStampOriginal;
	}
	#endregion

}

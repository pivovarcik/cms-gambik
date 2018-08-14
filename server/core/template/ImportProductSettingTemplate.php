<?php
define("T_IMPORT_PRODUCT_SET",DB_PREFIX . "import_product_setting");

/**
 * Entita pro Kategorie
 *
 */

require_once("Template.php");

class ImportProductSettingTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_IMPORT_PRODUCT_SET;
		$this->parent = "CiselnikEntity";
		$this->path =  "PATH_ROOT2 . 'core/entity/' . ";

		$this->_attributtes["deactive_product"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["import_product_is_active"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["import_images"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["url"] = array("type" => "varchar(255)");
		$this->_attributtes["nextid_product"] = array("type" => "int", "default" => "NULL");
		$this->_attributtes["block_size"] = array("type" => "int", "default" => "0");


		$this->_attributtes["import_reference"] = array("type" => "varchar(25)", "default" => "NULL");
		$this->_attributtes["shop_items"] = array("type" => "varchar(255)", "default" => "NULL");



		$this->_attributtes["sync_price"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["sync_stav"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["sync_aktivni"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["create_category"] = array("type" => "tinyint(1)", "default" => "0");


		$this->_attributtes["cron_hodina"] = array("type" => "int", "default" => "99");
		$this->_attributtes["syncLastId"] = array("type" => "int", "default" => "0");
		$this->_attributtes["syncStatus"] = array("type" => "int", "default" => "0");
		$this->_attributtes["syncLastTimeStamp"] = array("type" => "datetime", "default" => "null");

	}
}

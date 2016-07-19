<?php
define("T_IMPORT_PRODUCT_SET",DB_PREFIX . "import_product_setting");

/**
 * Entita pro Kategorie
 *
 */

require_once(PATH_ROOT . "core/template/Template.php");

class ImportProductSettingTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_IMPORT_PRODUCT_SET;
		$this->parent = "CiselnikEntity";
		$this->path =  "PATH_ROOT . 'core/entity/' . ";

		$this->_attributtes["deactive_product"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["import_product_is_active"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["import_images"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["url"] = array("type" => "varchar(255)");
		$this->_attributtes["nextid_product"] = array("type" => "int", "default" => "NULL");
		$this->_attributtes["block_size"] = array("type" => "int", "default" => "0");

	}
}

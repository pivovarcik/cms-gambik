<?php
define("T_CATEGORY",DB_PREFIX . "category");

/**
 * Entita pro Kategorie
 *
 */
require_once("Template.php");
class CategoryTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_CATEGORY;
		$this->parent = "PageEntity";

//		$this->_primary = 'id';
		//$this->_attributtes["id"] = array("type" => "int(11)");
		//$this->_attributtes["type_id"] = array("type" => "int(11)");
		$this->_attributtes["showPosted"] = array("type" => "tinyint(1)", "default" => "0");

		// přístupná role
		$this->_attributtes["role"] = array("type" => "tinyint(1)", "default" => "0");
	//	$this->_attributtes["category"] = array("type" => "int(11)", "default" => "NULL");
		$this->_attributtes["classLi"] = array("type" => "varchar(25)", "default" => "NULL");
		$this->_attributtes["classA"] = array("type" => "varchar(25)", "default" => "NULL");

		$this->_attributtes["icon_class"] = array("type" => "varchar(25)", "default" => "NULL");


		$this->_attributtes["logo_url"] = array("type" => "varchar(255)", "default" => "NULL");
		//$this->_attributtes["user_id"] = array("type" => "int(11)", "default" => "NULL");
//		$this->_attributtes["version"] = array("type" => "int(11)", "default" => "0");
	}
}

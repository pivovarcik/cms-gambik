<?php

/**
 * Abstraktní třída pro verzování různých typů stránek
 *
 */
require_once("Template.php");
class ViewCategoryTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = 'view_category';
		// foregin key Lang
		$this->_attributtes["lang_id"] = array("type" => "int(11)", "default" => "NOT NULL", "reference" => "Language");
		//foregin key Page
		$this->_attributtes["parent_id"] = array("type" => "int(11)", "default" => "NULL");
	//	$this->_attributtes["user_id"] = array("type" => "int(11)", "default" => "NOT NULL", "reference" => "User");
		$this->_attributtes["level"] = array("type" => "int(11)", "default" => "NOT NULL");

		$this->_attributtes["category_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "Category");

		$this->_attributtes["title"] = array("type" => "varchar(255)", "default" => "NOT NULL");
	//	$this->_attributtes["description"] = array("type" => "longtext");
		$this->_attributtes["serial_cat_id"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["serial_cat_url"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["serial_cat_title"] = array("type" => "varchar(255)", "default" => "NULL");

		$this->_attributtes["icon_class"] = array("type" => "varchar(25)", "default" => "NULL");


	}
}

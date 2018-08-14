<?php

/**
 * Abstraktní třída pro verzování různých typů stránek
 *
 */
require_once("Template.php");
class PageVersionTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = '';
		// foregin key Lang
		$this->_attributtes["lang_id"] = array("type" => "int(11)", "default" => "NOT NULL", "reference" => "Language");
		//foregin key Page
		$this->_attributtes["page_id"] = array("type" => "int(11)", "default" => "NOT NULL");
		$this->_attributtes["user_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "User");
		$this->_attributtes["version"] = array("type" => "int(11)", "default" => "0", "index" => true);

		$this->_attributtes["category_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "Category");

		$this->_attributtes["title"] = array("type" => "varchar(255)", "default" => "NOT NULL");
		$this->_attributtes["description"] = array("type" => "longtext");
		$this->_attributtes["perex"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["pagetitle"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["pagedescription"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["pagekeywords"] = array("type" => "varchar(255)", "default" => "NULL");
		// štítky
		$this->_attributtes["tags"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["url"] = array("type" => "varchar(255)", "default" => "NULL", "index" => true);
		$this->_attributtes["canonical"] = array("type" => "varchar(255)", "default" => "NULL");

	}
}

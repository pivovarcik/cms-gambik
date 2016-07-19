<?php


define("T_LANGUAGE",DB_PREFIX . "language");

/**
 * Entita Language
 *
 */

require_once("Template.php");
class LanguageTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_LANGUAGE;
		$this->parent = "CiselnikEntity";

		$this->_attributtes["code"] = array("type" => "varchar(2)");
		//$this->_attributtes["name"] = array("type" => "varchar(30)");
		$this->_attributtes["active"] = array("type" => "tinyint(1)", "default"=>"0");
		//$this->_attributtes["order"] = array("type" => "int(11)", "default"=>"0");
		$this->_attributtes["content_language"] = array("type" => "varchar(10)"); // pro metadata


	}
}

<?php
define("T_SYSCATEGORY",DB_PREFIX . "syscategory");

/**
 * Entita pro Kategorie
 *
 */
require_once("Template.php");
class SyscategoryTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SYSCATEGORY;
		$this->parent = "CategoryEntity";
		$this->_attributtes["category_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "SysCategory");

	}
}

<?php


define("T_PRODUCT_DOSTUPNOST",DB_PREFIX . "product_dostupnost");

/**
 * Entita Language
 *
 */

require_once("Template.php");
class ProductDostupnostTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_PRODUCT_DOSTUPNOST;
		$this->parent = "CiselnikEntity";
		// dostupnost v hodinách
		$this->_attributtes["hodiny"] = array("type" => "int", "default"=>"0");
	}
}

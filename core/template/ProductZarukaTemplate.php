<?php


	define("T_PRODUCT_ZARUKA",DB_PREFIX . "product_zaruka");

/**
 * Entita Language
 *
 */

require_once("Template.php");
class ProductZarukaTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_PRODUCT_ZARUKA;
		$this->parent = "CiselnikEntity";
		// dostupnost v hodinách
	//	$this->_attributtes["hodiny"] = array("type" => "int", "default"=>"0");
	}
}

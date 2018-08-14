<?php


define("T_SHOP_PRODUCT_CATEGORY",DB_PREFIX . "shop_skupiny");

/**
 * Entita Language
 *
 */

require_once("Template.php");
class ProductCategoryTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_PRODUCT_CATEGORY;
		$this->parent = "CiselnikEntity";
		$this->_attributtes["cenik_id"] = array("type" => "int", "default" => "NULL","reference" => "ProductCenik");
	}
}

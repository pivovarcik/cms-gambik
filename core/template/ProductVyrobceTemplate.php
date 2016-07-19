<?php


define("T_SHOP_PRODUCT_VYROBCE",DB_PREFIX . "shop_vyrobce");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class ProductVyrobceTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_PRODUCT_VYROBCE;
		$this->parent = "CiselnikEntity";
	}
}

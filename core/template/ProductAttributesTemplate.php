<?php
define("T_SHOP_PRODUCT_ATTRIBUTES",DB_PREFIX . "product_attributes");

/**
 * Entita Guestbook
 *
 */

require_once("CiselnikTemplate.php");
class ProductAttributesTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_PRODUCT_ATTRIBUTES;
		$this->parent = "CiselnikEntity";
	}
}

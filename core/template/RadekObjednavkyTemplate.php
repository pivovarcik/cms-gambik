<?php


define("T_SHOP_ORDER_DETAILS",DB_PREFIX . "shop_order_details");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class RadekObjednavkyTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_ORDER_DETAILS;
		$this->parent = "RadekDokladuEntity";

		$this->addReference("doklad_id","Orders");

	}
}

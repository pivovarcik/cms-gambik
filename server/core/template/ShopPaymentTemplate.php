<?php


define("T_SHOP_ZPUSOB_PLATBY",DB_PREFIX . "zpusob_platby");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class ShopPaymentTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_ZPUSOB_PLATBY;
		$this->parent = "CiselnikEntity";

		$this->_attributtes["brana"] = array("type" => "varchar(25)");
    $this->_attributtes["aktivni"] = array("type" => "tinyint", "default" => "1");
		//$this->_attributtes["price"] = array("type" => "decimal(12,2)");
	}
}

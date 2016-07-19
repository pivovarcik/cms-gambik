<?php
define("T_ORDER_STATUS",DB_PREFIX . "shop_orders_stavy");

/**
 * Entita Page status
 *
 */
require_once("Template.php");
class OrderStatusTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_ORDER_STATUS;
		$this->_attributtes["name"] = array("type" => "varchar(25)");
		$this->_attributtes["description"] = array("type" => "varchar(255)");
		$this->_attributtes["order"] = array("type" => "int(11)");
	}
}

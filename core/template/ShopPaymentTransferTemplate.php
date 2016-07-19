<?php


define("T_SHOP_PLATBY_DOPRAVY",DB_PREFIX . "platby_dopravy");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class ShopPaymentTransferTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_PLATBY_DOPRAVY;

		$this->_attributtes["doprava_id"] = array("type" => "int(11)", "reference" => "ShopTransfer");
		$this->_attributtes["platba_id"] = array("type" => "int(11)", "reference" => "ShopPayment");
		$this->_attributtes["price"] = array("type" => "decimal(10,2)", "default" => "0");
		$this->_attributtes["price_value"] = array("type" => "varchar(50)", "default" => "NULL");
	}
}

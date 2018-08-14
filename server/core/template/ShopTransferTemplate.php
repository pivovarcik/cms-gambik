<?php


define("T_SHOP_ZPUSOB_DOPRAVY",DB_PREFIX . "zpusob_dopravy");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class ShopTransferTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_ZPUSOB_DOPRAVY;
		$this->parent = "CiselnikEntity";

		$this->_attributtes["price"] = array("type" => "decimal(12,2)");
		$this->_attributtes["price_value"] = array("type" => "varchar(50)");
		$this->_attributtes["osobni_odber"] = array("type" => "tinyint", "default" => "0");
		$this->_attributtes["aktivni"] = array("type" => "tinyint", "default" => "1");
		$this->_attributtes["address1"] = array("type" => "varchar(50)", "default" => "NULL");
		$this->_attributtes["odberne_misto"] = array("type" => "varchar(150)", "default" => "NULL");
		$this->_attributtes["city"] = array("type" => "varchar(50)", "default" => "NULL");
		$this->_attributtes["zip_code"] = array("type" => "varchar(10)", "default" => "NULL");
		$this->_attributtes["kod_dopravce"] = array("type" => "varchar(10)", "default" => "NULL");
		$this->_attributtes["vypocet_id"] = array("type" => "int", "default" => "0");
    
   /* 
    $this->_attributtes["price_m3"] = array("type" => "decimal(12,2)");
		//$this->_attributtes["price_m3_value"] = array("type" => "varchar(50)");

    $this->_attributtes["price_kg"] = array("type" => "decimal(12,2)");
		//$this->_attributtes["price_kg_value"] = array("type" => "varchar(50)");               */
	}
}

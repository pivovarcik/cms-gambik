<?php


define("T_SHOP_ORDERS",DB_PREFIX . "shop_orders");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");

// Předek DokladEntity
class OrdersTemplate extends Template {

	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_ORDERS;
		$this->parent = "DokladEntity";

	//	$this->_attributtes["order_code"] = array("type" => "varchar(50)");
		$this->_attributtes["order_date"] = array("type" => "datetime","default" => "NULL");

		$this->_attributtes["heureka"] = array("type" => "int(11)", "default" => "0");
		$this->_attributtes["heurekaTimeStamp"] = array("type" => "datetime","default" => "NULL");


		$this->_attributtes["odeslano_stav"] = array("type" => "int(11)", "default" => "0");
		$this->_attributtes["odeslanoTimeStamp"] = array("type" => "datetime","default" => "NULL");

		$this->_attributtes["date_reserve"] = array("type" => "varchar(25)","default" => "NULL");

		// id poštovní zásilky
		$this->_attributtes["barcode"] = array("name" => "Číslo zásilky", "type" => "varchar(50)","default" => "NULL");

		$this->_attributtes["faktura_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "Faktura");
    
    // potvrzení souhlasu ze zasláním formuláře na Heureku - GDPR
    $this->_attributtes["heureka_souhlas"] = array("type" => "tinyint(1)", "default" => "0");
	}
}
<?php
/**
 * Abstraktní třída pro všechny entity typu Doklad
 *
 */
require_once("Template.php");
class DokladTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = '';
		//$this->_attributtes["type_id"] = array("type" => "int(11)");
		$this->_attributtes["code"] = array("type" => "varchar(25)");
		$this->_attributtes["user_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "User");

		$this->_attributtes["stav"] = array("type" => "int(11)", "default" => "0");

		$this->_attributtes["order_date"] = array("type" => "datetime", "default" => "NULL");
		$this->_attributtes["customer_id"] = array("type" => "int");

		$this->_attributtes["cost_subtotal"] = array("type" => "decimal(12,2)");
		$this->_attributtes["cost_shipping"] = array("type" => "decimal(12,2)");
		$this->_attributtes["cost_tax"] = array("type" => "decimal(12,2)");

		$this->_attributtes["cost_total"] = array("type" => "decimal(12,2)");



		$this->_attributtes["shipping_first_name"] = array("type" => "varchar(50)");
		$this->_attributtes["shipping_last_name"] = array("type" => "varchar(50)");

		$this->_attributtes["shipping_address_1"] = array("type" => "varchar(100)");
		$this->_attributtes["shipping_address_2"] = array("type" => "varchar(100)");

		$this->_attributtes["shipping_city"] = array("type" => "varchar(50)");
		$this->_attributtes["shipping_state"] = array("type" => "char(2)");
		$this->_attributtes["shipping_zip_code"] = array("type" => "char(8)");
		$this->_attributtes["shipping_phone"] = array("type" => "char(12)");
		$this->_attributtes["shipping_email"] = array("type" => "varchar(100)");
		$this->_attributtes["shipping_pay"] = array("type" => "int", "reference" => "ShopPayment");
		$this->_attributtes["shipping_transfer"] = array("type" => "int", "reference" => "ShopTransfer");

		$this->_attributtes["shipping_dic"] = array("type" => "varchar(25)","default" => "NULL");
		$this->_attributtes["shipping_ico"] = array("type" => "varchar(25)","default" => "NULL");
		$this->_attributtes["ip_address"] = array("type" => "varchar(30)","default" => "NULL");

		$this->_attributtes["storno"] = array("type" => "tinyint(4)", "default" => "0");
		$this->_attributtes["description"] = array("type" => "varchar(255)","default" => "NULL");

		// interní poznámka
		$this->_attributtes["description_secret"] = array("type" => "longtext","default" => "NULL" );

		$this->_attributtes["shipping_first_name2"] = array("type" => "varchar(50)");
		$this->_attributtes["shipping_last_name2"] = array("type" => "varchar(50)");

		$this->_attributtes["shipping_address_12"] = array("type" => "varchar(100)");
		$this->_attributtes["shipping_address_22"] = array("type" => "varchar(100)");
		$this->_attributtes["shipping_city2"] = array("type" => "varchar(50)");
		$this->_attributtes["shipping_state2"] = array("type" => "char(2)");
		$this->_attributtes["shipping_zip_code2"] = array("type" => "char(8)");

		// transakční klíč pro párování platby k dokladu
		$this->_attributtes["transId"] = array("type" => "varchar(50)", "default" => "NULL");


		$this->_attributtes["kurz_id"] = array("type" => "int", "default" => "NULL","reference"=>"Kurz");
		$this->_attributtes["kurz"] = array("type" => "decimal(8,3)", "default" => "NULL");
		$this->_attributtes["mena"] = array("type" => "varchar(3)", "default" => "NULL");
		$this->_attributtes["kurz_datum"] = array("type" => "datetime", "default" => "NULL");
		$this->_attributtes["kurz_mnoz"] = array("type" => "int", "default" => "NULL");

		$this->_attributtes["cost_subtotal_mena"] = array("type" => "decimal(12,2)");
		$this->_attributtes["cost_tax_mena"] = array("type" => "decimal(12,2)");

		$this->_attributtes["cost_total_mena"] = array("type" => "decimal(12,2)");


	}
}

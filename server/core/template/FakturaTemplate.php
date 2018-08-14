<?php


define("T_FAKTURY",DB_PREFIX . "faktury");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class FakturaTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_FAKTURY;
		$this->parent = "DokladEntity";


		$this->_attributtes["order_code"] = array("type" => "varchar(50)");
		$this->_attributtes["duzp_date"] = array("type" => "datetime", "default" => "NULL");
		$this->_attributtes["maturity_date"] = array("type" => "datetime", "default" => "NULL");
	//	$this->_attributtes["order_date"] = array("type" => "datetime", "default" => "NULL");
		$this->_attributtes["faktura_date"] = array("type" => "datetime", "default" => "NULL");
		$this->_attributtes["pay_date"] = array("type" => "datetime", "default" => "NULL");
		$this->_attributtes["duzp_date"] = array("type" => "datetime", "default" => "NULL");
		$this->_attributtes["pay_account"] = array("type" => "varchar(150)", "default" => "NULL");
		$this->_attributtes["amount_paid"] = array("type" => "decimal(8,2)", "default" => "NULL");
	//	$this->_attributtes["user_id"] = array("type" => "int(11)", "default" => "NULL");

		// Typ faktury: Standardní, Proforma, Zálohová
		$this->_attributtes["faktura_type_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "TypyFaktur");
		$this->_attributtes["order_id"] = array("type" => "int(11)", "default" => "NULL");

	}
}

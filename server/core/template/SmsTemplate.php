<?php
define("T_SMS",DB_PREFIX . "sms");

/**
 * Entita pro články
 *
 */
require_once("Template.php");
class SmsTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SMS;
		$this->_attributtes["ReadTimeStamp"] = array("type" => "datetime", "default" => "NULL");
		$this->_attributtes["autor_id"] = array("type" => "int(11)", "default" => "NOT NULL", "reference" => "User");
		$this->_attributtes["message"] = array("type" => "longtext", "default" => "NULL");
		$this->_attributtes["adresat_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "User");
		$this->_attributtes["phone"] = array("type" => "varchar(25)", "default" => "NULL");
		$this->_attributtes["price"] = array("type" => "decimal(10,2)", "default" => "0");
	}
}

<?php
define("T_MESSAGE",DB_PREFIX . "messages");

/**
 * Entita pro články
 *
 */
require_once("Template.php");
class MessageTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_MESSAGE;
//		$this->_primary = 'id';
		//$this->_attributtes["id"] = array("type" => "int(11)");
		$this->_attributtes["isDeleted"] = array("type" => "int(11)");
		$this->_attributtes["ReadTimeStamp"] = array("type" => "datetime", "default" => "NULL");
		$this->_attributtes["autor_id"] = array("type" => "int(11)", "default" => "NOT NULL", "reference" => "User");
		$this->_attributtes["message"] = array("type" => "longtext", "default" => "NULL");
		$this->_attributtes["adresat_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "User");
//		$this->_attributtes["user_id"] = array("type" => "int(11)", "default" => "NOT NULL");
		//$this->_attributtes["user_id"] = array("type" => "int(11)", "default" => "NULL");
//		$this->_attributtes["version"] = array("type" => "int(11)", "default" => "0");
	}
}

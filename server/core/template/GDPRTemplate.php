<?php


define("T_GDPR",DB_PREFIX . "gdpr_souhlas");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class GdprTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_GDPR;
//		$this->parent = "CiselnikEntity";

		$this->_attributtes["email"] = array("type" => "varchar(150)");
		$this->_attributtes["ip"] = array("type" => "varchar(50)");
		$this->_attributtes["subject"] = array("type" => "varchar(255)");
		$this->_attributtes["user_id"] = array("type" => "int");
		$this->_attributtes["souhlas_text"] = array("type" => "longtext");
		$this->_attributtes["souhlas_od"] = array("type" => "datetime");
		$this->_attributtes["souhlas_do"] = array("type" => "datetime");
		$this->_attributtes["zpusob_overeni"] = array("type" => "varchar(255)");
    
   // $this->_attributtes["aktivni"] = array("type" => "tinyint", "default" => "1");
		//$this->_attributtes["price"] = array("type" => "decimal(12,2)");
	}
}

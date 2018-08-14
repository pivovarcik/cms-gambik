<?php


define("T_PROTOKOL",DB_PREFIX . "protokol");

/**
 * Entita Data
 *
 */

require_once("Template.php");
class ProtokolTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_PROTOKOL;

		$this->_attributtes["akce"] = array("type" => "varchar(255)");
		$this->_attributtes["protokol"] = array("type" => "longtext");
		$this->_attributtes["user_id"] = array("type" => "int", "default"=>"null");
		$this->_attributtes["ip"] = array("type" => "varchar(50)", "default"=>"null");
		$this->_attributtes["url"] = array("type" => "varchar(255)");
	}
}

<?php


define("T_BLACKLISTIP",DB_PREFIX . "blacklistip");

/**
 * Entita Blacklist
 *
 */

require_once("Template.php");
class BlackListIpTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_BLACKLISTIP;
		$this->_attributtes["pokusy"] = array("type" => "int", "default"=>"0");
		$this->_attributtes["ip"] = array("type" => "varchar(30)");
		$this->_attributtes["description"] = array("type" => "varchar(255)");
		$this->_attributtes["active"] = array("type" => "tinyint(1)", "default"=>"0");
	}
}

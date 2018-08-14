<?php



/**
 * Entita Data
 *
 */
define("T_USER_ACTIVITY_MONITOR",DB_PREFIX . "user_activity_monitor");
require_once("Template.php");
class UserActivityMonitorTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_USER_ACTIVITY_MONITOR;



		$this->_attributtes["user_id"] = array("type" => "int(11)","reference"=>"User");
		$this->_attributtes["ip_adresa"] = array("type" => "varchar(50)");
		$this->_attributtes["from_url"] = array("type" => "varchar(255)");
		$this->_attributtes["to_url"] = array("type" => "varchar(255)");
	}
}

<?php


define("T_LOGSEARCH",DB_PREFIX . "logsearch");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class LogSearchTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_LOGSEARCH;
		$this->_attributtes["ip"] = array("type" => "varchar(50)");
		$this->_attributtes["search"] = array("type" => "varchar(100)");
		$this->_attributtes["form"] = array("type" => "varchar(50)");
		$this->_attributtes["results"] = array("type" => "int");
	}
}

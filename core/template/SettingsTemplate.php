<?php


define("T_OPTIONS",DB_PREFIX . "options");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class SettingsTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_OPTIONS;

		$this->_attributtes["key"] = array("type" => "varchar(100)");
		$this->_attributtes["value"] = array("type" => "longtext");
	}
}

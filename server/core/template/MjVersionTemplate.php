<?php


define("T_MJ_VERSION",DB_PREFIX . "mj_version");

/**
 * Entita Data
 *
 */

require_once("Template.php");
class MjVersionTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_MJ_VERSION;

		$this->_attributtes["name"] = array("type" => "longtext");
		$this->_attributtes["lang_id"] = array("type" => "int(11)");
		$this->_attributtes["mj_id"] = array("type" => "int(11)", "default" => "NOT NULL", "reference"=>"Mj");
	}
}

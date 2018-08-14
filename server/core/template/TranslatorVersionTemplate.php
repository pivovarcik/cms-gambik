<?php


define("T_SLOVNIK_VERSION",DB_PREFIX . "slovnik_version");

/**
 * Entita Data
 *
 */

require_once("Template.php");
class TranslatorVersionTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SLOVNIK_VERSION;

		$this->_attributtes["name"] = array("type" => "longtext");
		$this->_attributtes["lang_id"] = array("type" => "int(11)");
		$this->_attributtes["keyword_id"] = array("type" => "int(11)");
	}
}

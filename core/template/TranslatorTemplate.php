<?php


define("T_SLOVNIK",DB_PREFIX . "slovnik");

/**
 * Entita Data
 *
 */

require_once("Template.php");
class TranslatorTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SLOVNIK;

		$this->_attributtes["keyword"] = array("type" => "varchar(50)");
	}
}

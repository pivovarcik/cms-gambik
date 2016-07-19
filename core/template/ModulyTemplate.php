<?php


define("T_MODULY",DB_PREFIX . "moduly");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class ModulyTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_MODULY;
		$this->parent = "CiselnikEntity";
		$this->_attributtes["status"] = array("type" => "int");
	}
}

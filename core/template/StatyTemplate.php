<?php


define("T_STAT",DB_PREFIX . "staty");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class StatyTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_STAT;
		$this->parent = "CiselnikEntity";

		$this->_attributtes["kod"] = array("type" => "varchar(3)");
	}
}

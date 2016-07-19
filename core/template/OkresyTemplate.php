<?php


define("T_OKRES",DB_PREFIX . "okresy");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class OkresyTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_OKRES;
		$this->parent = "CiselnikEntity";
		$this->_attributtes["kraj_id"] = array("type" => "int");
	}
}

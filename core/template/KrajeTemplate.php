<?php


define("T_KRAJE",DB_PREFIX . "kraje");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class KrajeTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_KRAJE;
		$this->parent = "CiselnikEntity";

		$this->_attributtes["stat_id"] = array("type" => "int");
	}
}

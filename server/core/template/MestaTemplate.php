<?php


define("T_MESTA",DB_PREFIX . "mesta");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class MestaTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_MESTA;

		$this->_attributtes["obec"] = array("type" => "varchar(100)");
		$this->_attributtes["okres_id"] = array("type" => "int", "reference" => "Okresy");
		// typ - Obec / Město
		$this->_attributtes["typ_id"] = array("type" => "int");
		$this->_attributtes["latitude"] = array("type" => "decimal(10,7)");
		$this->_attributtes["longitude"] = array("type" => "decimal(10,7)");
	}
}

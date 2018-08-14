<?php


define("T_NEXTID",DB_PREFIX . "nextid");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class NextIdTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_NEXTID;
		$this->parent = "CiselnikEntity";

		$this->_attributtes["tabulka"] = array("type" => "varchar(25)");
		$this->_attributtes["polozka"] = array("type" => "varchar(25)");
		$this->_attributtes["rada"] = array("type" => "varchar(15)");
		$this->_attributtes["delka"] = array("type" => "int");
		$this->_attributtes["nazev"] = array("type" => "varchar(50)");
		$this->_attributtes["posledni"] = array("type" => "int");
		$this->_attributtes["nejvyssi"] = array("type" => "int");
	}
}

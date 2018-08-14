<?php


define("T_KURZY",DB_PREFIX . "kurzy");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class KurzTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_KURZY;

		$this->parent = "CiselnikEntity";
		$this->_attributtes["kod"] = array("type" => "varchar(10)");
	//	$this->_attributtes["mena"] = array("type" => "varchar(10)");
		$this->_attributtes["kurz"] = array("type" => "float");
		$this->_attributtes["datum"] = array("type" => "date");
		$this->_attributtes["mnozstvi"] = array("type" => "int");
	}
}

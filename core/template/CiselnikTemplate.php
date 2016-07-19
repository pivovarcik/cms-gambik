<?php

/**
 * Entita CiselnikTemplate
 *
 */

require_once("Template.php");
class CiselnikTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_attributtes["name"] = array("type" => "varchar(50)");
		$this->_attributtes["description"] = array("type" => "longtext");
		$this->_attributtes["order"] = array("type" => "int");

		// Podpora větvení číselníku
		$this->_attributtes["parent"] = array("type" => "int", "default" => "NULL");
	}
}

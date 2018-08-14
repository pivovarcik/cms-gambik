<?php

/**
 * Abstraktní třída pro všechny entity typu Page
 *
 */
require_once("Template.php");
class RadekTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = '';
		//$this->_attributtes["type_id"] = array("type" => "int(11)");
		$this->_attributtes["doklad_id"] = array("type" => "int(11)", "default" => "NOT NULL");

		$this->_attributtes["user_id"] = array("type" => "int(11)", "default" => "NULL");

		// pořadí řádků
		$this->_attributtes["order"] = array("type" => "int(11)", "default" => "0");

	}
}

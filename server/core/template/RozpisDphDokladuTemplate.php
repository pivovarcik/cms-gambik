<?php

/**
 * Abstraktní třída pro všechny entity typu Page
 *
 */
require_once("Template.php");
class RozpisDphDokladuTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_attributtes["tax_id"] = array("type" => "int");
		$this->_attributtes["doklad_id"] = array("type" => "int", "default" => "NULL");
		$this->_attributtes["zaklad_dph"] = array("type" => "numeric(12,2)");
		$this->_attributtes["vyse_dph"] = array("type" => "numeric(12,2)");
	}
}

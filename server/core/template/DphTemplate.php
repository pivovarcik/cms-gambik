<?php


define("T_DPH",DB_PREFIX . "dph");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class DphTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_DPH;
		$this->parent = "CiselnikEntity";

		//$this->_attributtes["sazba"] = array("type" => "varchar(10)");
		$this->_attributtes["value"] = array("type" => "decimal(10,2)");
		$this->_attributtes["platnost_od"] = array("type" => "datetime", "default" => "null");
		$this->_attributtes["platnost_do"] = array("type" => "datetime", "default" => "null");
	}
}

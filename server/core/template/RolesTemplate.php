<?php


define("T_ROLES",DB_PREFIX . "roles");

/**
 * Entita Data
 *
 */

require_once("Template.php");
class RolesTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_ROLES;

		$this->_attributtes["title"] = array("type" => "varchar(25)");
		$this->_attributtes["description"] = array("type" => "varchar(255)");
		$this->_attributtes["maska"] = array("type" => "varchar(5)", "default"=>"null");
		$this->_attributtes["typ_masky"] = array("type" => "int", "default"=>"0");

		$this->_attributtes["p1"] = array("type" => "tinyint(1)", "default"=>"0");
		$this->_attributtes["p2"] = array("type" => "tinyint(1)", "default"=>"0");
		$this->_attributtes["p3"] = array("type" => "tinyint(1)", "default"=>"0");
		$this->_attributtes["p4"] = array("type" => "tinyint(1)", "default"=>"0");
		$this->_attributtes["p5"] = array("type" => "tinyint(1)", "default"=>"0");
		$this->_attributtes["p6"] = array("type" => "tinyint(1)", "default"=>"0");
		$this->_attributtes["p7"] = array("type" => "tinyint(1)", "default"=>"0");
		$this->_attributtes["p8"] = array("type" => "tinyint(1)", "default"=>"0");
		$this->_attributtes["p9"] = array("type" => "tinyint(1)", "default"=>"0");
		$this->_attributtes["p10"] = array("type" => "tinyint(1)", "default"=>"0");
		$this->_attributtes["p11"] = array("type" => "tinyint(1)", "default"=>"0");
		$this->_attributtes["p12"] = array("type" => "tinyint(1)", "default"=>"0");
	}
}

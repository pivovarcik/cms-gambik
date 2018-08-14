<?php


define("T_DATA",DB_PREFIX . "data");

/**
 * Entita Data
 *
 */

require_once("Template.php");
class DataTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_DATA;

		$this->_attributtes["file"] = array("type" => "varchar(150)");
    $this->_attributtes["filename_original"] = array("type" => "varchar(150)");
		$this->_attributtes["description"] = array("type" => "varchar(255)");
		$this->_attributtes["size"] = array("type" => "int", "default"=>"0");
		$this->_attributtes["type"] = array("type" => "varchar(10)", "default"=>"null");
		$this->_attributtes["user_id"] = array("type" => "int", "default"=>"0");

		$this->_attributtes["tabulka"] = array("type" => "varchar(50)");

		// adresáø
		$this->_attributtes["dir"] = array("type" => "varchar(100)");
	}
}

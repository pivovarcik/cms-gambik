<?php


define("T_FILE_PLACES",DB_PREFIX . "umisteni_files");

/**
 * Entita Foto
 *
 */

require_once("Template.php");
class FilesPlacesTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_FILE_PLACES;
		$this->_attributtes["table"] = array("type" => "varchar(50)");
		$this->_attributtes["source_id"] = array("type" => "int", "default"=>"null");
		$this->_attributtes["target_id"] = array("type" => "int", "default"=>"null");
		$this->_attributtes["order"] = array("type" => "int", "default"=>"0");
		//$this->_attributtes["title"] = array("type" => "varchar(255)", "default"=>"null");
	}
}
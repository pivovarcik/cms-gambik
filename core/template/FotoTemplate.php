<?php


define("T_FOTO",DB_PREFIX . "foto");

/**
 * Entita Foto
 *
 */

require_once("Template.php");
class FotoTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_FOTO;

		$this->_attributtes["file"] = array("type" => "varchar(150)");
		$this->_attributtes["description"] = array("type" => "varchar(255)");
		$this->_attributtes["size"] = array("type" => "int", "default"=>"0");
		$this->_attributtes["type"] = array("type" => "varchar(10)", "default"=>"null");
		$this->_attributtes["user_id"] = array("type" => "int", "default"=>"0");
	}
}

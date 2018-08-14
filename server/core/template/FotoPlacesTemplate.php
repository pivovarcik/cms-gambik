<?php


define("T_FOTO_PLACES",DB_PREFIX . "umisteni_foto");

/**
 * Entita Foto
 *
 */

require_once("Template.php");
class FotoPlacesTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_FOTO_PLACES;
		$this->_attributtes["table"] = array("type" => "varchar(50)");
		$this->_attributtes["uid_source"] = array("type" => "int", "default"=>"null");
		$this->_attributtes["uid_target"] = array("type" => "int", "default"=>"null");
		$this->_attributtes["order"] = array("type" => "int", "default"=>"0");
		//$this->_attributtes["title"] = array("type" => "varchar(255)", "default"=>"null");
	}
}
<?php


/**
 * Abstraktní třída pro všechny entity typu Page
 *
 */
require_once("Template.php");
class PageTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = '';
		//$this->_attributtes["type_id"] = array("type" => "int(11)");
		$this->_attributtes["status_id"] = array("type" => "int(11)", "default" => "0", "index" => true);

		// To zajištuje již atribut ChangeTimeStamp v předkovi Model;
		//$this->_attributtes["last_modified_date"] = array("type" => "datetime");
		$this->_attributtes["user_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "User");

		// všechny Page mají category
		$this->_attributtes["category_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "Category");

		// možnost nastavit vlastní pořadí
		$this->_attributtes["level"] = array("type" => "int(11)", "default" => "0", "index" => true);


		$this->_attributtes["views"] = array("type" => "int(11)", "default" => "0");
		//$this->_attributtes["user_id"] = array("type" => "int(11)", "default" => "NULL");

		// Podpora verzování
		$this->_attributtes["version"] = array("type" => "int(11)", "default" => "0", "index" => true);

		$this->_attributtes["file_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "Data");

		$this->_attributtes["foto_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "Foto");

		// reference na záznam třetích stran
		$this->_attributtes["reference"] = array("type" => "varchar(150)", "default" => "NULL");

		// povolen přístup
		$this->_attributtes["pristup"] = array("type" => "tinyint(1)", "default" => "1");
    
    // index/ noindex
		$this->_attributtes["robots"] = array("type" => "tinyint(1)", "default" => "1");
	}
}

<?php


define("T_FAKTURA_RADEK",DB_PREFIX . "faktura_detail");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class RadekFakturyTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_FAKTURA_RADEK;
		$this->parent = "RadekDokladuEntity";
	//	$this->addReference("doklad_id",T_FAKTURY);

		//$this->_attributtes["doklad_id"] = array("type" => "int(11)", "default" => "NOT NULL", "reference" => "Faktura");

		$this->_attributtes["doklad_id"]["reference"] = "Faktura";


	}
}


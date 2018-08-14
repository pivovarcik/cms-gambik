<?php


define("T_PRODUCT_CENIK",DB_PREFIX . "product_cenik");

/**
 * Entita Language
 *
 */

require_once("Template.php");
class ProductCenikTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_PRODUCT_CENIK;
		$this->parent = "CiselnikEntity";


		$this->_attributtes["platnost_od"] = array("type" => "datetime");
		$this->_attributtes["platnost_do"] = array("type" => "datetime");
		$this->_attributtes["typ_slevy"] = array("type" => "varchar(1)", "default" => "NULL");
		$this->_attributtes["sleva"] = array("type" => "numeric(12,2)");
		$this->_attributtes["priorita"] = array("type" => "int", "default" => 0);

	}
}

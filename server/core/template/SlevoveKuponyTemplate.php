<?php


define("T_SHOP_KUPONY",DB_PREFIX . "shop_kupony");

/**
 * Entita Language
 *
 */

require_once("Template.php");
class SlevoveKuponyTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_KUPONY;
		$this->parent = "CiselnikEntity";


		$this->_attributtes["platnost"] = array("type" => "datetime");
		$this->_attributtes["typ_slevy"] = array("type" => "int");
		$this->_attributtes["sleva"] = array("type" => "numeric(12,2)");
		$this->_attributtes["customer_id"] = array("type" => "int");
		$this->_attributtes["pouzito"] = array("type" => "int", "default" => 0);

	}
}

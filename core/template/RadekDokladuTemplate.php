<?php

/**
 * Abstraktní třída pro všechny entity typu Page
 *
 */
require_once("Template.php");
class RadekDokladuTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	//	$this->_name = 'RadekEntity';
		$this->parent = "RadekEntity";
		//$this->_attributtes["type_id"] = array("type" => "int(11)");
	//	$this->_attributtes["doklad_id"] = array("type" => "int(11)", "default" => "NOT NULL");

	//	$this->_attributtes["user_id"] = array("type" => "int(11)", "default" => "NOT NULL");

		// řazení řádků
	//	$this->_attributtes["order"] = array("type" => "int(11)", "default" => "0");

		$this->_attributtes["qty"] = array("type" => "decimal(7,2)");
		$this->_attributtes["price"] = array("type" => "decimal(12,2)");
		$this->_attributtes["product_id"] = array("type" => "int");
		$this->_attributtes["product_code"] = array("type" => "varchar(25)");
		$this->_attributtes["product_name"] = array("type" => "varchar(150)");

		// Popisek k položce faktury
		$this->_attributtes["product_description"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["mj_id"] = array("type" => "int");
		$this->_attributtes["tax_id"] = array("type" => "int");
		$this->_attributtes["varianty_id"] = array("type" => "int", "default" => "NULL");


		$this->_attributtes["typ_slevy"] = array("type" => "varchar(1)", "default" => "NULL");
		$this->_attributtes["sleva"] = array("type" => "numeric(12,2)");

	//	$this->_attributtes["celkem"] = array("type" => "numeric(12,2)", "stereotyp" => "vypoctova", "default" => "\$this->qty * \$this->price");
		$this->_attributtes["celkem"] = array("type" => "numeric(12,2)", "stereotyp" => "vypoctova", "default" => "vypocetCelkoveCenyRadkuDokladu(\$this)");

		$this->_attributtes["price_sdani"] = array("type" => "decimal(12,2)");
		$this->_attributtes["celkem_sdani"] = array("type" => "numeric(12,2)", "stereotyp" => "vypoctova", "default" => "vypocetCelkoveCenyRadkuDokladuSDani(\$this)");




	}
}

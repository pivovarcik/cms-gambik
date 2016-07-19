<?php
define("T_CATALOG_FIREM_VERSION",DB_PREFIX . "catalog_firem_version");

/**
 * Verzování obsahu kategorie
 *
 */
require_once("Template.php");
class CatalogFiremVersionTemplate extends Template {
	function __construct()
	{
		parent::__construct();
		$this->_name = T_CATALOG_FIREM_VERSION;
		$this->parent = "CatalogVersionEntity";


		$this->_attributtes["page_id"]["reference"] = "CatalogFirem";

		$this->_attributtes["firstname"] = array("type" => "varchar(150)", "default" => "null");
		$this->_attributtes["lastname"] = array("type" => "varchar(150)", "default" => "null");
		$this->_attributtes["address1"] = array("type" => "varchar(150)", "default" => "null");
		$this->_attributtes["city"] = array("type" => "varchar(150)", "default" => "null");
		$this->_attributtes["zip_code"] = array("type" => "varchar(10)", "default" => "null");

		/**
		 * Fakturační adresa
		 * **/
		$this->_attributtes["firstname2"] = array("type" => "varchar(150)", "default" => "null");
		$this->_attributtes["lastname2"] = array("type" => "varchar(150)", "default" => "null");
		$this->_attributtes["city2"] = array("type" => "varchar(150)", "default" => "null");
		$this->_attributtes["address2"] = array("type" => "varchar(150)", "default" => "null");
		$this->_attributtes["zip_code2"] = array("type" => "varchar(10)", "default" => "null");


		$this->_attributtes["femail"] = array("type" => "varchar(150)", "default" => "null");
		$this->_attributtes["ftelefon"] = array("type" => "varchar(150)", "default" => "null");
		$this->_attributtes["fnazev_firmy"] = array("type" => "varchar(150)", "default" => "null");
		$this->_attributtes["website"] = array("type" => "varchar(150)", "default" => "null");

		$this->_attributtes["ico"] = array("type" => "varchar(25)", "default" => "null");
		$this->_attributtes["dic"] = array("type" => "varchar(25)", "default" => "null");


		$this->_attributtes["lng"] = array("type" => "varchar(25)", "default" => "null");
		$this->_attributtes["lat"] = array("type" => "varchar(25)", "default" => "null");
		$this->_attributtes["telefon"] = array("type" => "varchar(100)", "default" => "null");


		$this->_attributtes["registrace"] = array("type" => "datetime", "default" => "null");
		$this->_attributtes["expirace"] = array("type" => "datetime", "default" => "null");

		$this->_attributtes["foto_id"] = array("type" => "int", "default" => "null");
		$this->_attributtes["vip"] = array("type" => "int", "default" => "0");
		$this->_attributtes["status_id"] = array("type" => "int", "default" => "0");
		$this->_attributtes["poradi"] = array("type" => "int", "default" => "0");

		$this->_attributtes["popa_start"] = array("type" => "varchar(5)", "default" => "null");
		$this->_attributtes["popa_end"] = array("type" => "varchar(5)", "default" => "null");
		$this->_attributtes["ut_start"] = array("type" => "varchar(5)", "default" => "null");
		$this->_attributtes["ut_end"] = array("type" => "varchar(5)", "default" => "null");
		$this->_attributtes["st_start"] = array("type" => "varchar(5)", "default" => "null");
		$this->_attributtes["st_end"] = array("type" => "varchar(5)", "default" => "null");
		$this->_attributtes["ct_start"] = array("type" => "varchar(5)", "default" => "null");
		$this->_attributtes["ct_end"] = array("type" => "varchar(5)", "default" => "null");
		$this->_attributtes["pa_start"] = array("type" => "varchar(5)", "default" => "null");
		$this->_attributtes["pa_end"] = array("type" => "varchar(5)", "default" => "null");
		$this->_attributtes["sone_start"] = array("type" => "varchar(5)", "default" => "null");
		$this->_attributtes["sone_end"] = array("type" => "varchar(5)", "default" => "null");
		$this->_attributtes["ne_start"] = array("type" => "varchar(5)", "default" => "null");
		$this->_attributtes["ne_end"] = array("type" => "varchar(5)", "default" => "null");

		$this->_attributtes["cena_1"] = array("type" => "decimal(12,2)", "default" => "null");
		$this->_attributtes["cena_2"] = array("type" => "decimal(12,2)", "default" => "null");
		$this->_attributtes["cena_3"] = array("type" => "decimal(12,2)", "default" => "null");
		$this->_attributtes["cena_4"] = array("type" => "decimal(12,2)", "default" => "null");

	}
}

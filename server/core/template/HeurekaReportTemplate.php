<?php
define("T_HEUREKA_REPORT",DB_PREFIX . "heureka_report");

/**
 * Entita pro Kategorie
 *
 */
require_once("Template.php");
class HeurekaReportTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_HEUREKA_REPORT;
		// Autor
		$this->_attributtes["name"] = array("type" => "varchar(50)", "default" => "NULL");

		// Komentář
		$this->_attributtes["summary"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["plus"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["minus"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["rating_id"] = array("type" => "int", "default" => "null");

		// číslo objednávky
		$this->_attributtes["order_code"] = array("type" => "varchar(25)", "default" => "null");
		// číslo objednávky
		$this->_attributtes["order_id"] = array("type" => "int", "default" => "null");
		// Celková známka
		$this->_attributtes["total_rating"] = array("type" => "float");
		// Známka - dodací lhůta
		$this->_attributtes["delivery_time"] = array("type" => "float");
		// Známka za dopravu
		$this->_attributtes["transport_quality"] = array("type" => "float");
		// Známka - Hodnocení přehlednosti obchodu v rozmezí 0.5 až 5.
		$this->_attributtes["web_usability"] = array("type" => "float");
		// Známka - Hodnocení kvality komunikace obchodu se zákazníkem v rozmezí 0.5 až 5.
		$this->_attributtes["communication"] = array("type" => "float");

		$this->_attributtes["report_timestamp"] = array("type" => "datetime");
	}
}

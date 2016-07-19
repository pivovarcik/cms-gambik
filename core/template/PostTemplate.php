<?php
define("T_CLANKY",DB_PREFIX . "articles");

/**
 * Entita pro články
 *
 */
require_once("Template.php");
class PostTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_CLANKY;
		$this->parent = "PageEntity";

		$this->_attributtes["PublicDate"] = array("type" => "datetime");

		// podpora zobrazení článku v rozmezí od-do
		$this->_attributtes["PublicDate_end"] = array("type" => "datetime", "default" => "NULL");
		$this->_attributtes["logo_url"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["source_url"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["source_id"] = array("type" => "varchar(255)", "default" => "NULL");
	}
}

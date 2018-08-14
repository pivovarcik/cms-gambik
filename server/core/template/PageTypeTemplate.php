<?php
define("T_PAGE_TYPE",DB_PREFIX . "page_type");

/**
 * Entita Page Type
 *
 */
require_once("Template.php");
class PageTypeTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_PAGE_TYPE;
		$this->_attributtes["name"] = array("type" => "varchar(50)");
		$this->_attributtes["description"] = array("type" => "varchar(255)");
	}
}

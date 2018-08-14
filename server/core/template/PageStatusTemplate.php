<?php
define("T_PAGE_STATUS",DB_PREFIX . "page_status");

/**
 * Entita Page status
 *
 */
require_once("Template.php");
class PageStatusTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_PAGE_STATUS;
		$this->_attributtes["type"] = array("type" => "varchar(25)");
		$this->_attributtes["description"] = array("type" => "varchar(255)");
	}
}

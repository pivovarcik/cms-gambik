<?php
define("T_CATEGORY_ASSOC",DB_PREFIX . "category_association");

/**
 * Entita pro Kategorie
 *
 */
require_once("Template.php");
class CategoryAssociationTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_CATEGORY_ASSOC;

		$this->_attributtes["page_type_id"] = array("type" => "int(11)");
		$this->_attributtes["page_id"] = array("type" => "int(11)");
		$this->_attributtes["category_id"] = array("type" => "int(11)");
		$this->_attributtes["order"] = array("type" => "int(11)", "default" => "0");
	}
}

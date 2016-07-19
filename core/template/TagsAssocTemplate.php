<?php
define("T_TAGS_ASSOC",DB_PREFIX . "tagy_assoc");

/**
 * Entita pro Asociace tagů
 *
 */
require_once("Template.php");
class TagsAssocTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_TAGS_ASSOC;
		$this->_attributtes["page_id"] = array("type" => "int(11)");
		$this->_attributtes["tag_id"] = array("type" => "int(11)", "reference" => "Tags");
		$this->_attributtes["page_type"] = array("type" => "varchar(50)");
	}
}

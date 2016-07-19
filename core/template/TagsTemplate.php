<?php


define("T_TAGS",DB_PREFIX . "tagy");

/**
 * Entita Tagy
 *
 */

require_once("Template.php");
class TagsTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_TAGS;
		$this->parent = "CiselnikEntity";

		$this->_attributtes["lang_id"] = array("type" => "int(11)");
	}
}

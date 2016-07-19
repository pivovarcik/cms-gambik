<?php


define("T_SVATKY",DB_PREFIX . "svatky");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class SvatkyTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SVATKY;

		$this->_attributtes["dd"] = array("type" => "int");
		$this->_attributtes["mm"] = array("type" => "int");
		$this->_attributtes["svatek"] = array("type" => "varchar(50)");
		$this->_attributtes["volno"] = array("type" => "tinyint(1)");

	}
}

<?php


define("T_MJ",DB_PREFIX . "mj");

/**
 * Entita Language
 *
 */

require_once("Template.php");
class MjTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_MJ;
	//	$this->parent = "CiselnikEntity";
	}
}

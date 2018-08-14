<?php


define("T_TYPY_FAKTUR",DB_PREFIX . "faktury_type");

/**
 * Entita Typy faktur
 *
 */

require_once("Template.php");
class TypyFakturTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_TYPY_FAKTUR;
		$this->parent = "CiselnikEntity";
	}
}

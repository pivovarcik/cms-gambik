<?php

define("T_ROZPIS_DPH_FAKTURY",DB_PREFIX . "rozpis_dph_faktury");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class RozpisDphFakturyTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_ROZPIS_DPH_FAKTURY;
		$this->parent = "RozpisDphDokladuEntity";

		$this->addReference("doklad_id","Orders");

	}
}

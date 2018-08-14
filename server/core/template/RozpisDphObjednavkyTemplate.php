<?php

define("T_ROZPIS_DPH_OBJEDNAVKY",DB_PREFIX . "rozpis_dph_objednavky");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class RozpisDphObjednavkyTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_ROZPIS_DPH_OBJEDNAVKY;
		$this->parent = "RozpisDphDokladuEntity";

		$this->addReference("doklad_id","Faktura");

	}
}

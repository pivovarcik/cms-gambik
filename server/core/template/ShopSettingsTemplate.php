<?php


define("T_SHOP_SETTINGS",DB_PREFIX . "shop_settings");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class ShopSettingsTemplate extends Template	 {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_SETTINGS;
		$this->parent = "SettingsEntity";
	}
}

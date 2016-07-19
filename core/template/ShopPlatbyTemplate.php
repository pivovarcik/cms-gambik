<?php
/**
 * Řeší stavy produktů
 * */

define("T_SHOP_PLATBY",DB_PREFIX . "shop_platby");

/**
 * Entita ShopPlatbyTemplate
 *
 */

require_once("Template.php");
class ShopPlatbyTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_PLATBY;
		$this->parent = "Entity";
		$this->_attributtes["code"] = array("type" => "varchar(25)", "default" => "NULL");
		$this->_attributtes["amount"] = array("type" => "decimal(10,2)", "default" => "NULL");

		$this->_attributtes["method"] = array("type" => "varchar(25)", "default" => "NULL");
		$this->_attributtes["status"] = array("type" => "varchar(25)", "default" => "NULL");
		$this->_attributtes["label"] = array("type" => "varchar(50)", "default" => "NULL");
		$this->_attributtes["transId"] = array("type" => "varchar(50)", "default" => "NULL");

	}
}

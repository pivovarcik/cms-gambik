<?php
define("T_PRODUCT_AUDIT",DB_PREFIX . "shop_products_audit");

/**
 * Entita User
 *
 */
require_once("Template.php");
class ProductAuditTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_PRODUCT_AUDIT;


		$this->_attributtes["product_id"] = array("type" => "int(11)", "default" => "NULL");
		$this->_attributtes["ip_adresa"] = array("type" => "varchar(25)", "default" => "NULL");
		$this->_attributtes["user_id"] = array("type" => "int(11)", "default" => "NULL");
	}
}

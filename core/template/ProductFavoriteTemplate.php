<?php


define("T_SHOP_FAVORITE",DB_PREFIX . "shop_favorite");

/**
 * Entita Foto
 *
 */

require_once("Template.php");
class ProductFavoriteTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_FAVORITE;
		$this->_attributtes["product_id"] = array("type" => "int", "default"=>"null");
		$this->_attributtes["user_id"] = array("type" => "int", "default"=>"null");
		$this->_attributtes["ip_adresa"] = array("type" => "varchar(30)");
		$this->_attributtes["basket_id"] = array("type" => "varchar(50)", "default"=>"not null");

	}
}

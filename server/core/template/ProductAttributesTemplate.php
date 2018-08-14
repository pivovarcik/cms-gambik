<?php
define("T_SHOP_PRODUCT_ATTRIBUTES",DB_PREFIX . "product_attributes");

/**
 * Entita Guestbook
 *
 */

require_once("CiselnikTemplate.php");
class ProductAttributesTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_PRODUCT_ATTRIBUTES;
		$this->parent = "CiselnikEntity";
    $this->_attributtes["pohoda_id"] = array("type" => "int(11)");
    $this->_attributtes["public_filter"] = array("type" => "tinyint(1)");
    $this->_attributtes["multi_select"] = array("type" => "tinyint(1)");
    $this->_attributtes["secret"] = array("type" => "tinyint(1)","default"=>"0");
	}
}

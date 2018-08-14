<?php

//insert into mm_product_group_assoc (product_id,group_id) SELECT id,1 FROM `mm_products` WHERE skupina_id=1 and id not in (select product_id from mm_product_group_assoc) ORDER BY `skupina_id` DESC

define("T_PRODUCT_GROUP_ASSOC",DB_PREFIX . "product_group_assoc");

/**
 * Entita pro Kategorie
 *
 */
require_once("Template.php");
class ProductGroupAssocTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_PRODUCT_GROUP_ASSOC;
		$this->path =  "PATH_ROOT2 . 'core/entity/' . ";
		$this->_attributtes["product_id"] = array("type" => "int(11)","reference" => "Product");
		//	$this->_attributtes["song_id"] = array("type" => "int(11)","reference" => "CatalogSong");
		$this->_attributtes["group_id"] = array("type" => "int(11)","reference" => "ProductCategory");

		// počet
		//	$this->_attributtes["count"] = array("type" => "int(11)","default" => "0");
		//	$this->_attributtes["order"] = array("type" => "int(11)","default" => "0");
		//	$this->_attributtes["primary_service"] = array("type" => "int", "default" => "0");
		//	$this->_attributtes["label"] = array("type" => "varchar(25)", "default" => "NULL");
	}
}

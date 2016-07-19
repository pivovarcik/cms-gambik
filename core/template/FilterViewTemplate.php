<?php


define("T_FILTERVIEW",DB_PREFIX . "filter_view");

/**
 * Entita Blacklist
 *
 */

require_once("Template.php");
class FilterViewTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_FILTERVIEW;
		$this->_attributtes["name"] = array("type" => "varchar(30)");
		$this->_attributtes["definition"] = array("type" => "longtext", "default"=>"NULL");
		$this->_attributtes["sorting"] = array("type" => "longtext", "default"=>"NULL");
		$this->_attributtes["modelname"] = array("type" => "varchar(30)");
	//	$this->_attributtes["description"] = array("type" => "varchar(255)");
		$this->_attributtes["user_id"] = array("type" => "int", "default"=>"NULL");
		$this->_attributtes["isDefault"] = array("type" => "int", "default"=>"0");
		$this->_attributtes["selected"] = array("type" => "tinyint", "default"=>"0");

		$this->_attributtes["show_head"] = array("type" => "tinyint", "default"=>"1");
		$this->_attributtes["show_foot"] = array("type" => "tinyint", "default"=>"1");
		$this->_attributtes["isSelectable"] = array("type" => "tinyint", "default"=>"1");
	}
}

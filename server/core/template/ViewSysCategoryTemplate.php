<?php


/**
 * Abstraktní třída pro verzování různých typů stránek
 *
 */
require_once("Template.php");
class ViewSysCategoryTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = 'view_syscategory';
		$this->parent = "ViewCategoryEntity";
		$this->_attributtes["category_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "SysCategory");

	}
}

<?php


define("T_USERS_ACCESS_ASSOC",DB_PREFIX . "users_accsess_assoc");

/**
 * Entita Foto
 *
 */

require_once("Template.php");
class AccessUsersTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_USERS_ACCESS_ASSOC;
		$this->_attributtes["page_type"] = array("type" => "varchar(100)", "default"=>"null");
		$this->_attributtes["page_id"] = array("type" => "int", "default"=>"null");
		$this->_attributtes["user_id"] = array("type" => "int", "default"=>"null");
	}
}

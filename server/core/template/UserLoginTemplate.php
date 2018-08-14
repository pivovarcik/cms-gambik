<?php
define("T_USER_LOGIN",DB_PREFIX . "user_login");

/**
 * Entita User
 *
 */
require_once("Template.php");
class UserLoginTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_USER_LOGIN;

		$this->_attributtes["token"] = array("type" => "varchar(100)");
		$this->_attributtes["ip_adresa"] = array("type" => "varchar(50)", "default" => "NULL");
		$this->_attributtes["user_agent"] = array("type" => "varchar(150)", "default" => "NULL");
		$this->_attributtes["LastLogin"] = array("type" => "datetime", "default" => "NULL");
		$this->_attributtes["user_id"] = array("type" => "int(11)", "default" => "NOT NULL","reference" => "User");

	}
}

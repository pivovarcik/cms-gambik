<?php
define("T_USERS",DB_PREFIX . "users");

/**
 * Entita User
 *
 */
require_once("Template.php");
class UserTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_USERS;
		$this->_attributtes["nick"] = array("type" => "varchar(30)");
		$this->_attributtes["password"] = array("type" => "varchar(100)");
		$this->_attributtes["salt"] = array("type" => "varchar(100)");
		$this->_attributtes["sex"] = array("type" => "int(11)", "default" => "NULL");
		$this->_attributtes["timezone"] = array("type" => "varchar(30)", "default" => "NULL");
		$this->_attributtes["newsletter"] = array("type" => "tinyint", "default" => "0");


		$this->_attributtes["email"] = array("type" => "varchar(50)", "default" => "NULL");

		$this->_attributtes["titul"] = array("type" => "varchar(15)", "default" => "NULL");

		$this->_attributtes["jmeno"] = array("type" => "varchar(30)");
		$this->_attributtes["prijmeni"] = array("type" => "varchar(30)");
		$this->_attributtes["token"] = array("type" => "varchar(100)");
		$this->_attributtes["ip_adresa"] = array("type" => "varchar(50)", "default" => "NULL");
		$this->_attributtes["naposledy"] = array("type" => "datetime", "default" => "NULL");
		$this->_attributtes["stillin"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["last_page"] = array("type" => "varchar(20)");
		$this->_attributtes["aktivni"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["doba"] = array("type" => "int(11)", "default" => "0");
		$this->_attributtes["autorizace"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["role"] = array("type" => "int(11)", "default" => "NULL");
		$this->_attributtes["mobil"] = array("type" => "varchar(25)", "default" => "NULL");
		$this->_attributtes["telefon"] = array("type" => "varchar(25)", "default" => "NULL");
		$this->_attributtes["prihlasen"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["p1"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["p2"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["p3"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["p4"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["p5"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["p6"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["p7"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["p8"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["p9"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["p10"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["maska"] = array("type" => "varchar(5)", "default" => "NULL");
		$this->_attributtes["uid_category"] = array("type" => "int(11)", "default" => "NULL");
		$this->_attributtes["typ_masky"] = array("type" => "int(11)", "default" => "NULL");
		$this->_attributtes["lost_pwd"] = array("type" => "varchar(25)", "default" => "NULL");
		$this->_attributtes["lost_pwd_ip"] = array("type" => "varchar(25)", "default" => "NULL");
		$this->_attributtes["lost_pwd_date"] = array("type" => "datetime", "default" => "NULL");


		$this->_attributtes["foto_id"] = array("type" => "int(11)", "default" => "NULL");
		$this->_attributtes["birthday"] = array("type" => "datetime", "default" => "NULL");

		$this->_attributtes["fb_user_id"] = array("type" => "bigint(11)", "default" => "NULL");

	}
}

<?php
define("T_EMAIL",DB_PREFIX . "email");

/**
 * Entita pro články
 *
 */
require_once("Template.php");
class MailTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_EMAIL;

		$this->_attributtes["isDeleted"] = array("type" => "int(11)");
		$this->_attributtes["subject"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["user_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "User");
		$this->_attributtes["description"] = array("type" => "longtext", "default" => "NULL");

	}
}

<?php
define("T_NEWSLETTER_STATUS",DB_PREFIX . "newsletter_email_status");

/**
 * Entita pro články
 *
 */
require_once("Template.php");
class NewsletterStatusTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_NEWSLETTER_STATUS;


		$this->_attributtes["email"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["mailing_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "Mail");
		$this->_attributtes["visitor"] = array("type" => "varchar(150)", "default" => "NULL");
		$this->_attributtes["ReadTimeStamp"] = array("type" => "datetime", "default" => "NULL");

	}
}

<?php

define("T_NEWSLETTER",DB_PREFIX . "newsletter");

/**
 * Entita Newsletter
 *
 */

require_once("Template.php");
class NewsletterTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_NEWSLETTER;
		$this->parent = "CiselnikEntity";
		$this->_attributtes["html"] = array("type" => "longtext", "default" => "null");

		$this->_attributtes["html_footer"] = array("type" => "longtext", "default" => "null");
	}
}

?>
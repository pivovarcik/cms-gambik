<?php
define("T_POST_VERSION",DB_PREFIX . "articles_version");

/**
 * Verzování obsahu článku
 *
 */
require_once("Template.php");
class PostVersionTemplate extends Template {
	function __construct()
	{
		parent::__construct();
		$this->_name = T_POST_VERSION;
		$this->parent = "PageVersionEntity";

		$this->_attributtes["page_id"] = array("type" => "int(11)", "default" => "NOT NULL", "reference" => "Post");
	}
}

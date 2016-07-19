<?php


define("T_COMMENTS",DB_PREFIX . "comments");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class CommentTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_COMMENTS;

		$this->_attributtes["user_id"] = array("type" => "int");
		$this->_attributtes["ip"] = array("type" => "varchar(25)");
		$this->_attributtes["nick"] = array("type" => "varchar(25)");
		$this->_attributtes["parent_id"] = array("type" => "int");
		$this->_attributtes["text"] = array("type" => "longtext");
		$this->_attributtes["email"] = array("type" => "varchar(80)");
	}
}

<?php


define("T_GUESTBOOK",DB_PREFIX . "guestbook");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class GuestbookTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_GUESTBOOK;

		$this->_attributtes["user_id"] = array("type" => "int");
		$this->_attributtes["ip"] = array("type" => "varchar(25)");
		$this->_attributtes["nick"] = array("type" => "varchar(25)");
		$this->_attributtes["parent_id"] = array("type" => "int");
		$this->_attributtes["text"] = array("type" => "longtext");
	}
}

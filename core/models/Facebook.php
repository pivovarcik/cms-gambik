<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_Facebook extends G_Service{

	function __construct()
	{
		parent::__construct("fb_users");
	}

	public $total = 0;

	public function getUser($fb_id)
	{
		$query = "SELECT * FROM fb_users WHERE fb_id='" . $fb_id . "' LIMIT 1";

		$o = $this->get_row($query);
		if (count($o)>0) {
			return $o;
		} else {
			return false;
		}
	}
}
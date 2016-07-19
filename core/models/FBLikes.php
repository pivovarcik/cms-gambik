<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class models_FBLikes extends G_Service{

	function __construct()
	{
		parent::__construct("fb_like");
	}

	public $total = 0;

	//$query = "select * from fb_like where anketa_id=" . $anketa_id . " and user_id='" . $user->fb_id . "'";
	public function getLikeByUser($anketa_id, $fb_id)
	{
		$query = "SELECT * FROM fb_like WHERE anketa_id=" . $anketa_id . " and user_id='" . $fb_id . "' LIMIT 1";

		return $this->get_row($query);
	}
}
<?php




define("T_USER_NEWSLETTER",DB_PREFIX . "user_newsletter");
class UserNewsletterTemplate extends Template {

	function __construct()
	{
		parent::__construct();
		$this->_name = T_USER_NEWSLETTER;
		$this->path =  "PATH_ROOT2 . 'core/entity/' . ";

		$this->_attributtes["user_id"] = array("type" => "int", "reference" => "User");
		$this->_attributtes["newsletter_id"] = array("type" => "int", "reference" => "Newsletter");
	}
}

?>
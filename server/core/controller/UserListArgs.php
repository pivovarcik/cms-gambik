<?php

class UserListArgs extends ListArgs{

	public function __construct()
	{

		//$this->orderBy= "t1.TimeStamp desc";
		//$this->lang = LANG_TRANSLATOR;



		$this->allowedOrder = array(
		"TimeStamp" => "t1.TimeStamp",
		"naposledy" => "t1.naposledy",
		"nick" => "t1.nick",
		"email" => "t1.email",
		"jmeno" => "t1.jmeno",
		"prijmeni" => "t1.prijmeni",
		"nazev_role" => "nazev_role",
		"autorizace" => "t1.autorizace",
		);
		parent::__construct();

		if (isset($_GET["q"])) {
			$this->fulltext = $_GET["q"];
		}

	}
}

class UsersListArgs extends UserListArgs{

}
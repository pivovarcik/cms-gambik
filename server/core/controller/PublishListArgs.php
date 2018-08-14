<?php


class PublishListArgs extends ListArgs{
	//public $id;

	public $lang;


	public function __construct()
	{

		//$this->orderBy= "t1.TimeStamp desc";
		//$this->lang = LANG_TRANSLATOR;



		$this->allowedOrder = array(
		"TimeStamp" => "p.TimeStamp",
		"PageTimeStamp" => "p.TimeStamp",
		"ChangeTimeStamp" => "p.ChangeTimeStamp",
		"title" => "v.title",
		);
		parent::__construct();

		if (isset($_GET["q"])) {
			$this->fulltext = $_GET["q"];
		}

	//	$this->all_public_date = true;

		//$args->lang = LANG_TRANSLATOR;
	}
}
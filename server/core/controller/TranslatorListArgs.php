<?php
class TranslatorListArgs extends ListArgs{
	//public $id;

	public $lang;


	public function __construct()
	{

		//$this->orderBy= "t1.TimeStamp desc";
		//$this->lang = LANG_TRANSLATOR;


		$this->allowedOrder = array(
			"TimeStamp" => "p.TimeStamp",
			"ChangeTimeStamp" => "p.ChangeTimeStamp",
			"name" => "v.name",
			"keyword" => "p.keyword",
			);


		if (defined("LANG_TRANSLATOR")) {
			$this->lang = LANG_TRANSLATOR;
		}
		parent::__construct();



		if (isset($_GET["q"])) {
			$this->fulltext = $_GET["q"];
		}


		//$args->lang = LANG_TRANSLATOR;
	}
}
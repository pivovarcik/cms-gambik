<?php

class FotoGalleryListArgs extends ListArgs{
	//public $id;

	public $lang;


	public function __construct()
	{

		//$this->orderBy= "t1.TimeStamp desc";
		$this->lang = LANG_TRANSLATOR;


		$this->allowedOrder = array(
			"TimeStamp" => "t1.TimeStamp",
			"file" => "t1.file",
		"type" => "t1.type",
		"size" => "t1.size",
		"nick" => "u.nick",
			);
		parent::__construct();



		/*if (isset($_GET["pg"])) {
		   $this->page = (int) $_GET["pg"];
		   }*/

/*
		if (isset($_GET["lowestPrice"])) {
			$this->lowestPrice = (int) $_GET["lowestPrice"];
		}


		if (isset($_GET["highestPrice"])) {
			$this->highestPrice = (int) $_GET["highestPrice"];
		}

		if (isset($_GET["df"])) {
			$this->df = (string) $_GET["df"];
		}


		if (isset($_GET["dt"])) {
			$this->dt = (string) $_GET["dt"];
		}


		if (isset($_GET["vyr"])) {
			$this->vyrobce = $_GET["vyr"];
		}

		if (isset($_GET["skupina"])) {
			$this->skupina = $_GET["skupina"];
		}
		if (isset($_GET["q"])) {
			$this->fulltext = $_GET["q"];
		}
		if (isset($_GET["cislo"])) {
			$this->cislo = $_GET["cislo"];

		}*/

		//$args->lang = LANG_TRANSLATOR;
	}
}
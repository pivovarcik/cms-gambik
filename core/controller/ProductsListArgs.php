<?php
class ProductsListArgs extends ListArgs{
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
		"cislo" => "p.cislo",
		"title" => "v.title",
		"nazev_skupina" => "nazev_skupina",
		"nazev_vyrobce" => "nazev_vyrobce",
		"prodcena" => "prodcena",
		"prodcena_sdph" => "prodcena_sdph",
		"code01" => "code01",
		"code02" => "code02",
		"qty" => "qty",
		"aktivni" => "aktivni",
		"nazev_dostupnost" => "nazev_dostupnost",
		"nazev_category" => "nazev_category",
		);
		parent::__construct();



		/*if (isset($_GET["pg"])) {
		   $this->page = (int) $_GET["pg"];
		   }*/


		if (isset($_POST["lowestPrice"])) {
			$this->lowestPrice = (int) $_POST["lowestPrice"];
		}


		if (isset($_POST["highestPrice"])) {
			$this->highestPrice = (int) $_POST["highestPrice"];
		}

		if (isset($_GET["df"])) {
			$this->df = (string) $_GET["df"];
		}


		if (isset($_POST["dt"])) {
			$this->dt = (string) $_POST["dt"];
		}



		if (isset($_POST["df"])) {
			$this->df = (string) $_POST["df"];
		}


		if (isset($_GET["dt"])) {
			$this->dt = (string) $_GET["dt"];
		}


		if (isset($_GET["vyr"])) {
			$this->vyrobce = $_GET["vyr"];
		}

		if (isset($_POST["vyr"]) && is_array($_POST["vyr"])) {
			$this->vyrobce = array_flip($_POST["vyr"]);
		}

		if (isset($_GET["skupina"])) {
			$this->skupina = $_GET["skupina"];
		}


		if (isset($_POST["skupina"]) && is_array($_POST["skupina"])) {
			$this->skupina = array_flip($_POST["skupina"]);
		}

		if (isset($_GET["q"])) {
			$this->fulltext = $_GET["q"];
		}
		if (isset($_GET["cislo"])) {
			$this->cislo = $_GET["cislo"];




	}

	//$args->lang = LANG_TRANSLATOR;
}
}
<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */


class ProductListArgs extends PageListArgs{

	public $cislo = "";
	public $code01 = "";
	public $code02 = "";
	public $code03 = "";
	public function __construct()
	{
		parent::__construct();



		$this->allowedOrder = array(
		"TimeStamp" => "p.TimeStamp",
		"PageTimeStamp" => "p.TimeStamp",
		"ChangeTimeStamp" => "p.ChangeTimeStamp",
		"cislo" => "p.cislo",
		"title" => "v.title",
		"nazev_skupina" => "nazev_skupina",
		"nazev_vyrobce" => "nazev_vyrobce",
		"prodcena" => "min_prodcena",
		"prodcena_sdph" => "min_prodcena_sdph",
		"code01" => "code01",
		"code02" => "code02",
		"qty" => "qty",
		"aktivni" => "aktivni",
		"nazev_dostupnost" => "nazev_dostupnost",
		"nazev_category" => "nazev_category"
	);

		$name = "cislo";
		$this->$name = $this->request->getQuery($name, $this->$name);

		$name = "code01";
		$this->$name = $this->request->getQuery($name, $this->$name);

		$name = "code02";
		$this->$name = $this->request->getQuery($name, $this->$name);

		$name = "code03";
		$this->$name = $this->request->getQuery($name, $this->$name);


	}
}
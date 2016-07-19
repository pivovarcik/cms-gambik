<?php
require_once("DokladListArgs.php");
class FakturaListArgs extends DokladListArgs {

	public $order_code;
	public function __construct()
	{


		parent::__construct();


		$name = "order_code";
		$this->$name = $this->request->getQuery($name, "");

	}

}
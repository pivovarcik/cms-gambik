<?php

require_once("DokladListArgs.php");
class OrdersListArgs extends DokladListArgs {

	public function __construct()
	{





		parent::__construct();


		$this->allowedOrder["h_total_rating"] = "h.total_rating";



	}

}

?>
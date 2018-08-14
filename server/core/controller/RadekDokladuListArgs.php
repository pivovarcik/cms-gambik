<?php



class RadekDokladuListArgs extends ListArgs{

	public function __construct()
	{

		$this->allowedOrder = array(
		"TimeStamp" => "t1.TimeStamp",
		"ChangeTimeStamp" => "t1.ChangeTimeStamp",
		"name" => "t1.name",
		"code" => "t1.code",
		"price_sdani" => "t1.price_sdani",
		"price" => "t1.price",
		);
		parent::__construct();


		if (isset($_POST["doklad_id"])) {
			$this->doklad_id = (int) $_POST["doklad_id"];
		}

	}
}
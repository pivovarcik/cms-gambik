<?php



class ProductPohybListArgs extends ListArgs{

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


		if (isset($_POST["product_id"])) {
			$this->product_id = (int) $_POST["product_id"];
		}
		if (isset($_POST["lang"])) {
			$this->lang = (string) $_POST["lang"];
		}
	}
}
<?php



class ProductCenaListArgs extends ListArgs{

	public $product_cislo;
	public $product_name;
	public $cenik_name;
	public $prodcena;
	public $cenik_cena;
	public $sleva;
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
    
    
    		$name = "product_cislo";
		$this->$name = $this->request->getQuery($name, "");
		$name = "product_name";
		$this->$name = $this->request->getQuery($name, "");



		$name = "cenik_name";
		$this->$name = $this->request->getQuery($name, "");
		$name = "prodcena";
		$this->$name = $this->request->getQuery($name, "");


		$name = "cenik_cena";
		$this->$name = $this->request->getQuery($name, "");
		$name = "sleva";
		$this->$name = $this->request->getQuery($name, "");

	}
}
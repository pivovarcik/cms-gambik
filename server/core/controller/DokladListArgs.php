<?php

class DokladListArgs extends ListArgs {


	public $shipping_first_name;
	public $code;
	public $df;
	public $dt;
	public $shipping_email;
	public $lowestPrice;
	public $highestPrice;
	public $shipping_ico;
	public function __construct()
	{

		$this->cmdList = array("copy"=>"Kopírovat");
		$this->allowedOrder = array(
		"TimeStamp" => "t1.TimeStamp",
		"PageTimeStamp" => "t1.TimeStamp",
		"code" => "t1.code",
		"shipping_first_name" => "t1.shipping_first_name",
		"shipping_email" => "t1.shipping_email",
		"shipping_city" => "t1.shipping_city",
		"cost_total" => "t1.cost_total",
		);


		parent::__construct();


		$name = "shipping_first_name";
		$this->$name = $this->request->getQuery($name, "");

		$name = "shipping_ico";
		$this->$name = $this->request->getQuery($name, "");

		$name = "shipping_email";
		$this->$name = $this->request->getQuery($name, "");

		$name = "code";
		$this->$name = $this->request->getQuery($name, "");

		$name = "df";
		$this->$name = $this->request->getQuery($name, "");

		$name = "dt";
		$this->$name = $this->request->getQuery($name, "");

    $name = "lowestPrice";
		$this->$name = $this->request->getQuery($name, "");

		$name = "highestPrice";
		$this->$name = $this->request->getQuery($name, "");

    if ($this->request->isPost())
    {
  		$name = "shipping_first_name";
  		$this->$name = $this->request->getPost($name, "");
  
  		$name = "shipping_ico";
  		$this->$name = $this->request->getPost($name, "");
  
  		$name = "shipping_email";
  		$this->$name = $this->request->getPost($name, "");
  
  		$name = "code";
  		$this->$name = $this->request->getPost($name, "");
  
  		$name = "df";
  		$this->$name = $this->request->getPost($name, "");
  
  		$name = "dt";
  		$this->$name = $this->request->getPost($name, "");    

      $name = "lowestPrice";
  		$this->$name = $this->request->getPost($name, "");
  
  		$name = "highestPrice";
  		$this->$name = $this->request->getPost($name, "");    
    }

		if (isset($_GET["q"])) {
			$this->fulltext = $_GET["q"];
		}


	}

}

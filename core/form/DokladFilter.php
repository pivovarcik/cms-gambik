<?php
/**
 * Filter pro produkty
 * */
require_once("ListFilter.php");
abstract class DokladFilter extends ListFilter
{

	public 	$minCena = 0;
	public $maxCena = 999999;

	function __construct()
	{
		parent::__construct(true);
	//	$this->init();
	}

	public function loadModel()
	{
		parent::loadModel();
	}
	public function init()
	{

		$this->loadModel();
		parent::init();
		$minCena = $this->minCena;
		$maxCena = $this->maxCena;


		$params=array();
		if (defined("PAGE_ID") && PAGE_ID>0) {
			$params['child'] = (int) PAGE_ID;
		}

		$params['lowestPrice'] = isset($_GET['lowestPrice']) ? $_GET['lowestPrice'] : "";
		$params['highestPrice'] = isset($_GET['highestPrice']) ? $_GET['highestPrice'] : "";
		$params['fulltext'] = isset($_GET['q']) ? $_GET['q'] : "";

		if (!defined("USER_ROLE_ID") || USER_ROLE_ID != 2) {
			$params['aktivni'] = 1;
		}


		$name = "lowestPrice";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array(
				"id" => $name,
				"class" => "textbox num",
				"style" => "width: 65px;",
				));

		if ($minCena == $maxCena) {
			$minCena -=500;
			$maxCena +=500;
		}
		$value = round($this->Request->getQuery($name, $minCena));
		//$value = !empty($value) ? $value : FILTER_FROM_DATE;
		$elem->setAttribs('value',$value);
		$elem->setDecoration();
		$this->addElement($elem);



		$name = "highestPrice";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array(
				"id" => $name,
				"class" => "textbox num",
				"style" => "width: 65px;",
				));
		$value = round($this->Request->getQuery($name, $maxCena));
		//$value = !empty($value) ? $value : FILTER_TO_DATE;
		$elem->setAttribs('value',$value);
		$elem->setDecoration();
		$this->addElement($elem);


		$name = "code";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array(
		"class" => "textbox",
		));
		$value = $this->Request->getQuery($name, "");
		$elem->setAttribs('placeholder','Číslo dokladu');
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name = "shipping_email";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array(
		"class" => "textbox",
	));
		$value = $this->Request->getQuery($name, "");
		$elem->setAttribs('placeholder','Email');
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name = "shipping_ico";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array(
		"class" => "textbox",
	));
		$value = $this->Request->getQuery($name, "");
		$elem->setAttribs('placeholder','IČ');
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name = "shipping_first_name";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array(
		"class" => "textbox",
	));
		$value = $this->Request->getQuery($name, "");
		$elem->setAttribs('placeholder','Odběratel');
		$elem->setAttribs('value',$value);
		$this->addElement($elem);


	}
}
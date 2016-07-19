<?php

/**
 * Filter pro produkty
 * */
require_once("DokladFilter.php");
class FakturaFilter extends DokladFilter
{

	function __construct()
	{
		parent::__construct(true);
		$this->init();
	}

	public function init()
	{
		parent::init();

		$name = "order_code";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array(
"class" => "textbox",
));
		$value = $this->Request->getQuery($name, "");
		$elem->setAttribs('placeholder','Číslo objednávky');
		$elem->setAttribs('value',$value);
		$this->addElement($elem);
	}

	/*	public function loadModel()
	   {
	   parent::loadModel();
	   }
	   public function init()
	   {
	   $this->loadModel();
	   parent::init();
	   }*/
}
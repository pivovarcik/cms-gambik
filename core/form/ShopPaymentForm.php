<?php
/**
 * Společný předek pro formuláře typu Page
 * */
require_once("CiselnikVersionForm.php");
class ShopPaymentForm extends CiselnikVersionForm
{

	function __construct()
	{
		parent::__construct("models_Platba");


	}

	public function loadElements()
	{
		parent::loadElements();

		$eshopController = new EshopController();

		$page = $this->page;


		foreach ($this->languageList as $key => $val)
		{

			$name = "price_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			//$elem->setAttribs(array("is_money"=>true));
			$value = $this->getPost($name, $page->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label','Sleva z dopravného: ('.$val->code.')');
			$elem->setAttribs(array("is_money"=>true));
			$elem->setAttribs('style','width:100px;text-align:right;');
			$this->addElement($elem);

		}

		$typZpravy = array("AGMO","PAYU");


	//	print_r($page);
		$name="brana";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->Request->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox large');
		$elem->setAttribs('label','Použít platební bránu:');
		$pole = array();
		$pole["none"] = " - žádná - ";
		$attrib = array();
		foreach ($typZpravy as $key => $value)
		{
			$pole[$value] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

	}

}
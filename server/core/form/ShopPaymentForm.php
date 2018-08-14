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
    $this->setStyle(BootstrapForm::getStyle());


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

	//	$typZpravy = array("AGMO","PAYU");
		$typZpravy = array("AGMO" => "Comagate","GPWP"=>"GP webpay");


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
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);
    
    
    		$name = "aktivni";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
	//	$elem->setAttribs('class','dodaci_adresa_check');
		$elem->setAttribs('value',1);
		$elem->setAttribs('label','Aktivní');
		$this->addElement($elem);

	}

}
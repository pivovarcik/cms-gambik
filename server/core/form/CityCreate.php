<?php
/**
 * Třída pro přidání nového hitu
 * */
class F_CityCreate extends G_Form
{

	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{

//		$eshop = new Eshop();
	//	$g = new Gambik();
	//	$_product = new models_ProductCategory();



	//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$elements = array();

		$elemMesto = new G_Form_Element_Text("mesto");
		$value = $this->getPost("mesto", "");
		$elemMesto->setAttribs('value',$value);
		$elemMesto->setAttribs('label','Město:');

		array_push($elements, $elemMesto);

		$mesta = new models_Mesta();
		$mestaList = $mesta->get_krajeList();

		$elemKraj = new G_Form_Element_Select("okres");
		$elemKraj->setAttribs(array("id"=>"okres","required"=>false));
		$value = $this->getPost("okres", "");
		$elemKraj->setAttribs('value',$value);
		$elemKraj->setAttribs('label','Kraj:');
		$pole = array();
		$pole[0] = " -- neuvedeno -- ";
		$attrib = array();
		$okres = 0;
		foreach ($mestaList as $key => $value)
		{


			//if () {
			//$attrib[$value->uid]["class"] = "vnoreni1";
			/*
			if ($okres <> $value->okres) {
				//$attrib[$value->uid]["class"] = "vnoreni0";
				$pole[$value->uid] = $value->mesto;
			}
			$okres = $value->okres;
			*/
			$pole[$value->uid] = $value->kraj;
			//}
		}
		$elemKraj->setMultiOptions($pole,$attrib);
		array_push($elements, $elemKraj);

		$elemSubmit = new G_Form_Element_Submit("ins_city");
		$elemSubmit->setAttribs(array("id"=>"ins_city"));
		$elemSubmit->setAttribs('value','Přidej');
		$elemSubmit->setAttribs('class','tlac');
		$elemSubmit->setAttribs('label','');
		$elemSubmit->setIgnore(true);

		array_push($elements, $elemSubmit);



		$this->addElements($elements);
	}
}
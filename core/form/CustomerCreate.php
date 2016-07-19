<?php
/**
 * Třída pro přidání nového hitu
 * */
class Application_Form_CustomerCreate extends G_Form
{

	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{

		//$eshop = new Eshop();
		//$g = new Gambik();
		$_customer = new models_Customers();



	//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$elemFirstName = new G_Form_Element_Text("first_name");
		$elemFirstName->setAttribs(array("id"=>"first_name","required"=>true));
		$firstNamevalue = $this->getPost("first_name", "");
		$elemFirstName->setAttribs('value',$firstNamevalue);
		$elemFirstName->setAttribs('label','Jméno:');

		$elemLastName = new G_Form_Element_Text("last_name");
		$elemLastName->setAttribs(array("id"=>"last_name","required"=>true));
		$lastNamevalue = $this->getPost("last_name", "");
		$elemLastName->setAttribs('value',$lastNamevalue);
		$elemLastName->setAttribs('label','Příjmení:');

		$elemAddress1 = new G_Form_Element_Text("address_1");
		$elemAddress1->setAttribs(array("id"=>"address_1","required"=>true));
		$address1Value = $this->getPost("address_1", "");
		$elemAddress1->setAttribs('value',$address1Value);
		$elemAddress1->setAttribs('label','Ulice č.p.:');

		$elemCity = new G_Form_Element_Text("city");
		$elemCity->setAttribs(array("id"=>"city","required"=>true));
		$cityValue = $this->getPost("city", "");
		$elemCity->setAttribs('value',$cityValue);
		$elemCity->setAttribs('label','Město:');

		$elemZipCode = new G_Form_Element_Text("zip_code");
		$elemZipCode->setAttribs(array("id"=>"zip_code","required"=>true));
		$zipCodeValue = $this->getPost("zip_code", "");
		$elemZipCode->setAttribs('value',$zipCodeValue);
		$elemZipCode->setAttribs('label','PSČ:');

		$elemPhone = new G_Form_Element_Text("phone");
		$elemPhone->setAttribs(array("id"=>"phone","required"=>true));
		$phoneValue = $this->getPost("phone", "");
		$elemPhone->setAttribs('value',$phoneValue);
		$elemPhone->setAttribs('label','Telefon:');

		$elemEmail = new G_Form_Element_Text("email");
		$elemEmail->setAttribs(array("id"=>"email","required"=>true));
		$emailValue = $this->getPost("email", "");
		$elemEmail->setAttribs('value',$emailValue);
		$elemEmail->setAttribs('label','Email:');

		$elemSubmit = new G_Form_Element_Submit("save_order");
		$elemSubmit->setAttribs('value','>> POTVRDIT OBJEDNÁVKU >>');
		$elemSubmit->setAttribs('class','tlac');
		$elemSubmit->setAttribs('label','');
		$elemSubmit->setIgnore(true);

		$this->addElements(array(
				$elemFirstName, $elemLastName, $elemAddress1,
				$elemCity, $elemZipCode, $elemPhone,
				$elemEmail, $elemSubmit,
		));
	}
}
<?php


class Application_Form_NewsletterRegister extends G_Form
{

	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$name = "email";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, "");
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Email:');
		$elem->setAttribs('class','textbox');


		$elem->setAttribs("is_email",true);
		$elem->setAttribs("required",true);
		$this->addElement($elem);



		$name = "jmeno";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, "");
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Jméno:');
		$elem->setAttribs('class','textbox');

		$elem->setAttribs("required",false);
		$this->addElement($elem);


		$elem = new G_Form_Element_Button("newsletter_register");
		$elem->setAttribs('value','Přihlásit');
		$elem->setAttribs('class','login-btn');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);


		$elem = new G_Form_Element_Button("newsletter_unregister");
		$elem->setAttribs('value','Odhlásit');
		$elem->setAttribs('class','login-btn');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}

?>
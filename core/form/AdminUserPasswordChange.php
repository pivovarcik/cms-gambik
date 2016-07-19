<?php
/**
 * Třída pro přidání nového hitu
 * */
class Application_Form_AdminUserPasswordChange extends G_Form
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

		$elem = new G_Form_Element_Password("pwd1");
		$elem->setAttribs('value','');
		$elem->setAttribs('label','Nové heslo:');
		$elem->placeholder('Nové heslo');
		$elem->setAttribs("class","form-control");
		$elem->setAttribs("required",true);
		$this->addElement($elem);

		$elem = new G_Form_Element_Password("pwd2");
		$elem->setAttribs('value','');
		$elem->setAttribs('label','Znova heslo:');
		$elem->placeholder('Znovu heslo');
		$elem->setAttribs("class","form-control");
		$elem->setAttribs("required",true);
		$this->addElement($elem);

		$elem = new G_Form_Element_Hidden("key");
		$value = $this->Request->getQuery("key", "");
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$elem = new G_Form_Element_Submit("changepassword");
		$elem->setAttribs('value','Změna hesla');
		$elem->setAttribs('class','btn btn-lg btn-success btn-block');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
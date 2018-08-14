<?php
/**
 * Třída pro přidání nového hitu
 * */
class F_AdminUserLogin extends G_Form
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

		$elem = new G_Form_Element_Text("nick");
		$elem->setDecoration();
		$value = $this->getPost("nick", "");
		$elem->setAttribs('value',$value);
		$elem->setAttribs("required",true);
		$elem->placeholder('Uživatelské jméno');

		$elem->autofocus();

		$elem->setAttribs("class","form-control");
		$elem->setAttribs('label','Přihlašovací jméno:');
		$this->addElement($elem);
/*
		$elem = new G_Form_Element_Text("email");
		$value = $this->getPost("email", "");
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Email:');
		$elem->setAttribs("required",true);
		$this->addElement($elem);
*/

		$elem = new G_Form_Element_Password("pwd");
		$elem->setDecoration();
		$elem->setAttribs('value','');
		$elem->setAttribs('label','Heslo:');
		$elem->placeholder('Heslo');
		$elem->setAttribs("class","form-control");
		$elem->setAttribs("required",true);
    $elem->setAttribs("id","pwd");
    $elem->setAttribs('after_icon','<i class="fa fa-eye" aria-hidden="true"></i>');
		$this->addElement($elem);

		$elem = new G_Form_Element_Hidden("redirect");
		$redirect = isset($_GET["redirect"])? $_GET["redirect"] : $_SERVER["HTTP_REFERER"];
		$value = !empty($redirect) ? $redirect : URL_HOME;
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$elem = new G_Form_Element_Button("login");
		$elem->setAttribs('value','Přihlásit se');
		$elem->setAttribs('class','btn btn-lg btn-primary btn-block');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
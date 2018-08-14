<?php
/**
 * Třída pro přidání nového hitu
 * */
class F_AdminUserLostPassword extends G_Form
{

	function __construct()
	{
		parent::__construct();
		$this->setStyle(BootstrapForm::getStyle());
		$this->init();
	}
	public function init()
	{
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$elem = new G_Form_Element_Text("email");
		$value = $this->getPost("email", "");
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Registrační email:');
		$elem->placeholder('Registrační email');
		$elem->setAttribs('class','form-control');
		$elem->setAttribs("required",true);
		$elem->setAttribs("is_email",true);
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("captcha");
		$value = "";
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Opište kód:');
		$elem->placeholder('Opište kód');
		$elem->setAttribs('class','form-control');
//		$elem->setAttribs("required",true);
		$this->addElement($elem);

		$elem = new G_Form_Element_Hidden("redirect");
		$redirect = isset($_GET["redirect"])? $_GET["redirect"] : $_SERVER["HTTP_REFERER"];
		$value = !empty($redirect) ? $redirect : URL_HOME;
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$elem = new G_Form_Element_Button("lostpassword");
		$elem->setAttribs('value','Odeslat');
		$elem->setAttribs('class','btn btn-lg btn-success btn-block');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
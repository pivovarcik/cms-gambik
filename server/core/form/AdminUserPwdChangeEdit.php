<?php
/**
 * Třída pro přidání nového hitu
 * */
class F_AdminUserPwdChangeEdit extends G_Form
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

/*
		$this->setStyle(array(
				"label_wrap_start" => "<span>",
				"label_wrap_end" => "</span>",
				"password_wrap_start" => "<div class=\"textbox\">",
				"password_wrap_end" => "</div>",
				));
		*/
	//	$model = new models_Users();
	//	$session = $this->Request->getSession("uidlogin2", "sdsfsf");
	//	$userDetail = $model->getUserBySession($session);

		$elem = new G_Form_Element_Password("pwd");
		$elem->setAttribs("required",true);
		$elem->setAttribs('value','');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Staré heslo:');
		$this->addElement($elem);

		$elem = new G_Form_Element_Password("newpwd1");
		$elem->setAttribs('value','');
		$elem->setAttribs('label','Nové heslo:');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs("required",true);
	//	$elem->setAttribs("is_email",true);
		$this->addElement($elem);

		$elem = new G_Form_Element_Password("newpwd2");
		$elem->setAttribs('value','');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Potvrzení nového hesla:');
		$elem->setAttribs("required",true);
	//	$elem->setAttribs("is_email",true);
		$this->addElement($elem);

		$elem = new G_Form_Element_Button("user_pwd_change");
		$elem->setAttribs('value','Potvrdit změnu');
			$elem->setAttribs('class','btn btn-primary');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
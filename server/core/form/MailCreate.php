<?php
/**
 * Společný předek pro formuláře typu MailForm
 * */
require_once("MailForm.php");
class F_MailCreate extends MailForm
{

	public $formName = "Nová emailová zpráva";

	public $submitButtonName = "ins_mail";
	public $submitButtonTitle = "Odeslat";

	function __construct()
	{
		parent::__construct();
		$this->init();
	}

	public function init()
	{

		parent::init();
		$name = "ins_mail";
		$elem = new G_Form_Element_Button($name);
		$elem->setAttribs('value','Odeslat');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$this->addElement($elem);


		$name = "action";
		$elem = new G_Form_Element_Hidden($name);

		$elem->setAttribs('value',"ins_mail");

		$this->addElement($elem);



	}
}
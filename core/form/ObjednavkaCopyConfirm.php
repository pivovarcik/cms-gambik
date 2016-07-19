<?php


require_once("CopyConfirmForm.php");
class Application_Form_ObjednavkaCopyConfirm extends CopyConfirmForm {

	public $submitButtonTitle = "Kopírovat";
	public $formName = "Opravdu kopírovat objednávku?";

	function __construct()
	{

		parent::__construct("Orders");
		$this->init();
	}

	public function init()
	{
		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"ObjednavkaCopy");
		$elem->setAnonymous();
		$this->addElement($elem);


		$this->formName = "Kopírovat objednávku č. ".$this->page->code." ?";
	}

}
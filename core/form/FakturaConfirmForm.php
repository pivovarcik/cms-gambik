<?php

require_once("DeleteConfirmForm.php");
class Application_Form_FakturaConfirmForm extends DeleteConfirmForm {

	public $submitButtonTitle = "Smazat";
	public $formName = "Opravdu smazat fakturu?";

	function __construct()
	{

		parent::__construct("Faktura");
		$this->init();
	}

	public function init()
	{
		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"FakturaDelete");
		$elem->setAnonymous();
		$this->addElement($elem);


		$this->formName = "Smazat fakturu č. ".$this->page->code." ?";
	}

}
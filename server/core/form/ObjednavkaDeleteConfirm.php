<?php


require_once("DeleteConfirmForm.php");
class F_ObjednavkaDeleteConfirm extends DeleteConfirmForm {

	public $submitButtonTitle = "Smazat";
	public $formName = "Opravdu smazat objednávku?";

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
		$elem->setAttribs('value',"ObjednavkaDelete");
		$elem->setAnonymous();
		$this->addElement($elem);


		$this->formName = "Smazat objednávku č. ".$this->page->code." ?";
	}

}
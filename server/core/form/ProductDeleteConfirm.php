<?php

require_once("DeleteConfirmForm.php");
class F_ProductDeleteConfirm extends DeleteConfirmForm {

	public $submitButtonTitle = "Smazat";
	public $formName = "Opravdu smazat produkt?";

	function __construct()
	{

		parent::__construct("Products");
		$this->init();
	}

	public function init()
	{
		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"ProductDelete");
		$elem->setAnonymous();
		$this->addElement($elem);

		$this->formName = "Smazat produkt č. ".$this->page->cislo." ".$this->page->title." ?";

		//	$this->formName = "Smazat povoleného středisko ".$this->page->stredisko." uživatele ".$this->page->nick." ?";
	}

}
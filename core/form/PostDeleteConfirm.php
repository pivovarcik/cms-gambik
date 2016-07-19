<?php

require_once("DeleteConfirmForm.php");
class Application_Form_PostDeleteConfirm extends DeleteConfirmForm {

	public $submitButtonTitle = "Smazat";
	public $formName = "Opravdu smazat příspěvek?";

	function __construct()
	{

		parent::__construct("Publish");
		$this->init();
	}

	public function init()
	{
		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"PublishDelete");
		$elem->setAnonymous();
		$this->addElement($elem);

		$this->formName = "Smazat příspěvek ".$this->page->title." ?";

		//	$this->formName = "Smazat povoleného středisko ".$this->page->stredisko." uživatele ".$this->page->nick." ?";
	}

}
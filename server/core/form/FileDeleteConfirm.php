<?php



	require_once("DeleteConfirmForm.php");
class F_FileDeleteConfirm extends DeleteConfirmForm {

	public $submitButtonTitle = "Smazat";
	public $formName = "Opravdu smazat soubor?";

	function __construct()
	{

		parent::__construct("Files");
		$this->init();
	}

	public function init()
	{
		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"FileDelete");
		$elem->setAnonymous();
		$this->addElement($elem);



		$this->formName = "Smazat soubor ".$this->page->file." ?";
	}

}
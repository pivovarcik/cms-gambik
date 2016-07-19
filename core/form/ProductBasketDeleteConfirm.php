<?php



	require_once("DeleteConfirmForm.php");
class Application_Form_ProductBasketDeleteConfirm extends DeleteConfirmForm {

	public $submitButtonTitle = "Smazat";
	public $formName = "Opravdu odebrat zboží z košíku?";

	function __construct()
	{

		parent::__construct("Basket");
		$this->init();
	}

	public function init()
	{
		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"ProductBasketDelete");
		$elem->setAnonymous();
		$this->addElement($elem);


		//	$this->formName = "Smazat povoleného středisko ".$this->page->stredisko." uživatele ".$this->page->nick." ?";
	}

}
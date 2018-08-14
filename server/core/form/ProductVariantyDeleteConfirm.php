<?php


	require_once("DeleteConfirmForm.php");
class F_ProductVariantyDeleteConfirm extends DeleteConfirmForm {

	public $submitButtonTitle = "Smazat";
	public $formName = "Opravdu smazat vybranou variantu?";

	function __construct()
	{

		parent::__construct("ProductVarianty");
		$this->init();
	}

	public function init()
	{
		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"ProductVariantyDelete");
		$elem->setAnonymous();
		$this->addElement($elem);


	//	$this->formName = "Smazat povoleného středisko ".$this->page->stredisko." uživatele ".$this->page->nick." ?";
	}

}
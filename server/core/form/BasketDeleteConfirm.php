<?php

require_once("DeleteConfirmForm.php");
class F_BasketDeleteConfirm extends DeleteConfirmForm {

	public $submitButtonTitle = "Smazat";
	public $formName = "Opravdu smazat záznam v košíku?";

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
		$elem->setAttribs('value',"ProductBasketAdminDelete");
		$elem->setAnonymous();
		$this->addElement($elem);



		$this->formName = "Smazat produkt ".$this->page->product_name." z košíku?";
	}

}
<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("ShopPaymentForm.php");
class Application_Form_ShopPaymentCreate extends ShopPaymentForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct("models_Platba");
		$this->init();
	}
	public function init()
	{

		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);
		$this->loadElements();
		$page = $this->page;

		$elem = new G_Form_Element_Button("ins_payment");
		$elem->setAttribs(array("id"=>"ins_payment"));
		$elem->setAttribs('value','Přidej');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
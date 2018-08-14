<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("ShopPaymentForm.php");
class F_ShopPaymentEdit extends ShopPaymentForm
{

	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{

		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);
		$this->loadElements();
		$page = $this->page;

		//print_r($page);
		$elem = new G_Form_Element_Button("upd_payment");
		$elem->setAttribs(array("id"=>"upd_payment"));
		$elem->setAttribs('value','Ulož');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
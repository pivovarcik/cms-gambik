<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("ShopTransferForm.php");
class F_ShopTransferEdit extends ShopTransferForm
{

	function __construct()
	{
		// Typ Page
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
		$elem = new G_Form_Element_Button("upd_transfer");
		$elem->setAttribs(array("id"=>"upd_transfer"));
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("ShopTransferForm.php");
class F_ShopTransferCreate extends ShopTransferForm
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

		$elem = new G_Form_Element_Button("ins_transfer");
		$elem->setAttribs(array("id"=>"ins_transfer"));
		$elem->setAttribs('value','Přidej');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
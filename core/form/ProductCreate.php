<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("ProductForm.php");
class Application_Form_ProductCreate extends ProductForm
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

		$elem = new G_Form_Element_Button("ins_product");
		$elem->setAttribs(array("id"=>"ins_product"));
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
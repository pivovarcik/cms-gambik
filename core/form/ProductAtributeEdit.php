<?php

require_once("ProductAtributeForm.php");

class Application_Form_ProductAtributeEdit extends ProductAtributeForm
{

	public $formName = "Nastavení parametrů produktu";

	public $submitButtonName = "upd_attribute_product";
	public $submitButtonTitle = "Ulož";

	function __construct()
	{
		parent::__construct();
		$this->init();
	}

	public function init()
	{
		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);

		parent::loadElements();



		$elem = new G_Form_Element_Hidden("action");
		$elem->setAttribs('value',"upd_attribute_product");
		$this->addElement($elem);

		$elem = new G_Form_Element_Button("save");
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
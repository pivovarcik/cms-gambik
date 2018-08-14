<?php
require_once("DataGridDefinitionForm.php");

class F_DataGridDefinitionEdit extends DataGridDefinitionForm
{

	public $formName = "Nastavení gridu";

	public $submitButtonName = "saveFilter";
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
		$elem->setAttribs('value',"DataGridDefinitionEdit");
		$this->addElement($elem);

		$elem = new G_Form_Element_Button("saveFilter");
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
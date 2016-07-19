<?php
/**
 * Třída pro přidání nového hitu
 * */

require_once("CategoryForm.php");
class Application_Form_CategoryCreate extends CategoryForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct("models_Category");
		$this->init();
	}
	public function init()
	{
	//	$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage();
		$this->loadElements();
		$page = $this->page;

		$elem = new G_Form_Element_Button("ins_cat");
		$elem->setAttribs(array("id"=>"ins_cat"));
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

	}
}
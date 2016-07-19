<?php
/**
 * Třída pro přidání nového hitu
 * */

require_once("CategoryForm.php");
class Application_Form_SysCategoryEdit extends CategoryForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct("models_SysCategory");
		$this->init();
	}
	public function init()
	{
		$this->category_root = 1;
		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);
		$this->loadElements();
		$page = $this->page;

		$elem = new G_Form_Element_Submit("upd_cat");
		$elem->setAttribs(array("id"=>"upd_cat"));
		$elem->setAttribs('value','Ulož');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

	}
}
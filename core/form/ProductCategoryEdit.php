<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("ProductCategoryForm.php");
class Application_Form_ProductCategoryEdit extends ProductCategoryForm
{

	public $formName = "Editace skupiny";

	public $submitButtonName = "upd_cat";
	public $submitButtonTitle = "Ulož";


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

		$elem = new G_Form_Element_Submit("upd_cat");
		$elem->setAttribs(array("id"=>"upd_cat"));
		$elem->setAttribs('value','Ulož');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
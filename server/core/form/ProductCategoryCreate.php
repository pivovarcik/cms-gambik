<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("ProductCategoryForm.php");
class F_ProductCategoryCreate extends ProductCategoryForm
{
	public $formName = "Nová skupina";

	public $submitButtonName = "ins_nextid";
	public $submitButtonTitle = "Přidej";
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

		$elem = new G_Form_Element_Submit("ins_cat");
		$elem->setAttribs(array("id"=>"ins_cat"));
		$elem->setAttribs('value','Přidej');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
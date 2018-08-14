<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("ProductDostupnostForm.php");
class F_ProductDostupnostCreate extends ProductDostupnostForm
{

	public $formName = "Nová dostupnost";

	public $submitButtonName = "ins_cat";
	public $submitButtonTitle = "Přidej";

	function __construct()
	{
		// Typ Page
		parent::__construct();
		$this->init();
	}
	public function init()
	{
		parent::loadElements();

		$elem = new G_Form_Element_Submit("ins_cat");
		$elem->setAttribs(array("id"=>"ins_cat"));
		$elem->setAttribs('value','Přidej');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
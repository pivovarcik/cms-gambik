<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("ProductZarukaForm.php");
class Application_Form_ProductZarukaCreate extends ProductZarukaForm
{

	public $formName = "Nová záruka";

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
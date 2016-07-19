<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("ImportProductSettingForm.php");
class Application_Form_ImportProductSettingEdit extends ImportProductSettingForm
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

		$elem = new G_Form_Element_Submit("upd_cat");
		$elem->setAttribs(array("id"=>"upd_cat"));
		$elem->setAttribs('value','Save');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
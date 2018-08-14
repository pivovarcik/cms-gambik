<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("ImportProductSettingForm.php");
class F_ImportProductSettingEdit extends ImportProductSettingForm
{
  	public $formName = "Editace nastavení importu";

	public $submitButtonName = "ins_nextid";
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

		$elem = new G_Form_Element_Button("upd_cat");
		$elem->setAttribs(array("id"=>"upd_cat"));
		$elem->setAttribs('value','Ulož');
		$elem->setAttribs('class','btn btn-primary');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
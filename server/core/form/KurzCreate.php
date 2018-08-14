<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("KurzForm.php");
class F_KurzCreate extends KurzForm
{

	public $formName = "Nový kurz";

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

		$elem = new G_Form_Element_Button("ins_cat");
		$elem->setAttribs(array("id"=>"ins_cat"));
		$elem->setAttribs('value','Přidej');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
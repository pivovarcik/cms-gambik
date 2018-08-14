<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("TranslatorForm.php");
class F_TranslatorCreate extends TranslatorForm
{

	public $formName = "Nové slovo";

	public $submitButtonName = "ins_keyword";
	public $submitButtonTitle = "Přidej";


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

		$elem = new G_Form_Element_Submit("ins_keyword");
		$elem->setAttribs(array("id"=>"ins_keyword"));
		$elem->setAttribs('value','Přidej');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
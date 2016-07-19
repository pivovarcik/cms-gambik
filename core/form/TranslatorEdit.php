<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("TranslatorForm.php");
class Application_Form_TranslatorEdit extends TranslatorForm
{
	public $formName = "Editace slova";

	public $submitButtonName = "upd_keyword";
	public $submitButtonTitle = "Ulož";
	function __construct()
	{
		// Typ Page
		parent::__construct("models_Translator");
		$this->init();
	}
	public function init()
	{

		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);
		$this->loadElements();
		$page = $this->page;

		//print_r($page);
		$elem = new G_Form_Element_Submit("upd_keyword");
		$elem->setAttribs(array("id"=>"upd_keyword"));
		$elem->setAttribs('value','Ulož');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
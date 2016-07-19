<?php
/**
 * Třída pro přidání nového hitu
 * */

require_once("CiselnikForm.php");
class Application_Form_ProductVyrobceEdit extends CiselnikForm
{

	public $formName = "Editace značky";

	public $submitButtonName = "upd_cat";
	public $submitButtonTitle = "Ulož";

	function __construct()
	{
		parent::__construct("models_ProductVyrobce");
		$this->init();
	}
	public function init()
	{

		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);
		$this->loadElements();
		$page = $this->page;
		$elem = new G_Form_Element_Button("upd_cat");
		$elem->setAttribs(array("id"=>"upd_cat"));
		$elem->setAttribs('value','Ulož');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
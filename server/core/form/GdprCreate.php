<?php
require_once("GdprForm.php");
class F_GdprCreate extends GdprForm
{
  	public $formName = "Vytvoření souhlasu";
	public $submitButtonName = "upd_cat";
	public $submitButtonTitle = "Uložit";
	function __construct()
	{
		// Typ Page
		parent::__construct();
		$this->init();
	}
	public function init()
	{
	//s	$id = (int) $this->Request->getQuery("id",null);
		$this->loadPage();
		parent::loadElements();

		$elem = new G_Form_Element_Button("upd_cat");
		$elem->setAttribs(array("id"=>"upd_cat"));
		$elem->setAttribs('value','Ulož');
		//$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
<?php

require_once("NextIdForm.php");
class F_NextIdEdit extends NextIdForm
{

	public $formName = "Editace číselné řady";

	public $submitButtonName = "upd_cat";
	public $submitButtonTitle = "Ulož";

	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{
		$id = (int) $this->Request->getQuery("id",null);
		$this->loadPage($id);
		parent::loadElements();
		$elem = new G_Form_Element_Button("upd_cat");
	//	$elem = new G_Form_Element_Button("upd_nextid");
		$elem->setAttribs('value','Ulož');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

	}
}
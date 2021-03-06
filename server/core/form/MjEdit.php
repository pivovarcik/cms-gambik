<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("MJForm.php");
class F_MjEdit extends MJForm
{

	public $formName = "Editace MJ";
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
		$id = (int) $this->Request->getPost("F_MjEdit_id",$this->Request->getQuery("id",null));
		$this->loadPage($id);
		parent::loadElements();
		$elem = new G_Form_Element_Submit("upd_cat");
		$elem->setAttribs(array("id"=>"upd_cat"));
		$elem->setAttribs('value','Ulož');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
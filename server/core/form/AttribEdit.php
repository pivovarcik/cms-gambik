<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("AttribForm.php"); 
class F_AttribEdit extends AttribForm
{
	public $formName = "Editace parametru produktu";

	public $submitButtonName = "upd_cat";
	public $submitButtonTitle = "Ulož";
	function __construct()
	{
		parent::__construct();
    
		$this->init();
	}
  
  	public function init()
	{
  
  		$id = (int) $this->Request->getPost("F_AttribEdit_id",$this->Request->getQuery("id",null));
		$this->loadPage($id);
		parent::loadElements();
    
	//	parent::loadElements();

		$elem = new G_Form_Element_Submit("upd_cat");
		$elem->setAttribs(array("id"=>"upd_cat"));
		$elem->setAttribs('value','Ulož');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}

}
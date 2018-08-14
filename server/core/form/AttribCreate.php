<?php
/**
 * Třída pro přidání nového hitu
 * */      
require_once("AttribForm.php"); 
class F_AttribCreate extends AttribForm
{
	public $formName = "Vytvoření nového parametru produktu";
	public $submitButtonName = "ins_cat";
	public $submitButtonTitle = "Ulož";
  
	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{


  		$this->loadPage(null);
		parent::loadElements();
    
	/*	$elem = new G_Form_Element_Text("name");
		$elem->setAttribs(array(
						"id"=>"name",
						"required"=>true
						));
		$value = $this->getPost("name", "");
		$elem->setAttribs('label','Název:');
		$elem->setAttribs('style','width:300px;font-weight:bold;');
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		//$paramName = $elemParamName->render();

		$elem = new G_Form_Element_Textarea("description");
		$elem->setAttribs(array("id"=>"description"));
		$value = $this->getPost("description", "");
		$elem->setAttribs('class','textarea');
		$elem->setAttribs('value',	$value);
		$elem->setAttribs('label','Popis:');
		//$elem = $elemDescription->render();
		$this->addElement($elem);

		$elem = new G_Form_Element_Button("ins_attr");
		$elem->setAttribs('value','Přidej');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
	//	$paramSubmit = $elemSubmit->render();
		$this->addElement($elem);
    
    		// Akce
		$elem = new G_Form_Element_Hidden("action",true);
		$elem->setAnonymous();
		$elem->setAttribs('value',str_replace("F_", "" ,get_class($this) ));
		$this->addElement($elem);         */

	}
}
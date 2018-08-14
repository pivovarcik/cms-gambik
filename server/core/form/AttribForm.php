<?php

abstract class AttribForm extends G_Form
{

	public $pageModel;
	public $page;
	public $page_id;
  public $languageModel;
	public $languageList = array();
  public $attributy = array();
	function __construct()
	{
		parent::__construct();
//		$this->loadModel("models_Attributes");
		$this->loadModel("models_ProductAttributes");
		$this->setStyle(BootstrapForm::getStyle());


		//$this->loadElements();

	}

	// načte datový model
	public function loadModel($model)
	{
		$this->pageModel = new $model;
    
    		$this->languageModel = new models_Language();
		$this->languageList = $this->languageModel->getActiveLanguage();
	}
	// načte datový model
	public function loadPage($page_id = null)
	{



  		if ($page_id == null) {
			$this->page = new stdClass();
		} else {
			$this->page = $this->pageModel->getDetailById($page_id);
			$this->page_id = $page_id;
		}
    
		//	print "ID:" . $page_id;
		if ($page_id == null) {
			$this->page = array();

		} else {
      $this->page = $this->pageModel->getDetailById($page_id);
		//	$this->attributy = $this->pageModel->get_attribute_value_association($page_id);
			//print_r($this->page);
			$this->page_id = $page_id;

		}

	}

	// načte datový model
	public function loadElements()
	{
		//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");



    		$page = $this->page;

		foreach ($this->languageList as $key => $val)
		{
			// Title
			$name = "name_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
		  //	$elem->setAttribs('style','width:300px;font-weight:bold;');
			$value = $this->getPost($name, $page->$name);
			$elem->setAttribs('value',$value);
		  //	$elem->setAttribs('class','form-control');
			$elem->setAttribs('label','Název ('.$val->code.'):');
			$this->addElement($elem);
      
      $name = "description_$val->code";
      $elem = new G_Form_Element_Textarea($name);
		  $elem->setAttribs(array("id"=>$name));
			$elem->setAttribs('class','textarea');
		  $value = $this->getPost($name, $page->$name);
		  $elem->setAttribs('value',	$value);
		  $elem->setAttribs('label','Popis ('.$val->code.'):');
		  $this->addElement($elem);
    

		}

    $name = "multi_select";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Multi-výběrový');
		$this->addElement($elem);
    
    $name = "secret";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Neveřejný');
		$this->addElement($elem);
        
		// Akce
		$elem = new G_Form_Element_Hidden("action",true);
		$elem->setAnonymous();
		$elem->setAttribs('value',str_replace("F_", "" ,get_class($this) ));
		$this->addElement($elem);

		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}
    
    
    $name =   "pohoda_id";
    $elem = new G_Form_Element_Text($name);
		//$elem->setAttribs(array("id"=>"description"));
		//	$elem->setAttribs('class','textarea');
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',	$value);
		$elem->setAttribs('label','ID pohody:');
		$this->addElement($elem);
    
   /*
		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}     */

	}
}
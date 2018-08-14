<?php


class ProductDostupnostForm extends G_Form
{

	public $pageModel;
	public $page;
	public $page_id; // primární klíč page záznamu

	public $languageModel;
	public $languageList = array();


	function __construct()
	{
		parent::__construct();
		$this->loadModel("models_ProductDostupnost");

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

	}
	// načte datový model
	public function loadElements()
	{
	//	parent::loadElements();
		//print "PageForm()";
		//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$page = $this->page;
    //print_R($page);
    $name = "hodiny";
    
    $hod = $page->$name*1;
    $dny = $hod/24;
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Počet dnů:');
		$elem->setAttribs('is_numeric',true);
		$value = $this->getPost($name, $dny);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);
    
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
			$elem->setAttribs('label','Dostupnost ('.$val->code.'):');
			$this->addElement($elem);

		}


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
	}
}
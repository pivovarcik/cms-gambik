<?php

class FileForm extends G_Form
{

	public $pageModel;
	public $page;
	public $page_id;

	function __construct($model)
	{
		parent::__construct();
		$this->loadModel($model);
		$this->setStyle(BootstrapForm::getStyle());


		//$this->loadElements();

	}
	// načte datový model
	public function loadModel($model)
	{
		$this->pageModel = new $model;


	}
	// načte datový model
	public function loadPage($page_id = null)
	{

		//	print "ID:" . $page_id;
		if ($page_id == null) {
			$this->page = new stdClass();
			$this->page->name = null;
			$this->page->description = null;
			$this->page->parent = null;

		} else {
			$this->page = $this->pageModel->getDetailById($page_id);
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


		$name = "file";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
	//	$elem->setAttribs('style','width:300px;font-weight:bold;');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Název:');
		$this->addElement($elem);


		// Description
		$name = "description";
		$elem = new G_Form_Element_Textarea($name);
		$value = $this->getPost($name, htmlentities($page->$name, ENT_COMPAT, 'UTF-8'));
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',$value);
	//	$elem->setAttribs('class','textarea mceEditor');
		$elem->setAttribs('cols','55');
		$elem->setAttribs('rows','8');
		$elem->setAttribs('label','Popis:');
		$this->addElement($elem);



		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}

		// Akce
		$elem = new G_Form_Element_Hidden("action",true);
		$elem->setAnonymous();
		$elem->setAttribs('value',str_replace("Application_Form_", "" ,get_class($this) ));
		$this->addElement($elem);
	}
}
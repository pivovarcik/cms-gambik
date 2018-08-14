<?php

class F_BasketEdit extends G_Form {


	public $submitButtonName = "ins_nextid";
	public $submitButtonTitle = "Ulož";

	public function __construct()
	{
		$model = "models_Basket";
	//	parent::__construct($model);

		parent::__construct();
		$this->loadModel($model);
		$this->setStyle(BootstrapForm::getStyle());

		$this->init();
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
		//	print_r($this->page);
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

		$druhSlevyList = array("%","");

		$name = "typ_slevy";
		$elem = new G_Form_Element_Select($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox small_size');
		$elem->setAttribs('label','Druh slevy');
		//	$elem->setAttribs('class','form_edit small_size');
	//	$elem->setAttribs('onchange','prepocti_cenu2();');

		//	print_r($dphList);
		$pole = array();
		//$pole[0] = " -- neuveden -- ";
		$attrib = array();
		foreach ($druhSlevyList as $key => $value)
		{
			$pole[$value] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$name = "qty";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		//	$elem->setAttribs('style','width:300px;font-weight:bold;');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('is_numeric',true);
		$elem->setAttribs('label','Množství:');
		$this->addElement($elem);

		$name = "sleva";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		//	$elem->setAttribs('style','width:300px;font-weight:bold;');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('is_money',true);
		$elem->setAttribs('label','Sleva:');
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
		$elem->setAttribs('value',"BasketEdit");
		$this->addElement($elem);
	}

	public function init()
	{
		$page_id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($page_id);
		$this->loadElements();
		/*	$name = "action";
		   $elem = new G_Form_Element_Hidden($name);
		   $elem->setAttribs(array("id"=>$name));
		   $elem->setAttribs('value',"ImageEdit");
		   $elem->setAnonymous();
		   $this->addElement($elem);*/
		/*
		   $name = "description";
		   $elem = new G_Form_Element_Text($name);
		   $elem->setAttribs(array("id"=>$name));
		   $value = $this->getPost($name,$this->page->$name);
		   $elem->setAttribs('value',$value);
		   //	$elem->setAnonymous();
		   $this->addElement($elem);
		*/

		$this->formName = "Editace zboží v košíku ".$this->page->product_name."";
	}

}

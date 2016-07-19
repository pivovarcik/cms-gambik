<?php

abstract class ProductCenaForm extends G_Form
{

	public $formNameEdit = "ProductCenaEdit";

	public $pageModel;
	public $page;
	public $page_id;


	function __construct()
	{
		parent::__construct();
		$this->loadModel("models_ProductCena");
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
		//	$this->page->name = null;
		//	$this->page->description = null;

		} else {
			$this->page = $this->pageModel->getDetailById($page_id);
			//print_r($this->page);
			$this->page_id = $page_id;
		}

	}


	public function loadElements()
	{



		$page = $this->page;


		//	print_r($page);
		$name = "sleva";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Sleva:');
		$elem->setAttribs('is_numeric',true);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);


		$name = "priorita";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Priorita:');
		//	$elem->setAttribs('is_numeric',true);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);



		$name = "platnost_od";
		$datum_od = !empty($page->$name) ? date("j.n.Y H:i", strtotime($page->$name)) : "";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','date');
		$elem->setAttribs('label','Platnost od:');
		//	$elem->setAttribs('is_numeric',true);
		$value = $this->getPost($name, $datum_od);

		if (empty($value)) {
			$value = date("j.n.Y");
		}

		$value = date("j.n.Y", strtotime($value));


		$elem->setAttribs('value',$value);
		$this->addElement($elem);


		$name = "platnost_do";
		$datum_do = !empty($page->$name) ? date("j.n.Y H:i", strtotime($page->$name)) : "";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','date');
		$elem->setAttribs('label','Platnost do:');
		//	$elem->setAttribs('is_numeric',true);
		$value = $this->getPost($name, $datum_do);

		if (!empty($value)) {
			$value = date("j.n.Y", strtotime($value));
		}

		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$druhSlevyList = array("%","");
		$name = "typ_slevy";
		$elem = new G_Form_Element_Select($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox small_size');
		$elem->setAttribs('label','Typ slevy:');
		$pole = array();
		$attrib = array();
		foreach ($druhSlevyList as $key => $value)
		{
			$pole[$value] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

	}
}
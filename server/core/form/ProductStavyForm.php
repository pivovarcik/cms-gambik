<?php

abstract class ProductStavyForm extends G_Form
{

	public $formNameEdit = "ProductStavyEdit";

	public $pageModel;
	public $page;
	public $page_id;


	function __construct()
	{
		parent::__construct();
		$this->loadModel("models_ProductStavy");
	}
	// na�te datov� model
	public function loadModel($model)
	{
		$this->pageModel = new $model;
	}
	// na�te datov� model
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
		$name = "qty";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Mno�stv�:');
		$elem->setAttribs('is_numeric',true);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);


		$name = "qty_min";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Mni. mno�:');
		$elem->setAttribs('is_numeric',true);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);



		$name = "qty_max";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Mni. mno�:');
		$elem->setAttribs('is_numeric',true);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

	}
}
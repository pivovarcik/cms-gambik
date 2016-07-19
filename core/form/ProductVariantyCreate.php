<?php
require_once("ProductVariantyForm.php");
class Application_Form_ProductVariantyCreate extends ProductVariantyForm
{


	public $pageModel;
	public $page;
	public $page_id;


	public $formName = "Nová varianta";
	public $submitButtonName = "kontrolaConfirm";
	public $submitButtonTitle = "Přidej";



	function __construct()
	{
		parent::__construct();
		$this->init();

	}


	public function init()
	{
	//	$id = (int) $this->Request->getQuery("id",false);
		$product_id = (int) $this->Request->getQuery('id', 0);
		$this->loadPage(null, $product_id);
		$this->loadElements();
		$page = $this->page;

		// Akce
		$elem = new G_Form_Element_Hidden("action");
		$elem->setAnonymous();
		$elem->setAttribs('value',str_replace("Application_Form_", "" ,get_class($this) ));
		$this->addElement($elem);
		/*
		   $name = "kontrolaConfirm";
		   $elem = new G_Form_Element_Button($name);
		   $elem->setAttribs(array("id"=>$name));
		   $elem->setAttribs('value','Potvrdit');
		   $elem->setAttribs('class','btn btn-success');
		   $elem->setAttribs('label','');
		   $elem->setIgnore(true);
		   $this->addElement($elem);*/
	}



}
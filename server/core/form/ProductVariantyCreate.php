<?php
require_once("ProductVariantyForm.php");
class F_ProductVariantyCreate extends ProductVariantyForm
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
		$elem->setAttribs('value',str_replace("F_", "" ,get_class($this) ));
		$this->addElement($elem);

	}



}
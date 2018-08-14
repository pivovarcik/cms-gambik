<?php
require_once("ProductVariantyForm.php");
class F_ProductVariantyEdit extends ProductVariantyForm
{


	public $pageModel;
	public $page;
	public $page_id;


	public $formName = "Editace varianty";
	public $submitButtonName = "kontrolaConfirm";
	public $submitButtonTitle = "Ulož";


	function __construct()
	{
		parent::__construct();
		$this->init();

	}


	public function init()
	{
		$id = (int) $this->Request->getQuery("id",false);

		$this->loadPage($id);
		$this->loadElements();
		$page = $this->page;

		// Akce
		$elem = new G_Form_Element_Hidden("action");
		$elem->setAnonymous();
		$elem->setAttribs('value',str_replace("F_", "" ,get_class($this) ));
		$this->addElement($elem);

	}



}
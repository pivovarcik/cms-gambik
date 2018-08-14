<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("ProductForm.php");
class F_ProductEdit extends ProductForm
{
	public $formName = "Editace produktu";

	public $submitButtonName = "ins_nextid";
	public $submitButtonTitle = "Ulož";

	function __construct()
	{
		// Typ Page
		parent::__construct();
		$this->init();
	}

	public function init()
	{
		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);
		$this->loadElements();
		$page = $this->page;

		$this->detailLink = URL_HOME . "sortiment/edit_product?id=" . $id;

		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"ProductEdit");
		$elem->setAnonymous();
		$this->addElement($elem);

		$elem = new G_Form_Element_Hidden("cat_url");
		$elem->setAttribs('value', get_categorytourl($page->serial_cat_url,""," &#155; "));
		$elem->setIgnore(true);
		$this->addElement($elem);

		$elem = new G_Form_Element_Button("upd_product");
		$elem->setAttribs(array("id"=>"upd_product"));
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

		$elem = new G_Form_Element_Button("copy_product");
		$elem->setAttribs(array("id"=>"copy_product"));
		$elem->setAttribs('value','Kopírovat');
		$elem->setAttribs('onclick',"return confirm('Kopírovat produkt?');");
		$elem->setAttribs('class','btn btn-sm btn-warning');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);




	}
}
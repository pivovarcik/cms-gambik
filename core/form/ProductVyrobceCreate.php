<?php
/**
 * Třída pro přidání nového hitu
 * */

require_once("CiselnikForm.php");
class Application_Form_ProductVyrobceCreate extends CiselnikForm
{

	public $formName = "Nová značka";

	public $submitButtonName = "ins_product_vyrobce";
	public $submitButtonTitle = "Přidej";

	function __construct()
	{
		parent::__construct("models_ProductVyrobce");
		$this->init();
	}
	public function init()
	{

		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);
		$this->loadElements();
		$page = $this->page;
		$elem = new G_Form_Element_Submit("ins_product_vyrobce");
		$elem->setAttribs(array("id"=>"ins_product_vyrobce"));
		$elem->setAttribs('value','Přidej');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
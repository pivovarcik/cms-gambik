<?php
/**
 * Třída pro přidání nového hitu
 * */
//require_once("CiselnikForm.php");
require_once(PATH_ROOT . "core/form/CiselnikForm.php");
class ProductDostupnostForm extends CiselnikForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct("models_ProductDostupnost");

	}
	public function loadElements()
	{
		parent::loadElements();


		$page = $this->page;


		$name = "hodiny";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Počet minut:');
		$elem->setAttribs('is_numeric',true);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

	}
}
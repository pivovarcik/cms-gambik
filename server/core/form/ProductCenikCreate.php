<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("ProductCenikForm.php");
class F_ProductCenikCreate extends ProductCenikForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct();
		$this->init();
	}
	public function init()
	{
		parent::loadElements();

		$elem = new G_Form_Element_Button("ins_product_cenik");
		$elem->setAttribs(array("id"=>"ins_cat"));
		$elem->setAttribs('value','Přidej');
	//	$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
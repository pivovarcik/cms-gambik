<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("CiselnikForm.php");
abstract class ProductCategoryForm extends CiselnikForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct("models_ProductCategory");

	}

	public function loadElements()
	{
		parent::loadElements();

		$tree = new G_CiselnikTree("ProductCenik");
		$productCenikList = $tree->categoryTree();


		$name = "cenik_id";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Ceník:');
		$elem->setAttribs('class','selectbox');
		$pole = array();
		$pole[0] = " -- neuveden -- ";
		foreach ($productCenikList as $key => $value)
		{
			//$pole[$value->id] = $value->name;
			$pole[$value->id] = $value->title;
			$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);
	}
}
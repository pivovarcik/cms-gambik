<?php
/**
 * Společný předek pro formuláře typu Category
 * */
require_once("PageForm.php");
abstract class CategoryForm extends PageForm
{


	function __construct($model)
	{
		parent::__construct($model);
		$this->setStyle(BootstrapForm::getStyle());
	}


	// načte datový model
	public function loadElements()
	{
		parent::loadElements();


		$page = $this->page;


		$name = "icon_class";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Třída:');
		$this->addElement($elem);
	}
}
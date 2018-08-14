<?php

require_once("CiselnikForm.php");
abstract class ProductCenikForm extends CiselnikForm
{

	public $formNameEdit = "ProductCenikEdit";
	function __construct()
	{
		// Typ Page
		parent::__construct("models_ProductCenik");

	}
	public function loadElements()
	{
		parent::loadElements();


		$page = $this->page;


	//	print_r($page);
		$name = "sleva";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Sleva:');
		$elem->setAttribs('is_numeric',true);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);


		$name = "priorita";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Priorita:');
	//	$elem->setAttribs('is_numeric',true);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);




		$datum_publikace = date("j.n.Y H:i", strtotime($page->publicDate));
		$name = "platnost_od";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','date');
		$elem->setAttribs('label','Platnost od:');
	//	$elem->setAttribs('is_numeric',true);
		$value = $this->getPost($name, $page->$name);

		if (empty($value)) {
			$value = date("j.n.Y");
		}

		$value = date("j.n.Y", strtotime($value));


		$elem->setAttribs('value',$value);
		$this->addElement($elem);


		$name = "platnost_do";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','date');
		$elem->setAttribs('label','Platnost do:');
	//	$elem->setAttribs('is_numeric',true);
		$value = $this->getPost($name, $page->$name);

		if (!empty($value)) {
			$value = date("j.n.Y", strtotime($value));
		}

		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$druhSlevyList = array("%","");
		$name = "typ_slevy";
		$elem = new G_Form_Element_Select($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox small_size');
		$elem->setAttribs('label','Typ slevy:');
		$pole = array();
		$attrib = array();
		foreach ($druhSlevyList as $key => $value)
		{
			$pole[$value] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

	}
}
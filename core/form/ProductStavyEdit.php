<?php

require_once("ProductStavyForm.php");
class Application_Form_ProductStavyEdit extends ProductStavyForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct();
		$this->init();
	}
	public function init()
	{
		$id = (int) $this->Request->getQuery("id",null);
		$this->loadPage($id);
		parent::loadElements();

		$elem = new G_Form_Element_Button("upd_cat");
		$elem->setAttribs(array("id"=>"upd_cat"));
		$elem->setAttribs('value','Ulož');
		//$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}

?>
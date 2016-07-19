<?php
/**
 * Třída pro přidání podniku
 * */
require_once(PATH_ROOT . "core/form/CatalogFiremForm.php");
class Application_Form_CatalogFiremCreate extends CatalogFiremForm
{

	function __construct()
	{
		parent::__construct("models_CatalogFirem");
		$this->init();
	}

	public function init()
	{
		$this->loadPage();
		$this->loadElements();
		$page = $this->page;


		$elem = new G_Form_Element_Submit("ins_catalog");
		$elem->setAttribs(array("id"=>"ins_catalog"));
		$elem->setAttribs('value','Přidej');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
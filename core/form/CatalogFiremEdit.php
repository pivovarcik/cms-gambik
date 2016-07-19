<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once(PATH_ROOT . "core/form/CatalogFiremForm.php");
class Application_Form_CatalogFiremEdit extends CatalogFiremForm
{

	function __construct()
	{
		parent::__construct("models_CatalogFirem");
		$this->init();
	}
	public function init()
	{

		$id = (int) $this->Request->getQuery("id",false);

		$this->loadPage($id);

		$this->loadElements();
		$page = $this->page;


		$elem = new G_Form_Element_Button("upd_catalog");
		$elem->setAttribs(array("id"=>"upd_catalog"));
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
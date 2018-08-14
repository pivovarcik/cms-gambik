<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once(PATH_ROOT2 . "core/form/CatalogForm.php");
class F_CatalogEdit extends CatalogForm
{

	function __construct()
	{
		parent::__construct("models_Catalog");
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
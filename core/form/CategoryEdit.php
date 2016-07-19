<?php
/**
 * Třída pro přidání nového hitu
 * */

require_once("CategoryForm.php");
class Application_Form_CategoryEdit extends CategoryForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct("models_Category");
		$this->init();
	}
	public function init()
	{
		$this->category_root = 1;
		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);
		$this->loadElements();
		$page = $this->page;



		$EshopController = new EshopController();

		if ($EshopController->isEshopCategory($id)) {

			$label = "Odebrat ze shopu";
		} else {
			$label = "Přidat do shopu";
		}

		$elem = new G_Form_Element_Button("set_cat_shop");
		$elem->setAttribs(array("id"=>"set_cat_shop"));
		$elem->setAttribs('value',$label);
		$elem->setAttribs('class','btn btn-sm btn-info');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);



		$elem = new G_Form_Element_Button("upd_cat");
		$elem->setAttribs(array("id"=>"upd_cat"));
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

		$elem = new G_Form_Element_Button("del_cat");
		$elem->setAttribs(array("id"=>"del_cat"));
		$elem->setAttribs('value','Smazat');
		$elem->setAttribs('onclick',"return confirm('Opravdu smazat rubriku?');");
		$elem->setAttribs('class','btn btn-sm btn-warning');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
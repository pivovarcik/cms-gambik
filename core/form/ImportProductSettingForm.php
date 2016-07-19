<?php

require_once(PATH_ROOT . "core/form/CiselnikForm.php");
abstract class ImportProductSettingForm extends CiselnikForm
{

	protected $nextidProductList;
	function __construct()
	{
		$this->setStyle(BootstrapForm::getStyle());
		parent::__construct("models_ImportProductSetting");

	}
	/*
	public function init()
	{

		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);
		$this->loadElements();
		$page = $this->page;

	}*/

	public function loadElements()
	{
		parent::loadElements();
		$nextid = new models_NextId();
		$args = new ListArgs();
		$args->limit = 1000;
		$args->tabulka = T_SHOP_PRODUCT;
		$this->nextidProductList = $nextid->getList($args);
		$page = $this->page;
		$name = "url";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Adresa XML:');
		$elem->setAttribs("required",true);
		$elem->setAttribs('class','textbox');
	//	$elem->setAttribs('is_numeric',true);
		$this->addElement($elem);

		$name = "block_size";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Propustnost:');
		$elem->setAttribs("required",true);
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('is_numeric',true);
		$this->addElement($elem);

		$name = "deactive_product";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label','Deaktivovat produkty:');
		$this->addElement($elem);

		$name = "import_product_is_active";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label','Importovat produkty jako aktivní:');
		$this->addElement($elem);

		$name = "import_images";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label','Import vč. obrázků:');
		$this->addElement($elem);

		$name = "nextid_product";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Řada produktů:');
		$pole = array();
		$pole[0] = " -- žádná -- ";
		$attrib = array();
		foreach ($this->nextidProductList as $key => $value)
		{
			$pole[$value->id] = $value->rada;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);
	}
}
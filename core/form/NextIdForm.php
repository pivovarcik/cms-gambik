<?php
require_once(PATH_ROOT . "core/form/CiselnikForm.php");
class NextIdForm extends CiselnikForm
{
//	protected $page;
//	protected $page_id;
//	protected $pageModel;

	protected $delka_dokladu;
	protected $tabulky;
	function __construct()
	{
		// Typ Page
		parent::__construct("models_NextId");

	}
	public function loadElements()
	{
		parent::loadElements();

		$page = $this->page;

		$name = "rada";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$elem->setAttribs('style','width:35px;text-align:left');
		$elem->setAttribs('maxlength','4');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Řada:');
		$this->addElement($elem);

		$name = "nazev";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Název řady:');
		$this->addElement($elem);


		$name = "delka";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Celková délka dokladu:');
		$pole = array();
		foreach ($this->delka_dokladu as $row)
		{
			$pole[$row] = $row;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);

		$name = "tabulka";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Druh dokladu:');
		$pole = array();
		foreach ($this->tabulky as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);
	}

	public function loadPage($page_id = null)
	{
		parent::loadPage($page_id);
		$this->delka_dokladu = array("5","6","7","8","9","10");


		$this->tabulky = array(
		strToUpper(T_SHOP_PRODUCT) => "Produkty",
		strToUpper(T_SHOP_ORDERS) => "Objednávky",
		strToUpper(T_FAKTURY) => "Faktury",
		);
	}



	public function init()
	{

		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);
		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}

		$page = $this->page;

		$name = "rada";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$elem->setAttribs('style','width:35px;text-align:left');
		$elem->setAttribs('maxlength','4');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Řada:');
		$this->addElement($elem);

		$name = "nazev";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Název řady:');
		$this->addElement($elem);


		$name = "delka";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Celková délka dokladu:');
		$pole = array();
		foreach ($this->delka_dokladu as $row)
		{
			$pole[$row] = $row;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);

		$name = "tabulka";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Druh dokladu:');
		$pole = array();
		foreach ($this->tabulky as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);




	}
}
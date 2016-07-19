<?php
/**
 * Třída pro přidání nového hitu
 * */
//require_once("CiselnikForm.php");
require_once(PATH_ROOT . "core/form/CiselnikForm.php");
abstract class KurzForm extends CiselnikForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct("models_kurz");

	}
	public function loadElements()
	{
		parent::loadElements();


		$page = $this->page;


		$name = "kod";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Kód měny:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "kurz";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Kurz:');
		$elem->setAttribs('class','textbox small_size numeric');
		$elem->setAttribs('is_money',true);
		$this->addElement($elem);

		$name = "mnozstvi";

		$value = $this->page->$name;
		if (empty($this->page->$name)) {
			$value = 1;
		}
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Množství měny:');
		$elem->setAttribs('class','textbox small_size numeric');
		$elem->setAttribs('is_numeric',true);
		$this->addElement($elem);


		$name = "datum";

		if (isset($this->page->$name)) {
			$datum_expirace = date("j.n.Y", strtotime($this->page->$name));
		} else {
			$datum_expirace = "";
		}

		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $datum_expirace);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Datum:');
		$elem->setAttribs('class','textbox small_size datepicker');
		$this->addElement($elem);


		$this->getElement("name")->setAttribs('label','Název měny:');;
	}
}
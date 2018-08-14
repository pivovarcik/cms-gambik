<?php
/**
 * Třída pro přidání nového žádanky
 * */
require_once("ObjednavkaForm.php");
class F_ObjednavkaCreate extends ObjednavkaForm
{

	function __construct()
	{
		parent::__construct();
		$this->init();
	}

	public function init()
	{

		$id = (int) $this->Request->getQuery("id",null);
		$this->loadPage($id);
		$this->loadElements();
		$doklad = $this->doklad;


		$elem = new G_Form_Element_Button("ins");
		$elem->setAttribs(array("id"=>"ins"));
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

	}
}
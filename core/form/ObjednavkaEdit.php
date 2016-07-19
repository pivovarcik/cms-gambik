<?php
/**
 * Třída pro editaci objednávky
 * */
require_once("ObjednavkaForm.php");
class Application_Form_ObjednavkaEdit extends ObjednavkaForm
{

	public $formName = "Editace objednávky";

	public $submitButtonName = "ins_nextid";
	public $submitButtonTitle = "Ulož";

	public $detailLink = "";

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

		$this->detailLink = URL_HOME . "objednavky/objednavka_detail?id=" . $id;


		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"ObjednavkaEdit");
		$elem->setAnonymous();
		$this->addElement($elem);

	//	print_R($this->doklad);

		$elem = new G_Form_Element_Button("save");
		$elem->setAttribs(array("id"=>"save"));
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

		$elem = new G_Form_Element_Button("generovat_fakturu");
		$elem->setAttribs(array("id"=>"generovat_fakturu"));
		$elem->setAttribs('value','Vystavit fakturu');
		$elem->setAttribs('class','btn btn-sm btn-warning');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

		if ($this->doklad_id > 0)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->doklad_id);
			$this->addElement($elem);
		}
	}
}
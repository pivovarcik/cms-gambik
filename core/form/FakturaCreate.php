<?php
/**
 * Třída pro přidání nového žádanky
 * */
require_once("FakturaForm.php");
class Application_Form_FakturaCreate extends FakturaForm
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

		$eshopController = new EshopController();
		$rada_user = "";
		$nextIdModel = new models_NextId();
		$doklad->code = $nextIdModel->vrat_nextid(array(
				"tabulka" => T_FAKTURY,
				"polozka" => "code",
				"rada_id" => (int) $eshopController->setting["NEXTID_FAKTURA"],
				"rada" => $rada_user,
			));
	//	print $doklad->code;
		$name = "code";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$elem->setAttribs('style','width:185px;font-weight:bold;');
		$elem->setAttribs('readonly','readonly');
		$value = $doklad->$name;
		$elem->setAttribs('value',$value);
	//	print $value;
		$elem->setAttribs('label','Číslo faktury:');
		$elem->setAttribs('class','form_edit medium_size readonly');
		$this->addElement($elem);

		$elem = new G_Form_Element_Button("ins");
		$elem->setAttribs(array("id"=>"ins"));
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

	}
}
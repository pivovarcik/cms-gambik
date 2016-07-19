<?php
/**
 * Třída pro přidání nového hitu
 * */
class Application_Form_AttribCreate extends G_Form
{

	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{

		$elem = new G_Form_Element_Text("name");
		$elem->setAttribs(array(
						"id"=>"name",
						"required"=>true
						));
		$value = $this->getPost("name", "");
		$elem->setAttribs('label','Název:');
		$elem->setAttribs('style','width:300px;font-weight:bold;');
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		//$paramName = $elemParamName->render();

		$elem = new G_Form_Element_Textarea("description");
		$elem->setAttribs(array("id"=>"description"));
		$value = $this->getPost("description", "");
		$elem->setAttribs('class','textarea');
		$elem->setAttribs('value',	$value);
		$elem->setAttribs('label','Popis:');
		//$elem = $elemDescription->render();
		$this->addElement($elem);

		$elem = new G_Form_Element_Button("ins_attr");
		$elem->setAttribs('value','Přidej');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
	//	$paramSubmit = $elemSubmit->render();
		$this->addElement($elem);

	}
}
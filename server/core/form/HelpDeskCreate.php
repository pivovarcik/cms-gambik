<?php

/**
 * Třída pro přidání nového hitu
 * */
class F_HelpDeskCreate extends G_Form
{

	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{
		$translator = G_Translator::instance();

		$typZpravy = array("Nahlásit problém/chybu",
				"Potřebuji poradit",
				"Námět na vylepšení",
				"jiné");


		$name="typ";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$value = $this->Request->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox large');
		$elem->setAttribs('label','Druh zprávy:*');
		$pole = array();
		$pole[0] = " - vyberte - ";
		$attrib = array();
		foreach ($typZpravy as $key => $value)
		{

			//if (!in_array($value->id, $this->ignore_category)) {
			$pole[$value] = $value;
			//	$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
			//}
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$name = "zprava";
		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs(array("id"=>$name,));
		$value = $this->getPost($name, "");
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','editbox');
		$elem->setAttribs('placeholder',$translator->prelozitFrazy($name));
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);


		$elem = new G_Form_Element_Button("send_dotaz");
		$elem->setAttribs('value',$translator->prelozitFrazy("odeslat"));
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label',' ');
		$elem->setIgnore(true);
		$this->addElement($elem);

	}
}
<?php
/**
 * Třída pro přidání nového hitu
 * */
class AboutCMSForm extends G_Form
{
	protected $page;
	private $page_id;
	function __construct()
	{
		parent::__construct();
		//$this->loadModel("models_Users");
		$this->setStyle(BootstrapForm::getStyle());
		$this->init();
	}

	public function init()
	{
		$settings = G_Setting::instance();


		$name = "verze_cms";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs('value',VERSION_RS);
		$elem->setAttribs("label","Verze systému");
		$elem->setAttribs("readonly",true);
		$this->addElement($elem);



		$name = "licence_key_cms";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs('value',$settings->get("LICENCE_KEY"));
		$elem->setAttribs("label","Licenční klíč");
		$elem->setAttribs("readonly",true);
		$this->addElement($elem);

		$name = "datum_cms";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs('value',date("j.n.Y",strtotime(VERSION_DATE)));
		$elem->setAttribs("label","Datum první instalace");
		$elem->setAttribs("readonly",true);
		$this->addElement($elem);


		$name = "datum_instalace";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs('value',date("j.n.Y",strtotime(INSTALL_DATE)));
		$elem->setAttribs("label","Datum licence do");
		$elem->setAttribs("readonly",true);
		$this->addElement($elem);



		$name = "verze_php";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs('value',phpversion());
		$elem->setAttribs("label","Verze PHP");
		$elem->setAttribs("readonly",true);
		$this->addElement($elem);

		$name = "robots_txt";
		$filename = PATH_ROOT. "robots.txt";
		$file = file_get_contents($filename);

		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs('value',$file);
		$elem->setAttribs("label","Robots.txt");
		$elem->setAttribs("readonly",true);
		$this->addElement($elem);

		$name = "htaccess";
		$filename = PATH_ROOT. ".htaccess";
		$file = file_get_contents($filename);

		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs('value',$file);
		$elem->setAttribs("label",".htaccess");
		$elem->setAttribs("readonly",true);
		$this->addElement($elem);

		$name = "autor_cms";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs('value',AUTOR_RS);
		$elem->setAttribs("label","Autor CMS");
		$elem->setAttribs("readonly",true);
		$this->addElement($elem);

		$name = "autor_contact";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs('value',CONTACT_RS);
		$elem->setAttribs("label","Helpdesk");
		$elem->setAttribs("readonly",true);
		$this->addElement($elem);
	}
}
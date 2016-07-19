<?php
/**
 * Upload formulář
 * 10.2.2012
 * */
class Application_Form_FileUpload extends G_Form
{

	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setEnctype("multipart/form-data");
		$this->setClass("standard_form");

		$elem = new G_Form_Element_File("file");
		$elem->setAttribs(array("id"=>"file"));
		//,"required"=>true
		//$elem->setAttribs('style','width:35px;text-align:left');
		$value = $this->getPost("file", "");
		$elem->setAttribs('value',$value);
		$elem->setAttribs('size','45');
		$elem->setAttribs('label','Soubor:');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("popis");
		$value = $this->getPost("popis", "");
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('size','45');
		$elem->setAttribs('label','Popis:');
		$this->addElement($elem);

		$elem = new G_Form_Element_Submit("upload_file");
		$elem->setAttribs('value','Nahraj');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','&nbsp;');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
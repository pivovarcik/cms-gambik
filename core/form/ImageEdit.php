<?php
require_once("FileForm.php");
class Application_Form_ImageEdit extends FileForm {


	public $submitButtonName = "ins_nextid";
	public $submitButtonTitle = "Ulož";

	public function __construct()
	{
		$model = "models_FotoGallery";
		parent::__construct($model);
		$this->init();
	}


	public function init()
	{
		$page_id = (int) $this->Request->getQuery("id",false);
		parent::loadPage($page_id);
		parent::loadElements();
	/*	$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"ImageEdit");
		$elem->setAnonymous();
		$this->addElement($elem);*/
/*
		$name = "description";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name,$this->page->$name);
		$elem->setAttribs('value',$value);
	//	$elem->setAnonymous();
		$this->addElement($elem);
		*/

		$this->formName = "Editace obrázku ".$this->page->file."";
	}

}

?>
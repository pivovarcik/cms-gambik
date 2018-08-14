<?php



	require_once("FileForm.php");
class F_FileEdit extends FileForm {


	public $submitButtonName = "ins_nextid";
	public $submitButtonTitle = "Ulož";

	public function __construct()
	{
		$model = "models_Files";
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

		$this->formName = "Editace souboru ".$this->page->file."";
	}

}

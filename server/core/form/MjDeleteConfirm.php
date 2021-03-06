<?php

require_once("DeleteConfirmForm.php");
class CiselnikDeleteConfirm  extends DeleteConfirmForm {

	public $submitButtonTitle = "Smazat";
	public $modelName = "Mj";
	public $formName = "";

	function __construct($modelName)
	{
		$this->modelName = $modelName;
		parent::__construct($this->modelName);
		$this->init();
	}

	public function init()
	{
		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"delete" . $this->modelName);
		$elem->setAnonymous();
		$this->addElement($elem);

		$this->formName = "Smazat záznam ".$this->page->name." ?";

		//	$this->formName = "Smazat povoleného středisko ".$this->page->stredisko." uživatele ".$this->page->nick." ?";
	}

}
<?php

require_once("DeleteConfirmForm.php");
class F_ImageDeleteConfirm extends DeleteConfirmForm {

	public $submitButtonTitle = "Smazat";
	public $formName = "Opravdu smazat fotku?";

	function __construct()
	{

		parent::__construct("FotoGallery");
		$this->init();
	}

	public function init()
	{
		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"ImageDelete");
		$elem->setAnonymous();
		$this->addElement($elem);

		$name = "delete";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, 1);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Úlpné odstranění');
		$this->addElement($elem);


		$this->formName = "Smazat obrázek ".$this->page->file." ?";
	}

}
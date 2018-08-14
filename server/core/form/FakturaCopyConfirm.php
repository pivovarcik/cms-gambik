<?php



require_once("CopyConfirmForm.php");
class F_FakturaCopyConfirm extends CopyConfirmForm {

	public $submitButtonTitle = "Kopírovat";
	public $formName = "Opravdu kopírovat fakturu?";

	function __construct()
	{

		parent::__construct("Faktura");
		$this->init();
	}

	public function init()
	{
		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"FakturaCopy");
		$elem->setAnonymous();
		$this->addElement($elem);


		$this->formName = "Kopírovat fakturu č. ".$this->page->code." ?";
	}

}
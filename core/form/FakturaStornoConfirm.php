<?php



	require_once("ConfirmForm.php");
class Application_Form_FakturaStornoConfirm extends ConfirmForm {

	public $submitButtonTitle = "Stornovat";
	public $formName = "Opravdu stornovat fakturu?";

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
		$elem->setAttribs('value',"FakturaStorno");
		$elem->setAnonymous();
		$this->addElement($elem);


		$this->formName = "Stornovat fakturu č. ".$this->page->code." ?";
	}

}
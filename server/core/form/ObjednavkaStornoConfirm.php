<?php



require_once("ConfirmForm.php");
class F_ObjednavkaStornoConfirm extends ConfirmForm {

	public $submitButtonTitle = "Stornovat";
	public $formName = "Opravdu stornovat objednávku?";

	function __construct()
	{

		parent::__construct("Orders");
		$this->init();
	}

	public function init()
	{
		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"ObjednavkaStorno");
		$elem->setAnonymous();
		$this->addElement($elem);


		$this->formName = "Stornovat objednávku č. ".$this->page->code." ?";
	}

}
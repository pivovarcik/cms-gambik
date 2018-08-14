<?php


require_once("CopyConfirmForm.php");
class F_NewsletterCopyConfirm extends CopyConfirmForm {

	public $submitButtonTitle = "Kopírovat";
	public $formName = "Opravdu kopírovat newsletter?";

	function __construct()
	{

		parent::__construct("Newsletter");
		$this->init();
	}

	public function init()
	{
		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"NewsletterCopy");
		$elem->setAnonymous();
		$this->addElement($elem);


	//	$this->formName = "Kopírovat objednávku č. ".$this->page->code." ?";
	}

}
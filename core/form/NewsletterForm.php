<?php

require_once(PATH_ROOT . "core/form/CiselnikForm.php");
abstract class NewsletterForm extends CiselnikForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct("models_Newsletter");

	}
	public function loadElements()
	{
		parent::loadElements();


		$page = $this->page;


		$name = "html";
		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','HTML:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

	}
}


?>
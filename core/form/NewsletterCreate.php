<?php



	require_once("NewsletterForm.php");
class Application_Form_NewsletterCreate extends NewsletterForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct();
		$this->init();
	}
	public function init()
	{
		parent::loadElements();

		$elem = new G_Form_Element_Submit("ins_cat");
		$elem->setAttribs(array("id"=>"ins_cat"));
		$elem->setAttribs('value','Přidej');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}

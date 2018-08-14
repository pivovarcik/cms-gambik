<?php



	require_once("NewsletterForm.php");
class F_NewsletterCreate extends NewsletterForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct();
		$this->init();
	}
	public function init()
	{
		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);
		$this->loadElements();

		$elem = new G_Form_Element_Submit("ins_cat");
		$elem->setAttribs(array("id"=>"ins_cat"));
		$elem->setAttribs('value','Přidej');
		$elem->setAttribs('class','btn btn-primary');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
    
    
    		$name = "action";
		$elem = new G_Form_Element_Hidden($name);

		$elem->setAttribs('value',"send_news");

		$this->addElement($elem);
    
	}
}

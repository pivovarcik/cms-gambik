<?php

require_once("NewsletterForm.php");
class F_NewsletterEdit extends NewsletterForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct();
		$this->init();
	}
	public function init()
	{
		$id = (int) $this->Request->getQuery("id",null);
		$this->loadPage($id);
		parent::loadElements();
		$elem = new G_Form_Element_Submit("upd_cat");
		$elem->setAttribs(array("id"=>"upd_cat"));
		$elem->setAttribs('value','Ulož');
		$elem->setAttribs('class','btn btn-primary');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
    
    
		$elem = new G_Form_Element_Submit("send_newsletter");
		$elem->setAttribs(array("id"=>"send_newsletter"));
		$elem->setAttribs('value','Odeslat newsletter');
		$elem->setAttribs('class','btn btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
    
	}
}
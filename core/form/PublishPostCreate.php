<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("PublishPostForm.php");
class Application_Form_PublishPostCreate extends PublishPostForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct();
		$this->init();
	}
	public function init()
	{
		$this->loadPage($id);
		$this->loadElements();

		$elem = new G_Form_Element_Button("ins_post");
		$elem->setAttribs(array("id"=>"ins_post"));
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);


	}
}
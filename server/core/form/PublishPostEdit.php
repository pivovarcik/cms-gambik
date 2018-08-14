<?php
/**
 * Třída pro přidání nového hitu
 * */

require_once("PublishPostForm.php");
class F_PublishPostEdit extends PublishPostForm
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

		$elem = new G_Form_Element_Button("upd_post");
		$elem->setAttribs(array("id"=>"upd_post"));
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

	}
}
<?php
require_once("AdminUserForm.php");

class Application_Form_AdminUserEdit extends AdminUserForm
{
	private $page;
	function __construct()
	{
		parent::__construct();
		$this->init();
	}

	public function init()
	{
		parent::init();
		$elem = new G_Form_Element_Button("edit_user");
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
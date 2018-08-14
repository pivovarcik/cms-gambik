<?php
require_once("AdminRoleForm.php");

class F_AdminRoleEdit extends AdminRoleForm
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
		$elem = new G_Form_Element_Button("upd_role");
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
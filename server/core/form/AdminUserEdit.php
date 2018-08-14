<?php
require_once("AdminUserForm.php");

class F_AdminUserEdit extends AdminUserForm
{
	public $formName = "Editace uživatele";

	public $submitButtonName = "ins_nextid";
	public $submitButtonTitle = "Ulož";
	function __construct()
	{
		parent::__construct();
		$this->init();
	}

	public function init()
	{
		parent::init();

		if (!empty($this->page->nick)) {
			$this->formName =  "Editace uživatele " . $this->page->nick . ", #"  . $this->page->id;
		} else {
			$this->formName .=  "Založení nového uživatele";
		}

		$elem = new G_Form_Element_Button("edit_user");
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"UserEdit");
		$elem->setAnonymous();
		$this->addElement($elem);
	}
}
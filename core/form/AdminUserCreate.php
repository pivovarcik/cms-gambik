<?php
require_once("AdminUserForm.php");

class Application_Form_AdminUserCreate extends AdminUserForm
{
	public $formName = "Nový uživatel";

	public $submitButtonName = "ins_nextid";
	public $submitButtonTitle = "Ulož";

	private $page;
	function __construct()
	{
		parent::__construct();
		$this->init();
	}

	public function init()
	{
		parent::init();

		$name = "nick";
		$elem = $this->getElement($name);
		$value = $this->getPost($name, "");
		$elem->setAttribs('value',$value);
		$elem->setAttribs("required",true);

		$name = "newpassword";
		$elem = $this->getElement($name);
		$elem->setAttribs("required",true);


		$elem = new G_Form_Element_Button("add_user");
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"UserCreate");
		$elem->setAnonymous();
		$this->addElement($elem);

	}
}
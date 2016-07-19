<?php
abstract class MailForm extends G_Form
{
	protected $page;
	protected $page_id;
	protected $pageModel;

	protected $userList = array();
	function __construct()
	{
		$this->setStyle(BootstrapForm::getStyle());
		parent::__construct();
		$this->loadModel("models_Mailing");
		//$this->init();
	}

	public function loadModel($model)
	{
		$this->pageModel = new $model;
	}

	public function loadPage($page_id = null)
	{
		if ($page_id == null) {
			$this->page = new MailEntity();
		} else {
			$this->page = $this->pageModel->getDetailById($page_id);
			$this->page_id = $page_id;
		}

		$user = new models_User();

		$userArgs = new ListArgs();
		$userArgs->orderBy = "t1.email ASC";
		$userArgs->limit = 10000;
		$this->userList = $user->getList($userArgs);

	}

	public function init()
	{

		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);
		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}

		$page = $this->page;


		$name="adresat_id";
		$nameAlias="email";
		$elem = new G_Form_Element_Picker($name);

		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);

		$valueAlias = $this->getPost($nameAlias, $page->$nameAlias);
		$elem->setAttribs('value-alias',$valueAlias);


		//	$elem->setAttribs("class","combobox");
		$elem->setAttribs('label','Adresát');
		$elem->setAttribs('data-picker','UserEmailPicker');
	//	$elem->setAttribs('data-col',$nameAlias);
	//	$elem->setAttribs('data-id',$nameAlias);
		$this->addElement($elem);

		/*
		$name = "adresat_id";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $this->Request->getQuery($name, ""));
		$elem->setAttribs('value',$value);

		$elem->setAttribs('class','form-control');
		$elem->setAttribs('label','To:');
		$pole = array();
		$pole[0] = " -- adresát -- ";
		$attrib = array();
		foreach ($this->userList as $key => $value)
		{
			if ($value->id != USER_ID && isEmail($value->email)) {
				$pole[$value->email] = $value->email;
				//$value->nick . " " .
			}

		}
		if (count($pole) == 2) {
			$elem->setAttribs('value',$this->userList[(count($this->userList)-1)]->id);
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

*/
		// Perex
		$name = "subject";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','form-control');
		$elem->setAttribs('label','Předmět:');
		$this->addElement($elem);

		// Perex
		$name = "description";
		$elem = new G_Form_Element_Textarea($name);
		//$elem->setAttribs(array("id"=>"perex_$val","required"=>true));
		//$elem->setAttribs('style','width:300px;font-weight:bold;');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Mes.:');
		$elem->setAttribs('class','form-control');
		$this->addElement($elem);


	}
}

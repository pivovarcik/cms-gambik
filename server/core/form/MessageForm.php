<?php
abstract class MessageForm extends G_Form
{
	protected $page;
	protected $page_id;
	protected $pageModel;

	protected $userList = array();
	function __construct()
	{
		$this->setStyle(BootstrapForm::getStyle());
		parent::__construct();
		$this->loadModel("models_Message");
		//$this->init();
	}

	public function loadModel($model)
	{
		$this->pageModel = new $model;
	}

	public function loadPage($page_id = null)
	{
		if ($page_id == null) {
			$this->page = new MessageEntity();
		} else {
			$this->page = $this->pageModel->getDetailById($page_id);
			$this->page_id = $page_id;
		}
/*
		$user = new models_User();

		$userArgs = new ListArgs();
		$userArgs->orderBy = "t1.email ASC";
		$userArgs->limit = 10000;
		$this->userList = $user->getList($userArgs);
		*/

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
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs('class','form-control');
		$pole = array();
		$pole[] = "";
		$attrib = array();
		$elem->setAttribs('label','Adresát');
		$elem->setAttribs('data-picker','UserNickNamePicker');
		$elem->setAttribs("class","combobox");
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$name = "message";
		$elem = new G_Form_Element_Textarea($name);
		//$elem->setAttribs(array("id"=>"perex_$val","required"=>true));
		//$elem->setAttribs('style','width:300px;font-weight:bold;');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Zpráva');
		$elem->setAttribs('class','form-control');
		$this->addElement($elem);


	}
}

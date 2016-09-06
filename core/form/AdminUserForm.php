<?php
/**
 * Třída pro přidání nového hitu
 * */
class AdminUserForm extends G_Form
{
	private $page;
	private $page_id;
	function __construct()
	{
		parent::__construct();
		$this->loadModel("models_Users");
	//	$this->setStyle(BootstrapForm::getStyle());
		//$this->init();
	}

	public function loadModel($model)
	{
		$this->pageModel = new $model;
	}
	// načte datový model
	public function loadPage($page_id = null)
	{
		if ($page_id == null) {
			$this->page = new UserEntity();
		} else {
			$this->page = $this->pageModel->getUserById($page_id);
			$this->page_id = $page_id;
		}

	}

	public function init()
	{

		$translator = G_Translator::instance();
		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);

		$userDetail = $this->page;
		//	print_r($this->page);
		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}

		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");


		$rolesController = new models_Roles();
		$rolesList = $rolesController->getList();


		$name = "nick";
		$elem = new G_Form_Element_Text($name);
		//$value = $this->getPost("nick", "");
		$elem->setAttribs('value',$userDetail->$name);
		$elem->setAttribs("class","form-control");

		//$elem->setAttribs("disabled","disabled");
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "newpassword";
		$elem = new G_Form_Element_Password($name);
		//$value = $this->getPost("newpassword", "");
		$elem->setAttribs('value',"");
		$elem->setAttribs('label','Nové heslo:');
		$elem->setAttribs("class","form-control");
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$elem->setAttribs('autocomplete','off');
		$this->addElement($elem);

		$name = "titul";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs("class","form-control");
		$value = $this->getPost($name, $userDetail->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "jmeno";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $userDetail->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs("class","form-control");
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "prijmeni";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $userDetail->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs("class","form-control");
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "email";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $userDetail->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$elem->setAttribs("required",true);
		$elem->setAttribs("is_email",true);
		$elem->setAttribs("class","form-control");
		$this->addElement($elem);

		$name = "telefon";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $userDetail->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs("class","form-control");
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "mobil";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $userDetail->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs("class","form-control");
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "maska";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $userDetail->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs("class","form-control");
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);


		$name = "sex";
		$elem = new G_Form_Element_Select($name);
		$value = $this->getPost($name, $userDetail->$name);
		$elem->setAttribs("class","form-control");
		$elem->setAttribs('value',$value);

		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');

		$sexList = array("1"=>$translator->prelozitFrazy("male"), "2" => $translator->prelozitFrazy("female"));
		$pole = array();
		$attrib =array();
		foreach ($sexList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);




		$name = "role";
		$elem = new G_Form_Element_Select($name);
		$value = $this->getPost($name, $userDetail->$name);
		$elem->setAttribs("class","form-control");
		$elem->setAttribs('value',$value);

		// správce nelze zrušit u admina
		if ($id == 2) {
			//$elem->setAttribs("disabled","disabled");
		}
		$elem->setAttribs("required",true);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		//$elemUmisteni->setAttribs('style','width:100px;');

		$pole = array();
		$attrib =array();
		//$pole[0] = " -- bez umístění -- ";
		foreach ($rolesList as $key => $value)
		{
			$pole[$value->id] = $value->title;
			//$attrib[$value->uid]["class"] = "vnoreni" . $value->vnoreni;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);

		$name = "aktivni";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $userDetail->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "newsletter";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $userDetail->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "p1";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $userDetail->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "p2";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $userDetail->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "p3";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $userDetail->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "p4";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $userDetail->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "p5";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $userDetail->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "p6";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $userDetail->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "p7";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $userDetail->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "p8";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $userDetail->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "p9";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $userDetail->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "p10";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $userDetail->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);
	}
}
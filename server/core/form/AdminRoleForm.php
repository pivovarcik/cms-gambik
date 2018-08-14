<?php
/**
 * Třída pro přidání nového hitu
 * */
class AdminRoleForm extends G_Form
{
	private $page;
	function __construct()
	{
		parent::__construct();
		$this->loadModel("models_Roles");
		$this->init();
	}


	public function loadModel($model)
	{
		$this->pageModel = new $model;
	}
	// načte datový model
	public function loadPage($page_id = null)
	{
		if ($page_id == null) {
			$this->page = new stdClass();
		} else {
			$this->page = $this->pageModel->getDetailById($page_id);
			$this->page_id = $page_id;
		}

	}
	public function init()
	{
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$translator = G_Translator::instance();
		$id = (int) $this->Request->getQuery("id",false);
		$this->loadPage($id);

		$page = $this->page;
		//	print_r($this->page);
		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}

		$name="title";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		//$elem->setAttribs("disabled","disabled");
		$elem->setAttribs('label','Název role:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "p1";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);


		$name = "p2";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name = "p3";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);


		$name = "p4";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name="p5";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name="p6";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name="p7";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name="p8";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name="p9";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$name="p10";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('value',1);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$this->addElement($elem);

		$elem = new G_Form_Element_Submit("upd_role");
		$elem->setAttribs('value','Ulož');
		$elem->setAttribs('class','tlac');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);
	}
}
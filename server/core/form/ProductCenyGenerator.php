<?php
class F_ProductCenyGenerator extends G_Form
{

	public $pageModel;
	public $page;
	public $page_id;

	public $languageModel;
	public $languageList;

	public $cenikList = array();
	public $vyrobceList = array();
	public $skupinaList = array();

	function __construct()
	{
		parent::__construct();
		$this->loadPage();
		//$this->loadElements();
		$this->init();
	}

	// načte datový model
	public function loadPage()
	{

		$this->page = new stdClass();
		$this->page->platnost_od = date("j.n.Y");
		$this->page->cenik_id = null;
		$this->page->skupina_id = null;
		$this->page->vyrobce_id = null;
		$this->page->platnost_od = null;
		$this->page->platnost_do = null;

		$this->page->cenik_cena = null;
		$this->page->sleva = null;
		$this->page->typ_slevy = null;

		$args = new ListArgs();
		$args->limit = 10000;
		$dph_model = new models_ProductCenik();
		$this->cenikList = $dph_model->getList($args);

		$dph_model = new models_ProductCategory();
		$this->skupinaList = $dph_model->getList($args);

		$dph_model = new models_ProductVyrobce();
		$this->vyrobceList = $dph_model->getList($args);


	}
	// načte datový model
	public function init()
	{


		$set = $this->page;


		$name = "platnost_od";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Platnost ceny od:');
		$elem->setAttribs('class','datepicker');
		$this->addElement($elem);

		$name = "platnost_do";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Platnost ceny do:');
		$elem->setAttribs('class','datepicker');
		$this->addElement($elem);


		$name = "cenik_cena";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Cena:');
		$elem->setAttribs('is_numeric',true);
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "sleva";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Sleva:');
		$elem->setAttribs('is_numeric',true);
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);



		$druhSlevyList = array("%","");
		$name = "typ_slevy";
		$elem = new G_Form_Element_Select($name);
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox small_size');
		$elem->setAttribs('label','Typ slevy:');
		$pole = array();

		$attrib = array();
		foreach ($druhSlevyList as $key => $value)
		{
			$pole[$value] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$druhSlevyList = array("in"=>"Mají","not in" => "Nemají");
		$name = "skupina";
		$elem = new G_Form_Element_Select($name);
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox small_size');
	//	$elem->setAttribs('label','Typ slevy:');
		$pole = array();

		$attrib = array();
		foreach ($druhSlevyList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		$druhSlevyList = array("in"=>"Mají","not in" => "Nemají");
		$name = "vyrobce";
		$elem = new G_Form_Element_Select($name);
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox small_size');
		//	$elem->setAttribs('label','Typ slevy:');
		$pole = array();

		$attrib = array();
		foreach ($druhSlevyList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);
		$name = "cenik_id";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Kód ceny:');
		$pole = array();

		$attrib = array();
		foreach ($this->cenikList as $key => $value)
		{
			$pole[$value->id] = $value->name;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

/*
		$name = "vyrobce_id";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Pro vybranou značku:');
		$pole = array();
		$pole[0] = " všechny ";
		$attrib = array();
		foreach ($this->vyrobceList as $key => $value)
		{
			$pole[$value->id] = $value->name;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		*/
		foreach ($this->vyrobceList as $index => $value)
		{
			$name = "vyrobce_id[]";
			$elem = new G_Form_Element_Checkbox($name);
			$elem->setDecoration();
			$value2 = $this->getPost($name, $value->id);
			$elem->setAttribs('value', $value2);
			$elem->setAttribs('label',$value->name);
			$this->addElement($elem);
		}


		foreach ($this->vyrobceList as $index => $value)
		{
			$name = "not_vyrobce_id[]";
			$elem = new G_Form_Element_Checkbox($name);
			$elem->setDecoration();
			$value2 = $this->getPost($name, $value->id);
			$elem->setAttribs('value', $value2);
			$elem->setAttribs('label',$value->name);
			$this->addElement($elem);
		}


/*
		$name = "skupina_id";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $this->page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Pro vybranou skupinu:');
		$pole = array();
		$pole[0] = " všechny ";
		$attrib = array();
		foreach ($this->skupinaList as $key => $value)
		{
			$pole[$value->id] = $value->name;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		*/



		foreach ($this->skupinaList as $index => $value)
		{
			$name = "skupina_id[]";
			$elem = new G_Form_Element_Checkbox($name);
			$elem->setDecoration();
			$value2 = $this->getPost($name, $value->id);
			$elem->setAttribs('value', $value2);
			$elem->setAttribs('label',$value->name);
			$this->addElement($elem);
		}



		foreach ($this->skupinaList as $index => $value)
		{
			$name = "not_skupina_id[]";
			$elem = new G_Form_Element_Checkbox($name);
			$elem->setDecoration();
			$value2 = $this->getPost($name, $value->id);
			$elem->setAttribs('value', $value2);
			$elem->setAttribs('label',$value->name);
			$this->addElement($elem);
		}



		$elem = new G_Form_Element_Button("generator");
		$elem->setAttribs(array("id"=>"ins"));
		$elem->setAttribs('value','Generuj ceny');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

	}
}
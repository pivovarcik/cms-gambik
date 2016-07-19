<?php
/**
 * Společný předek pro formuláře typu Číselník s jazykovými verzemi
 * */
abstract class CiselnikVersionForm extends G_Form
{

	public $pageModel;
	public $page;
	public $page_id;

	public $languageModel;
	public $languageList = array();

	function __construct($model)
	{
		parent::__construct();
		$this->loadModel($model);
	}
	// načte datový model
	public function loadModel($model)
	{
		$this->pageModel = new $model;

		$this->languageModel = new models_Language();
		$this->languageList = $this->languageModel->getActiveLanguage();

	}
	// načte datový model
	public function loadPage($page_id = null)
	{

		if ($page_id == null) {
			$this->page = new stdClass();

		} else {
			$this->page = $this->pageModel->getDetailById($page_id);
			//print_r($this->page);
			$this->page_id = $page_id;
		}

	}
	// načte datový model
	protected function loadElements()
	{
		$page = $this->page;

		$name = "order";
		$elem = new G_Form_Element_Number($name);
		$elem->setAttribs(array("id"=>$name));
		//$elem->setAttribs(array("is_money"=>true));
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Pořadí:');
		$elem->setAttribs(array("is_numeric"=>true));
		$elem->setAttribs('style','width:100px;text-align:right;');
		$this->addElement($elem);


		foreach ($this->languageList as $key => $val)
		{
			// Title
			$name = "name_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			//	$elem->setAttribs('style','width:300px;font-weight:bold;');
			$value = $this->getPost($name, $page->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('style','width:300px;font-weight:bold;');
			$elem->setAttribs('label','Název ('.$val->code.'):');
			$this->addElement($elem);

			// Title
			$name = "description_$val->code";
			$elem = new G_Form_Element_Textarea($name);
			$elem->setAttribs(array("id"=>$name));
			//	$elem->setAttribs('style','width:300px;font-weight:bold;');
			$value = $this->getPost($name, $page->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textarea');
			$elem->setAttribs('label','Popis ('.$val->code.'):');
			$this->addElement($elem);

		}



		// Akce
		$elem = new G_Form_Element_Hidden("action",true);
		$elem->setAnonymous();
		$elem->setAttribs('value',str_replace("Application_Form_", "" ,get_class($this) ));
		$this->addElement($elem);


		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}
	}
}
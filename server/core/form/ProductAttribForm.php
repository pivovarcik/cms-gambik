<?php



/**
 * Třída pro přidání nového hitu
 * */
//require_once("CiselnikForm.php");
/*require_once(PATH_ROOT . "core/form/CiselnikForm.php");
class MJForm extends CiselnikForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct("models_Mj");

	}
	public function loadElements()
	{
		parent::loadElements();


		$page = $this->page;
	}
}
   */

class ProductAttribForm extends G_Form
{

	public $pageModel;
	public $page;
	public $page_id; // primární klíč page záznamu

	public $languageModel;
	public $languageList = array();


	function __construct()
	{
		parent::__construct();
    $this->setStyle(BootstrapForm::getStyle());
		$this->loadModel("models_ProductAttributes");

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
			$this->page_id = $page_id;
		}

	}
	// načte datový model
	public function loadElements()
	{
	//	parent::loadElements();
		//print "PageForm()";
		//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$page = $this->page;
    
   /* 		$elem = new G_Form_Element_Text("name");
		$elem->setAttribs(array(
						"id"=>"name",
						"required"=>true
						));
		$value = $this->getPost("name", $page->name);
		$elem->setAttribs('label','Název:');
		$elem->setAttribs('style','font-weight:bold;');
		$elem->setAttribs('value',$value);
		$this->addElement($elem);





		//$paramName = $elemParamName->render();

		$elem = new G_Form_Element_Textarea("description");
		$elem->setAttribs(array("id"=>"description"));
			$elem->setAttribs('class','textarea');
		$value = $this->getPost("description", $page->description);
		$elem->setAttribs('value',	$value);
		$elem->setAttribs('label','Popis:');
		$this->addElement($elem);  */
/*
		// keyword
		$name = "keyword";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$elem->setAttribs('style','font-weight:bold;');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','form-control');
	//	$this->addElement($elem);
		$this->addElement($elem);
             */
		foreach ($this->languageList as $key => $val)
		{
			// Title
			$name = "name_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
		//	$elem->setAttribs('style','width:300px;font-weight:bold;');
			$value = $this->getPost($name, $page->$name);
			$elem->setAttribs('value',$value);
		//	$elem->setAttribs('class','form-control');
			$elem->setAttribs('label','Název ('.$val->code.'):');
			$this->addElement($elem);
      
       $name = "description_$val->code";
      $elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs(array("id"=>$name));
			$elem->setAttribs('class','textarea');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',	$value);
		$elem->setAttribs('label','Popis ('.$val->code.'):');
		$this->addElement($elem);
    

		}


		// Akce
		$elem = new G_Form_Element_Hidden("action",true);
		$elem->setAnonymous();
		$elem->setAttribs('value',str_replace("F_", "" ,get_class($this) ));
		$this->addElement($elem);

		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}
	}
}
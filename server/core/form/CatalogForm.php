<?php
/**
 * Společný předek pro formuláře typu Katalog
 * */

require_once(PATH_ROOT2 . "core/form/PageForm.php");
abstract class CatalogForm extends PageForm
{


	public $userController;
	public $usersList = array();

	function __construct($model)
	{
		parent::__construct($model);
	//	$this->category_root = 0;
		$this->loadModel($model);
	}
	// načte datový model
	public function loadModel($model)
	{
		parent::loadModel($model);
		//$this->pageModel = new $model;

		$this->userController = new UserController();
	/*	$this->usersList = $this->userController->usersList(array(
									"parent"=>0,
									"debug"=>0,
									"limit" => 1000,
									));
		*/
		$model = new models_User();

		$args = new ListArgs();
		$args->limit = 1000;
		$this->usersList = $model->getList($args);
	}
	// načte datový model
	public function loadPage($page_id = null)
	{
		parent::loadPage($page_id);
	}
	// načte datový model
	public function loadElements()
	{
		//print "CatalogPage()";
		parent::loadElements();
		//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$catalog = $this->page;

		//print_r($catalog);

		$page_id = 0;
		if ($this->page_id) {
			$page_id = $this->page_id;
		}

		$name = "status_id";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $catalog->$name);
		$elem->setAttribs('label','Aktivní');
		$elem->setAttribs('value',1);
		if ($value == 1) {
			//$elem->setAttribs('checked','checked');
			$elem->checked();
		}
		//$elem->setAttribs('label','');
		$this->addElement($elem);


		$elem = new G_Form_Element_Select("vlastnik_id");
		$elem->setAttribs(array("id"=>"vlastnik_id"));
		$value = $this->getPost("vlastnik_id", $catalog->vlastnik_id);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox');
		$elem->setAttribs('label','Vlastník:');
		$pole = array();
		$pole[0] = " -- neuveden -- ";
		$attrib = array();
		foreach ($this->usersList as $key => $value)
		{
			$pole[$value->id] = $value->nick . " (" . $value->email . ")";
		}

		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);



		$name = "foto_id";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs('value', $catalog->$name);
		$elem->setIgnore(true);
		$this->addElement($elem);

		$name = "logo_id";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs('value', $catalog->$name);
		$elem->setIgnore(true);
		$this->addElement($elem);



		// Description
		$name = "interni_poznamka";
		$elem = new G_Form_Element_Textarea($name);
		$value = $this->getPost($name, htmlentities($page->$name, ENT_COMPAT, 'UTF-8'));
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','textarea');
		$elem->setAttribs('cols','55');
		$elem->setAttribs('rows','6');
				$elem->setAttribs('label','Interní:');
		$this->addElement($elem);



		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}
	}
}
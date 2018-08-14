<?php
/**
 * Společný předek pro formuláře typu Page
 * */
abstract class PageForm extends G_Form
{

	public $entityName = "";
	public $entityVersionName = "";
	public $pageModel;
	public $page;
	public $page_id; // primární klíč page záznamu

	public $category_root = 0; // defaultně vše i neveřejné složky
	public $ignore_category = array(); // vyjmnované klíče ignorovaných kategorii

	protected $accessUsersAssoc = array();
	public $languageModel;
	public $languageList = array();

	public $categoryTreeList = array();

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
		$this->accessUsersAssoc = array();

/*
		$this->categoryTreeList = array();
	//	if ($this->category_root > 0) {
			$tree = new G_Tree();
	//	print $this->category_root . "<br />";
			$this->categoryTreeList = $tree->categoryTree(array(
						"parent"=>$this->category_root,
						"debug"=>0,
						));*/
	//	}


	}
	// načte datový model
	public function loadPage($page_id = null)
	{
		$modelAccessUsers = new models_AccessUsers();
		$params = array();
		$params["page_type"] = $this->pageModel->getTableName();
		if ($page_id == null) {
			$this->page = new stdClass();
			$params["page_id"] = 0;
			$this->page->pristup=1;
		} else {
			$this->page = $this->pageModel->getDetailById($page_id);
			$this->page_id = $page_id;



			$params["page_id"] = $this->page_id;

		}
		$this->accessUsersAssoc = $modelAccessUsers->getAssociationList($params);
		//print $modelAccessUsers->getlastQuery();
		//print_r($this->accessUsersAssoc);

	}
	// načte datový model
	public function loadElements()
	{
		//print "PageForm()";
		//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$page = $this->page;

		$selectedCategory = new stdClass();
		$selectedCategory->title = $page->nazev_category;
		$selectedCategory->id = $this->getPost("category_id", $page->category_id);
	//	$this->categoryTreeList = array();
		array_push($this->categoryTreeList, $selectedCategory);


		$name =  "category_id";
		$elem = new G_Form_Element_Select($name, $this->entityName);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $page->category_id);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Rubrika:');
		$elem->setAttribs('class','selectbox');
		$pole = array();
		$pole[0] = " -- nezařazené -- ";
		$attrib = array();
	//	print_r($this->categoryTreeList);
		foreach ($this->categoryTreeList as $key => $value)
		{

			if (!in_array($value->id, $this->ignore_category)) {
				$pole[$value->id] = $value->title;
				$vnoreni = isset($value->vnoreni) ? $value->vnoreni : "";
				$attrib[$value->id]["class"] = "vnoreni" . $vnoreni;
			}
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

	//	print_r($this->languageList);
	//	exit;
		foreach ($this->languageList as $key => $val)
		{
			// Title
			$name =  "title";
			$name2 = "title_$val->code";
			$elem = new G_Form_Element_Text($name2);
			$elem->setAttribs(array("id"=>$name2,"required"=>true));
			$elem->setAttribs('style','font-weight:bold;');
			$value = $this->getPost($name2, $page->$name2);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textbox');
			$elem->setAttribs('label','Název:');
			$this->addElement($elem);

			// Perex
			$name = "perex";
			$name2 = "perex_$val->code";
			$elem = new G_Form_Element_Textarea($name2);
			$elem->setAttribs(array("id"=>$name2,"required"=>false));
			//$elem->setAttribs('style','width:300px;font-weight:bold;');
			$value = $this->getPost($name2, $page->$name2);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','editbox');
			$elem->setAttribs('label','Perex:');
			$elem->setAttribs('cols','55');
			$elem->setAttribs('rows','3');
			$this->addElement($elem);

			// Description
			$name = "description";
			$name2 = "description_$val->code";
			$elem = new G_Form_Element_Textarea($name2);
			$value = $this->getPost($name2, htmlentities($page->$name2, ENT_COMPAT, 'UTF-8'));
			$elem->setAttribs(array("id"=>$name2));
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','editbox mceEditor tinyMce');
			$elem->setAttribs('cols','55');
			$elem->setAttribs('rows','3');
	//		$elem->setAttribs('label','Description:');
			$this->addElement($elem);

			// Keywords
			$name = "pagekeywords";
			$name2 = "pagekeywords_$val->code";
			$elem = new G_Form_Element_Textarea($name2);
			$value = $this->getPost($name2, $page->$name2);
			$elem->setAttribs(array("id"=>$name2));
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','editbox');
			$elem->setAttribs('cols','55');
			$elem->setAttribs('rows','3');
			$elem->setAttribs('label','Pagekeywords:');
			$this->addElement($elem);

			// Pagetitle
			$name = "pagetitle";
			$name2 = "pagetitle_$val->code";
			$elem = new G_Form_Element_Text($name2);
			$elem->setAttribs("id",$name2);
			$elem->setAttribs('style','font-weight:bold;');
			$value = $this->getPost($name2, $page->$name2);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textbox');
			$elem->setAttribs('label','Pagetitle:');

		//	print_r($elem);
			$this->addElement($elem);

			// Pagedescription
			$name = "pagedescription";
			$name2 = "pagedescription_$val->code";
			$elem = new G_Form_Element_Textarea($name2);
			$value = $this->getPost($name2, $page->$name2);
			$elem->setAttribs(array("id"=>$name2));
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','editbox');
			$elem->setAttribs('cols','55');
			$elem->setAttribs('rows','3');
			$elem->setAttribs('label','Pagedescription:');
			$this->addElement($elem);


			// štítky
			$name = "tags";
			$name2 = "tags_$val->code";
			$elem = new G_Form_Element_Textarea($name2);
			$value = $this->getPost($name2, $page->$name2);
			$elem->setAttribs(array("id"=>$name2));
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','editbox');
			$elem->setAttribs('cols','55');
			$elem->setAttribs('rows','3');
			$elem->setAttribs('label','Štítky:');
			$this->addElement($elem);
			// Pagetitle
			$name = "url";
			$name2 = "url_$val->code";
			$elem = new G_Form_Element_Text($name2);
			$elem->setAttribs("id",$name2);
			$elem->setAttribs('style','font-weight:bold;');
			$value = $this->getPost($name2, $page->$name2);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textbox');
			$elem->setAttribs('label','Url:');
			$this->addElement($elem);

			$name = "id";
			$elem = new G_Form_Element_Hidden($name);
			$elem->setAttribs('value',$page->$name2);
			$this->addElement($elem);


				//	print_r($this->getElement());
		}


	//	exit;
	//	print_r($this->accessUsersAssoc);
	//	exit;
		$this->ignore_category = array(7,11,12);
		foreach ($this->accessUsersAssoc as $key => $val)
		{

			//if (!in_array($val->page_id, $this->ignore_category)) {
				//$pole[$value->id] = $value->title;
				//$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;

				//	print "tudy" . $value->id;
			//	$name = "user_assoc_id[" . $key . "]";
				$name = "user_assoc_id[]";
				//	$name = "category_id[]";
				$elem= new G_Form_Element_Checkbox($name);
				//$value = $this->Request->getPost($name, false);
				//$elem->setAttribs('value',$value);

				$elem->setAttribs('value',$val->id);
				if ($val->selected == 1 || $this->getPost($name, false)) {
					$elem->setAttribs('checked','checked');
				}
				//	print "title" . $val->title;
				$elem->setAttribs('label',$val->nick);

				$this->addElement($elem);
			//}

		}


		$name = "pristup";
		//	$name = "category_id[]";
		$elem= new G_Form_Element_Checkbox($name);
		//$value = $this->Request->getPost($name, false);
		//$elem->setAttribs('value',$value);

		$elem->setAttribs('value',1);
		if ($this->getPost($name, $page->$name)) {
			$elem->setAttribs('checked','checked');
		}
		//	print "title" . $val->title;
		$elem->setAttribs('label',"Přístupný pro všechny");

		$this->addElement($elem);
		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}
	}
}
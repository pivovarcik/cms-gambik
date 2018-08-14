<?php

abstract class GdprForm extends G_Form
{

	public $formNameEdit = "GdprEdit";

	public $pageModel;
	public $page;
	public $page_id;


	function __construct()
	{
		parent::__construct();
		$this->loadModel("models_Gdpr");
	}
	// načte datový model
	public function loadModel($model)
	{
		$this->pageModel = new $model;
	}
	// načte datový model
	public function loadPage($page_id = null)
	{

		//	print "ID:" . $page_id;
		if ($page_id == null) {
			$this->page = new stdClass();
		//	$this->page->name = null;
		//	$this->page->description = null;

		} else {
			$this->page = $this->pageModel->getDetailById($page_id);
     

      
		//	print_r($this->page);
			$this->page_id = $page_id;
		}

	}


	public function loadElements()
	{



		$page = $this->page;


		//	print_r($page);

              /*
              
              		$this->_attributtes["user_id"] = array("type" => "int");
		$this->_attributtes["souhlas_text"] = array("type" => "longtext");
		$this->_attributtes["souhlas_od"] = array("type" => "datetime");
		$this->_attributtes["souhlas_do"] = array("type" => "datetime");
		$this->_attributtes["zpusob_overeni"] = array("type" => "varchar(255)");
              
              
              */
    
    $name = "email";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Email:');
 //   $elem->setAttribs('class','text-right');
//		$elem->setAttribs('is_numeric',true);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);
    
    $name = "subject";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
	//	$elem->setAttribs('class','text-right');
		$elem->setAttribs('label','Přemět souhlasu');
	//	$elem->setAttribs('is_numeric',true);
      if (is_null($page->id))
    {
      $elem->setAttribs('disabled',true);
    
    }
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);    
    
    
    $name = "souhlas_text";
		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','text-right');
		$elem->setAttribs('label','Znění souhlasu:');
	//	$elem->setAttribs('is_numeric',true);
    
    if (is_null($page->id))
    {
        $elem->setAttribs('disabled',true);
    }
     
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);   
    




		$name = "souhlas_od";
		$datum_od = !empty($page->$name) ? date("j.n.Y H:i", strtotime($page->$name)) : "";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox datepicker');
		$elem->setAttribs('label','Souhlas od:');
		//	$elem->setAttribs('is_numeric',true);
    
		$value = $this->getPost($name, $datum_od);

		if (!empty($value)) {
			$value = date("j.n.Y", strtotime($value));
		}


		$elem->setAttribs('value',$value);
		$this->addElement($elem);


		$name = "souhlas_do";
		$datum_do = !empty($page->$name) ? date("j.n.Y H:i", strtotime($page->$name)) : "";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox datepicker');
		$elem->setAttribs('label','Souhlas do:');
		//	$elem->setAttribs('is_numeric',true);
		$value = $this->getPost($name, $datum_do);

		if (!empty($value)) {
			$value = date("j.n.Y", strtotime($value));
		}

		$elem->setAttribs('value',$value);
		$this->addElement($elem);


    
    
		$druhSlevyList = array("Email","Osobní");
		$name = "zpusob_overeni";
		$elem = new G_Form_Element_Select($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox small_size');
		$elem->setAttribs('label','Způsob získání souhlasu');
		$pole = array();
		$attrib = array();
		foreach ($druhSlevyList as $key => $value)
		{
			$pole[$value] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);
    
    
    
    		// Akce
		$elem = new G_Form_Element_Hidden("action",true);
		$elem->setAnonymous();
		$elem->setAttribs('value',str_replace("F_", "" ,get_class($this) ));
		$this->addElement($elem);

	}
}
<?php

abstract class ProductVariantyForm extends G_Form
{
	public $pageModel;
	public $page;
	public $product;
	public $page_id;
	public $product_id;

	public $atributyList = array();
	public $atributyValuesList = array();
	public $productDostupnostList = array();

	public $dphList = array();

	function __construct()
	{
		parent::__construct();
		$this->setStyle(BootstrapForm::getStyle());
		$this->loadModel("models_ProductVarianty");

	}


	public function loadModel($model)
	{
		$this->pageModel = new $model;
	}
	// načte datový model
	public function loadPage($page_id = null,$product_id = null)
	{

  $eshopSettings = G_EshopSetting::instance();
		if ($page_id == null) {
			$this->page = new stdClass();
      
      $this->page->dph_id = $eshopSettings->get("SLCT_TAX");
		//	$this->page->hl_mj_id = $eshopSettings->get("SLCT_QTY");
      
		} else {
			$this->page = $this->pageModel->getDetailById($page_id);

			$this->product_id = $this->page->product_id;
			$product_id = $this->page->product_id;
			$this->page_id = $page_id;
		}

		// umožnuje načíst hodnoty z hlavního produktu
		if (!is_null($product_id)) {
			$productModel = new models_Products();
			$this->product = $productModel->getDetailById($product_id);


			if ($page_id == null) {
				$this->page->dph_id = $this->product->dph_id;
				$this->page->dostupnost_id = $this->product->dostupnost_id;
				$this->page->price = $this->product->prodcena;
				$this->page->price_sdani = $this->product->prodcena_sdph;

				$this->page->name = $this->product->title;
				$this->page->code = $this->product->cislo;
			}
			$this->product_id = (int)$product_id;
		}

		$modelAttributes = new models_Attributes();


		if ($page_id == null) {

      $args = new ListArgs();
      $args->lang =    LANG_TRANSLATOR;
			$this->atributyList = $modelAttributes->getList($args);
		} else {
			$this->atributyList = $this->pageModel->get_attribute_value_association($page_id,LANG_TRANSLATOR);
		}

		// načtení seznamů hodnot atributů
		foreach ($this->atributyList as $key => $atribut ) {


			$this->atributyValuesList[$atribut->id] = $modelAttributes->get_attributeValues($atribut->id);
		}

	//	print_r($this->atributyList);

		$tree = new G_CiselnikTree("ProductDostupnost");
		$this->productDostupnostList = $tree->categoryTree();

		$dph_model = new models_Dph();
		$this->dphList = $dph_model->getList();

	}

	// načte datový model
	public function loadElements()
	{

		//	parent::loadElements();
		$translator = G_Translator::instance();
    $eshopSettings = G_EshopSetting::instance();
		$page = $this->page;



		$page_id = 0;
		if ($this->page_id) {
			$page_id = $this->page_id;
		}

		$name = "code";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$elem->setAttribs('required',true);
		//		$elem->setAttribs('class','textbox');
		//	$elem->setAttribs('style','width:100px;font-weight:bold;');
		$this->addElement($elem);


    		$name = "qty";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$elem->setAttribs('is_numeric',true);
    $elem->setAttribs('style','text-align:right;');
		//		$elem->setAttribs('class','textbox');
		//	$elem->setAttribs('style','width:100px;font-weight:bold;');
		$this->addElement($elem);
    
    
		$name = "stav_qty";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Aktuální stav');
		$elem->setAttribs('is_numeric',true);
    $elem->setAttribs('style','text-align:right;');
		//		$elem->setAttribs('class','textbox');
		//	$elem->setAttribs('style','width:100px;font-weight:bold;');
		$this->addElement($elem);


    $name = "stav_qty_min";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Minimalní stav');
		$elem->setAttribs('is_numeric',true);
    $elem->setAttribs('style','text-align:right;');
		//		$elem->setAttribs('class','textbox');
		//	$elem->setAttribs('style','width:100px;font-weight:bold;');
		$this->addElement($elem);
    
    
    
    $name = "stav_qty_max";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Maximální stav');
		$elem->setAttribs('is_numeric',true);
    $elem->setAttribs('style','text-align:right;');
		//		$elem->setAttribs('class','textbox');
		//	$elem->setAttribs('style','width:100px;font-weight:bold;');
		$this->addElement($elem);
    
		$name = "name";
		$elem= new G_Form_Element_Textarea($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		//	$elem->setAttribs('class','editbox');
		$elem->setAttribs('required',false);
		$elem->setAttribs('placeholder','Název varianty');
		$this->addElement($elem);

		
		if ($eshopSettings->get("PRICE_TAX") == 0) {
			$name = "price";
		} else {
			$name = "price_sdani";
		}

		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $page->$name);

		$elem->setAttribs('is_money',true);

		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$elem->setAttribs('required',false);
    $elem->setAttribs('style','text-align:right;');
		$this->addElement($elem);


		$name = "dph_id";
		$elem = new G_Form_Element_Select($name);
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox small_size');
		$elem->setAttribs('onchange','prepocti_cenu2();');

		if ($eshopSettings->get("PLATCE_DPH") == "0") {
			$elem->setAttribs('disabled','disabled');
			//	$dphList = array();
		}
   
		//	print_r($dphList);
		$pole = array();
		$pole[0] = " -- ";
		$attrib = array();
		foreach ($this->dphList as $key => $value)
		{
			$pole[$value->id] = $value->name;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$name = "dostupnost_id";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Dostupnost:');
		$elem->setAttribs('class','selectbox');
		$pole = array();
		$pole[0] = "Automaticky dle stavu";
		foreach ($this->productDostupnostList as $key => $value)
		{
			//$pole[$value->id] = $value->name;
			$pole[$value->id] = $value->title;
			$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);


		$name = "order";
		$elem= new G_Form_Element_Number($name);
		$value = $this->getPost($name, $page->$name);

		$elem->setAttribs('is_int',true);

		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy($name) . ':');
		$elem->setAttribs('required',false);
		$this->addElement($elem);


		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}

	}
}
<?php
/**
 * Společný předek pro formuláře typu Katalog
 * */
require_once("PageForm.php");
class ProductForm extends PageForm
{

	public $pageModel;
	public $page;
	public $page_id;
	public $eshopSetting = array();
	public $languageModel;
	public $languageList;
	public $skupinaList = array();

	public $attributes;

	function __construct()
	{
		parent::__construct("models_Products");
		$this->setStyle(BootstrapForm::getStyle());
	}
	// načte datový model
	public function loadPage($page_id = null)
	{
		parent::loadPage($page_id);
		//	$this->languageModel = new models_Language();
		//	$this->languageList = $this->languageModel->getActiveLanguage();
		//	print "ID:" . $page_id;
		if ($this->page_id == null) {

			$this->page = new ProductEntity();
			$this->page->prodcena = "0.00";
			$this->page->bezna_cena = "0.00";
			$this->page->qty = "1";

			$this->attributes = array();
			// Prevyplnění volného čísla
			$nextIdModel = new models_NextId();
			$this->cislo = $nextIdModel->vrat_nextid(array(
				"tabulka"=>T_SHOP_PRODUCT,
				"polozka"=>"cislo",
			));

		} else {
			$attributes = new models_Attributes();
			//	$this->attributes = $attributes->get_attributeValues2($page_id);
			$this->attributes = $attributes->get_attribute_value_association2($this->page_id,LANG_TRANSLATOR);
			//print "attr";
			//print_r($this->attributes);
			//	$this->page_id = $page_id;
			$this->cislo = $this->page->cislo;
		}

    
    
		$ProductGroupAssocModel = new models_ProductGroupAssoc();

		$this->skupinaList = $ProductGroupAssocModel->getAssociationList($page_id);



		$dph_model = new models_Dph();
		$this->dphList = $dph_model->getList();



	}
	// načte datový model
	public function loadElements()
	{
		parent::loadElements();

    $elem = $this->getElement("category_id");
    $elem->setAttribs('data-picker','CategoryPicker');
    
		$elem->setAttribs('label','Umístění:');
		$elem->setAttribs('class','combobox');

		//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$product = $this->page;

		//		print_r($product);
		//		exit;
		$eshopSettings = G_EshopSetting::instance();
		if ($this->page_id == false) {
			$product->dph_id = $eshopSettings->get("SLCT_TAX");
			$product->hl_mj_id = $eshopSettings->get("SLCT_QTY");
		}

		//$attributes = array();






		$params = new ListArgs();
		$params->limit = 1000;
		$params->lang = LANG_TRANSLATOR;
		//	print_r($dphList);
		$mj_model = new models_Mj();
		$mjList = $mj_model->getList($params);
		//$dphList = array();
		//	$productCategoryModel = new models_ProductCategory();
		//	$productCategoryList = $productCategoryModel->getList($params);

		$tree = new G_CiselnikTree("ProductCategory");
		$productCategoryList = $tree->categoryTree();


		//$productVyrobceModel = new models_ProductVyrobce();
		//	$productVyrobceList = $productVyrobceModel->getList($params);

		$tree = new G_CiselnikTree("ProductVyrobce");
		$productVyrobceList = $tree->categoryTree();


		//	print_r($productVyrobceList);
		$tree = new G_CiselnikTree("ProductDostupnost");
		$productDostupnostList = $tree->categoryTree();

		$tree = new G_CiselnikTree("ProductZaruka");
		$productZarukaList = $tree->categoryTree();


		/*
		   $tree = new G_CiselnikTree("ProductCenik");
		   $productCenikList = $tree->categoryTree();

		*/
		$druhSlevyList = array("%","");

		$name = "druh_slevy";
		$elem = new G_Form_Element_Select($name);
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox small_size');
		$elem->setAttribs('label','Druh slevy');
		//	$elem->setAttribs('class','form_edit small_size');
		$elem->setAttribs('onchange','prepocti_cenu2();');

		//	print_r($dphList);
		$pole = array();
		//$pole[0] = " -- neuveden -- ";
		$attrib = array();
		foreach ($druhSlevyList as $key => $value)
		{
			$pole[$value] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$name = "dph_id";
		$elem = new G_Form_Element_Select($name);
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox small_size');
		$elem->setAttribs('label','Sazba DPH');
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


		$name = "cislo";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		//	$elem->setAttribs('style','width:300px;font-weight:bold;');
		$elem->setAttribs('class','textbox');
		if ($eshopSettings->get("PRODUCT_NEXTID_AUTO") == "1") {
			$elem->setAttribs('readonly','readonly');
		}


		$value = $this->getPost($name, $this->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Katalogové číslo:');
		$this->addElement($elem);

/*
		$name = "skupina_id";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Skupina:');
		$elem->setAttribs('class','selectbox');
		$pole = array();
		$pole[0] = " -- žádná skupina -- ";
		$attrib = array();
		foreach ($productCategoryList as $key => $value)
		{
			$pole[$value->id] = $value->title;
			$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		*/

		foreach ($this->skupinaList as $key => $val)
		{

			$name = "group_id[" . $key . "]";
			$elem= new G_Form_Element_Checkbox($name);
			$elem->setAttribs('value',$val->id);
			if ($val->selected == 1 || $this->getPost($name, false)) {
				$elem->setAttribs('checked','checked');
			}
			$elem->setAttribs('label',$val->name);
			$this->addElement($elem);
		}


		$name = "vyrobce_id";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Značka:');
		$elem->setAttribs('class','selectbox');
		$pole = array();
		$pole[0] = " -- neuveden -- ";
		foreach ($productVyrobceList as $key => $value)
		{
			//$pole[$value->id] = $value->name;
			$pole[$value->id] = $value->title;
			$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		/*
		   $name = "cenik_id";
		   $elem = new G_Form_Element_Select($name);
		   $elem->setAttribs(array("id"=>$name));
		   $value = $this->getPost($name, $product->$name);
		   $elem->setAttribs('value',$value);
		   $elem->setAttribs('label','Ceník:');
		   $elem->setAttribs('class','selectbox');
		   $pole = array();
		   $pole[0] = " -- neuveden -- ";
		   foreach ($productCenikList as $key => $value)
		   {
		   //$pole[$value->id] = $value->name;
		   $pole[$value->id] = $value->title;
		   $attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
		   }
		   $elem->setMultiOptions($pole);
		   $this->addElement($elem);
		*/

		$name = "dostupnost_id";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Dostupnost:');
		$elem->setAttribs('class','selectbox');
		$pole = array();
		$pole[0] = "Automaticky dle stavu";
		foreach ($productDostupnostList as $key => $value)
		{
			//$pole[$value->id] = $value->name;
			$pole[$value->id] = $value->title;
			$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);


		$name = "zaruka_id";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Záruka:');
		$elem->setAttribs('class','selectbox');
		$pole = array();
		$pole[0] = " -- neuvedena -- ";
		foreach ($productZarukaList as $key => $value)
		{
			//$pole[$value->id] = $value->name;
			$pole[$value->id] = $value->title;
			$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);



		$elem = new G_Form_Element_Select("hl_mj");
		$elem->setAttribs(array("id"=>"hmj","required"=>true));
		$value = $this->getPost("hl_mj", $product->hl_mj_id);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Měrná jednotka');
		$elem->setAttribs('class','selectbox');
		$pole = array();
		foreach ($mjList as $key => $value)
		{
			$pole[$value->id] = $value->name;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);
		/*
		   $elem = new G_Form_Element_Select("vyrobce");
		   $elem->setAttribs(array("id"=>"vyrobce"));
		   $value = $this->getPost("vyrobce", $product->vyrobce_id);
		   $elem->setAttribs('value',$value);
		   $elem->setAttribs('label','Značka:');
		   $pole = array();
		   $pole[0] = " -- neuveden -- ";
		   foreach ($productVyrobceList as $key => $value)
		   {
		   $pole[$value->id] = $value->name;
		   }
		   $elem->setMultiOptions($pole);
		   $this->addElement($elem);
		*/

		$name = "nakupni_cena";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Nákupní cena:');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('style','text-align:right;');

		$elem->setAttribs(array("is_money"=>true));
		$this->addElement($elem);

		/*
		   if ($eshopSettings->get("PRICE_TAX") == 1) {
		   $elem->setAttribs('disabled',true);
		   $elem->setAttribs('class','textbox disabled');
		   $elem->setAttribs('style','width:100px;text-align:right;');
		   } else {

		   $elem->setAttribs('style','width:100px;text-align:right;font-weight:bold;');
		   }
		*/

       $name = "stav_qty";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Aktuální stav');
		$elem->setAttribs('is_numeric',true);
    $elem->setAttribs('style','text-align:right;');
    
   // if (!$product->$name == 1){
    if ($product->dostupnost_id > 0){
        $elem->setAttribs('disabled','disabled');
    }
		//		$elem->setAttribs('class','textbox');
		//	$elem->setAttribs('style','width:100px;font-weight:bold;');
		$this->addElement($elem);


    $name = "stav_qty_min";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Minimalní stav');
		$elem->setAttribs('is_numeric',true);
    $elem->setAttribs('style','text-align:right;');
    
   // if (!$product->$name == 1){
    if ($product->dostupnost_id > 0){
        $elem->setAttribs('disabled','disabled');
    }
    
		//		$elem->setAttribs('class','textbox');
		//	$elem->setAttribs('style','width:100px;font-weight:bold;');
		$this->addElement($elem);
    
    
    
    $name = "stav_qty_max";
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Maximální stav');
		$elem->setAttribs('is_numeric',true);
    $elem->setAttribs('style','text-align:right;');
    
   // if (!$product->$name == 1){
    if ($product->dostupnost_id > 0){
        $elem->setAttribs('disabled','disabled');
    }
		//		$elem->setAttribs('class','textbox');
		//	$elem->setAttribs('style','width:100px;font-weight:bold;');
		$this->addElement($elem);

		$name = "prodcena";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Prodejní cena:');
		$elem->setAttribs('class','textbox');

		if ($eshopSettings->get("PRICE_TAX") == 1) {
			$elem->setAttribs('disabled',true);
			$elem->setAttribs('class','textbox disabled');
			$elem->setAttribs('style','text-align:right;');
		} else {

			$elem->setAttribs('style','text-align:right;font-weight:bold;');
		}


		//	$elem->setAttribs('style','width:100px;text-align:right;');
		$elem->setAttribs(array("is_money"=>true));
		$this->addElement($elem);

		$name = "prodcena_sdph";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);






    
    

		if ($eshopSettings->get("PLATCE_DPH") == 0)
		{

			$elem->setAttribs('style','text-align:right;font-weight:bold;');
			$elem->setAttribs('label','Prodejní cena:');
		} else {

			if ($eshopSettings->get("PRICE_TAX") == 0) {
				$elem->setAttribs('disabled',true);
				$elem->setAttribs('class','textbox disabled');

				$elem->setAttribs('style','text-align:right;');
			} else {

				$elem->setAttribs('style','text-align:right;font-weight:bold;');
			}

			$elem->setAttribs('label','Prodejní cena s DPH:');
		}

		$elem->setAttribs('class','textbox');
		//$elem->setAttribs('style','width:100px;text-align:right;');
		$elem->setAttribs(array("is_money"=>true));
		$this->addElement($elem);


		$name = "bezna_cena";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		//$elem->setAttribs(array("is_money"=>true));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Běžná cena:');
		$elem->setAttribs(array("is_money"=>true));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('style','text-align:right;');
		$this->addElement($elem);

		$name ="qty";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs(array("is_numeric"=>true));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Nabízené (minimální) množství:');
		$elem->setAttribs('style','text-align:right;');
		$this->addElement($elem);

		$name ="netto";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs(array("is_numeric"=>true));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Vlastní váha (kg):');
		$elem->setAttribs('style','text-align:right;');
		$this->addElement($elem);
    
    $name ="objem";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
	//	$elem->setAttribs(array("is_numeric"=>true));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',numberFormat($value,5));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Vlastní objem (m3):');
		$elem->setAttribs('style','text-align:right;');
		$this->addElement($elem);
    
     $name ="rozmer";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
	//	$elem->setAttribs(array("is_numeric"=>true));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Rozměr v x š x d:');
		//$elem->setAttribs('style','text-align:right;');
		$this->addElement($elem);
    
		$name="sleva";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs(array("is_numeric"=>true));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Sleva:');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('style','width:100px;text-align:right;');
		$this->addElement($elem);


		$elem = new G_Form_Element_Text("code01");
		$value = $this->getPost("code01", $product->code01);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Dodavatelský kód produktu:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("code02");
		$value = $this->getPost("code02", $product->code02);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Specifikace:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);



		$elem = new G_Form_Element_Text("dostupnost");
		$value = $this->getPost("dostupnost", $product->dostupnost);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Dostupnost:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);



		$name = "aktivni";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Aktivní produkt');
		$this->addElement($elem);


		$name = "bazar";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Bazarová položka');
		$this->addElement($elem);

		$name = "sync_not";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Již neaktualizovat');
		$this->addElement($elem);
    
    
    
		$name = "neexportovat";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Nepřenášet do porovnávačů cen');
		$this->addElement($elem);


    $name = "neprodejne";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Neprodejné zboží');
		$this->addElement($elem);
       
       

		$name = "doporucujeme";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Doporučujeme');
		$this->addElement($elem);


		$name = "akce";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Akční zboží');
		$this->addElement($elem);

		$name = "novinka";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Novinka');
		$this->addElement($elem);

		// jazykové verze
		foreach ($this->languageList as $key => $val)
		{


			$name = "polozka1_$val->code";
			$elem = new G_Form_Element_Textarea($name);
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textarea');
			$elem->setAttribs('cols','55');
			$elem->setAttribs('rows','3');
			$elem->setAttribs('label',$eshopSettings->get("POLOZKA01") . ':');
			$this->addElement($elem);

			$name = "polozka2_$val->code";
			$elem = new G_Form_Element_Textarea($name);
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textarea');
			$elem->setAttribs('cols','55');
			$elem->setAttribs('rows','3');
			$elem->setAttribs('label',$eshopSettings->get("POLOZKA02") . ':');
			$this->addElement($elem);

			$name = "polozka3_$val->code";
			$elem = new G_Form_Element_Textarea($name);
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textarea');
			$elem->setAttribs('cols','55');
			$elem->setAttribs('rows','3');
			$elem->setAttribs('label',$eshopSettings->get("POLOZKA03") . ':');
			$this->addElement($elem);

			$name = "polozka4_$val->code";
			$elem = new G_Form_Element_Textarea($name);
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textarea');
			$elem->setAttribs('cols','55');
			$elem->setAttribs('rows','3');
			$elem->setAttribs('label',$eshopSettings->get("POLOZKA04") . ':');
			$this->addElement($elem);

			$name = "polozka5_$val->code";
			$elem = new G_Form_Element_Textarea($name);
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textarea');
			$elem->setAttribs('cols','55');
			$elem->setAttribs('rows','3');
			$elem->setAttribs('label',$eshopSettings->get("POLOZKA05") . ':');
			$this->addElement($elem);



			$name = "polozka6_$val->code";
			$elem = new G_Form_Element_Textarea($name);
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textarea');
			$elem->setAttribs('cols','55');
			$elem->setAttribs('rows','3');
			$elem->setAttribs('label',$eshopSettings->get("POLOZKA06") . ':');
			$this->addElement($elem);

			$name = "polozka7_$val->code";
			$elem = new G_Form_Element_Textarea($name);
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textarea');
			$elem->setAttribs('cols','55');
			$elem->setAttribs('rows','3');
			$elem->setAttribs('label',$eshopSettings->get("POLOZKA07") . ':');
			$this->addElement($elem);

			$name = "polozka8_$val->code";
			$elem = new G_Form_Element_Textarea($name);
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textarea');
			$elem->setAttribs('cols','55');
			$elem->setAttribs('rows','3');
			$elem->setAttribs('label',$eshopSettings->get("POLOZKA08") . ':');
			$this->addElement($elem);

			$name = "polozka9_$val->code";
			$elem = new G_Form_Element_Textarea($name);
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textarea');
			$elem->setAttribs('cols','55');
			$elem->setAttribs('rows','3');
			$elem->setAttribs('label',$eshopSettings->get("POLOZKA09") . ':');
			$this->addElement($elem);

			$name = "polozka10_$val->code";
			$elem = new G_Form_Element_Textarea($name);
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textarea');
			$elem->setAttribs('cols','55');
			$elem->setAttribs('rows','3');
			$elem->setAttribs('label',$eshopSettings->get("POLOZKA10") . ':');
			$this->addElement($elem);




			$name = "cislo1_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			$elem->setAttribs(array("is_numeric"=>true));
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label',$eshopSettings->get("CISLO01") . ':');
			$elem->setAttribs('style','width:100px;text-align:right;');
			$elem->setAttribs('class','textbox');
			$this->addElement($elem);

			$name = "cislo2_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			$elem->setAttribs(array("is_numeric"=>true));
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label',$eshopSettings->get("CISLO02") . ':');
			$elem->setAttribs('style','width:100px;text-align:right;');
			$elem->setAttribs('class','textbox');
			$this->addElement($elem);

			$name = "cislo3_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			$elem->setAttribs(array("is_numeric"=>true));
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label',$eshopSettings->get("CISLO03") . ':');
			$elem->setAttribs('style','width:100px;text-align:right;');
			$elem->setAttribs('class','textbox');
			$this->addElement($elem);

			$name = "cislo4_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			$elem->setAttribs(array("is_numeric"=>true));
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label',$eshopSettings->get("CISLO04") . ':');
			$elem->setAttribs('style','width:100px;text-align:right;');
			$elem->setAttribs('class','textbox');
			$this->addElement($elem);

			$name = "cislo5_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			$elem->setAttribs(array("is_numeric"=>true));
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label',$eshopSettings->get("CISLO05") . ':');
			$elem->setAttribs('style','width:100px;text-align:right;');
			$elem->setAttribs('class','textbox');
			$this->addElement($elem);



			$name = "cislo6_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			$elem->setAttribs(array("is_numeric"=>true));
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label',$eshopSettings->get("CISLO06") . ':');
			$elem->setAttribs('style','width:100px;text-align:right;');
			$elem->setAttribs('class','textbox');
			$this->addElement($elem);

			$name = "cislo7_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			$elem->setAttribs(array("is_numeric"=>true));
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label',$eshopSettings->get("CISLO07") . ':');
			$elem->setAttribs('style','width:100px;text-align:right;');
			$elem->setAttribs('class','textbox');
			$this->addElement($elem);

			$name = "cislo8_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			$elem->setAttribs(array("is_numeric"=>true));
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label',$eshopSettings->get("CISLO08") . ':');
			$elem->setAttribs('style','width:100px;text-align:right;');
			$elem->setAttribs('class','textbox');
			$this->addElement($elem);

			$name = "cislo9_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			$elem->setAttribs(array("is_numeric"=>true));
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label',$eshopSettings->get("CISLO09") . ':');
			$elem->setAttribs('style','width:100px;text-align:right;');
			$elem->setAttribs('class','textbox');
			$this->addElement($elem);

			$name = "cislo10_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			$elem->setAttribs(array("is_numeric"=>true));
			$value = $this->getPost($name, $product->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label',$eshopSettings->get("CISLO10") . ':');
			$elem->setAttribs('style','width:100px;text-align:right;');
			$elem->setAttribs('class','textbox');
			$this->addElement($elem);
		}



   $_attribs = new models_Attributes();

		// atributy

		//	print_r($this->attributes);
		if (is_array($this->attributes)) {


			foreach ($this->attributes as $key => $value){
				//print_r($value);
        
        if ($value->multi_select == 1)
        {
        
          
  				//	print $key . "<br />";
  			//	$attribList = $_attribs->get_attributeValues($value->id);
  				$attribList = $_attribs->get_attribute_multi_values($this->page_id, $value->id);
           //   print_r($attribList);
  				foreach ($attribList as $keya => $valuea)
  				{
      
      			$name = "attr[" . $value->id . "][" . $valuea->value . "]";
      			$elem= new G_Form_Element_Checkbox($name);
            
            //	$pole[$valuea->value] = $valuea->name;
              
      			$elem->setAttribs('value',$valuea->value);
      			if ($valuea->has_attribute == 1 || $this->getPost($name, false)) {
      				$elem->setAttribs('checked','checked');
      			}
      			$elem->setAttribs('label',$valuea->value_name);
      			$this->addElement($elem);
      		}
        
        } else {
        
  				//print $key;
  				$name = "attr[" . $value->id . "]";
  				$elem = new G_Form_Element_Select($name);
  				$value2 = $this->getPost($name, $value->attribute_id);
  				$elem->setAttribs('value', $value2);
  				$elem->setAttribs('class','selectbox');
  				$elem->setAttribs('label', $value->name . ':');
  				$pole = array();
  				//$pole[0] = " -- bez umístění -- ";
  				$attrib = array();
  			//	$_attribs = new models_Attributes();
  				//	print $key . "<br />";
  				$attribList = $_attribs->get_attributeValues($value->id);
  				//	print_r($attribList);
  				//	print "Klíč" . $key . ":<br />";
  				//$attribList = $_attribs->get_attribute_value_association($key);
  				/*
  				   print "<pre>";
  				   print_r($attribList);
  				   print "</pre>";
  				*/
  				foreach ($attribList as $keya => $valuea)
  				{
  					//print_r();
  					$pole[$valuea->id] = $valuea->name;
  
  					//if () {
  					//$attrib[$key]["class"] = "vnoreni" . $value["vnoreni"];
  					//}
  				}
  				//print_r($pole);
  				$elem->setMultiOptions($pole);        
			   	//	array_push($elements, $elemAttrib);
				  $this->addElement($elem);        
        }




				$name = "attrOrder[" . $value->id . "]";
				$elem = new G_Form_Element_Hidden($name);
				$elem->setAttribs('value', $value->order);
				//print_r($elem);
				$this->addElement($elem);
			}
		}
		$elem = new G_Form_Element_Hidden("foto_id");
		$elem->setAttribs('value', $product->foto_id);
		$elem->setIgnore(true);
		$this->addElement($elem);




    $name = "qty_nasobek";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Povolený odběr:');
		$elem->setAttribs('class','selectbox');
		$pole = array();
    
    $nasobekList= array(0=>"Bez omezení",1=>"Pouze v násobcích");

		foreach ($nasobekList as $key => $value)
		{
			//$pole[$value->id] = $value->name;
			$pole[$key] = $value;
		//	$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);
    


		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}
	}
}
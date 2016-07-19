<?php
/**
 * Společný předek pro formuláře typu Katalog
 * */
class Application_Form_ProductReklamaceForm extends G_Form
{

	public $pageModel;
	public $page;
	public $page_id;
	public $eshopSetting = array();
	public $languageModel;
	public $languageList;

	public $attributes;

	function __construct($model)
	{
		parent::__construct();
		$this->setStyle(BootstrapForm::getStyle());
	//	$this->loadModel($model);


		$this->loadElements();

	}
	// načte datový model
	public function loadModel($model)
	{
	//	$this->pageModel = new $model;



	}
	// načte datový model
	public function loadPage($page_id = null)
	{

		$this->languageModel = new models_Language();
		$this->languageList = $this->languageModel->getActiveLanguage();
	//	print "ID:" . $page_id;
		if ($page_id == null) {
			$this->page = new stdClass();
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
			$this->page = $this->pageModel->getDetailById($page_id);

			//print_r($this->page);

			//$attributes = $product->getAttributes();
			$attributes = new models_Attributes();
		//	$this->attributes = $attributes->get_attributeValues2($page_id);
			$this->attributes = $attributes->get_attribute_value_association2($page_id);
			//print "attr";
			//print_r($this->attributes);
			$this->page_id = $page_id;
			$this->cislo = $this->page->cislo;
		}

	}
	// načte datový model
	public function loadElements()
	{
		//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$product = $this->page;
		$eshopController = new EshopController();
		$this->eshopSetting = $eshopController->setting;




		$name = "order_code";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Číslo objednávky:');
		$value = $this->getPost($name, $this->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name = "customer_email";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Email:<span class="required">*</span>');
		$value = $this->getPost($name, $this->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name = "faktura_code";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Číslo faktury:<span class="required">*</span>');
		$value = $this->getPost($name, $this->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name = "customer_name";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Jméno/Firma objednávacího:<span class="required">*</span>');
		$value = $this->getPost($name, $this->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name = "customer_person";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Jméno reklamujícího:');
		$value = $this->getPost($name, $this->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name = "customer_phone";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Telefon:');
		$value = $this->getPost($name, $this->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);



		$name = "order_date";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Datum objednání zboží:');
		$value = $this->getPost($name, $this->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name = "transfer_date";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Datum dodání zboží:<span class="required">*</span>');
		$value = $this->getPost($name, $this->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name = "product_name";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Název zboží:<span class="required">*</span>');
		$value = $this->getPost($name, $this->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);


		$name = "priloha";
		$elem = new G_Form_Element_File($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
	//	$elem->setAttribs('class','textbox');
		$value = $this->getPost($name, $this->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);


		$name = "description";
		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Popis závady - důvod reklamace:<span class="required">*</span>');
		$value = $this->getPost($name, $this->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name = "qty";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('label','Počet reklamovaných kusů:<span class="required">*</span>');
		$value = $this->getPost($name, $this->$name);
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name = "reklamace";
		$elem = new G_Form_Element_Button($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value','Odeslat reklamační formulář');
		$elem->setAttribs('class','btn btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

	}
}
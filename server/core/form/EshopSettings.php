<?php
/**
 * Společný předek pro formuláře typu Katalog
 * */
class F_EshopSettings extends G_Form
{

	public $pageModel;
	public $page;
	public $page_id;

	public $languageModel;
	public $languageList;

	public $attributes;

	function __construct()
	{
		parent::__construct();
		$this->setStyle(BootstrapForm::getStyle());
		$this->loadPage();
		//$this->loadElements();
		$this->init();
	}

	// načte datový model
	public function loadPage()
	{

		$eshop = new EshopController();
		$eshop->getSettings();
		$this->page = $eshop->setting;




	}
	// načte datový model
	public function init()
	{

		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$set = $this->page;

		$nextid = new models_NextId();

		$listArgs = new ListArgs();
		$listArgs->limit = 1000;
		$listArgs->tabulka = T_SHOP_ORDERS;
		$nextidOrderList = $nextid->getList($listArgs);
		$listArgs->tabulka = T_FAKTURY;
		$nextidFakturyList = $nextid->getList($listArgs);
		$listArgs->tabulka = T_SHOP_PRODUCT;

		$nextidProductList = $nextid->getList($listArgs);


		$args = new ListArgs();

		$ProductCenik = new models_ProductCenik();

		$ProductCenikList = $ProductCenik->getList($args);


    		$stavObjedavkyModel = new models_OrderStatus();
		$stavObjednavkyList = $stavObjedavkyModel->getList();
    
    $name="ADD_BASKET_BEZSTAVU";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('label','Povolit objednat zboží bez stavu');
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);
    
        
    $name = "POHODA_OBJ_XML_STAV";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox');
		$elem->setAttribs('label','Pouze stav');
		$pole = array();
		$pole[0] = " -- vše -- ";
		$attrib = array();
	//	$doklad->odeslano_stav_nazev = "";

		foreach ($stavObjednavkyList as $key => $value)
		{
			$pole[$value->id] = $value->name;
      
      switch($value->id)
			{
				case 1:
					//$stav = "Čeká na schválení";
					$style_color='';
					break;
				case 2:
					$stav = "Vyexpedovaná";
					$style_color='expedice';
					break;
				case 3:
					$stav = "Vyřizuje se";
					$style_color='kvyrizeni';
					break;
				case 4:
					$stav = "Dokonceno";
					$style_color='vyrizena';
					break;
				default:
					$stav = "schvaleno_faktura";
					$style_color='';
					break;
			}
			$attrib[$value->id]["class"] = $style_color;
    
    }  
    
        
    		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);  
    
		$elem = new G_Form_Element_Text("COMPANY_NAME");
		$elem->setAttribs(array("id"=>"COMPANY_NAME"));
		$value = $this->getPost("COMPANY_NAME", $set["COMPANY_NAME"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Název firmy');
    $elem->setAttribs("id","shipping_first_name");
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name = "KONTAKT_EMAIL";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Kontaktní email');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "KONTAKT_TELEFON";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Kontaktní telefon');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$elem = new G_Form_Element_Text("ADDRESS1");
		$elem->setAttribs(array("id"=>"ADDRESS1"));
		$value = $this->getPost("ADDRESS1", $set["ADDRESS1"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Ulice, č.p.');
    $elem->setAttribs("id","shipping_address_1");
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("ADDRESS2");
		$elem->setAttribs(array("id"=>"ADDRESS2"));
		$value = $this->getPost("ADDRESS2", $set["ADDRESS2"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Část obce');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("CITY");
		$elem->setAttribs(array("id"=>"CITY"));
		$value = $this->getPost("CITY", $set["CITY"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Město');
    $elem->setAttribs("id","shipping_city");
	//	$elem->setAttribs('style','width: 250px;');
		$this->addElement($elem);



		$elem = new G_Form_Element_Text("ZIP_CODE");
		$elem->setAttribs(array("id"=>"ZIP_CODE"));
		$value = $this->getPost("ZIP_CODE", $set["ZIP_CODE"]);
		$elem->setAttribs('value',$value);
    $elem->setAttribs("id","shipping_zip_code");
		$elem->setAttribs('label','PSČ');
	//	$elem->setAttribs('style','width: 100px;');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("COUNTRY");
		$elem->setAttribs(array("id"=>"COUNTRY"));
		$value = $this->getPost("COUNTRY", $set["COUNTRY"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Země');
	//	$elem->setAttribs('style','width: 150px;');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("ICO");
		$elem->setAttribs(array("id"=>"ICO"));
		$value = $this->getPost("ICO", $set["ICO"]);
    $elem->setAttribs("id","shipping_ico");
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','IČ');
//		$elem->setAttribs('style','width: 150px;');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("DIC");
		$elem->setAttribs(array("id"=>"DIC"));
		$value = $this->getPost("DIC", $set["DIC"]);
    $elem->setAttribs("id","shipping_dic");
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','DIČ');
	//	$elem->setAttribs('style','width: 150px;');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("UCET");
		$elem->setAttribs(array("id"=>"UCET"));
		$value = $this->getPost("UCET", $set["UCET"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Bankovní účet');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("IBAN");
		$elem->setAttribs(array("id"=>"IBAN"));
		$value = $this->getPost("IBAN", $set["IBAN"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','IBAN:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("OR");
		$elem->setAttribs(array("id"=>"OR"));
		$value = $this->getPost("OR", $set["OR"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','OR:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
/*
		$elem = new G_Form_Element_Text("PLATCE_DPH");
		$elem->setAttribs(array("id"=>"PLATCE_DPH"));
		$value = $this->getPost("PLATCE_DPH", $set["PLATCE_DPH"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Plátce DPH:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
*/
		$platceDaneList = array("0"=>"Dodavatel není platcem DPH","1"=>"Dodavatel je platcem DPH",);
		$elem = new G_Form_Element_Select("PLATCE_DPH");
		$elem->setAttribs(array("id"=>"PLATCE_DPH","required"=>false));
		$value = $this->getPost("PLATCE_DPH", $set["PLATCE_DPH"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Plátce DPH:');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);



		$platceDaneList = array("0"=>"Cena bez DPH","1"=>"Cena s DPH",);
		$elem = new G_Form_Element_Select("PRICE_TAX");
		$elem->setAttribs(array("id"=>"PRICE_TAX","required"=>false));
		$value = $this->getPost("PRICE_TAX", $set["PRICE_TAX"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Hlavní cena:');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$platceDaneList = array("0"=>"1.00","1"=>"1",);
		$name = "FORMAT_QTY";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Formát množství:');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$mj_model = new models_Mj();
		$mjList = $mj_model->getList();
		$name = "SLCT_QTY";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Hlavní MJ:');
		$pole = array();

		$attrib = array();
		foreach ($mjList as $key => $value)
		{
			$pole[$value->id] = $value->name;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);





		$name = "CENIK_ID";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Ceník pro neregistrované');
		$pole = array();
		$pole[0] = "";
		$attrib = array();
		foreach ($ProductCenikList as $key => $value)
		{
			$pole[$value->id] = $value->name;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$dph_model = new models_Dph();
		$dphList = $dph_model->getList();
		$name = "SLCT_TAX";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Hlavní DPH:');
		$pole = array();

		$attrib = array();
		foreach ($dphList as $key => $value)
		{
			$pole[$value->id] = $value->name;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);



		$platceDaneList = array("0"=>"Jedno dopravné za objednávku","1"=>"Dopravné za každou pokoložku",);
		$elem = new G_Form_Element_Select("DOPRAVNE_ZA_MJ");
		$elem->setAttribs(array("id"=>"DOPRAVNE_ZA_MJ","required"=>false));
		$value = $this->getPost("DOPRAVNE_ZA_MJ", $set["DOPRAVNE_ZA_MJ"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Výpočet dopravného:');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		$platceDaneList = array("0"=>"Ne","1"=>"Ano",);
		$name = "PRODUCT_NEXTID_AUTO";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Automatické číslování produktů:');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$platceDaneList = array("0"=>"Ne","1"=>"Ano",);
		$name = "PRODUCT_VARIANTY";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Varianty produktů:');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		$tree = new G_Tree();
		$rubrikyList = $tree->categoryTree(array(
				"parent"=>0,
				"debug"=>0,
				));

	//	print_r($rubrikyList);
		$name = "CATEGORY_ROOT";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Strom eshopu:');
		$pole = array();

		$attrib = array();
		foreach ($rubrikyList as $key => $value)
		{
			$pole[$value->id] = $value->title;

			//if () {
			$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$name = "SLIDER_CATEGORY";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Slider pro kategorii:');
		$pole = array();

		$attrib = array();
		foreach ($rubrikyList as $key => $value)
		{
			$pole[$value->id] = $value->title;

			//if () {
			$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("DOPRAVNE_ZDARMA");
		$elem->setAttribs(array("id"=>"DOPRAVNE_ZDARMA"));
		$value = $this->getPost("DOPRAVNE_ZDARMA", $set["DOPRAVNE_ZDARMA"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Doprava zdarma od:');
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('style','text-align:right;width: 150px;');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("EMAIL_SMTP_SERVER");
		$elem->setAttribs(array("id"=>"EMAIL_SMTP_SERVER"));
		$value = $this->getPost("EMAIL_SMTP_SERVER", $set["EMAIL_SMTP_SERVER"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','SMTP server:');
		$elem->setAttribs('class','textbox');

		$this->addElement($elem);

		$elem = new G_Form_Element_Text("EMAIL_ORDER");
		$elem->setAttribs(array("id"=>"EMAIL_ORDER"));
		$value = $this->getPost("EMAIL_ORDER", $set["EMAIL_ORDER"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Emailová adresa:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("EMAIL_ORDER_ALIAS");
		$elem->setAttribs(array("id"=>"EMAIL_ORDER_ALIAS"));
		$value = $this->getPost("EMAIL_ORDER_ALIAS", $set["EMAIL_ORDER_ALIAS"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Alias odesílatele:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$elem = new G_Form_Element_Text("EMAIL_ORDER_SUBJECT");
		$elem->setAttribs(array("id"=>"EMAIL_ORDER_SUBJECT"));
		$value = $this->getPost("EMAIL_ORDER_SUBJECT", $set["EMAIL_ORDER_SUBJECT"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Předmět objednávky:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("LOGO_PDF");
		$elem->setAttribs(array("id"=>"LOGO_PDF"));
		$value = $this->getPost("LOGO_PDF", $set["LOGO_PDF"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Logo v objednávce:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
    
    
    $name = "LOGO_PDF_FILE";
		$elem = new G_Form_Element_File($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Nahrát logo v objednávce');

		$this->addElement($elem);
    
    $name = "RAZITKO_PDF_FILE";
		$elem = new G_Form_Element_File($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Nahrát razítko');

		$this->addElement($elem);    
    
    $name = "OP_PDF_FILE";
		$elem = new G_Form_Element_File($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Nahrát Obchodní podmínky');

		$this->addElement($elem);    
        

		$name = "HEUREKA_CODE";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Heureka klíč:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="CISLO_FAK_OBJ";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('label','Číslo faktury dle čísla objednávky');
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);


		$name="HEUREKA_ENABLED";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('label','Odesílat objednávky na Heureka.cz');
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);




		$name = "HEUREKA_RECENZE_CRON";
		$elem = new G_Form_Element_Select($name);

		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);

		$elem->setAttribs('value',trim($value));
		$elem->setAttribs('label','Doba pro import recenzí z Heureky.cz');
		$pole = array();

		$attrib = array();

		for ($i=0;$i<24;$i++)
		{

			if ($i<10) {
				$label = "0".$i.":00";
			}else {
				$label = $i.":00";
			}
			$pole[$i] = $label;
		}
		$pole[99] = "Nenastaveno";

		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);



		$name="OP_PDF";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('label','Připojit obchodní podmínky k objednávce');
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);



		$name = "RAZITKO_OBJ_PDF";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Razítko v objednávce:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name = "RAZITKO_FAK_PDF";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Razítko na faktuře:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$elem = new G_Form_Element_Text("INFO_EMAIL");
		$elem->setAttribs(array("id"=>"INFO_EMAIL"));
		$value = $this->getPost("INFO_EMAIL", $set["INFO_EMAIL"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Informace o objednávce:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$elem = new G_Form_Element_Text("BCC_EMAIL");
		$elem->setAttribs(array("id"=>"BCC_EMAIL"));
		$value = $this->getPost("BCC_EMAIL", $set["BCC_EMAIL"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Skrytá kopie objednávky:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$elem = new G_Form_Element_Select("NEXTID_PRODUCT");
		$elem->setAttribs(array("id"=>"NEXTID_PRODUCT","required"=>false));
		$value = $this->getPost("NEXTID_PRODUCT", $set["NEXTID_PRODUCT"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Řada produktů:');
		$pole = array();
		$pole[0] = " -- žádná -- ";
		$attrib = array();
		foreach ($nextidProductList as $key => $value)
		{
			$pole[$value->id] = $value->rada;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		$elem = new G_Form_Element_Select("NEXTID_ORDER");
		$elem->setAttribs(array("id"=>"NEXTID_ORDER","required"=>false));
		$value = $this->getPost("NEXTID_ORDER", $set["NEXTID_ORDER"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Řada objednávek:');
		$pole = array();
		$pole[0] = " -- žádná -- ";
		$attrib = array();
		foreach ($nextidOrderList as $key => $value)
		{
			$pole[$value->id] = $value->rada;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		$elem = new G_Form_Element_Select("NEXTID_FAKTURA");
		$elem->setAttribs(array("id"=>"NEXTID_FAKTURA","required"=>false));
		$value = $this->getPost("NEXTID_FAKTURA", $set["NEXTID_FAKTURA"]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Řada faktur:');
		$pole = array();
		$pole[0] = " -- žádná -- ";
		$attrib = array();
		foreach ($nextidFakturyList as $key => $value)
		{
			$pole[$value->id] = $value->rada;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		for ($i=1;$i<=10;$i++)
		{

			$cislo = $i;
			if ($i < 10) {
				$cislo = "0".$i;
			}

			$name="CISLO" . $cislo . "_CHECK";

			$elem = new G_Form_Element_Checkbox($name);
			$elem->setAttribs(array("id"=>$name));
			$value = $this->getPost($name, $set[$name]);
			$elem->setAttribs('value',1);
			$elem->setAttribs('label',"Povoleno");
			if ($value == 1) {
				$elem->setAttribs('checked','checked');
			}
			$this->addElement($elem);

			$name="CISLO" . $cislo . "_SECRET";

			$elem = new G_Form_Element_Checkbox($name);
			$elem->setAttribs(array("id"=>$name));
			$value = $this->getPost($name, $set[$name]);
			$elem->setAttribs('value',1);
			$elem->setAttribs('label',"Skrýt");
			if ($value == 1) {
				$elem->setAttribs('checked','checked');
			}
			$this->addElement($elem);
      

			$name="CISLO" . $cislo;
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			$value = $this->getPost($name, $set[$name]);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label',$name.':');
			$elem->setAttribs('class','textbox');
			$this->addElement($elem);

			$name="CISLO" . $cislo . "_ID";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			$value = $this->getPost($name, $set[$name]);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label',$name.':');
			$elem->setAttribs('class','textbox');
			$this->addElement($elem);


			$name="POLOZKA" . $cislo . "_CHECK";
			$elem = new G_Form_Element_Checkbox($name);
			$elem->setAttribs(array("id"=>$name));
			$value = $this->getPost($name, $set[$name]);
			$elem->setAttribs('value',1);
			if ($value == 1) {
				$elem->setAttribs('checked','checked');
			}
			$elem->setAttribs('label',"Povoleno");
			$this->addElement($elem);


			$name="POLOZKA" . $cislo . "_SECRET";
			$elem = new G_Form_Element_Checkbox($name);
			$elem->setAttribs(array("id"=>$name));
			$value = $this->getPost($name, $set[$name]);
			$elem->setAttribs('value',1);
			if ($value == 1) {
				$elem->setAttribs('checked','checked');
			}
			$elem->setAttribs('label',"Skrýt");
			$this->addElement($elem);
      
			$name="POLOZKA" . $cislo;
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			$value = $this->getPost($name, $set[$name]);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label',$name.':');
			$elem->setAttribs('class','textbox');

			$this->addElement($elem);


			$name="POLOZKA" . $cislo . "_ID";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			$value = $this->getPost($name, $set[$name]);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label',$name.':');
			$elem->setAttribs('class','textbox');

			$this->addElement($elem);


		}
		/*
		$name="CISLO01_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="CISLO02_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
	//	$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name="CISLO03_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="CISLO04_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="CISLO05_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);


		$name="CISLO06_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="CISLO07_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		//	$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name="CISLO08_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="CISLO09_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="CISLO10_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);
*/



		/*
		$name="CISLO01";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name="CISLO02";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
		$name="CISLO03";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
		$name="CISLO04";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
		$name="CISLO05";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name="CISLO06";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name="CISLO07";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
		$name="CISLO08";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
		$name="CISLO09";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
		$name="CISLO10";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
*/

		/*
		/////////////////
		$name="POLOZKA01_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="POLOZKA02_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		//	$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name="POLOZKA03_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="POLOZKA04_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="POLOZKA05_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);



		$name="POLOZKA06_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="POLOZKA07_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		//	$elem->setAttribs('value',$value);
		$this->addElement($elem);

		$name="POLOZKA08_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="POLOZKA09_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="POLOZKA10_CHECK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);
*/

/*
		$name="POLOZKA01";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="POLOZKA02";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="POLOZKA03";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="POLOZKA04";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="POLOZKA05";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name="POLOZKA06";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="POLOZKA07";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="POLOZKA08";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="POLOZKA09";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="POLOZKA10";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$name.':');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
*/

		$name="BASKET_REDIRECT";
		$agmoBranaRezim = array("0"=>"Zůstat na původní stránce","1"=>"Přejít do košíku","2"=>"Přidat a zobrazit rozcestník");
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Akce po přidání zboží do košíku');
		$pole = array();
		$attrib = array();
		foreach ($agmoBranaRezim as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);
    
    
    
		$name="SPLATNOST";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('style','text-align:right;width: 150px;');
		$elem->setAttribs('label','Splatnost:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name="AGMO_TEST";
		$agmoBranaRezim = array("0"=>"Testovací provoz","1"=>"Ostrý provoz",);
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Typ brány:');
		$pole = array();
		$attrib = array();
		foreach ($agmoBranaRezim as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$name="AGMO_MERCHANT";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Merchant:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="AGMO_SECRET";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Secret:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="GPWP_TEST";
		$agmoBranaRezim = array("0"=>"Testovací provoz","1"=>"Ostrý provoz",);
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Typ brány:');
		$pole = array();
		$attrib = array();
		foreach ($agmoBranaRezim as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$name="GPWP_MERCHANT";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Merchant:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="GPWP_SECRET";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Heslo k PVK:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
    
		$name="GPWP_SECRET_TEST";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Heslo k PVK (testovací):');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
        
		$name="GPWP_PRIVATE_KEY";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Privátní klíč:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
    
		$name="GPWP_PRIVATE_KEY_TEST";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Privátní klíč (testovací):');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
    
    $name="GPWP_PUBLIC_KEY";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Veřejný klíč:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
    
		$name="GPWP_PUBLIC_KEY_TEST";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Veřejný klíč (testovací):');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);
    
        
		$name="PAYU_POS_ID";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Merchant:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="PAYU_KEY1";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Secret:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="PAYU_KEY2";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Secret:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name="ESHOP_TEMPLATE";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Id šablony:');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);





		$name="SLEVA_DOKLAD_TISK";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('label','Tisk slevy na dokladech');
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="SKLAD_AKTIVNI";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('label','Použít sklad:');
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="SKLAD_BLOKACE";
		$agmoBranaRezim = array("0"=>"Při objednání","1"=>"Při potvrzení objednávky",);
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Způsob vyskladnění:');
		$pole = array();
		$attrib = array();
		foreach ($agmoBranaRezim as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$platceDaneList = array("0"=>"Katalog","1"=>"Tabulka");
		$name = "PRODUCT_LIST_TYPE";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Způsob vypisování produktů');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$platceDaneList = array("0"=>"Ne","1"=>"Ano");
		$name = "PAGE_PODCATEGORY";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Zobrazení podkategorií na stránce');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$platceDaneList = array("0"=>"Ne","1"=>"Ano");
		$name = "PRODUCT_FILTER";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Zobrazení filtru na stránce');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);





		$platceDaneList = array("NONE"=>"Nikde","LEFT"=>"Vlevo","RIGHT"=>"Vpravo");


		$name = "PRODUCT_AKCE_POS";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Umístění produktů v akci');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		$name = "PRODUCT_HISTORY_POS";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Umístění historie navštívených produktů');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		$name = "SEARCH_BOX_POS";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Umístění menu produktů');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		$platceDaneList = array("TOP"=>"Nahoře","LEFT"=>"Vlevo","RIGHT"=>"Vpravo");
		$name = "ESHOP_MENU_POS";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Umístění menu produktů');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$platceDaneList = array("TOP"=>"Nahoře","LEFT"=>"Vlevo","RIGHT"=>"Vpravo",""=>"Nikde");
		$name = "ESHOP_MENU_MAIN_POS";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Umístění menu produktů');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		$platceDaneList = array("TOP"=>"Nahoře","MAIN"=>"V obsahu");
		$name = "ESHOP_SLIDER_POS";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Umístění slideru na stránce');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);



		$platceDaneList = array("MAIN"=>"Jen úvodní stránka","ALL"=>"Na všech stránkách");
		$name = "ESHOP_SLIDER_PAGE";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Kde se bude zobrazovat');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);



		$name="LEFT_PANEL_ON";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('label','Levý panel');
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);


		$name="LEFT_PANEL_SLIM";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('label','Úzký levý panel ');
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);


		$name="SHOP_LEFT_PANEL_SLIM";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('label','Úzký levý panel pro shop ');
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);
		$name="RIGHT_PANEL_ON";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('label','Pravý panel');
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="RIGHT_PANEL_SLIM";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('label','Úzký pravý panel ');
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="SHOP_RIGHT_PANEL_SLIM";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('label','Úzký pravý panel pro shop ');
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="ADD_BASKET_LIST";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('label','Do košíku z výpisu');
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);

		$name="ADD_BASKET_DETAIL";
		$elem = new G_Form_Element_Checkbox($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('label','Do košíku z detailu');
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$this->addElement($elem);


		$name="BASKET_CALLBACK_URL";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('is_numeic',true);
		$elem->setAttribs('label','Po dokončení nákupu přesměrovat na url');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="PRODUCT_LIST_LIMIT";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('is_numeic',true);
		$elem->setAttribs('label','Zobrazení položek na stránce');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="SLIDER_CATEGORY_LIMIT";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('is_numeic',true);
		$elem->setAttribs('label','Zobrazení položek ve slideru');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="ESHOP_SLIDER_WIDTH";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('is_numeic',true);
		$elem->setAttribs('label','Šířka slideru');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name="ESHOP_SLIDER_HEIGHT";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('is_numeic',true);
		$elem->setAttribs('label','Výška slideru');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);




		$name="PRODUCT_THUMB_WIDTH";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('is_numeic',true);
		$elem->setAttribs('label','Šířka miniatury produktu ve výpisu');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);

		$name="PRODUCT_THUMB_HEIGHT";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('is_numeic',true);
		$elem->setAttribs('label','Výška miniatury produktu ve výpisu');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);



		$name="ESHOP_CATEGORY_LIST";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
//		$elem->setAttribs('is_numeic',true);
		$elem->setAttribs('label','Hlavní kategorie eshopu');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);


		$name="MENA";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		//		$elem->setAttribs('is_numeic',true);
		$elem->setAttribs('label','Měna');
		$elem->setAttribs('class','textbox');
		$this->addElement($elem);



    $name = "POHODA_OBJ_XML_FDATE";
    $datum = $set[$name];
    if (empty($datum)) {
			//$datum = date("j.n.Y H:i:s");
		} else {
			$datum = date("j.n.Y H:i:s", strtotime($set[$name]));
		}
		
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $datum);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','datetimepicker');
	//	$elem->setAttribs('style','width:120px');
		$elem->setAttribs('label','Pořízené od:');
		$this->addElement($elem);

    $name = "POHODA_OBJ_XML_TDATE";
    $datum = $set[$name];
    if (empty($datum)) {
		//	$datum = date("j.n.Y H:i:s");
		} else {
			$datum = date("j.n.Y H:i:s", strtotime($set[$name]));
		}
		
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $datum);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','datetimepicker');
	//	$elem->setAttribs('style','width:120px');
		$elem->setAttribs('label','Pořízené do:');
		$this->addElement($elem);

    $name = "POHODA_OBJ_XML_FCODE";
    $elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','');
	//	$elem->setAttribs('style','width:120px');
		$elem->setAttribs('label','Číslo od:');
		$this->addElement($elem);

    
    $name = "POHODA_OBJ_XML_TCODE";
    $elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','');
	//	$elem->setAttribs('style','width:120px');
		$elem->setAttribs('label','Číslo do:');
		$this->addElement($elem);
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  //////////////
  
    $name = "POHODA_FAK_XML_FDATE";
    $datum = $set[$name];
    if (empty($datum)) {
			//$datum = date("j.n.Y H:i:s");
		} else {
			$datum = date("j.n.Y H:i:s", strtotime($set[$name]));
		}
		
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $datum);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','datetimepicker');
	//	$elem->setAttribs('style','width:120px');
		$elem->setAttribs('label','Pořízené od:');
		$this->addElement($elem);

    $name = "POHODA_FAK_XML_TDATE";
    $datum = $set[$name];
    if (empty($datum)) {
		//	$datum = date("j.n.Y H:i:s");
		} else {
			$datum = date("j.n.Y H:i:s", strtotime($set[$name]));
		}
		
		$elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $datum);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','datetimepicker');
	//	$elem->setAttribs('style','width:120px');
		$elem->setAttribs('label','Pořízené do:');
		$this->addElement($elem);

    $name = "POHODA_FAK_XML_FCODE";
    $elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','');
	//	$elem->setAttribs('style','width:120px');
		$elem->setAttribs('label','Číslo od:');
		$this->addElement($elem);

    
    $name = "POHODA_FAK_XML_TCODE";
    $elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','');
	//	$elem->setAttribs('style','width:120px');
		$elem->setAttribs('label','Číslo do:');
		$this->addElement($elem);
    
    
    $name = "POHODA_ZBOZI_XML_SKLAD";
    $elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','');
	//	$elem->setAttribs('style','width:120px');
		$elem->setAttribs('label','Číslo skladu');
		$this->addElement($elem);
  
  
  ////////////////  
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        
    $name = "FAVI_KOD_DOPRAVCE";
    $elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','');
	//	$elem->setAttribs('style','width:120px');
		$elem->setAttribs('label','Kód dopravce');
		$this->addElement($elem);

    $name = "FAVI_CENA_DOPRAVCE";
    $elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','');
		$elem->setAttribs('is_numeric',true);
		$elem->setAttribs('label','Cena dopravce');
		$this->addElement($elem);
        

    $name = "POHODA_EXP_USER";
    $elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','');
	//	$elem->setAttribs('style','width:120px');
		$elem->setAttribs('label','Uživatelské jméno:');
		$this->addElement($elem);
    
    $name = "POHODA_EXP_PWD";
    $elem= new G_Form_Element_Text($name);
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','');
	//	$elem->setAttribs('style','width:120px');
		$elem->setAttribs('label','Heslo:');
		$this->addElement($elem);
            
		$name="MSG_NENALEZENO";
		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		//		$elem->setAttribs('is_numeic',true);
		$elem->setAttribs('label','Text s prázdnýnm výsledkem hledání');
		$elem->setAttribs('class','editbox mceEditor');
		$elem->setAttribs('cols','55');
		$elem->setAttribs('rows','3');
		$this->addElement($elem);


		$name="ROW_PRODUCT_COUNT";
		$platceDaneList = array(1,2,3,4,5);
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Počet produktů na řádku');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key)
		{
			$pole[$key] = $key;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);



		$name="LOGO_MENU";
		$platceDaneList = array("WITHOUT_LOGO" => "Logo nahoře a menu samostatně","WITH_LOGO" => "Logo v menu","WITHOUT_LOGO_BOTTOM" => "Logo dole a menu samostatně","NONE" => "bez loga");
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $set[$name]);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Umístění loga');
		$pole = array();

		$attrib = array();
		foreach ($platceDaneList as $key => $val)
		{
			$pole[$key] = $val;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

    $name = "ZBOZICZ_EXPORT_CRON";
		$elem = new G_Form_Element_Select($name);

		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);

		$elem->setAttribs('value',trim($value));
		$elem->setAttribs('label','Doba pro export feedu:');
		$pole = array();

		$attrib = array();

		for ($i=0;$i<24;$i++)
		{

			if ($i<10) {
				$label = "0".$i.":00";
			}else {
				$label = $i.":00";
			}
			$pole[$i] = $label;
		}
		$pole[99] = "Nenastaveno";

		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);
    
    
    
    $name = "FAVI_EXPORT_CRON";
		$elem = new G_Form_Element_Select($name);

		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);

		$elem->setAttribs('value',trim($value));
		$elem->setAttribs('label','Doba pro export feedu:');
		$pole = array();

		$attrib = array();

		for ($i=0;$i<24;$i++)
		{

			if ($i<10) {
				$label = "0".$i.":00";
			}else {
				$label = $i.":00";
			}
			$pole[$i] = $label;
		}
		$pole[99] = "Nenastaveno";

		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);    

    $name = "HEUREKA_EXPORT_CRON";
		$elem = new G_Form_Element_Select($name);

		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $set[$name]);

		$elem->setAttribs('value',trim($value));
		$elem->setAttribs('label','Doba pro export feedu:');
		$pole = array();

		$attrib = array();

		for ($i=0;$i<24;$i++)
		{

			if ($i<10) {
				$label = "0".$i.":00";
			}else {
				$label = $i.":00";
			}
			$pole[$i] = $label;
		}
		$pole[99] = "Nenastaveno";

		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);
    
		$elem = new G_Form_Element_Button("upd-setting-eshop");
		$elem->setAttribs(array("id"=>"upd-setting-eshop"));
		$elem->setAttribs('value','Uložit');
		$elem->setAttribs('class','btn btn-primary');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);




		$elem = new G_Form_Element_Button("heureka-import");
		$elem->setAttribs(array("id"=>"heureka-import"));
		$elem->setAttribs('value','Natáhnout recenze');
		$elem->setAttribs('class','btn btn-info');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

	}
}
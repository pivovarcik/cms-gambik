<?php
/**
 * Společný předek pro formuláře typu Faktura
 * */
abstract class DokladForm extends G_Form
{

	public static $model;
	public $doklad;
	public $doklad_id;

	public $languageModel;
	public $languageList;
	public $dokladSettings;
	public static $entita;
	function __construct($TDoklad)
	{
		parent::__construct();
		$this->loadModel($TDoklad);

	}

	// načte datový model
	public function loadModel($TDoklad)
	{


		$name = "models_" . $TDoklad;
		self::$model = new $name;

		$name = $TDoklad . "Entity";
		self::$entita = $name;

		$this->translator = G_Translator::instance();

		$dopravaModel = new models_Doprava();
		$params = new ListArgs();
		$params->lang = LANG_TRANSLATOR;
    
    $this->dopravaList = array();
    
		$this->dopravaList = $dopravaModel->getList($params);

    
    

		$platbyModel = new models_Platba();
		$this->platbyList = $platbyModel->getList($params);

		$eshopController = new EshopController();
		$this->dokladSettings = $eshopController->setting;
	}
	// načte datový model
	public function loadPage($doklad_id = null)
	{
     $eshopSettings = G_EshopSetting::instance(); 
	//	print "ID:" . $page_id;
		if ($doklad_id == null) {
			//$this->doklad = new stdClass();

			$this->doklad = new self::$entita;



      
      
			$this->doklad->platba_castka = 0;
			$this->doklad->cost_subtotal = 0;
			$this->doklad->cost_total = 0;
			$this->doklad->cost_tax = 0;
			$this->doklad->code = "";
			$this->doklad->faktura_date = date("j.n.Y");
      
      
      $duzp_date =  (trim($eshopSettings->get("PLATCE_DPH"))*1 == 1 ? date("j.n.Y")  : null);

      
			$this->doklad->duzp_date = $duzp_date;
      
     
         // print $doklad->$name;
    $splatnost = (trim($eshopSettings->get("SPLATNOST"))*1 > 0 ? date("j.n.Y",strtotime("+" . trim($eshopSettings->get("SPLATNOST")) . "days"))  : date("j.n.Y"));

		//	$splatnost = (trim($this->dokladSettings["SPLATNOST"])*1 > 0 ? date("j.n.Y",strtotime("+" . trim($this->dokladSettings["SPLATNOST"]) . "days"))  : date("j.n.Y"));
			$this->doklad->maturity_date = $splatnost;
		} else {

			$doklad = self::$model->getDetailById($doklad_id);
		//	print_R($doklad);
			$this->doklad = new self::$entita($doklad);
		//	print_R($this->doklad);
			//$this->doklad = $this->model->getDetailById($doklad_id);


			$this->doklad_id = $doklad_id;
		}

	}
	// načte datový model
	public function loadElements()
	{

		$translator = G_Translator::instance();

		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$doklad = $this->doklad;
		$dopravaList = $this->dopravaList;
		$platbyList = $this->platbyList;

		$name = "code";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$elem->setAttribs('style','font-weight:bold;');
		$elem->setAttribs('readonly','readonly');
		$value = $doklad->$name;
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Číslo dokladu:');
		$elem->setAttribs('class','textbox readonly');
		$this->addElement($elem);


	/*	$name = "order_code";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs('style','width:185px;');
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Číslo objednávky:');
		$elem->setAttribs('class','textbox ');
		$this->addElement($elem);*/

		$name = "shipping_first_name";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy("jmeno_firma") . ':');
		$elem->setAttribs('class','textbox ');
		$this->addElement($elem);

		$name = "shipping_last_name";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy("kontaktni_osoba") . ':');
		$elem->setAttribs('class','textbox ');
		$this->addElement($elem);

		$name = "shipping_address_1";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy("ulice") . ':');
		$elem->setAttribs('class','textbox ');
		$this->addElement($elem);


		//////////////
		$name = "shipping_first_name2";
		$elem = new G_Form_Element_Text($name);
	//	$elem->setAttribs(array("id"=>$name,"required"=>true));
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		//$elem->setAttribs('label','Jméno/firma:');
		$elem->setAttribs('label',$translator->prelozitFrazy("jmeno_firma") . ':');
		$elem->setAttribs('class','textbox ');
		$this->addElement($elem);

		$name = "shipping_last_name2";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy("kontaktni_osoba") . ':');
		$elem->setAttribs('class','textbox ');
		$this->addElement($elem);

		$name = "shipping_address_12";
		$elem = new G_Form_Element_Text($name);
		//$elem->setAttribs(array("id"=>$name,"required"=>true));
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy("ulice") . ':');
		$elem->setAttribs('class','textbox ');
		$this->addElement($elem);

		$name = "shipping_address_22";
		$elem = new G_Form_Element_Text($name);
		//$elem->setAttribs(array("id"=>$name,"required"=>true));
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Ulice č.p.:');
		$elem->setAttribs('class','textbox ');
		$this->addElement($elem);

		$name = "shipping_zip_code2";
		$elem = new G_Form_Element_Text($name);
		//$elem->setAttribs(array("id"=>$name,"required"=>true));
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy("psc") . ':');
		$elem->setAttribs('class','textbox small_size');
		$this->addElement($elem);

		$name = "shipping_city2";
		$elem = new G_Form_Element_Text($name);
	//	$elem->setAttribs(array("id"=>$name,"required"=>true));
		$value = $this->getPost($name,$doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy("mesto") . ':');
		$elem->setAttribs('class','textbox ');
		$this->addElement($elem);


		///////////////////////
		$name = "shipping_city";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$value = $this->getPost($name,$doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy("mesto") . ':');
		$elem->setAttribs('class','textbox ');
		$this->addElement($elem);

		$name = "shipping_zip_code";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy("psc") . ':');
		$elem->setAttribs('class','textbox small_size');
		$this->addElement($elem);


		$name = "shipping_phone";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy("telefon") . ':');
		$elem->setAttribs('class','textbox ');
		$this->addElement($elem);

		$name = "shipping_email";
		$elem = new G_Form_Element_Email($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setLabel($translator->prelozitFrazy("email") . ':');
		$elem->setAttribs('class','textbox ');
		$this->addElement($elem);

		$name = "shipping_ico";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy("ico") . ':');
		$elem->setAttribs('class','textbox ');
		$this->addElement($elem);

		$name = "shipping_dic";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name,$doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label',$translator->prelozitFrazy("dic") . ':');
		$elem->setAttribs('class','textbox ');
		$this->addElement($elem);



		$name = "cost_total";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs('id',$name);
		$value = $this->getPost($name,$doklad->$name);
		$elem->setAttribs('value',$value);
	//	$elem->setAttribs('label','Částka platby:');
		$elem->setAttribs('style','font-size:12px;text-align:right;font-weight:bold;background-color:#CCFFCC;');
		$elem->setAttribs('is_money','true');
		$elem->setAttribs('readonly','readonly');
		$elem->setAttribs('class','textbox small_size');
		$this->addElement($elem);

		$name = "cost_tax";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs('id',$name);
		$value = $this->getPost($name,$doklad->$name);
		$elem->setAttribs('value',$value);
		//	$elem->setAttribs('label','Částka platby:');
		$elem->setAttribs('style','text-align:right;');
		$elem->setAttribs('is_money','true');
		$elem->setAttribs('readonly','readonly');
		$elem->setAttribs('class','textbox small_size');
		$this->addElement($elem);

		$name = "cost_subtotal";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs('id',$name);
		$value = $this->getPost($name,$doklad->$name);
		$elem->setAttribs('value',$value);
		//	$elem->setAttribs('label','Částka platby:');
		$elem->setAttribs('style','text-align:right;');
		$elem->setAttribs('is_money','true');
		$elem->setAttribs('readonly','readonly');
		$elem->setAttribs('class','textbox small_size');
		$this->addElement($elem);

		$name = "shipping_pay";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox');
		$elem->setAttribs('label','Způsob úhrady:');
		$pole = array();
		//$pole[0] = " -- neuvedeno -- ";
		$attrib = array();
		$okres = 0;
		foreach ($platbyList as $key => $value)
		{
			$pole[$value->id] = $value->name;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$name = "shipping_transfer";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox');
		$elem->setAttribs('label','Doprava:');
		$pole = array();
		$pole[0] = " -- neuvedeno -- ";
		$attrib = array();

    //print_R($dopravaList);
		foreach ($dopravaList as $key => $value)
		{
    
           
       $attrib[$value->id] =array();
       $img = "";
       if (!empty($value->kod_dopravce))
        {
       // print_r($value);
        //$attrib[$value->id] ='style="background-image:url(/admin/style/images/' . strtolower($value->kod_dopravce) . '.png);';
        $attrib[$value->id] = array('style'=>'background-image:url(/admin/style/images/' . strtolower($value->kod_dopravce) . '.png);');
       // array_push($attrib[$value->id],array('style','background-image:url(/admin/style/images/' . strtolower($value->kod_dopravce) . '.png);'));
       
           //$img = '<img style="height:25px;" src="/admin/style/images/' . strtolower($value->kod_dopravce) . '.png" /> ';
        }
    
    
			$pole[$value->id] = $img . $value->name;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		$name = "order_date";
		$value = $doklad->$name;
		$value = (!empty($value)) ? date("j.n.Y", strtotime($value)) : "";

		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name,$value);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('id',$name);
		$elem->setAttribs('label','Datum objednávky:');
		$elem->setAttribs('class','textbox small_size datepicker');
		$this->addElement($elem);


		$name = "description";
		$elem = new G_Form_Element_Textarea($name);
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Poznámka:');
	//	$elem->setAttribs('style','width:100%;');
		$elem->setAttribs('rows','5');
		$elem->setAttribs('class','textarea');
		$this->addElement($elem);


		$name = "description_secret";
		$elem = new G_Form_Element_Textarea($name);
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Interní poznámka:');
		//	$elem->setAttribs('style','width:100%;');
		$elem->setAttribs('rows','5');
		$elem->setAttribs('class','textarea');
		$this->addElement($elem);

		if ($this->doklad_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->doklad_id);
			$this->addElement($elem);
		}
	}
}
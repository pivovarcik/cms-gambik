<?php
/**
 * Společný předek pro formuláře typu Číselník s jazykovými verzemi
 * */
require_once("CiselnikVersionForm.php");
class ShopTransferForm extends CiselnikVersionForm
{

	function __construct()
	{
		parent::__construct("models_Doprava");
		$this->setStyle(BootstrapForm::getStyle());
	}


	public function loadElements()
	{
		parent::loadElements();
    $this->dopravceList = array ();
    $this->dopravceList["CPOST"] = "Česká pošta";
    $this->dopravceList["PPL"] = "PPL";
    $this->dopravceList["DHL"] = "DHL";
    $this->dopravceList["GEIS"] = "Geis";
    $this->dopravceList["GLS"] = "GLS";
    $this->dopravceList["DPD"] = "DPD";
    $this->dopravceList["FOFR"] = "FOFR";
    $this->dopravceList["TOPTRANS"] = "Toptrans";
    $this->dopravceList["INTIME"] = "In-time";
    $this->dopravceList["FEDEX"] = "FedEx";
    $this->dopravceList["ULOZENKA"] = "Uloženka";
    $this->dopravceList["ZASILKOVNA"] = "Zásilkovna";
		$eshopController = new EshopController();
		$dph_model = new models_Dph();
		$dphList = $dph_model->getList();


		$mj_model = new models_Mj();
		$mjList = $mj_model->getList();
    $vypocetList = array(0=>"Fixní cena",1=>"Cena za MJ",2=>"Cena za m3",3=>"Cena za kg");
		$page = $this->page;


    #region chart_rezim
		$name = "kod_dopravce";
		$elem = new G_Form_Element_Radio($name);

		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$pole = array();
		$attrib = array();
		foreach ($this->dopravceList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);
		#endregion
    
		$name = "aktivni";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
	//	$elem->setAttribs('class','dodaci_adresa_check');
		$elem->setAttribs('value',1);
		$elem->setAttribs('label','Aktivní');
		$this->addElement($elem);
    
        
		$name = "osobni_odber";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, $page->$name);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('class','dodaci_adresa_check');
		$elem->setAttribs('value',1);
		$elem->setAttribs('label','Osobní odběr');
		$this->addElement($elem);


		$name = "address1";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('class','textbox');
		$value = $this->getPost("name", $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Ulice:');
		$this->addElement($elem);

		$name = "city";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('class','textbox');
		$value = $this->getPost("name", $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Město:');
		$this->addElement($elem);


		$name = "odberne_misto";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('class','textbox');
		$value = $this->getPost("name", $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Odběrné místo:');
		$this->addElement($elem);

		$name = "zip_code";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name));
		//	$elem->setAttribs('style','width:300px;font-weight:bold;');
		$value = $this->getPost("name", $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','PSČ:');
		$this->addElement($elem);

        /*

    			$name = "price_m3";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			//$elem->setAttribs(array("is_money"=>true));
			$value = $this->getPost($name, $page->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label','Cena za m3');
			$elem->setAttribs(array("is_money"=>true));
			$elem->setAttribs('style','width:100px;text-align:right;');
			$this->addElement($elem);
 
    			$name = "price_kg";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			//$elem->setAttribs(array("is_money"=>true));
			$value = $this->getPost($name, $page->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label','Cena za kg');
			$elem->setAttribs(array("is_money"=>true));
			$elem->setAttribs('style','width:100px;text-align:right;');
			$this->addElement($elem);
                                   */
                                   
                                   
      $name = "vypocet_id";
			$elem = new G_Form_Element_Select($name);
			$value = $this->getPost($name, $page->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label','Způsob výpočtu dopravy');
		//	$elem->setAttribs('class','form_edit small_size');



			//	print_r($dphList);
			$pole = array();
			//$pole[0] = " -- neuveden -- ";
			$attrib = array();
			foreach ($vypocetList as $key => $value)
			{
				$pole[$key] = $value;
			}
			$elem->setMultiOptions($pole,$attrib);
			$this->addElement($elem);
      
		foreach ($this->languageList as $key => $val)
		{

			$name = "price_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			//$elem->setAttribs(array("is_money"=>true));
			$value = $this->getPost($name, $page->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label','Cena: ('.$val->code.')');
			$elem->setAttribs(array("is_money"=>true));
			$elem->setAttribs('style','width:100px;text-align:right;');
			$this->addElement($elem);

			$name = "price_value_$val->code";
			$elem = new G_Form_Element_Text($name);
			$elem->setAttribs(array("id"=>$name));
			//$elem->setAttribs(array("is_money"=>true));
			$value = $this->getPost($name, $page->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label','Cena popis ('.$val->code.'):');
			$elem->setAttribs('style','width:100px;text-align:left;');
			$this->addElement($elem);


			$name = "tax_id_$val->code";
			$elem = new G_Form_Element_Select($name);
			$value = $this->getPost($name, $page->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('label','Sazba DPH ('.$val->code.'):');
			$elem->setAttribs('class','form_edit small_size');

			if ($eshopController->setting["PLATCE_DPH"] == "0") {
				$elem->setAttribs('disabled','disabled');
				//	$dphList = array();
			}

			//	print_r($dphList);
			$pole = array();
			//$pole[0] = " -- neuveden -- ";
			$attrib = array();
			foreach ($dphList as $key => $value)
			{
				$pole[$value->id] = $value->name;
			}
			$elem->setMultiOptions($pole,$attrib);
			$this->addElement($elem);

			$name = "mj_id_$val->code";
			$elem = new G_Form_Element_Select($name);
			$elem->setAttribs(array("id"=>$name,"required"=>false));
			$value = $this->getPost($name, $page->$name);
			$elem->setAttribs('label','MJ ('.$val->code.'):');
			$elem->setAttribs('value',$value);
			//$elemHMJ->setAttribs('label','HMJ:');
			$pole = array();
			foreach ($mjList as $key => $value)
			{
				$pole[$value->id] = $value->name;
			}
			$elem->setMultiOptions($pole);
			$this->addElement($elem);

		}
	}
}
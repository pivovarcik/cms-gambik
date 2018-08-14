<?php

class EshopSetingsTabs extends G_Tabs {

	protected $form;
	protected $logo_pdf_file;
	protected $razitko_pdf_file;
	protected $op_pdf_file;
	public function __construct($pageForm)
	{
		parent::__construct("left");
		$this->form = $pageForm;
    
    
   $logo_id = $this->form->page["LOGO_PDF"];

    
    if (!empty($logo_id)) {
    
        $this->logo_pdf_file = URL_IMG . $logo_id;
    }
    
       $logo_id = $this->form->page["RAZITKO_OBJ_PDF"];

    
    if (!empty($logo_id)) {
    
        $this->razitko_pdf_file = URL_IMG . $logo_id;
    }
    
    
       $logo_id = $this->form->page["OP_PDF_FILE"];

        //    PRINT   PATH_DATA . $logo_id;
    if (!empty($logo_id) && file_exists(PATH_DATA . $logo_id)) {
    
        $this->op_pdf_file = URL_DATA . $logo_id;
    }    
    
    
      
	}

	protected function MainTabs()
	{
		$form = $this->form;
		$contentMain = '';

		$contentMain .= '<div class="well">';
		$contentMain .= '<fieldset>';
		$contentMain .= '<legend>Kontaktní a fakturační údaje</legend>';


		$contentMain .= '<div class="row">';
		$contentMain .= '<div class="col-md-6">';

		$contentMain .= $form->getElement("COMPANY_NAME")->render();

		$contentMain .= '</div>';


		$contentMain .= '<div class="col-md-6">';
		$contentMain .= '<div class="row">';

		$contentMain .= '<div class="col-md-4">';
		$contentMain .= $form->getElement("ICO")->render();
    
    
    		$contentMain .= '<p class="desc"><a href="#" class="ares btn btn-info btn-xs">Dotáhnout z ARES.</a></p><br />';
		$contentMain .= '<script>$( ".ares" ).click(function(event) {
		event.preventDefault();
		 aresLoad(this);

	});</script>';
  
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-md-4">';
		$contentMain .= $form->getElement("DIC")->render();
		$contentMain .= '</div>';

		$contentMain .= '<div class="col-md-4">';
		$contentMain .= $form->getElement("PLATCE_DPH")->render();
		$contentMain .= '</div>';

		$contentMain .= '</div>';
		$contentMain .= '</div>';


		//	$contentMain .= '<p class="desc">Název společnosti podle Obchodního rejstříku.</p><br />';

		$contentMain .= '<div class="col-md-3">';
		$contentMain .= $form->getElement("ADDRESS1")->render();
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-md-3">';
		//	$contentMain .= '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("ADDRESS2")->render();
		$contentMain .= '</div>';



		$contentMain .= '<div class="col-md-6">';
		$contentMain .= '<div class="row">';

		$contentMain .= '<div class="col-md-4">';
		$contentMain .= $form->getElement("CITY")->render();
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-md-4">';
		$contentMain .= $form->getElement("ZIP_CODE")->render();
		$contentMain .= '</div>';

		$contentMain .= '<div class="col-md-4">';
		$contentMain .= $form->getElement("COUNTRY")->render();
		$contentMain .= '</div>';

		$contentMain .= '</div>';
		$contentMain .= '</div>';


		$contentMain .= '<div class="col-md-3">';
		$contentMain .= $form->getElement("KONTAKT_EMAIL")->render();
		$contentMain .= '</div>';

		$contentMain .= '<div class="col-md-3">';
		$contentMain .= $form->getElement("KONTAKT_TELEFON")->render();
		$contentMain .= '</div>';


		$contentMain .= '<div class="col-md-3">';
		$contentMain .= $form->getElement("UCET")->render();
		$contentMain .= '</div>';


		$contentMain .= '<div class="col-md-3	">';
		$contentMain .= $form->getElement("IBAN")->render();
		$contentMain .= '</div>';



		$contentMain .= '</div>';


		$contentMain .= $form->getElement("OR")->render();

		$contentMain .= '</fieldset>';
		$contentMain .= '</div>';


		$contentMain .= $form->getElement("MENA")->render() . '';
		$contentMain .= '<p class="desc"></p><br />';


		$contentMain .= $form->getElement("DOPRAVNE_ZA_MJ")->render();
		$contentMain .= '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("DOPRAVNE_ZDARMA")->render();
		$contentMain .= '<p class="desc">0 = žádná sleva, 1000 = od 1000 Kč včetně</p><br />';

		return $contentMain;
	}

	protected function MailTabs()
	{
		$form = $this->form;

		$contentVarianty = '';

		$contentVarianty .= $form->getElement("EMAIL_ORDER")->render();
		$contentVarianty .= '<p class="desc">Pod tímto účtem budou odesílány objednávky.</p><br />';
		$contentVarianty .= $form->getElement("EMAIL_ORDER_ALIAS")->render();
		$contentVarianty .= '<p class="desc">Bude uveden vedle emailové adresy. Např.: <strong>Karel Novák</strong> (info@eshop.com)</p><br />';


		return $contentVarianty;

	}

	protected function ProductsTabs()
	{

		$eshopSettings = G_EshopSetting::instance();

		$form = $this->form;

		$contentParametry = '';
		$contentParametry .= '<div class="row">';

		$contentParametry .= '<div class="col-sm-6">';
		$contentParametry .= $form->getElement("NEXTID_PRODUCT")->render();
		$contentParametry .= '</div>';

		$contentParametry .= '<div class="col-sm-6">';
		$contentParametry .= $form->getElement("PRODUCT_NEXTID_AUTO")->render();
    $contentParametry .= '</div>';
                         /*
		$contentParametry .= '</div>';

		$contentParametry .= '<div class="row">';   */
		$contentParametry .= '<div class="col-sm-12">';    
		$contentParametry .= $form->getElement("PRODUCT_VARIANTY")->render();
		$contentParametry .= '</div>';
    $contentParametry .= '<div class="col-sm-12">';  
		$contentParametry .= $form->getElement("CATEGORY_ROOT")->render();
		$contentParametry .= '</div>';


		if ($eshopSettings->get("PLATCE_DPH") == "1") {
      $contentParametry .= '<div class="col-sm-12">';  
			$contentParametry .= $form->getElement("PRICE_TAX")->render();
			$contentParametry .= '</div>';
		}
    $contentParametry .= '<div class="col-sm-12">'; 
		$contentParametry .= $form->getElement("CENIK_ID")->render();
		$contentParametry .= '</div>';

    $contentParametry .= '<div class="col-sm-12">'; 
		$contentParametry .= $form->getElement("ADD_BASKET_BEZSTAVU")->render();
    $contentParametry .= '</div>';

    $contentParametry .= '<div class="col-sm-12">'; 
		$contentParametry .= $form->getElement("FORMAT_QTY")->render();
		$contentParametry .= '</div>';
    
    $contentParametry .= '<div class="col-sm-12">';
		$contentParametry .= $form->getElement("SLCT_QTY")->render();
		$contentParametry .= '</div>';

		if ($eshopSettings->get("PLATCE_DPH") == "1") {
      $contentParametry .= '<div class="col-sm-12">';
			$contentParametry .= $form->getElement("SLCT_TAX")->render();
			$contentParametry .= '</div>';
		}
		$contentParametry .= '</div>';
    
    
    
		$contentParametry .= '<h2>Další parametry produktu</h2>';
		$contentParametry .= '<div class="row">';
		

    $contentParametry .= '<div class="col-sm-6">';
    $contentParametry .= '<fieldset class="well">';
		for ($i=1;$i<=10;$i++)
		{

			$cislo = $i;
			if ($i < 10) {
				$cislo = "0".$i;
			}

			$contentParametry .= '<div class="col-sm-2">';

			$name="CISLO" . $cislo . "_CHECK";
			$contentParametry .=  $form->getElement($name)->render();
			$contentParametry .= '</div>';
 
 			$contentParametry .= '<div class="col-sm-2">';

			$name="CISLO" . $cislo . "_SECRET";
			$contentParametry .=  $form->getElement($name)->render();
			$contentParametry .= '</div>';
           
      
			$contentParametry .= '<div class="col-sm-6">';

			$name="CISLO" . $cislo;
			$contentParametry .= $form->getElement($name)->render();
			$contentParametry .= '</div>';
            $contentParametry .= '<div class="col-sm-2">';
			$name="CISLO" . $cislo . "_ID";
			$contentParametry .=  $form->getElement($name)->render();
			$contentParametry .= '</div>';
		}
     		$contentParametry .= '</fieldset>';
		$contentParametry .= '</div>';

	//	$contentParametry .= '</div>';



//		$contentParametry .= '<div class="row">';

    $contentParametry .= '<div class="col-sm-6">';
     $contentParametry .= '<fieldset class="well">';
		for ($i=1;$i<=10;$i++)
		{

			$cislo = $i;
			if ($i < 10) {
				$cislo = "0".$i;
			}

			$contentParametry .= '<div class="col-sm-2">';

			$name="POLOZKA" . $cislo . "_CHECK";
			$contentParametry .=  $form->getElement($name)->render();
			$contentParametry .= '</div>';
      
             			$contentParametry .= '<div class="col-sm-2">';

			$name="POLOZKA" . $cislo . "_SECRET";
			$contentParametry .=  $form->getElement($name)->render();
			$contentParametry .= '</div>';
      
			$contentParametry .= '<div class="col-sm-6">';



      
      
			$name="POLOZKA" . $cislo;
			$contentParametry .= $form->getElement($name)->render();

			$contentParametry .= '</div>';
      
      
      $contentParametry .= '<div class="col-sm-2">';
			$name="POLOZKA" . $cislo . "_ID";
			$contentParametry .=  $form->getElement($name)->render();
			$contentParametry .= '</div>';

		}
    	$contentParametry .= '</fieldset>';
		$contentParametry .= '</div>';
		$contentParametry .= '</div>';
		return $contentParametry;
	}

	protected function OrdersTabs()
	{


    $eshopSettings = G_EshopSetting::instance();
		$form = $this->form;
		$contentNastaveni = '';
		$contentNastaveni .= $form->getElement("NEXTID_ORDER")->render();
		$contentNastaveni .= '<p class="desc"></p><br />';
		$contentNastaveni .= $form->getElement("EMAIL_ORDER_SUBJECT")->render();
		$contentNastaveni .= '<p class="desc">Např.: Potrvzení objednávky č.%ORDER_NUMBER%</p><br />';
		$contentNastaveni .= $form->getElement("INFO_EMAIL")->render();
		$contentNastaveni .= '<p class="desc">Emailová adresa na kterou bude zaslána informace o vystavení objednávky.</p><br />';
		$contentNastaveni .= $form->getElement("BCC_EMAIL")->render();
		$contentNastaveni .= '<p class="desc">Emailová adresa na kterou bude zaslána skrytá kopie objednávky poslané přímo zákazníkovi.</p><br />';
	
  
  
 // 	$contentNastaveni .= $form->getElement("LOGO_PDF_FILE")->render();
    
    
    
    	if (!empty($this->logo_pdf_file)) {
	//	$contentNastaveni .= '<img src="'. $this->logo_pdf_file.'"/>';
	}


//		$contentNastaveni .= '<p class="desc"></p>';


	//	return $contentNastaveni;
    
    
  //	$contentNastaveni .= $form->getElement("LOGO_PDF")->render();
    
	//	$contentNastaveni .= '<p class="desc">veřejná url včetně http://</p><br />';
	//	$value = $form->getElement("LOGO_PDF")->getValue();
	$contentNastaveni .= '<div class="row"><div class="col-sm-6">' . $form->getElement("LOGO_PDF_FILE")->render() . '</div>';
   	if ( !empty($this->logo_pdf_file)) { 
	$contentNastaveni .= '<div class="col-sm-6"><img src="' . $this->logo_pdf_file . '" /></div>'; 
  }
 	$contentNastaveni .=  '</div>'; 
  
    $contentNastaveni .= '<script>
    $("#LOGO_PDF_FILE").on("change", function (e) {
    var file = $(this)[0].files[0];
    var upload = new Upload(file,"/admin/ajax/form.php?action=OrderLogo");

    // maby check size or type here with upload.getSize() and upload.getType()

    // execute upload
    upload.doUpload();
});
   </script>';
 
 
 	$contentNastaveni .= '<div class="row"><div class="col-sm-6">' . $form->getElement("RAZITKO_PDF_FILE")->render() . '</div>' ;
   	if ( !empty($this->razitko_pdf_file)) { 
	$contentNastaveni .= '<div class="col-sm-6"><img src="' . $this->razitko_pdf_file . '" /></div>'; 
  }
 	$contentNastaveni .=  '</div>'; 
  
  
    $contentNastaveni .= '<script>
    $("#RAZITKO_PDF_FILE").on("change", function (e) {
    var file = $(this)[0].files[0];
    var upload = new Upload(file,"/admin/ajax/form.php?action=OrderRazitko");

    // maby check size or type here with upload.getSize() and upload.getType()

    // execute upload
    upload.doUpload();
});
   </script>';
   
   
             /*
		$contentNastaveni .= $form->getElement("RAZITKO_OBJ_PDF")->render();
		$contentNastaveni .= '<p class="desc">veřejná url včetně http://</p><br />';
		$value = $form->getElement("RAZITKO_OBJ_PDF")->getValue();
		if ( !empty($value) ) { $contentNastaveni .= '<dl><label></label><dt></dt><dd><img src="' . $value . '" /></dd></dl><br />'; }
                   */
                   
                   
                   
                   
    
     	$contentNastaveni .= '<div class="row"><div class="col-sm-6">' . $form->getElement("OP_PDF_FILE")->render() . '</div>' ;
   	if ( !empty($this->op_pdf_file)) { 
	$contentNastaveni .= '<div class="col-sm-6"><a target="_blank" href="' . $this->op_pdf_file . '" />obchodní podmínky</a></div>'; 
  }
 	$contentNastaveni .=  '</div>'; 
  
  
    $contentNastaveni .= '<script>
    $("#OP_PDF_FILE").on("change", function (e) {
    var file = $(this)[0].files[0];
    var upload = new Upload(file,"/admin/ajax/form.php?action=OrderOP");

    // maby check size or type here with upload.getSize() and upload.getType()

    // execute upload
    upload.doUpload();
});
   </script>';
                  
		$contentNastaveni .= $form->getElement("OP_PDF")->render();

		return $contentNastaveni;
	}

	protected function FakturyTabs()
	{
		$form = $this->form;

		$contentFaktury = '';
		$contentFaktury .= $form->getElement("NEXTID_FAKTURA")->render();
		$contentFaktury .= '<p class="desc"></p><br />';
		$contentFaktury .= $form->getElement("CISLO_FAK_OBJ")->render();
		$contentFaktury .= '<p class="desc"></p><br />';
		$contentFaktury .= $form->getElement("SPLATNOST")->render();
		$contentFaktury .= '<p class="desc">Počet dnů od vystavení dokladu. 0 = okamžitá splatnost</p><br />';

		$contentFaktury .= $form->getElement("SLEVA_DOKLAD_TISK")->render();
		$contentFaktury .= '<p class="desc"></p><br />';
                  /*
		$contentFaktury .= $form->getElement("RAZITKO_FAK_PDF")->render();
		$contentFaktury .= '<p class="desc">veřejná url včetně http://</p><br />';
		$value = $form->getElement("RAZITKO_FAK_PDF")->getValue();
		if ( !empty($value) ) { $contentFaktury .= '<dl><label></label><dt></dt><dd><img src="' . $value . '" /></dd></dl><br />'; }  */
		return $contentFaktury;

	}

	protected function PlatbyTabs()
	{
		$form = $this->form;

		$contentPlatby = '';
    
    
    		
				

        
          $contentPlatby .= '<img src="/admin/images/logo_gpwebpay.jpg" style="height: 50px;">';  
    		$contentPlatby .= '<fieldset class="well">';

		$contentPlatby .= '<p class="alert alert-info">Nastavení platební brány gpwebpay <a target="_blank" href="http://gpwebpay.cz/">gpwebpay.cz</a></p>';
		$contentPlatby .= $form->getElement("GPWP_TEST")->render();
		$contentPlatby .= '<p class="desc"></p><br />';

		$contentPlatby .= $form->getElement("GPWP_MERCHANT")->render();

    $contentPlatby .= '<div class="row">';
    $contentPlatby .= '<div class="col-md-4">';
		$contentPlatby .= $form->getElement("GPWP_PUBLIC_KEY")->render();
    $contentPlatby .= '</div>';
    $contentPlatby .= '<div class="col-md-4">';
    $contentPlatby .= $form->getElement("GPWP_PRIVATE_KEY")->render();
    $contentPlatby .= '</div>';
    $contentPlatby .= '<div class="col-md-4">';
		$contentPlatby .= $form->getElement("GPWP_SECRET")->render();
    $contentPlatby .= '</div>';
    $contentPlatby .= '</div>';
                                         
    $contentPlatby .= '<div class="row">';
    $contentPlatby .= '<div class="col-md-4">';   
		$contentPlatby .= $form->getElement("GPWP_PUBLIC_KEY_TEST")->render();
    $contentPlatby .= '</div>';
    $contentPlatby .= '<div class="col-md-4">';
    $contentPlatby .= $form->getElement("GPWP_PRIVATE_KEY_TEST")->render();
    $contentPlatby .= '</div>';
    $contentPlatby .= '<div class="col-md-4">';
		$contentPlatby .= $form->getElement("GPWP_SECRET_TEST")->render();
    $contentPlatby .= '</div>';
    
    
        $contentPlatby .= '<div class="col-md-12">';
		$contentPlatby .= 'Test. číslo karty: <strong>4056070000000008</strong>, Platnost karty: <strong>12/2020</strong>, CVC2: <strong>200</strong>';
    $contentPlatby .= '</div>';
    
    $contentPlatby .= '</div>';
		$contentPlatby .= '</fieldset>';
    
    $contentPlatby .= '<img src="/admin/images/comgate.png" style="height: 50px;">';    
    
		$contentPlatby .= '<fieldset class="well">';

		$contentPlatby .= '<p class="alert alert-info">Nastavení platební brány ComGate <a target="_blank" href="http://www.comgate.cz">comgate.cz</a></p>';
		$contentPlatby .= $form->getElement("AGMO_TEST")->render();
		$contentPlatby .= '<p class="desc"></p><br />';

		$contentPlatby .= $form->getElement("AGMO_MERCHANT")->render();
		$contentPlatby .= '<p class="desc"></p><br />';
		$contentPlatby .= $form->getElement("AGMO_SECRET")->render();
		$contentPlatby .= '<p class="desc"></p><br />';

		$contentPlatby .= '</fieldset>';

    /*
		$contentPlatby .= '<fieldset class="well">';
		$contentPlatby .= '<p class="alert alert-info">Nastavení platební brány PayU <a target="_blank" href="http://www.payu.cz">payu.cz</a></p>';
		$contentPlatby .= $form->getElement("PAYU_POS_ID")->render();
		$contentPlatby .= '<p class="desc"></p><br />';

		$contentPlatby .= $form->getElement("PAYU_KEY1")->render();
		$contentPlatby .= '<p class="desc"></p><br />';
		$contentPlatby .= $form->getElement("PAYU_KEY2")->render();
		$contentPlatby .= '<p class="desc"></p><br />';
		$contentPlatby .= '</fieldset>';
    */
		return $contentPlatby;

	}
  protected function FaviTabs()
	{
		$form = $this->form;
    $eshopSettings = G_EshopSetting::instance();
    $settings = G_Setting::instance();
    
    $contentNastaveni = '';
    $contentNastaveni .= '<img src="/admin/images/favicz.png" style="height: 50px;">';       
  	$contentNastaveni .= '<fieldset class="well">';

             
              
    
    $contentNastaveni .= '<div class="row">';
    $contentNastaveni .= '<div class="col-sm-12">';
    $contentNastaveni .= $form->getElement("FAVI_EXPORT_CRON")->render();
    $contentNastaveni .= '</div>';
    
    $contentNastaveni .= '<div class="col-sm-6">';
    $contentNastaveni .= $form->getElement("FAVI_KOD_DOPRAVCE")->render();
    $contentNastaveni .= '</div>';
    $contentNastaveni .= '<div class="col-sm-6">';
    $contentNastaveni .= $form->getElement("FAVI_CENA_DOPRAVCE")->render();
    $contentNastaveni .= '</div>';
    $contentNastaveni .= '<div class="col-sm-3">';
		$contentNastaveni .= '<button name="faviProductFeed" type="submit" class="btn btn-info">Exportovat</button> ';
		$contentNastaveni .= '</div>';    
    $contentNastaveni .= '<div class="col-sm-9">';

    if ($eshopSettings->get("FAVI_XML_DATE") != "")
    {
      $url =  $settings->get("URL_HOME") . "export/favicz.xml";
      $contentNastaveni .= '<span class="label label-info">'.date("j.n.Y H:i:s",strtotime($eshopSettings->get("FAVI_XML_DATE"))).'</span> ';  
      $contentNastaveni .= '<a target="_blank" href="'.$url.'" class="">'.$url.'</a> ';
    }
  
		$contentNastaveni .= '</div>';
		$contentNastaveni .= '</div>';
    $contentNastaveni .= '</fieldset>';  
    return $contentNastaveni;
  }
	protected function ZboziCzTabs()
	{
		$form = $this->form;
    $eshopSettings = G_EshopSetting::instance();
    $settings = G_Setting::instance();
    
    $contentNastaveni = '';
    
        $contentNastaveni .= '<img src="/admin/images/zbozicz.png" style="height: 50px;">';
        
  	$contentNastaveni .= '<fieldset class="well">';
       
    $contentNastaveni .= $form->getElement("ZBOZICZ_EXPORT_CRON")->render();
              
    $contentNastaveni .= '<div class="col-sm-3">';  
		$contentNastaveni .= '<button name="zboziProductFeed" type="submit" class="btn btn-info">Exportovat</button> ';
		$contentNastaveni .= '</div>';    
    $contentNastaveni .= '<div class="col-sm-9">';

    if ($eshopSettings->get("ZBOZICZ_XML_DATE") != "")
    {
      $url =  $settings->get("URL_HOME") . "export/zbozicz.xml";
      $contentNastaveni .= '<span class="label label-info">'.date("j.n.Y H:i:s",strtotime($eshopSettings->get("ZBOZICZ_XML_DATE"))).'</span> ';  
      $contentNastaveni .= '<a target="_blank" href="'.$url.'" class="">'.$url.'</a> ';
    }
  
		$contentNastaveni .= '</div>';  
    $contentNastaveni .= '</fieldset>';  
    return $contentNastaveni;
  }

	protected function HeurekaTabs()
	{
		$form = $this->form;
$eshopSettings = G_EshopSetting::instance();
$settings = G_Setting::instance();

$contentNastaveni = '';
	
				$contentNastaveni .= '<img src="/admin/images/heureka.jpg" style="height: 50px;">';

        	$contentNastaveni .= '<fieldset class="well">';
        	$contentNastaveni .= '<h2>Služba - Ověřeno zákazníky</h2>';
		$contentNastaveni .= $form->getElement("HEUREKA_ENABLED")->render();
		$contentNastaveni .= '<p class="desc">Aktivní zasílání objednávek pro ověření spokojenosti zákazníka</p><br />';


		$contentNastaveni .= $form->getElement("HEUREKA_CODE")->render();
		$contentNastaveni .= '<p class="desc">Tajný klíč pro komunikaci ze službou Heureka.cz</p><br />';
            	$contentNastaveni .= '</fieldset>';
    	$contentNastaveni .= '<fieldset class="well">';
      $contentNastaveni .= '<h2>Recenze heureky</h2>';
		$contentNastaveni .= $form->getElement("HEUREKA_RECENZE_CRON")->render();
    		$contentNastaveni .= $form->getElement("heureka-import")->render();
     
         	$contentNastaveni .= '</fieldset>';
     	$contentNastaveni .= '<fieldset class="well">';   
      $contentNastaveni .= '<h2>Export produktů</h2>';
		$contentNastaveni .= $form->getElement("HEUREKA_EXPORT_CRON")->render();
    
//		$contentNastaveni .= '<p class="desc">'.date("j.n.Y H:i:s",strtotime($eshopSettings->get("HEUREKA_CRON_DATE"))).'</p><br />';


    $contentNastaveni .= '<div class="col-sm-3">';
		$contentNastaveni .= '<button name="heurekaProductFeed" type="submit" class="btn btn-info">Exportovat</button> ';

		$contentNastaveni .= '</div>';    
    $contentNastaveni .= '<div class="col-sm-9">';

    if ($eshopSettings->get("HEUREKA_XML_DATE") != "")
    {
      $url =  $settings->get("URL_HOME") . "export/heurekacz.xml";
      $contentNastaveni .= '<span class="label label-info">'.date("j.n.Y H:i:s",strtotime($eshopSettings->get("HEUREKA_XML_DATE"))).'</span> ';  
      $contentNastaveni .= '<a target="_blank" href="'.$url.'" class="">'.$url.'</a> ';
    }
  
		$contentNastaveni .= '</div>';  
		$contentNastaveni .= '</fieldset>';
    
    return $contentNastaveni;
}
	protected function PohodaTabs()
	{
		$form = $this->form;
$eshopSettings = G_EshopSetting::instance();
$settings = G_Setting::instance();

		$contentMain = '';
    
    		$contentMain .= '<img src="/admin/style/images/stormwarePohodaLogo.png">';
        
		$contentMain .= '<fieldset class="well">';

		$contentMain .= '<h2>Export Objednávek</h2>';

		$contentMain .= '<div class="alert alert-info">Vygeneruje datový soubor objednávek z eshopu pro import do Pohody</div>';
      $contentMain .= '<div class="row">';
      $contentMain .= '<div class="col-sm-9">';                   
                              
         					$contentMain .= '<div class="row">';

			$contentMain .= '<div class="col-sm-3">';
		$contentMain .= $form->getElement("POHODA_OBJ_XML_FDATE")->render();
		$contentMain .= '</div>';

		$contentMain .= '<div class="col-sm-3">';
		$contentMain .= $form->getElement("POHODA_OBJ_XML_TDATE")->render();
	$contentMain .= '</div>';
  
  			$contentMain .= '<div class="col-sm-3">';
		$contentMain .= $form->getElement("POHODA_OBJ_XML_FCODE")->render();
		$contentMain .= '</div>';

		$contentMain .= '<div class="col-sm-3">';
		$contentMain .= $form->getElement("POHODA_OBJ_XML_TCODE")->render();
	$contentMain .= '</div>';

			$contentMain .= '</div>';
      	$contentMain .= '</div>';
                                             
    $contentMain .= '<div class="col-sm-3">';
		$contentMain .= $form->getElement("POHODA_OBJ_XML_STAV")->render();
	//	$contentMain .= '<button name="pohodaOrderFeed" type="submit" class="btn btn-info">Exportovat</button> ';
		$contentMain .= '</div>';
    
    
    $contentMain .= '<div class="col-sm-3">';
		$contentMain .= '<button name="pohodaOrderFeed" type="submit" class="btn btn-info">Exportovat</button> ';
		$contentMain .= '</div>';    
    $contentMain .= '<div class="col-sm-9">';

    if ($eshopSettings->get("POHODA_OBJ_XML_DATE") != "")
    {
      $url =  $settings->get("URL_HOME") . "export/pohoda_export_objednavky.xml";
      $contentMain .= '<span class="label label-info">'.date("j.n.Y H:i:s",strtotime($eshopSettings->get("POHODA_OBJ_XML_DATE"))).'</span> ';  
      $contentMain .= '<a target="_blank" href="'.$url.'" class="">'.$url.'</a> ';
    }
  
		$contentMain .= '</div>';  
    $contentMain .= '</div>';

    $contentMain .= '</fieldset>';
        
        
		$contentMain .= '<fieldset class="well">';
	//	$contentMain .= '<img src="/admin/style/images/stormwarePohodaLogo.png">';
		$contentMain .= '<h2>Export Faktur</h2>';

		$contentMain .= '<div class="alert alert-info">Vygeneruje datový soubor faktur z eshopu pro import do Pohody</div>';
      $contentMain .= '<div class="row">';
      $contentMain .= '<div class="col-sm-9">';                   
                              
         					$contentMain .= '<div class="row">';

			$contentMain .= '<div class="col-sm-3">';
		$contentMain .= $form->getElement("POHODA_FAK_XML_FDATE")->render();
		$contentMain .= '</div>';

		$contentMain .= '<div class="col-sm-3">';
		$contentMain .= $form->getElement("POHODA_FAK_XML_TDATE")->render();
	$contentMain .= '</div>';
  
  			$contentMain .= '<div class="col-sm-3">';
		$contentMain .= $form->getElement("POHODA_FAK_XML_FCODE")->render();
		$contentMain .= '</div>';

		$contentMain .= '<div class="col-sm-3">';
		$contentMain .= $form->getElement("POHODA_FAK_XML_TCODE")->render();
	$contentMain .= '</div>';

			$contentMain .= '</div>';
      	$contentMain .= '</div>';
             /*                                
    $contentMain .= '<div class="col-sm-3">';
		$contentMain .= $form->getElement("POHODA_OBJ_XML_STAV")->render();
	//	$contentMain .= '<button name="pohodaOrderFeed" type="submit" class="btn btn-info">Exportovat</button> ';
		$contentMain .= '</div>';
              */
        $contentMain .= '</div>';
        

    $contentMain .= '<div class="row">';
    



    $contentMain .= '<div class="col-sm-3">';
		$contentMain .= '<button name="pohodaFakturyFeed" type="submit" class="btn btn-info">Exportovat</button> ';
		$contentMain .= '</div>';    
    $contentMain .= '<div class="col-sm-9">';

    if ($eshopSettings->get("POHODA_OBJ_XML_DATE") != "")
    {
      $url =  $settings->get("URL_HOME") . "export/pohoda_export_faktury.xml";
      $contentMain .= '<span class="label label-info">'.date("j.n.Y H:i:s",strtotime($eshopSettings->get("POHODA_FAK_XML_DATE"))).'</span> ';  
      $contentMain .= '<a target="_blank" href="'.$url.'" class="">'.$url.'</a> ';
    }
  
		$contentMain .= '</div>';
		$contentMain .= '</div>';


    $contentMain .= '</fieldset>';        
        
   		$contentMain .= '<fieldset class="well">';     
        
    		$contentMain .= '<h2>Export produktů</h2>';
    $contentMain .= '<div class="alert alert-info">Vygeneruje datový soubor produktů z eshopu pro import do  Pohody</div>';
               $contentMain .= '<div class="row">';
    
    		$contentMain .= '<div class="col-sm-3">';
		$contentMain .= $form->getElement("POHODA_ZBOZI_XML_SKLAD")->render();
	$contentMain .= '</div>';
		$contentMain .= '</div>';  
     
      $contentMain .= '<div class="row">';
             			$contentMain .= '<div class="col-sm-3">';
		$contentMain .= '<button name="pohodaProductFeed" type="submit" class="btn btn-info">Exportovat</button> ';
		$contentMain .= '</div>';    
               			$contentMain .= '<div class="col-sm-9">';

  if ($eshopSettings->get("POHODA_ZBOZI_XML_DATE") != "")
  {
    $url =  $settings->get("URL_HOME") . "export/pohoda_export_produkty.xml";
		  
          $contentMain .= '<span class="label label-info">'.date("j.n.Y H:i:s",strtotime($eshopSettings->get("POHODA_ZBOZI_XML_DATE"))).'</span> ';  
		$contentMain .= '<a target="_blank" href="'.$url.'" class="">'.$url.'</a> ';
  }

		$contentMain .= '</div>'; 
    $contentMain .= '</div>'; 
    $contentMain .= '</fieldset>';

    	$contentMain .= '<fieldset class="well">';     
        
    		$contentMain .= '<h2>Export obrázků produktů</h2>';
    $contentMain .= '<div class="alert alert-info">Vygeneruje archiv s obrázky produktů eshopu pro import do  Pohody</div>';
    
    
             			$contentMain .= '<div class="col-sm-3">';
		$contentMain .= '<button name="productImagesZip" type="submit" class="btn btn-info">Exportovat</button> ';
		$contentMain .= '</div>';    
               			$contentMain .= '<div class="col-sm-9">';

  if ($eshopSettings->get("PRODUCT_IMG_ZIP_DATE") != "")
  {
    $url =  $settings->get("URL_HOME") . "export/product_images.zip";
		  
          $contentMain .= '<span class="label label-info">'.date("j.n.Y H:i:s",strtotime($eshopSettings->get("PRODUCT_IMG_ZIP_DATE"))).'</span> ';  
		$contentMain .= '<a target="_blank" href="'.$url.'" class="">'.$url.'</a> ';
  }

		$contentMain .= '</div>';  
    $contentMain .= '</fieldset>';

    		$contentMain .= '<h2>Propojení eshopu s Pohodou</h2>';
    $contentMain .= '<div class="alert alert-info">Vygeneruje datový soubor produktů z eshopu pro import do  Pohody</div>';
    
    

             					$contentMain .= '<div class="row">';

			$contentMain .= '<div class="col-sm-3">';
		$contentMain .= $form->getElement("POHODA_EXP_USER")->render();
		$contentMain .= '</div>';

		$contentMain .= '<div class="col-sm-3">';
		$contentMain .= $form->getElement("POHODA_EXP_PWD")->render();
	$contentMain .= '</div>';
  
		$contentMain .= '</div>';  
    
            $url =  $settings->get("URL_HOME") . "export/pohoda.php";
    
    $contentMain .= '<div class="row">';
    $contentMain .= '<div class="col-sm-12">';   
    $contentMain .= '<p>';
    $contentMain .= '<span class="">Adresa exportu: </span> ';
    
    $contentMain .= '<a target="_blank" href="'.$url.'" class="">'.$url.'</a> ';
     $contentMain .= '</p>';
    $contentMain .= '</div>';  
		$contentMain .= '</div>';
    
    $contentMain .= '</fieldset>';
    
        
		return $contentMain;

	}
	protected function SkladTabs()
	{
		$form = $this->form;

		$contentFaktury = '';
		$contentFaktury .= $form->getElement("SKLAD_AKTIVNI")->render();
		$contentFaktury .= '<p class="desc"></p><br />';
		$contentFaktury .= $form->getElement("SKLAD_BLOKACE")->render();
		$contentFaktury .= '<p class="desc"></p><br />';
		return $contentFaktury;

	}

	protected function ZobrazeniTabs()
	{
		$form = $this->form;

		$contentFaktury = '';

		$contentFaktury .= $form->getElement("ESHOP_CATEGORY_LIST")->render();
	//	$contentFaktury .= '<p class="desc"></p><br />';

		$contentFaktury .= '<div class="well">';
		$contentFaktury .= '<fieldset>';
		$contentFaktury .= '<legend>Výpis produktů</legend>';
		$contentFaktury .= $form->getElement("PRODUCT_LIST_TYPE")->render();


		$contentFaktury .= $form->getElement("PRODUCT_FILTER")->render();
	//	$contentFaktury .= '<p class="desc"></p><br />';
		$contentFaktury .= $form->getElement("PRODUCT_LIST_LIMIT")->render();
		$contentFaktury .= $form->getElement("ROW_PRODUCT_COUNT")->render();
	//	$contentFaktury .= '<p class="desc"></p><br />';



		$contentFaktury .= '<div class="row">';
		$contentFaktury .= '<div class="col-xs-6">';
		$contentFaktury .= $form->getElement("PRODUCT_THUMB_WIDTH")->render();
		//$contentFaktury .= '<p class="desc"></p>';
		$contentFaktury .= '</div>';
		$contentFaktury .= '<div class="col-xs-6">';
		$contentFaktury .= $form->getElement("PRODUCT_THUMB_HEIGHT")->render();
		//$contentFaktury .= '<p class="desc"></p>';
		$contentFaktury .= '</div>';
		$contentFaktury .= '</div>';

		$contentFaktury .= '</fieldset>';
		$contentFaktury .= '</div>';


		$contentFaktury .= $form->getElement("PAGE_PODCATEGORY")->render();
		$contentFaktury .= '<p class="desc"></p><br />';

		$contentFaktury .= '<h2>Nákupní košík</h2>';
		$contentFaktury .= '<div class="well">';
		$contentFaktury .= '<fieldset>';

		$contentFaktury .= $form->getElement("ADD_BASKET_DETAIL")->render() . '';
//		$contentFaktury .= '<p class="desc"></p><br />';

		$contentFaktury .= $form->getElement("ADD_BASKET_LIST")->render() . '';
    
		$contentFaktury .= $form->getElement("BASKET_REDIRECT")->render() . '';
//		$contentFaktury .= '<p class="desc"></p><br />';

		$contentFaktury .= '</fieldset>';
		$contentFaktury .= '</div>';


		$contentFaktury .= '<div class="well">';
		$contentFaktury .= '<fieldset>';
		$contentFaktury .= '<legend>Nastavení slideru</legend>';


		$contentFaktury .= '<div class="row">';
		$contentFaktury .= '<div class="col-xs-4">';
		$contentFaktury .= $form->getElement("ESHOP_SLIDER_POS")->render();
		$contentFaktury .= '<p class="desc"></p>';
		$contentFaktury .= '</div>';
		$contentFaktury .= '<div class="col-xs-4">';

		$contentFaktury .= $form->getElement("ESHOP_SLIDER_PAGE")->render();
		$contentFaktury .= '<p class="desc"></p>';
		$contentFaktury .= '</div>';
		$contentFaktury .= '<div class="col-xs-4">';

		$contentFaktury .= $form->getElement("SLIDER_CATEGORY")->render();

		$contentFaktury .= '</div>';
		$contentFaktury .= '</div>';

		$contentFaktury .= $form->getElement("SLIDER_CATEGORY_LIMIT")->render();
		$contentFaktury .= '<p class="desc"></p>';




		$contentFaktury .= '<div class="row">';
		$contentFaktury .= '<div class="col-xs-6">';
		$contentFaktury .= $form->getElement("ESHOP_SLIDER_WIDTH")->render();
		$contentFaktury .= '<p class="desc"></p>';
		$contentFaktury .= '</div>';
		$contentFaktury .= '<div class="col-xs-6">';
		$contentFaktury .= $form->getElement("ESHOP_SLIDER_HEIGHT")->render();
		$contentFaktury .= '<p class="desc"></p>';
		$contentFaktury .= '</div>';
		$contentFaktury .= '</div>';
		$contentFaktury .= '</fieldset>';
		$contentFaktury .= '</div>';



		$contentFaktury .= '<div class="row">';
		$contentFaktury .= '<div class="col-xs-6">';
		$contentFaktury .= $form->getElement("LEFT_PANEL_ON")->render();
		$contentFaktury .= '<p class="desc"></p>';
		$contentFaktury .= $form->getElement("LEFT_PANEL_SLIM")->render();
		$contentFaktury .= '<p class="desc"></p>';
		$contentFaktury .= $form->getElement("SHOP_LEFT_PANEL_SLIM")->render();
		$contentFaktury .= '<p class="desc"></p>';

		$contentFaktury .= '</div>';
		$contentFaktury .= '<div class="col-xs-6">';
		$contentFaktury .= $form->getElement("RIGHT_PANEL_ON")->render();
		$contentFaktury .= '<p class="desc"></p>';
		$contentFaktury .= $form->getElement("RIGHT_PANEL_SLIM")->render();
		$contentFaktury .= '<p class="desc"></p>';
		$contentFaktury .= $form->getElement("SHOP_RIGHT_PANEL_SLIM")->render();
		$contentFaktury .= '<p class="desc"></p>';

		$contentFaktury .= '</div>';
		$contentFaktury .= '</div>';





		$contentFaktury .= $form->getElement("MSG_NENALEZENO")->render() . '';
		$contentFaktury .= '<p class="desc"></p><br />';


		$contentFaktury .= $form->getElement("ESHOP_MENU_POS")->render() . '';
		$contentFaktury .= $form->getElement("PRODUCT_AKCE_POS")->render() . '';
		$contentFaktury .= $form->getElement("PRODUCT_HISTORY_POS")->render() . '';
		$contentFaktury .= $form->getElement("ESHOP_TEMPLATE")->render() . '';
		$contentFaktury .= $form->getElement("LOGO_MENU")->render() . '';
		$contentFaktury .= '<p class="desc"></p>';
		return $contentFaktury;

	}

	public function makeTabs($tabs = array()) {
		array_push($tabs, array("name" => "Main", "title" => 'Hlavní',"content" => $this->MainTabs()));
		array_push($tabs, array("name" => "Mail", "title" => 'Pošta',"content" => $this->MailTabs()));
		array_push($tabs, array("name" => "Produkty", "title" => "Produkty","content" => $this->ProductsTabs()));
		array_push($tabs, array("name" => "Orders", "title" => "Objednávky","content" => $this->OrdersTabs()));

		array_push($tabs, array("name" => "Faktury", "title" => 'Faktury',"content" => $this->FakturyTabs()));
		array_push($tabs, array("name" => "Platby", "title" => 'Platby',"content" => $this->PlatbyTabs()));
		array_push($tabs, array("name" => "ZboziCz", "title" => 'Zboží.cz',"content" => $this->ZboziCzTabs()));
		array_push($tabs, array("name" => "Pohoda", "title" => "Pohoda","content" => $this->PohodaTabs()));
		array_push($tabs, array("name" => "Heureka", "title" => "Heureka.cz","content" => $this->HeurekaTabs()));
		array_push($tabs, array("name" => "Favi", "title" => "Favi.cz","content" => $this->FaviTabs()));
		array_push($tabs, array("name" => "Sklad", "title" => "Sklad","content" => $this->SkladTabs()));
		array_push($tabs, array("name" => "Zobrazeni", "title" => "Zobrazení","content" => $this->ZobrazeniTabs()));
		return parent::makeTabs($tabs);
	}
}

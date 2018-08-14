<?php

class ObjednavkaTabs extends G_Tabs {

	protected $form;
	protected $radkyTab;
	public function __construct($pageForm, $radkyTab = true)
	{
		$this->form = $pageForm;
		$this->radkyTab = $radkyTab;
	}


	protected function MainTab()
	{

		$form = $this->form;
    
    

    
    
		$contentMain = '';
		$contentMain .= '<div class="row">';
		$contentMain .= '<div class="col-xs-3">';
		$contentMain .= $form->getElement("code")->render();
		if ($form->getElement("id")) {

			$contentMain .= $form->getElement("id")->render();

		//	$contentMain .=' <a target="_blank" href="' . URL_HOME . 'orders_pdf.php?id=' . $form->getElement("id")->getValue(). '">Tisk PDF</a>';
		}
    
    
    

		$contentMain .= '</div>';
		$contentMain .= '<div class="col-xs-3">';

		$contentMain .= $form->getElement("stav")->render();
		$contentMain .= '<p class="desc">Stav zpracování objednávky.</p>';
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-xs-3">';
		$contentMain .= $form->getElement("order_date")->render();
		$contentMain .= '<p class="desc">Datum přijetí objednávky.</p>';
		$contentMain .= '</div>';

		$contentMain .= '<div class="col-xs-3">';
		$contentMain .= $form->getElement("shipping_pay")->render();
		$contentMain .= '<p class="desc"></p>';
		$contentMain .= '</div>';

		$contentMain .= '</div>';

		$contentMain .= '<div class="row">';
		$contentMain .= '<div class="col-xs-3">';

		$contentMain .= $form->getElement("shipping_transfer")->render();
    /*if (!empty($form->doklad->kod_dopravce))
    {
        $contentMain .= '<p class="desc"><img style="height:25px;" src="/admin/style/images/' . strtolower($form->doklad->kod_dopravce) . '.png" /></p>';
    }  */
    
		$contentMain .= '</div>';


    		$contentMain .= '<div class="col-xs-3">';

	//	$contentMain .= $form->getElement("kod_dopravce")->render();
    
    		$contentMain .= '	<div class="form-group"><label for="" class="control-label">Dopravce</label>
		<input class="textbox form-control" name="" value="' . $form->doklad->kod_dopravce . '" disabled type="text"></div>';

	//	$contentMain .= '</div>';
    
    if (!empty($form->doklad->kod_dopravce))
    {
        $contentMain .= '<p class="desc"><img style="height:25px;" src="/admin/style/images/' . strtolower($form->doklad->kod_dopravce) . '.png" /></p>';
    }
    
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-xs-3">';
		$contentMain .= $form->getElement("barcode")->render() . '';
    
    
            $zasilka_link = "";
    
    switch($form->doklad->kod_dopravce)
    {
      case "CPOST" :
        $zasilka_link = "http://www.ceskaposta.cz/cz/nastroje/sledovani-zasilky.php?locale=CZ&go=ok&barcode=";
      break; 
      case "FOFR" :
        $zasilka_link = "https://objednavky.fofrcz.cz/index.php?id=sledovani&rok=2018&shipment_num=";
      break; 
      case "DPD" :
        $zasilka_link = "https://tracking.dpd.de/parcelstatus?locale=cs_CZ&Tracking=Sledovat&query=";
      break; 
    }

    		$contentMain .= '<p class="desc"><a target="_blank" href="' . $zasilka_link . $form->getElement("barcode")->getValue(). '">Sledovat zásilku ' . $form->getElement("barcode")->getValue(). '</a></p>';
            $contentMain .= '</div>';
    		$contentMain .= '<div class="col-xs-3">';

		$contentMain .= '	<div class="form-group"><label for="" class="control-label">Faktura</label>
		<input class="textbox form-control" name="" value="' . $form->doklad->faktura_code . '" disabled type="text"></div>';

		$contentMain .= '</div>';
    
    
		$contentMain .= '</div>';


		$contentMain .= '<div class="row">';
		$contentMain .= '<div class="col-xs-12">';

		$contentMain .= $form->getElement("description")->render();
		$contentMain .= '</div>';

		$contentMain .= '</div>';

		return $contentMain;
	}
  
  
  protected function RadkyTab()
	{
		$form = $this->form;
    
    
    		$form = $this->form;
        $contentVarianty = '';
        /*
		$contentVarianty .='<div class="row">';
    
    		$contentVarianty .='<div class="col-sm-3">';
		$contentVarianty .= $form->getElement("dostupnost_id")->render();
		$contentVarianty .='</div>';
    
		$contentVarianty .='<div class="col-sm-3">';
   
   		$contentVarianty .=$form->getElement("stav_qty")->render();
    
    	$contentVarianty .='</div>';
      
      
      		$contentVarianty .='<div class="col-sm-3">';
   
   		$contentVarianty .=$form->getElement("stav_qty_min")->render() ;
    
    	$contentVarianty .='</div>';
      
      
      		$contentVarianty .='<div class="col-sm-3">';
   
   		$contentVarianty .=$form->getElement("stav_qty_max")->render() ;
    
    	$contentVarianty .='</div>';
      
      	$contentVarianty .='</div>';  */
    
    
		$args = new ListArgs();
		$args->doklad_id = (int) $form->doklad_id;
    
		$args->isDeleted = 0;
		$args->lang = LANG_TRANSLATOR;
		$args->limit = 10000;
		//$args->orderBy = 't1.order ASC, t1.TimeStamp ASC';

		$DataGridProvider = new DataGridProvider("RadekObjednavky", $args);
		$DataGridProvider->setModalForm();
  
	//	$contentVarianty = $DataGridProvider->addButton("Nová", '/admin/sortiment?do=variantyCreate&id='.$form->page_id);

		//	$contentVarianty = '<a id="dg-add-form" href="#" data-url="/admin/sortiment?do=variantyCreate&id='.$form->page_id.'" class="btn btn-sm btn-info">Nová</a>';
		$contentVarianty .= $DataGridProvider->ajaxtable();
		/*	$form = $this->form;
		   $Variantyform = new ProductVariantyForm();
		   $contentVarianty = $Variantyform->tableRender();
		*/

		return $contentVarianty;

	}

	protected function FakturacniTab()
	{
		$form = $this->form;
		$contentFak = '';
		$contentFak .= '<div class="row">';
		$contentFak .= '<div class="col-xs-6">';
		$contentFak .= $form->getElement("shipping_first_name")->render();
		$contentFak .= '<p class="desc"></p>';
		$contentFak .= '</div>';

		$contentFak .= '<div class="col-xs-6">';
		$contentFak .= $form->getElement("shipping_last_name")->render();
		$contentFak .= '<p class="desc"></p>';
		$contentFak .= '</div>';
		$contentFak .= '</div>';

		$contentFak .= '<div class="row">';
		$contentFak .= '<div class="col-xs-4">';

		$contentFak .= $form->getElement("shipping_address_1")->render();
		$contentFak .= '<p class="desc"></p>';
		$contentFak .= '</div>';

		$contentFak .= '<div class="col-xs-4">';
		$contentFak .= $form->getElement("shipping_city")->render();
		$contentFak .= '<p class="desc"></p>';
		$contentFak .= '</div>';

		$contentFak .= '<div class="col-xs-4">';

		$contentFak .= $form->getElement("shipping_zip_code")->render();
		$contentFak .= '<p class="desc"></p>';

		$contentFak .= '</div>';
		$contentFak .= '</div>';

		$contentFak .= '<div class="row">';
		$contentFak .= '<div class="col-xs-6">';
	//	$contentFak .= $form->getElement("shipping_ico")->render();
    $contentFak .= $form->getElement("shipping_ico")->render() . ' <a href="#" class="ares btn btn-info">Dotažení partenra z Ares</a>';
		$contentFak .= '<p class="desc"></p>';
		$contentFak .= '</div>';

		$contentFak .= '<div class="col-xs-6">';
		$contentFak .= $form->getElement("shipping_dic")->render();
		$contentFak .= '<p class="desc"></p>';
		$contentFak .= '</div>';

		$contentFak .= '<div class="col-xs-6">';
		$contentFak .= $form->getElement("shipping_phone")->render();
		$contentFak .= '<p class="desc"></p>';
		$contentFak .= '</div>';

		$contentFak .= '<div class="col-xs-6">';
		$contentFak .= $form->getElement("shipping_email")->render();
		$contentFak .= '<p class="desc"></p>';
		$contentFak .= '</div>';

		$contentFak .= '</div>';





		return $contentFak;

	}

	// TODO - přepracovat na asynchronní dotažení v případě přepnutí na záložku
	protected function DodaciTab()
	{
		$form = $this->form;
		$contentDod = '';
		$contentDod .= $form->getElement("shipping_first_name2")->render();
		$contentDod .= '<p class="desc"></p>';
		$contentDod .= $form->getElement("shipping_first_name2")->render();
		$contentDod .= '<p class="desc"></p>';
		$contentDod .= $form->getElement("shipping_address_12")->render();
		$contentDod .= '<p class="desc"></p>';
		$contentDod .= $form->getElement("shipping_city2")->render();
		$contentDod .= '<p class="desc"></p>';
		$contentDod .= $form->getElement("shipping_zip_code2")->render();
		$contentDod .= '<p class="desc"></p>';
		return $contentDod;

	}

	protected function InterniTab()
	{
		$form = $this->form;
		$contentInt = '';

		$contentInt .= '<div class="row">';
		$contentInt .= '<div class="col-xs-3">';

		$contentInt .= '	<div class="form-group"><label for="" class="control-label">Vytvořena</label>
		<input class="textbox form-control" name="" value="' . date("j.n.Y H:i:s",strtotime($form->doklad->TimeStamp)) . '" disabled type="text"></div>';

		$contentInt .= '</div>';

		$contentInt .= '<div class="col-xs-3">';

		$contentInt .= '	<div class="form-group"><label for="" class="control-label">Poslední změna</label>
		<input class="textbox form-control" name="" value="' . date("j.n.Y H:i:s",strtotime($form->doklad->ChangeTimeStamp)) . '" disabled type="text"></div>';

		$contentInt .= '</div>';

		$contentInt .= '<div class="col-xs-3">';


		$contentInt .= '	<div class="form-group"><label for="" class="control-label">IP adresa</label>
		<input class="textbox form-control" name="" value="' . ($form->doklad->ip_address) . '" disabled type="text"></div>';
		$contentInt .= '</div>';

		$contentInt .= '<div class="col-xs-3">';


		$contentInt .= '	<div class="form-group"><label for="" class="control-label">Uživatel</label>
		<input class="textbox form-control" name="" value="' . ($form->doklad->nick) . '" disabled type="text"></div>';
		$contentInt .= '</div>';
		$contentInt .= '</div>';






		$contentInt .= $form->getElement("description_secret")->render();
		$contentInt .= '<p class="desc"></p><br />';

		return $contentInt;

	}

 	protected function HeurekaTab()
	{
		$form = $this->form;
		$contentInt = '';






		$contentInt .= '<div class="row">';
		$contentInt .= '<div class="col-xs-4">';

		$contentInt .= '	<div class="form-group"><label for="" class="control-label">Celkové hodnocení</label>
		<input class="textbox  form-control" name="" value="' . ($form->doklad->h_summary) . '" disabled type="text"></div>';

		$contentInt .= '</div>';

		$contentInt .= '<div class="col-xs-4">';

		$contentInt .= '	<div class="form-group"><label for="" class="control-label">Plusy</label>
		<input class="textbox  form-control" name="" value="' . ($form->doklad->h_plus) . '" disabled type="text"></div>';

		$contentInt .= '</div>';

		$contentInt .= '<div class="col-xs-4">';

		$contentInt .= '	<div class="form-group"><label for="" class="control-label">Mínusy</label>
		<input class="textbox  form-control" name="" value="' . ($form->doklad->h_minus) . '" disabled type="text"></div>';
		$contentInt .= '</div>';


		$contentInt .= '</div>';



		$contentInt .= '<div class="row">';
		$contentInt .= '<div class="col-xs-3">';
		$contentInt .= '	<div class="form-group"><label for="" class="control-label">Celkově</label>
		<input class="textbox  form-control" name="" value="' . ($form->doklad->h_total_rating) . '" disabled type="text"></div>';
		$contentInt .= '</div>';

		$contentInt .= '<div class="col-xs-3">';
		$contentInt .= '	<div class="form-group"><label for="" class="control-label">Dodací lhůta</label>
		<input class="textbox  form-control" name="" value="' . ($form->doklad->h_delivery_time) . '" disabled type="text"></div>';
		$contentInt .= '</div>';



		$contentInt .= '<div class="col-xs-3">';
		$contentInt .= '	<div class="form-group"><label for="" class="control-label">Kvalita dopravy</label>
		<input class="textbox  form-control" name="" value="' . ($form->doklad->h_transport_quality) . '" disabled type="text"></div>';
		$contentInt .= '</div>';

		$contentInt .= '<div class="col-xs-3">';
		$contentInt .= '	<div class="form-group"><label for="" class="control-label">Přehlednost obchodu</label>
		<input class="textbox  form-control" name="" value="' . ($form->doklad->h_web_usability) . '" disabled type="text"></div>';
		$contentInt .= '</div>';

		$contentInt .= '<div class="col-xs-3">';
		$contentInt .= '	<div class="form-group"><label for="" class="control-label">Kvalita komunikace</label>
		<input class="textbox  form-control" name="" value="' . ($form->doklad->h_communication) . '" disabled type="text"></div>';
		$contentInt .= '</div>';


		$contentInt .= '</div>';


		return $contentInt;

	}

	public function makeTabs($tabs = array()) {

		$eshopController = new EshopController();
		$this->eshopSetting = $eshopController->setting;


		$tabs[] = array("name" => "Main", "title" => "Hlavní","content" => $this->MainTab()  );     
    if ($this->radkyTab)
    {
         $tabs[] = array("name" => "Radky", "title" => "Položky","content" => $this->RadkyTab()  );
    }
		
		$tabs[] = array("name" => "Fak", "title" => "Fakturační údaje","content" => $this->FakturacniTab()  );
		$tabs[] = array("name" => "Dod", "title" => "Dodací adresa","content" => $this->DodaciTab() );
		$tabs[] = array("name" => "Heureka", "title" => "Heureka","content" => $this->HeurekaTab() );
		$tabs[] = array("name" => "Nastaveni", "title" => "Interní","content" => $this->InterniTab() );

		return parent::makeTabs($tabs);
	}

}
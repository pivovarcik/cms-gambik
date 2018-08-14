<?php

class ShopTransferTabs extends G_Tabs {

	protected $form;
	protected $languageList;
	protected $entityName;
	protected $paymentList = array();
	public function __construct($pageForm, $entityName=null)
	{

		$this->form = $pageForm;

		$this->entityName = $entityName;
		$languageModel = new models_Language();
		$this->languageList = $languageModel->getActiveLanguage();


		if ($this->form->page->id) {
			$shopTransferController = new ShopPaymentController();
			$params = new ListArgs();
			$params->lang = LANG_TRANSLATOR;
			$params->doprava_id = $this->form->page->id;
			$this->paymentList = $shopTransferController->shopPaymentList($params);
      
     // print_r($this->paymentList);
		}




	}

	protected function MainTabs()
	{

		$contentSeo = '';
		$form = $this->form;
		$languageList = $this->languageList;
		// Verzování dle jazyků
		$first = true;
		foreach ($languageList as $key => $val)
		{
			$style = ($first) ? "display:block;" : "display:none;";$first = false;
			$contentSeo .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("name_$val->code")->render() . '</div>';
		}
		if ($form->getElement("id")) {
			$contentSeo .=$form->getElement("id")->render();
		}

		$contentSeo .= '<p class="desc"></p><br />';


		$first = true;
		foreach ($languageList as $key => $val)
		{
			$style = ($first) ? "display:block;" : "display:none;";$first = false;
			$contentSeo .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("description_$val->code")->render() . '</div>';
		}
		$contentSeo .= '<p class="desc"></p><br />';

     /*
		$first = true;
		foreach ($languageList as $key => $val)
		{
			$style = ($first) ? "display:block;" : "display:none;";$first = false;
			$contentSeo .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("price_$val->code")->render() . '</div>';
		}
		$contentSeo .= '<p class="desc"></p><br />';

		$first = true;
		foreach ($languageList as $key => $val)
		{
			$style = ($first) ? "display:block;" : "display:none;";$first = false;
			$contentSeo .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("price_value_$val->code")->render() . '</div>';
		}
		$contentSeo .= '<p class="desc"></p><br />';
     */
		$first = true;
		foreach ($languageList as $key => $val)
		{
			$style = ($first) ? "display:block;" : "display:none;";$first = false;
			$contentSeo .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("mj_id_$val->code")->render() . '</div>';
		}
		$contentSeo .= '<p class="desc"></p><br />';


		$first = true;
		foreach ($languageList as $key => $val)
		{


			$style = ($first) ? "display:block;" : "display:none;";$first = false;
			$contentSeo .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("tax_id_$val->code")->render() . '</div>';
		}
		$contentSeo .= '<p class="desc"></p><br />';




		$contentSeo .= $form->getElement("aktivni")->render();
		//$contentSeo .= $form->getElement("price_m3")->render();
		$contentSeo .= $form->getElement("vypocet_id")->render();
		$contentSeo .= $form->getElement("order")->render();
		$contentSeo .= '<p class="desc"></p><br />';

		if ($form->getElement("id")) {
			$contentSeo .= $form->getElement("id")->render();
		}
		return $contentSeo;

	}
	protected function DopravceTabs()
	{
  
  		$contentSeo = '';
		$form = $this->form;
    $contentSeo .= $form->getElement("kod_dopravce")->render();
		$contentSeo .= '<p class="desc"></p><br />';
    return $contentSeo;
  }
	protected function OdberneMistoTabs()
	{
  
  		$contentSeo = '';
		$form = $this->form;
    $contentSeo .= $form->getElement("osobni_odber")->render();
		$contentSeo .= '<p class="desc"></p><br />';

		$contentSeo .= '<div class="dodaci_adresa2">';
		$contentSeo .= $form->getElement("address1")->render();
		$contentSeo .= '<p class="desc"></p><br />';

		$contentSeo .= $form->getElement("odberne_misto")->render();
		$contentSeo .= '<p class="desc"></p><br />';

		$contentSeo .= $form->getElement("city")->render();
		$contentSeo .= '<p class="desc"></p><br />';

		$contentSeo .= $form->getElement("zip_code")->render();
		$contentSeo .= '<p class="desc"></p><br />';

    		$contentSeo .= '</div>';
    return $contentSeo;
  }
	protected function TypyPlatebTabs()
	{

		$contentSeo = '';
		$form = $this->form;
		$contentSeo = '<h2>Párování plateb s dopravou</h2>';
		$contentSeo .= '<div>';



		//PRINT_R($params);
		$paymentList = $this->paymentList;
		for ($i=0;$i<count($paymentList);$i++)
		{
			$checked = '';
			$disabled = '';
			$selectedrow = '';
			if ($paymentList[$i]->isAllowed == 1) {
				$checked = ' checked="checked"';
			}

					$contentSeo .= '<div class="well">';
					$contentSeo .= '<div class="row">';

			$contentSeo .= '<div class="col-md-3">';
      
      $contentSeo .= '<div class="checkbox"><label for=""><input value="' . $paymentList[$i]->id. '"' . $checked. ' id="" name="platba[]" type="checkbox"><span>' . $paymentList[$i]->name. '</span></label></div>';
      
      
			$contentSeo .= '<input type="hidden" class="form-control" value="' . $paymentList[$i]->id. '" name="platba_id[]">';
		//	$contentSeo .= '<input type="checkbox" class="form-control" value="' . $paymentList[$i]->id. '" name="platba[]"' . $checked. '>';

			//$contentSeo .= '<span class="name">' . $paymentList[$i]->name. '</span>';
			$contentSeo .= '</div>';
      
      $contentSeo .= '<div class="col-md-2">';
      $contentSeo .= '<div class="row">';

			$contentSeo .= '<div class="col-sm-6">';
      $contentSeo .= 'Fixní cena';
			$contentSeo .= '<input type="text"  class="form-control" style="text-align:right;" value="' . numberFormat($paymentList[$i]->price). '" name="pdprice[]">';
			$contentSeo .= '</div>';


			$contentSeo .= '<div class="col-sm-6">';
      $contentSeo .= 'Popisek fixní ceny';
			$contentSeo .= '<input type="text"  class="form-control" value="' . $paymentList[$i]->price_value. '" name="pdprice_value[]">';
			$contentSeo .= '</div>';
       $contentSeo .= '</div>';
       $contentSeo .= '</div>';
       
      $contentSeo .= '<div class="col-md-2">';
      $contentSeo .= '<div class="row">';

			$contentSeo .= '<div class="col-sm-6">';
      $contentSeo .= 'Cena za MJ';
			$contentSeo .= '<input type="text"  class="form-control" style="text-align:right;" value="' . numberFormat($paymentList[$i]->price_mj). '" name="pdprice_mj[]">';
			$contentSeo .= '</div>';


			$contentSeo .= '<div class="col-sm-6">';
      $contentSeo .= 'Popisek ceny za MJ';
			$contentSeo .= '<input type="text"  class="form-control" value="' . $paymentList[$i]->price_mj_value. '" name="pdprice_mj_value[]">';
			$contentSeo .= '</div>';
       $contentSeo .= '</div>';
       $contentSeo .= '</div>';
              
       
      $contentSeo .= '<div class="col-md-2">';
      $contentSeo .= '<div class="row">';

			$contentSeo .= '<div class="col-sm-6">';
      $contentSeo .= 'Cena za m3';
			$contentSeo .= '<input type="text"  class="form-control" style="text-align:right;" value="' . numberFormat($paymentList[$i]->price_m3). '" name="pdprice_m3[]">';
			$contentSeo .= '</div>';


			$contentSeo .= '<div class="col-sm-6">';
      $contentSeo .= 'Popisek ceny za m3';
			$contentSeo .= '<input type="text"  class="form-control" value="' . $paymentList[$i]->price_m3_value. '" name="pdprice_m3_value[]">';
			$contentSeo .= '</div>';
       $contentSeo .= '</div>';
       $contentSeo .= '</div>';
       

      $contentSeo .= '<div class="col-md-2">';
      $contentSeo .= '<div class="row">';

			$contentSeo .= '<div class="col-sm-6">';
      $contentSeo .= 'Cena za kg';
			$contentSeo .= '<input type="text"  class="form-control" style="text-align:right;" value="' . numberFormat($paymentList[$i]->price_kg). '" name="pdprice_kg[]">';
			$contentSeo .= '</div>';


			$contentSeo .= '<div class="col-sm-6">';
      $contentSeo .= 'Popisek ceny za kg';
			$contentSeo .= '<input type="text"  class="form-control" value="' . $paymentList[$i]->price_kg_value. '" name="pdprice_kg_value[]">';
			$contentSeo .= '</div>';
       $contentSeo .= '</div>';
       $contentSeo .= '</div>';
              

			$contentSeo .= '</div>';
      
      
			$contentSeo .= '</div>';



		}

		$contentSeo .= '</div>';
		return $contentSeo;

	}
	public function makeTabs($tabs = array()) {
		array_push($tabs, array("name" => "Main", "title" => 'Hlavní',"content" => $this->MainTabs()));
		array_push($tabs, array("name" => "Platby", "title" => 'Typy plateb',"content" => $this->TypyPlatebTabs()));
		array_push($tabs, array("name" => "OdberneMisto", "title" => 'Odběrné místo',"content" => $this->OdberneMistoTabs()));
		array_push($tabs, array("name" => "Dopravce", "title" => 'Dopravce',"content" => $this->DopravceTabs()));
		//	array_push($tabs, array("name" => "Files", "title" => '<span id="filesCountTab">Soubory</span>',"content" => $this->FileTabs()));
		//	array_push($tabs, array("name" => "Seo", "title" => "SEO","content" => $this->SeoTabs()));
		//	array_push($tabs, array("name" => "Access", "title" => "Přístup","content" => $this->AccessTabs()));

		return parent::makeTabs($tabs);
	}
}
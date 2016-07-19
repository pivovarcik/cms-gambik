<?php

class ShopTransferTabs extends G_Tabs {

	protected $form;
	protected $languageList;
	protected $entityName;
	protected $paymentList = array();
	public function __construct($pageForm, $entityName=null)
	{

		$this->form = $pageForm;
		//	$form = new Application_Form_CategoryEdit();
		$this->entityName = $entityName;
		$languageModel = new models_Language();
		$this->languageList = $languageModel->getActiveLanguage();


		if ($this->form->page->id) {
			$shopTransferController = new ShopPaymentController();
			$params = new ListArgs();
			$params->lang = LANG_TRANSLATOR;
			$params->doprava_id = $this->form->page->id;
			$this->paymentList = $shopTransferController->shopPaymentList($params);
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


		$contentSeo .= $form->getElement("osobni_odber")->render();
		$contentSeo .= '<p class="desc"></p><br />';

		$contentSeo .= '<div class="dodaci_adresa">';
		$contentSeo .= $form->getElement("address1")->render();
		$contentSeo .= '<p class="desc"></p><br />';

		$contentSeo .= $form->getElement("odberne_misto")->render();
		$contentSeo .= '<p class="desc"></p><br />';

		$contentSeo .= $form->getElement("city")->render();
		$contentSeo .= '<p class="desc"></p><br />';

		$contentSeo .= $form->getElement("zip_code")->render();
		$contentSeo .= '<p class="desc"></p><br />';
		$contentSeo .= '</div>';

		$contentSeo .= $form->getElement("order")->render();
		$contentSeo .= '<p class="desc"></p><br />';

		if ($form->getElement("id")) {
			$contentSeo .= $form->getElement("id")->render();
		}
		return $contentSeo;

	}


	protected function TypyPlatebTabs()
	{

		$contentSeo = '';
		$form = $this->form;
		$contentSeo = '<table>';


		$contentSeo .= '<tr>';

		$contentSeo .= '<th>Typ platby</th>';
		$contentSeo .= '<th>Cena</th>';
		$contentSeo .= '<th>Popisek ceny</th>';

		$contentSeo .= '</tr>';
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

					$contentSeo .= '<tr>';

			$contentSeo .= '<td>';
			$contentSeo .= '<input type="hidden" value="' . $paymentList[$i]->id. '" name="platba_id[]">';
			$contentSeo .= '<input type="checkbox" value="' . $paymentList[$i]->id. '" name="platba[]"' . $checked. '>';

			$contentSeo .= '<span class="name">' . $paymentList[$i]->name. '</span>';



			$contentSeo .= '</td>';


			$contentSeo .= '<td>';
			$contentSeo .= '<input type="text" style="text-align:right;" value="' . numberFormat($paymentList[$i]->price). '" name="pdprice[]">';
			$contentSeo .= '</td>';


			$contentSeo .= '<td>';
			$contentSeo .= '<input type="text" value="' . $paymentList[$i]->price_value. '" name="pdprice_value[]">';
			$contentSeo .= '</td>';


			$contentSeo .= '</tr>';



		}

		$contentSeo .= '</table>';
		return $contentSeo;

	}
	public function makeTabs($tabs = array()) {
		array_push($tabs, array("name" => "Main", "title" => 'Hlavní',"content" => $this->MainTabs()));
		array_push($tabs, array("name" => "Platby", "title" => 'Typy plateb',"content" => $this->TypyPlatebTabs()));
		//	array_push($tabs, array("name" => "Files", "title" => '<span id="filesCountTab">Soubory</span>',"content" => $this->FileTabs()));
		//	array_push($tabs, array("name" => "Seo", "title" => "SEO","content" => $this->SeoTabs()));
		//	array_push($tabs, array("name" => "Access", "title" => "Přístup","content" => $this->AccessTabs()));

		return parent::makeTabs($tabs);
	}
}
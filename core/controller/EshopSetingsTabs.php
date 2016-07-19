<?php

class EshopSetingsTabs extends G_Tabs {

	protected $form;
	public function __construct($pageForm)
	{
		parent::__construct("left");
		$this->form = $pageForm;
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
	/*	$contentVarianty .= $form->getElement("EMAIL_SMTP_SEND")->render();
		$contentVarianty .= '<p class="desc">K odesílání používat SMTP server</p><br />';
		$contentVarianty .= $form->getElement("EMAIL_SMTP_SERVER")->render();
		$contentVarianty .= '<p class="desc">např: localhost</p><br />';*/
		$contentVarianty .= $form->getElement("EMAIL_ORDER")->render();
		$contentVarianty .= '<p class="desc">Pod tímto účtem budou odesílány objednávky.</p><br />';
		$contentVarianty .= $form->getElement("EMAIL_ORDER_ALIAS")->render();
		$contentVarianty .= '<p class="desc">Bude uveden vedle emailové adresy. Např.: <strong>Karel Novák</strong> (info@eshop.com)</p><br />';
	/*	$contentVarianty .= $form->getElement("EMAIL_SMTP_AUTH")->render();
		$contentVarianty .= '<p class="desc"></p><br />';
		$contentVarianty .= $form->getElement("EMAIL_USERNAME")->render();
		$contentVarianty .= '<p class="desc"></p><br />';
		$contentVarianty .= $form->getElement("EMAIL_PWD")->render();
		$contentVarianty .= '<p class="desc"></p><br />';*/

		return $contentVarianty;

	}

	protected function ProductsTabs()
	{

		$eshopSettings = G_EshopSetting::instance();

		$form = $this->form;

		$contentParametry = '';
		$contentParametry .= $form->getElement("NEXTID_PRODUCT")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("PRODUCT_NEXTID_AUTO")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("PRODUCT_VARIANTY")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("CATEGORY_ROOT")->render();
		$contentParametry .= '<p class="desc"></p><br />';


		if ($eshopSettings->get("PLATCE_DPH") == "1") {
			$contentParametry .= $form->getElement("PRICE_TAX")->render();
			$contentParametry .= '<p class="desc"></p><br />';
		}


		$contentParametry .= $form->getElement("FORMAT_QTY")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("SLCT_QTY")->render();
		$contentParametry .= '<p class="desc"></p><br />';

		if ($eshopSettings->get("PLATCE_DPH") == "1") {
			$contentParametry .= $form->getElement("SLCT_TAX")->render();
			$contentParametry .= '<p class="desc"></p><br />';
		}

		$contentParametry .= $form->getElement("CISLO01")->render() . ' ' . $form->getElement("CISLO01_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("CISLO02")->render() . ' ' . $form->getElement("CISLO02_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("CISLO03")->render() . ' ' . $form->getElement("CISLO03_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("CISLO04")->render() . ' ' . $form->getElement("CISLO04_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("CISLO05")->render() . ' ' . $form->getElement("CISLO05_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';

		$contentParametry .= $form->getElement("CISLO06")->render() . ' ' . $form->getElement("CISLO06_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("CISLO07")->render() . ' ' . $form->getElement("CISLO07_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("CISLO08")->render() . ' ' . $form->getElement("CISLO08_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("CISLO09")->render() . ' ' . $form->getElement("CISLO09_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("CISLO10")->render() . ' ' . $form->getElement("CISLO10_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';


		$contentParametry .= $form->getElement("POLOZKA01")->render() . ' ' . $form->getElement("POLOZKA01_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("POLOZKA02")->render() . ' ' . $form->getElement("POLOZKA02_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("POLOZKA03")->render() . ' ' . $form->getElement("POLOZKA03_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("POLOZKA04")->render() . ' ' . $form->getElement("POLOZKA04_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("POLOZKA05")->render() . ' ' . $form->getElement("POLOZKA05_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';


		$contentParametry .= $form->getElement("POLOZKA06")->render() . ' ' . $form->getElement("POLOZKA06_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("POLOZKA07")->render() . ' ' . $form->getElement("POLOZKA07_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("POLOZKA08")->render() . ' ' . $form->getElement("POLOZKA08_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("POLOZKA09")->render() . ' ' . $form->getElement("POLOZKA09_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= $form->getElement("POLOZKA10")->render() . ' ' . $form->getElement("POLOZKA10_CHECK")->render();
		$contentParametry .= '<p class="desc"></p><br />';

		return $contentParametry;
	}

	protected function OrdersTabs()
	{

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
		$contentNastaveni .= $form->getElement("LOGO_PDF")->render();
		$contentNastaveni .= '<p class="desc">veřejná url včetně http://</p><br />';
		$value = $form->getElement("LOGO_PDF")->getValue();
		if ( !empty($value) ) { $contentNastaveni .= '<dl><label></label><dt></dt><dd><img src="' . $value . '" /></dd></dl><br />'; }
		$contentNastaveni .= $form->getElement("RAZITKO_OBJ_PDF")->render();
		$contentNastaveni .= '<p class="desc">veřejná url včetně http://</p><br />';
		$value = $form->getElement("RAZITKO_OBJ_PDF")->getValue();
		if ( !empty($value) ) { $contentNastaveni .= '<dl><label></label><dt></dt><dd><img src="' . $value . '" /></dd></dl><br />'; }

		$contentNastaveni .= '<fieldset class="well">';
		$contentNastaveni .= $form->getElement("HEUREKA_CODE")->render();
		$contentNastaveni .= '<p class="desc">Tajný klíč pro komunikaci ze službou Heureka.cz</p><br />';
		$contentNastaveni .= $form->getElement("HEUREKA_ENABLED")->render();
		$contentNastaveni .= '<p class="desc">Aktivní zasílání objednávek pro ověření spokojenosti zákazníka</p><br />';
		$contentNastaveni .= '</fieldset>';


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

		$contentFaktury .= $form->getElement("RAZITKO_FAK_PDF")->render();
		$contentFaktury .= '<p class="desc">veřejná url včetně http://</p><br />';
		$value = $form->getElement("RAZITKO_FAK_PDF")->getValue();
		if ( !empty($value) ) { $contentFaktury .= '<dl><label></label><dt></dt><dd><img src="' . $value . '" /></dd></dl><br />'; }
		return $contentFaktury;

	}

	protected function PlatbyTabs()
	{
		$form = $this->form;

		$contentPlatby = '';
		$contentPlatby .= '<fieldset>';
		$contentPlatby .= '<legend>Nastavení platební brány ComGate <a target="_blank" href="http://www.comgate.cz">comgate.cz</a></legend>';
		$contentPlatby .= $form->getElement("AGMO_TEST")->render();
		$contentPlatby .= '<p class="desc"></p><br />';

		$contentPlatby .= $form->getElement("AGMO_MERCHANT")->render();
		$contentPlatby .= '<p class="desc"></p><br />';
		$contentPlatby .= $form->getElement("AGMO_SECRET")->render();
		$contentPlatby .= '<p class="desc"></p><br />';

		$contentPlatby .= '</fieldset>';

		$contentPlatby .= '<fieldset>';
		$contentPlatby .= '<legend>Nastavení platební brány PayU <a target="_blank" href="http://www.payu.cz">payu.cz</a></legend>';
		$contentPlatby .= $form->getElement("PAYU_POS_ID")->render();
		$contentPlatby .= '<p class="desc"></p><br />';

		$contentPlatby .= $form->getElement("PAYU_KEY1")->render();
		$contentPlatby .= '<p class="desc"></p><br />';
		$contentPlatby .= $form->getElement("PAYU_KEY2")->render();
		$contentPlatby .= '<p class="desc"></p><br />';
		$contentPlatby .= '</fieldset>';
		return $contentPlatby;

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


		$contentFaktury .= '<div class="well">';
		$contentFaktury .= '<fieldset>';
		$contentFaktury .= '<legend>Nákupní košík</legend>';
		$contentFaktury .= $form->getElement("ADD_BASKET_DETAIL")->render() . '';
//		$contentFaktury .= '<p class="desc"></p><br />';

		$contentFaktury .= $form->getElement("ADD_BASKET_LIST")->render() . '';
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




		$contentFaktury .= $form->getElement("MSG_NENALEZENO")->render() . '';
		$contentFaktury .= '<p class="desc"></p><br />';

		$contentFaktury .= $form->getElement("LEFT_PANEL_ON")->render() . '';
		$contentFaktury .= $form->getElement("LEFT_PANEL_SLIM")->render() . '';
	//	$contentFaktury .= '<p class="desc"></p><br />';

		$contentFaktury .= $form->getElement("RIGHT_PANEL_ON")->render() . '';
		$contentFaktury .= $form->getElement("RIGHT_PANEL_SLIM")->render() . '';
	//	$contentFaktury .= '<p class="desc"></p><br />';


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
		array_push($tabs, array("name" => "Sklad", "title" => "Sklad","content" => $this->SkladTabs()));
		array_push($tabs, array("name" => "Zobrazeni", "title" => "Zobrazení","content" => $this->ZobrazeniTabs()));
		return parent::makeTabs($tabs);
	}
}

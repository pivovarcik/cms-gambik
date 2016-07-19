<?php

class ObjednavkaTabs extends G_Tabs {

	protected $form;
	public function __construct($pageForm)
	{
		$this->form = $pageForm;
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

		$contentMain .= $form->getElement("shipping_transfer")->render();
		$contentMain .= '<p class="desc"></p>';
		$contentMain .= $form->getElement("barcode")->render() . ' <a target="_blank" href="http://www.ceskaposta.cz/cz/nastroje/sledovani-zasilky.php?locale=CZ&go=ok&barcode=' . $form->getElement("barcode")->getValue(). '">ukázat</a>';
		$contentMain .= '<p class="desc"></p>';
		$contentMain .= $form->getElement("description")->render();
		$contentMain .= '<p class="desc"></p>';

		return $contentMain;
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
		$contentFak .= $form->getElement("shipping_ico")->render();
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

		$contentInt .= '<dl><dt><label for="shipping_transfer">Vytvořena:</label>
						</dt><dd><strong>' . date("j.n.Y H:i:s",strtotime($form->doklad->TimeStamp)) . '</strong></dd></dl>';
		$contentInt .= '<p class="desc"></p><br />';
		$contentInt .= '<dl><dt><label for="shipping_transfer">IP:</label>
						</dt><dd><strong>' . $form->doklad->ip_address . '</strong></dd></dl>';
		$contentInt .= '<p class="desc"></p><br />';
		$contentInt .= '<dl><dt><label for="shipping_transfer">Poslední změna:</label>
						</dt><dd><strong>' . date("j.n.Y H:i:s",strtotime($form->doklad->ChangeTimeStamp)) . '</strong></dd></dl>';
		$contentInt .= '<p class="desc"></p><br />';
		$contentInt .= $form->getElement("description_secret")->render();
		$contentInt .= '<p class="desc"></p><br />';

		return $contentInt;

	}


	public function makeTabs($tabs = array()) {

		$eshopController = new EshopController();
		$this->eshopSetting = $eshopController->setting;


		$tabs[] = array("name" => "Main", "title" => "Hlavní","content" => $this->MainTab()  );
		$tabs[] = array("name" => "Fak", "title" => "Fakturační údaje","content" => $this->FakturacniTab()  );
		$tabs[] = array("name" => "Dod", "title" => "Dodací adresa","content" => $this->DodaciTab() );
		$tabs[] = array("name" => "Nastaveni", "title" => "Interní","content" => $this->InterniTab() );

		return parent::makeTabs($tabs);
	}

}
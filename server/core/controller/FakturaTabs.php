<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
class FakturaTabs extends G_Tabs {

	protected $form;
  public $pohledavkyList = array();
	public function __construct($pageForm)
	{
		$this->form = $pageForm;
    
    
    $args = new ListArgs();
		$args->shipping_ico= $this->form->doklad->shipping_ico;
		$args->neuhrazene = true;
		$args->storno = 0;
		$Faktura = new models_Faktura;
    $this->pohledavkyList = $Faktura->getList($args);
    
    
	}

	protected function FakturyTab()
	{
		$form = $this->form;


		if (!$form->getElement("id")) {
			return $contentNastaveni;
		}

		$args = new ListArgs();
		$args->shipping_ico= $form->getElement("shipping_ico")->getValue();
		//$args->storno = 0;
		$DataGridProvider = new DataGridProvider("Faktura",$args);

		$contentVarianty = $DataGridProvider->table();

		return $contentVarianty;

	}

  protected function FakturySaldoTab()
	{
		$form = $this->form;

    for ($i=0;$i<count($this->pohledavkyList);$i++)
    {
    
    }
		if (!$form->getElement("id")) {
			return $contentNastaveni;
		}

		$args = new ListArgs();
		$args->shipping_ico= $form->getElement("shipping_ico")->getValue();
		$args->neuhrazene = true;
		$args->storno = 0;
		$DataGridProvider = new DataGridProvider("Faktura",$args);

		$contentVarianty = $DataGridProvider->Table();

		return $contentVarianty;

	}
  
	protected function MainTab()
	{

		$form = $this->form;
		$contentMain = '';
		$contentMain .= '<div class="row">';
		$contentMain .= '<div class="col-sm-3 col-xs-12">';
		$contentMain .= $form->getElement("code")->render();
		if ($form->getElement("id")) {

			$contentMain .= $form->getElement("id")->render();

			//	$contentMain .=' <a target="_blank" href="' . URL_HOME . 'orders_pdf.php?id=' . $form->getElement("id")->getValue(). '">Tisk PDF</a>';
		}

		$contentMain .= '</div>';
		$contentMain .= '<div class="col-sm-3 col-xs-12">';

		$contentMain .= $form->getElement("faktura_type_id")->render();
		$contentMain .= '<p class="desc">ZAL,PRO</p>';
		$contentMain .= '</div>';
		$contentMain .= '<div class="col-sm-3 col-xs-12">';
		$contentMain .= $form->getElement("faktura_date")->render();
		$contentMain .= '<p class="desc">Datum vystavení.</p>';
		$contentMain .= '</div>';

		$contentMain .= '<div class="col-sm-3 col-xs-12">';
		$contentMain .= $form->getElement("duzp_date")->render();
		$contentMain .= '<p class="desc"></p>';
		$contentMain .= '</div>';

		$contentMain .= '</div>';

		$contentMain .= '<div class="row">';
		$contentMain .= '<div class="col-sm-3 col-xs-12">';

		$contentMain .= $form->getElement("maturity_date")->render();
		$contentMain .= '</div>';

		$contentMain .= '<div class="col-sm-3 col-xs-12">';
		$contentMain .= $form->getElement("order_code")->render();
		$contentMain .= '</div>';


		$contentMain .= '<div class="col-sm-3 col-xs-12">';
		$contentMain .= $form->getElement("order_date")->render() ;
		$contentMain .= '</div>';


		$contentMain .= '<div class="col-sm-3 col-xs-12">';
		$contentMain .= $form->getElement("shipping_transfer")->render();
		$contentMain .= '</div>';


		$contentMain .= '</div>';


		$contentMain .= '<div class="row">';
		$contentMain .= '<div class="col-xs-12">';

		$contentMain .= $form->getElement("description")->render();
		$contentMain .= '</div>';

		$contentMain .= '</div>';

		return $contentMain;
	}


	protected function FakturacniTab()
	{
		$form = $this->form;
		$contentFak = '';
		$contentFak .= $form->getElement("shipping_first_name")->render();
		$contentFak .= '<p class="desc"></p><br />';
		$contentFak .= $form->getElement("shipping_last_name")->render();
		$contentFak .= '<p class="desc"></p><br />';
		$contentFak .= $form->getElement("shipping_address_1")->render();
		$contentFak .= '<p class="desc"></p><br />';
		$contentFak .= $form->getElement("shipping_city")->render();
		$contentFak .= '<p class="desc"></p><br />';
		$contentFak .= $form->getElement("shipping_zip_code")->render();
		$contentFak .= '<p class="desc"></p><br />';
		$contentFak .= $form->getElement("shipping_ico")->render() . ' <a href="#" class="ares btn btn-info">Dotažení partenra z Ares</a>';
		$contentFak .= '<p class="desc"></p><br />';
		$contentFak .= $form->getElement("shipping_dic")->render();
		$contentFak .= '<p class="desc"></p><br />';
		$contentFak .= $form->getElement("shipping_phone")->render();
		$contentFak .= '<p class="desc"></p><br />';
		$contentFak .= $form->getElement("shipping_email")->render() . '
					<p class="desc"></p>';


		return $contentFak;

	}

	protected function DodaciTab()
	{
		$form = $this->form;
		$contentFak = '';
		$contentFak .= $form->getElement("shipping_first_name2")->render();
		$contentFak .= '<p class="desc"></p><br />';
		$contentFak .= $form->getElement("shipping_last_name2")->render();
		$contentFak .= '<p class="desc"></p><br />';
		$contentFak .= $form->getElement("shipping_address_12")->render();
		$contentFak .= '<p class="desc"></p><br />';

		$contentFak .= $form->getElement("shipping_address_22")->render();
		$contentFak .= '<p class="desc"></p><br />';

		$contentFak .= $form->getElement("shipping_zip_code2")->render();
		$contentFak .= '<p class="desc"></p><br />';

		$contentFak .= $form->getElement("shipping_city2")->render();
		$contentFak .= '<p class="desc"></p><br />';


		return $contentFak;

	}

	protected function PlatbaTab()
	{


		$form = $this->form;
		$contentFak = '';
		$contentFak .= $form->getElement("shipping_pay")->render();
		$contentFak .= '<p class="desc"></p><br />';
		$contentFak .= $form->getElement("pay_account")->render();
		$contentFak .= '<p class="desc"></p><br />';
		$contentFak .= $form->getElement("pay_date")->render();
		$contentFak .= '<p class="desc"></p><br />';

		$contentFak .= $form->getElement("amount_paid")->render();
		$contentFak .= '<p class="desc"></p><br />';

		return $contentFak;

	}

	protected function InterniTab()
	{
		$form = $this->form;
		$contentInt = '';


		$contentInt .= '<div class="form-group"><label for="code" class="control-label">Doklad vytvořen:</label>';
		$contentInt .= '<input value="' . date("j.n.Y H:i:s",strtotime($form->doklad->TimeStamp)) . '" readonly="readonly" class="textbox readonly form-control" type="text"></div>';

		$contentInt .= '<div class="form-group"><label for="code" class="control-label">IP adresa:</label>';
		$contentInt .= '<input value="' . $form->doklad->ip_address . '" readonly="readonly" class="textbox readonly form-control" type="text"></div>';

		$contentInt .= '<div class="form-group"><label for="code" class="control-label">Poslední změna:</label>';
		$contentInt .= '<input value="' . date("j.n.Y H:i:s",strtotime($form->doklad->ChangeTimeStamp)) . '" readonly="readonly" class="textbox readonly form-control" type="text"></div>';

		$contentInt .= '<div class="form-group"><label for="code" class="control-label">Hash:</label>';
		$contentInt .= '<input value="' . $form->doklad->download_hash . '" readonly="readonly" class="textbox readonly form-control" type="text"></div>';


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
		$tabs[] = array("name" => "Platba", "title" => "Platba","content" => $this->PlatbaTab() );
		$tabs[] = array("name" => "Faktury", "title" => "Faktury","content" => $this->FakturyTab() );
		$tabs[] = array("name" => "Saldo", "title" => "Saldo","content" => $this->FakturySaldoTab() );
		$tabs[] = array("name" => "Nastaveni", "title" => "Interní","content" => $this->InterniTab() );

		return parent::makeTabs($tabs);
	}

}

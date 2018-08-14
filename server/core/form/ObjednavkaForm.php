<?php
/**
 * Společný předek pro formuláře typu Faktura
 * */

require_once("DokladForm.php");
abstract class ObjednavkaForm extends DokladForm
{

	public $stavObjednavkyList = array();
	function __construct()
	{
		$this->setStyle(BootstrapForm::getStyle());
		parent::__construct("Orders");
	//	$this->loadModel();
		$stavObjedavkyModel = new models_OrderStatus();
		$this->stavObjednavkyList = $stavObjedavkyModel->getList();

	}

	// načte datový model
	public function loadPage($doklad_id = null)
	{

	//	print "ID:" . $page_id;
		if ($doklad_id == null) {
	//		$this->doklad = new stdClass();
      
      
      
          $eshopSettings = G_EshopSetting::instance();
  		    $rada_user = "";
  		    $nextIdModel = new models_NextId();
  		    $this->doklad->code  = $nextIdModel->vrat_nextid(array(
  				"tabulka" => T_SHOP_ORDERS,
  				"polozka" => "code",
  				"rada_id" => (int) $eshopSettings->get("NEXTID_ORDER"),
  				"rada" => $rada_user,
  			));
        
        
			$this->doklad->platba_castka = 0;
			$this->doklad->cost_subtotal = 0;
			$this->doklad->cost_total = 0;
			$this->doklad->cost_tax = 0;

			$this->doklad->faktura_date = date("j.n.Y");
			$this->doklad->maturity_date = date("j.n.Y",strtotime("+14days"));

			if (defined("USER_ID")) {

				$model = new models_Users();
				$userDetail = $model->getUserById(USER_ID);

				$this->doklad->shipping_first_name = $userDetail->jmeno;
			//	$this->doklad->shipping_first_name2 = $userDetail->jmeno;

				$this->doklad->shipping_last_name = $userDetail->prijmeni;
			//	$this->doklad->shipping_last_name2 = $userDetail->prijmeni;

				$this->doklad->shipping_phone = $userDetail->mobil;
				$this->doklad->shipping_email = $userDetail->email;

				$model2 = new models_CatalogFirem();
				$userCatalogDetail = $model2->getDetailByVlastnikId(USER_ID);

				if ($userCatalogDetail) {

					if (!empty($userCatalogDetail->ico)) {
						$this->doklad->shipping_last_name .= " " . $this->doklad->shipping_first_name;
						$this->doklad->shipping_first_name = $userCatalogDetail->title;
					}


					$this->doklad->shipping_address_1 = $userCatalogDetail->address1;
					$this->doklad->shipping_address_12 = $userCatalogDetail->address2;

					$this->doklad->shipping_city = $userCatalogDetail->city;
					$this->doklad->shipping_city2 = $userCatalogDetail->city2;

					$this->doklad->shipping_zip_code = $userCatalogDetail->zip_code;
					$this->doklad->shipping_zip_code2 = $userCatalogDetail->zip_code2;

					if (!empty($userCatalogDetail->mobil)) {
						$this->doklad->shipping_phone = $userCatalogDetail->mobil;
					}
					if (!empty($userCatalogDetail->email)) {
						$this->doklad->shipping_email = $userCatalogDetail->email;
					}
					$this->doklad->shipping_ico = $userCatalogDetail->ico;
					$this->doklad->shipping_dic = $userCatalogDetail->dic;

				}

					//print_r($userDetail);


				//print_r($userCatalogDetail);
			} else {

				$this->doklad->shipping_first_name = $this->Request->getCookie("shipping_first_name","");
				$this->doklad->shipping_first_name2 = $this->Request->getCookie("shipping_first_name2","");
				$this->doklad->shipping_last_name = $this->Request->getCookie("shipping_last_name","");
				$this->doklad->shipping_last_name2 = $this->Request->getCookie("shipping_last_name2","");
				$this->doklad->shipping_address_1 = $this->Request->getCookie("shipping_address_1","");
				$this->doklad->shipping_address_12 = $this->Request->getCookie("shipping_address_12","");
				$this->doklad->shipping_city = $this->Request->getCookie("shipping_city","");
				$this->doklad->shipping_city2 = $this->Request->getCookie("shipping_city2","");
				$this->doklad->shipping_zip_code = $this->Request->getCookie("shipping_zip_code","");
				$this->doklad->shipping_zip_code2 = $this->Request->getCookie("shipping_zip_code2","");
				$this->doklad->shipping_phone = $this->Request->getCookie("shipping_phone","");
				$this->doklad->shipping_email = $this->Request->getCookie("shipping_email","");
				$this->doklad->shipping_ico = $this->Request->getCookie("shipping_ico","");
				$this->doklad->shipping_dic = $this->Request->getCookie("shipping_dic","");

			}


		} else {
			$this->doklad = self::$model->getDetailById($doklad_id);

		//	print_r($this->doklad);
			$this->doklad_id = $doklad_id;
		}

		$this->translator = G_Translator::instance();
	//	$this->translator->prekladacInit();


	}
	public function loadElements()
	{
		parent::loadElements();

		$translator = G_Translator::instance();

	//	print_r($doklad);


		$doklad = $this->doklad;

		$stavObjednavkyList = $this->stavObjednavkyList;
		$dopravaList = $this->dopravaList;
		$platbyList = $this->platbyList;

		$name = "stav";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox');
		$elem->setAttribs('label','Stav:');
		$pole = array();
		//$pole[0] = " -- neuvedeno -- ";
		$attrib = array();
		$doklad->odeslano_stav_nazev = "";

		foreach ($stavObjednavkyList as $key => $value)
		{
			$pole[$value->id] = $value->name;

			if ($doklad->odeslano_stav == 999) {
				$doklad->odeslano_stav_nazev = "[ Storno - " . date("j.n.Y H:i:s",strtotime($doklad->odeslanoTimeStamp)) . " ]";
				$doklad->nazev_stav = "Storno";
			}
			if ($doklad->odeslano_stav == $value->id) {
				$doklad->odeslano_stav_nazev = "[ " . $value->name . " - " . date("j.n.Y H:i:s",strtotime($doklad->odeslanoTimeStamp)) . " ]";
			}

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


		if ($doklad->storno == 1) {


			 $doklad->nazev_stav = "Storno";


			}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);




		$name = "barcode";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name,$doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Číslo zásilky:');
		$elem->setAttribs('class','textbox');
	//	$elem->setAttribs('style','width:185px;');
		$this->addElement($elem);

	}
}
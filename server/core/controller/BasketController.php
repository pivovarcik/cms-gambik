<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class BasketController extends G_Controller_Action
{
	private $attributes = array();
	private $photos = array();

	public $basketList = array();

	private $desetinna_mista = 2;
	// celková cena dopravy
	private $cena_dopravy = 0;
	private $cena_dph_dopravy = 0;
	private $cena_dopravy_value = "";

	private $jedn_cena_dopravy = 0;
	private $mnozstvi_dopravy = 0;

	public $total = 0;
	private $total_price = 0;
	private $total_price_sdph = 0;
	private $total_price_vat = 0;
	private $total_tax = 0;
	public $isEmpty = true;
	public $status = array();
	private $basket_id;
	public $qty = 0;
	public $postovne = 125;

	public $platba_id;
	public $doprava_id;

	private $doprava_name = "";
	private $platba_name = "";


	function __construct()
	{

		parent::__construct();


		// Zavádím seanci
		$this->basket_id = $this->getRequest->getSession("temp_cart",
							$this->getRequest->getCookie("temp_cart",false)
					);

		//$this->setDoprava();
		//$this->setPlatba();
	//	print_r($_SESSION["platba_id"]);
		$this->platba_id = (int) $this->getRequest->getSession("platba_id",
					$this->getRequest->getCookie("platba_id",0)
			);
	//	print $this->platba_id;
	//	$this->setPlatba($this->platba_id);


		$this->doprava_id = (int) $this->getRequest->getSession("doprava_id",
			$this->getRequest->getCookie("doprava_id",0)
			);


		//$this->setDoprava($this->doprava_id);

		if (false === $this->basket_id) {
			$this->basket_id = mt_rand();
		}
		$this->getRequest->setSession("temp_cart", $this->basket_id);
		$this->getRequest->setCookie("temp_cart", $this->basket_id);

		$basketlist = $this->basketList();
		$this->getPlatbaDopravy();

	}

	public function getBasketInfo()
	{
		$basketList = $this->basketList();
		$data = array();
		$data["mnozstvi_dopravy"] = $this->getMnozstviDopravy();
		$data["jedn_cena_dopravy"] = $this->getJednotkovaCenaDopravy();
		$data["cena_dopravy"] = $this->getCenaDopravyValue();
		$data["cena_dopravy_sdph"] = $this->getCenaDopravySDph();
		$data["celkova_cena_zbozi_sdph"] = $this->getCelkovaCenaSDph();
		$data["castka_zbozi_dph"] = number_format($this->getCastkaDph(), 0, ',', ' '). '&nbsp;' . MENA;

		$data["castka_dph"] = number_format($this->getCastkaDph() + $this->getCastkaDphDopravy(), 0, ',', ' '). '&nbsp;' . MENA;
		$data["celkova_cena_sdph"] = number_format($this->getCelkovaCenaSDph() + $this->getCenaDopravySDph(), 0, ',', ' '). '&nbsp;' . MENA;

			$data["doprava_id"] = $this->doprava_id;
		$data["platba_id"] = $this->platba_id;

		$data["productList"] = array();
	//	print_r($basketList);


		foreach ($basketList as $product) {

			$item = $product; //new stdClass();


			array_push($data["productList"], $item);



		}


		return $data;
	}
	public function getMnozstviDopravy()
	{
		if ($this->isDopravaFree()) {
			return 0;
		}
		return $this->mnozstvi_dopravy;
	}


	public function getNazevDopravy()
	{
		return $this->doprava_name;
	}
	public function getNazevPlatby()
	{
		return $this->platba_name;
	}


	public function getJednotkovaCenaDopravy()
	{
		if ($this->isDopravaFree()) {
			return 0;
		}
		return $this->jedn_cena_dopravy;
	}
  
  public function getPocetJednotekDopravy()
	{
		if ($this->isDopravaFree()) {
			return 0;
		}
		return $this->pocet_jednotek_dopravy;
	}
  
	public function getCenaDopravy()
	{
		if ($this->isDopravaFree()) {
			return 0;
		}
		return $this->cena_dopravy;
	}
	public function getCenaDopravySDph()
	{

		if ($this->isDopravaFree()) {
			return 0;
		}
	//	return $this->cena_dopravy + $this->cena_dph_dopravy;
		return $this->cena_dph_dopravy;
	}

	public function getCastkaDphDopravy()
	{
		if ($this->isDopravaFree()) {
			return 0;
		}
		return $this->cena_dph_dopravy;
	}
	public function getCenaDopravyValue()
	{
		if ($this->isDopravaFree()) {
			$translator = G_Translator::instance();
			return $translator->prelozitFrazy("zdarma");
		}
    
    if ($this->vypocet_id == 2)
    {
       //return $this->celkem_m3 . "m3 x " . $this->price_m3_value;
    }

		return $this->cena_dopravy_value;
	}

	public function getCastkaDopravneFree()
	{
		$eshopSettings = G_EshopSetting::instance();
		return $eshopSettings->get("DOPRAVNE_ZDARMA");
	}
	// vrací True pokud částka objednávky splňuje podmínky pro dopravné zdarma
	public function isDopravaFree()
	{

		if ($this->getCastkaDopravneFree() <=0) {
			return false;
		}
    $eshopSettings = G_EshopSetting::instance();
    
    if ($eshopSettings->get("PRICE_TAX") == "0") {
      if ($this->getCelkovaCenaBezDph() > $this->getCastkaDopravneFree()) {
  			return true;
  		}
    } else {
      if ($this->getCelkovaCenaSDph() > $this->getCastkaDopravneFree()) {
  			return true;
  		}    
    
    }

		return false;
	}
  
  
  public function castkaZbyvaDopravaFree()
	{

		if ($this->getCastkaDopravneFree() <=0) {
			return 0;
		}
    $eshopSettings = G_EshopSetting::instance();
    
    if ($eshopSettings->get("PRICE_TAX") == "0") {
      if ($this->getCelkovaCenaBezDph() > $this->getCastkaDopravneFree()) {
  			return 0;
  		} else {
        return $this->getCastkaDopravneFree() - $this->getCelkovaCenaBezDph();   
      }
    } else {
      if ($this->getCelkovaCenaSDph() > $this->getCastkaDopravneFree()) {
  			return 0;
  		} else {
        return $this->getCastkaDopravneFree() - $this->getCelkovaCenaSDph();   
      }    
    
    }

		return false;
	}
	public function setDopravaAction(){
		// Ověřím si
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('doprava', false))
		{
			$doprava_id = (int) $this->getRequest->getPost('doprava', 0);
			if ($this->setDoprava($doprava_id) == true) {
				//$this->getRequest->goBackRef();
				header("Location: " . URL_HOME2 . "payment", true, 303);
			}
		}
	}
	public function setDopravaAjax(){
		// Ověřím si
		if($this->getRequest->isPost() && "setTransfer" == $this->getRequest->getPost('action', false)
			&& false !== $this->getRequest->getPost('id', false))
		{
			$doprava_id = (int) $this->getRequest->getPost('id', 0);
			if ($this->setDoprava($doprava_id) == true) {
				return true;
			}
		}
	}
	public function setDoprava($doprava_id){

		if ($doprava_id > 0) {

			//if ($this->platba_id > 0) {

				$shopTransferController = new ShopPaymentController();
				$params = new ListArgs();
				$params->lang = LANG_TRANSLATOR;
				$params->doprava_id = (int)$doprava_id;
				$paymentList = $shopTransferController->shopPaymentList($params);

			//	print_r($paymentList);
				$prvniPovolenaPlatba = 0;
				$jeShoda = false;
				for ($i=0;$i<count($paymentList);$i++)
				{
					if ( $paymentList[$i]->isAllowed == 1) {
						// nastavím první povolenou
						//	PRINT $paymentList[$i]->id;
						if ($prvniPovolenaPlatba == 0) {
							$prvniPovolenaPlatba = $paymentList[$i]->id;
						}
						if ($this->platba_id == $paymentList[$i]->id) {
						//	break;
							$jeShoda = true;
						}


					}
				}


				if ($this->platba_id == 0 || !$jeShoda) {
					$this->platba_id = $prvniPovolenaPlatba;
					//$this->platba_id = (int) $platba_id;
				//	print "doprava:".$doprava_id . "platba:" . $this->platba_id;
					$this->getRequest->setSession("platba_id", $prvniPovolenaPlatba);
					$this->getRequest->setCookie("platba_id", $prvniPovolenaPlatba);
				}


				// existuje definice platby
			//}

		//	print "doprava:".$doprava_id . "platba:" . $this->platba_id;
			$this->doprava_id = (int) $doprava_id;

			// pokud setuju dopravu musím ověřit i platbu

			$this->getRequest->setSession("doprava_id", $this->doprava_id);
			$this->getRequest->setCookie("doprava_id", $this->doprava_id);

			return true;
		}
		return false;
	}

	public function getDoprava($id)
	{
		$model = new models_Doprava();
		return $model->getDetailById($id);
	}

	public function getPlatbaDopravy($platba_id = null,$doprava_id = null)
	{

		if (is_null($platba_id)) {
			$platba_id = $this->platba_id;
		}
		if (is_null($doprava_id)) {
			$doprava_id = $this->doprava_id;
		}
		$model = new models_Platba();
		$params = array();
		$params["platba_id"] = (int) $platba_id;
		$params["doprava_id"] = (int) $doprava_id;
		$list = $model->getPlatbaDopravyList($params);

	//	print $model->getLastQuery();
		//print_r($list);
		/*
		if ($list[0]->dph_value > 0) {

		}*/

		if (count($list)>0) {
			$this->cena_dph_dopravy = $list[0]->price * $list[0]->dph_value * 0.01;
		}

		//print $this->cena_dph_dopravy;

		$jednotek = 1;
		$eshopSettings = G_EshopSetting::instance();

		if ($eshopSettings->get("DOPRAVNE_ZA_MJ") == "1") {
			$jednotek = $this->qty;
		}
    
    
		//print_r($list);
		if (count($list)>0) {
			$this->doprava_name = $list[0]->doprava_name;
			$this->platba_name = $list[0]->platba_name;
			$this->jedn_cena_dopravy = $list[0]->price;
			$this->vypocet_id = $list[0]->vypocet_id;
      $this->price_m3_value = $list[0]->price_m3_value;


      			$this->mnozstvi_dopravy = $jednotek;
			$this->cena_dopravy = $list[0]->price * $jednotek;
      
            if ($list[0]->price <> 0 && $jednotek > 1)
      {
          $this->cena_dopravy_value = $list[0]->price * $jednotek . ' ' . MENA;
      }   else {
        $this->cena_dopravy_value = $list[0]->price_value;
      }
      
      
     // print_r($list[0]);
      if ($list[0]->vypocet_id == 1)
      {
        // cena za mj
        $jednotek = $this->qty;
      }      
      if ($list[0]->vypocet_id == 2)
      {
        // cena za m3
        $jednotek = $this->celkem_m3;
        //$this->price_value = $list[0]->price_m3_value;
        
        $this->jedn_cena_dopravy = $list[0]->price_m3;
        
        $this->cena_dph_dopravy = $this->celkem_m3 * $list[0]->price_m3 * ($list[0]->dph_value+100) / 100;
        
        $this->cena_dopravy = $list[0]->price_m3 * $jednotek;
          
        $this->cena_dopravy_value = round($list[0]->price_m3 * $jednotek,0) . ' ' . MENA;
        
        //   print $this->celkem_m3 . "*" . $list[0]->price_m3 . "*" . $list[0]->dph_value . "=" . $this->cena_dph_dopravy . "<br />";
        
      }
      
      if ($list[0]->vypocet_id == 3)
      {
        // cena za kg
        $jednotek = $this->celkem_kg;
      }
      
      

       $this->pocet_jednotek_dopravy =  $jednotek;

			
   //   print $list[0]->price_value;
		} else {
			//print $model->getLastQuery();
		}
		return $list;
	}
	public function getPlatba($id)
	{
		$model = new models_Platba();
		return $model->getDetailById($id);
	}


	public function setPlatbaAjax(){
		// Ověřím si
		if($this->getRequest->isPost() && "setPayment" == $this->getRequest->getPost('action', false)
			&& false !== $this->getRequest->getPost('id', false))
		{
			$doprava_id = (int) $this->getRequest->getPost('id', 0);
			if ($this->setPlatba($doprava_id) == true) {
				return true;
			}
		}
	}

	public function setPlatbaAction(){
		// Ověřím si
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('platba', false))
		{
			$platba_id = (int) $this->getRequest->getPost('platba', 0);
			if ($this->setPlatba($platba_id) == true) {
				//$this->getRequest->goBackRef();
				header("Location: " . URL_HOME2 . "udaje", true, 303);
			}
		}
	}

	public function setPlatba($platba_id){
		// TODO - měl bych kontrolovat příslušnost platby k přepravě
		if ($platba_id > 0 && $this->doprava_id  > 0) {
/*
			$platabDopravy = new models_PlatbaDopravy();
			$params = array();
			$params['platba_id'] = (int) $platba_id;
			$params['doprava_id'] = (int) $this->doprava_id;

			$list = $platabDopravy->get_list($params);
			*/
		//	print $platabDopravy->getLastQuery();
			//print count($list);

			$list = $this->getPlatbaDopravy($platba_id,$this->doprava_id);

		//	print_r($list);
			//print	$this->cena_dopravy;
			if (count($list) == 1) {

				$this->platba_id = (int) $platba_id;
				$this->getRequest->setSession("platba_id", $platba_id);
				$this->getRequest->setCookie("platba_id", $platba_id);
				return true;
			}
			//return false;

		}


		return false;

	}


	public function dopravaList($params = array())
	{
		$args = new ListArgs();
		$args->limit = 1000;
		$basket = new models_Doprava();


		$l = $basket->getList($args);
		return $l;
	}
	public function platbaList($params = array())
	{

		$limit = 1000;
		$basket = new models_Platba();
		$l = $basket->getList(array(
						'limit' => $limit,
						'debug' => 0,
						));
		return $l;
	}
	public function basketList(IListArgs $args = null)
	{

		if (is_null($args)) {
			$args = new ListArgs();
		}
		$args->limit = 1000;
		if (isset($args->all) && $args->all == 1) {
		//	$params2["basket_id"] = (int) $params['basket_id'];
		} else {
			$args->basket_id = (int) $this->basket_id;
		}


		if (defined("USER_ID")) {
			$args->user_id = USER_ID;
		}

		$args->lang = LANG_TRANSLATOR;
		$basket = new models_Basket();
		$l = $basket->getList($args);

	//	print $basket->getLastQUery();
	//	print "řádků:" . count($l);

		//print_r($l);
		$this->total = $basket->total;

		if ($this->total > 0) {
			$this->isEmpty = false;
		} else {
			$this->isEmpty = true;
		}
		//$this->categoryTable();
		$this->qty = 0;
    $this->celkem_m3 = 0;
		$this->celkem_kg = 0;
      
		$this->total_price = 0;
		$this->total_price_sdph = 0;
		$this->total_tax = 0;

		//print_r($l);

		$productController = new ProductController();
		for ($i=0;$i < count($l);$i++)
		{
			$this->qty += $l[$i]->mnozstvi;
			$this->celkem_m3 += ($l[$i]->mnozstvi * $l[$i]->objem);
			$this->celkem_kg += ($l[$i]->mnozstvi * $l[$i]->netto);

			$vyse_slevy = 0;
			$znak_slevy = " " . MENA;
		/*	if ($l[$i]->basket_sleva <> 0) {
				// výpočet slevy
				if ($l[$i]->basket_typ_slevy == "%" && $l[$i]->price <> 0) {
					$vyse_slevy = $l[$i]->price * $l[$i]->basket_sleva / 100;
					$znak_slevy = "%";
				} else {
					$vyse_slevy = $l[$i]->sleva;
				}
			}*/
			$zaklad = $l[$i]->price + $vyse_slevy;

		//	$l[$i]->cena_bezdph_po_sleve = $zaklad;


	//		$l[$i]->cena_sdph_po_sleve = ($zaklad + $l[$i]->castka_dph);

			// částka bez DPH
			$this->total_price += $l[$i]->cenacelkem;

			// částka s DPH
		//	$this->total_price_sdph += ($l[$i]->cena_sdph * $l[$i]->mnozstvi);

			$this->total_price_sdph += $l[$i]->cenacelkem_sdph;






	//		$l[$i]->cenacelkem_sdph = $l[$i]->cena_sdph_po_sleve * $l[$i]->mnozstvi;
  
			$l[$i]->cenacelkem_sdph_label = $l[$i]->cena_sdph * $l[$i]->qty;


		//	$l[$i]->cenacelkem = $l[$i]->cena_bezdph_po_sleve * $l[$i]->mnozstvi;
			$l[$i]->sleva_label = round($l[$i]->sleva) . $znak_slevy;


			// částka DPH

			$this->total_tax += ($l[$i]->castka_dph * $l[$i]->mnozstvi);
		//	$this->total_tax += ($l[$i]->cena_sdph * $l[$i]->mnozstvi) - ($l[$i]->price * $l[$i]->mnozstvi);

			if (!empty($l[$i]->varianty_id)) {
				$l[$i]->product_description = $productController->getProductVariantText($l[$i]->product_id,$l[$i]->varianty_id);
			}

			if (!empty($l[$i]->varianty_code)) {
				$l[$i]->cislo = $l[$i]->varianty_code;
			}

			if (!empty($l[$i]->varianty_name)) {
				$l[$i]->title = $l[$i]->varianty_name;
			}



		//	print $this->total_tax . "<br />";
		}
		$this->basketList = $l;
	//	print "celkem DPH:" . $this->total_tax . "<br />";
		return $l;
	}

	public function getCelkovaCenaSDph()
	{
		return $this->total_price_sdph;
	}
	public function getCastkaDph()
	{
		return $this->total_tax;
	}


	/**
	 * Vrací celkovou cenu zboží s ohledem na nastavení cen s/bez DPH
	 * */
	public function getCelkovaCena()
	{
		$eshopSettings = G_EshopSetting::instance();
		if ($eshopSettings->get("PRICE_TAX") == "1") {
			return $this->getCelkovaCenaSDph();
		}
		return $this->getCelkovaCenaBezDph();
	}
	public function getCelkovaCenaBezDph()
	{
		return $this->total_price;
	}
	public function basketListTable($params = array())
	{
		$sorting = new G_Sorting("date","desc");

		//$params = array();
		//	$params['limit'] = 25;
		//	$zadankyController = new ZadankyController();
		//	$l = $zadankyController->zadankyListEdit($params);
		$l = $this->basketListEdit($params);


		$data = array();
		$th_attrib = array();




		$data = array();
		$th_attrib = array();
		$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
		$column["preview"] = '';
		$column["cislo"] = $sorting->render("Číslo", "num");
		$column["title"] = $sorting->render("Produkt", "prod");
		$column["BasketTimeStamp"] = $sorting->render("Vloženo / IP", "tree");
		//$column["skupina_nazev"] = $headCat;
		$column["prodcena"] = $sorting->render("Prod. cena", "prc");
		$column["mnozstvi"] = $sorting->render("Množ.", "qty");



	/*

		//$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
		$column["counter"] = '#';
		$column["faktura"] = $sorting->render("Faktura", "num"); // 'Žádanka /<br />Smlouva';
		$column["order_code"] = $sorting->render("Var.symbol", "vs"); //$g->get_orderByHead2(array('title'=>'Dodavatel','url'=>'dod','sql'=>'t1.partner'));
		//'Dodavatel';
		$column["shipping_first_name"] = $sorting->render("Odběratel", "stred");
		$column["cost_subtotal"] = $sorting->render("Částka", "price");
		$column["payment"] = $sorting->render("Uhrazeno", "payment");
		$column["maturity_date"] = $sorting->render("Splatnost", "maturity");

		$column["TimeStamp"] =  $sorting->render("Vloženo", "date");
		$column["print_pdf"] = 'Tisk/PDF';
		$column["cmd"] = '';

*/
				$th_attrib["preview"]["class"] = "column-thumb";
		$th_attrib["checkbox"]["class"] = "check-column";
		$th_attrib["code"]["class"] = "column-num";
		$th_attrib["order_code"]["class"] = "column-cat";
		$th_attrib["odberatel"]["class"] = "column-cat";

		$th_attrib["cmd"]["class"] = "column-cmd";
		$th_attrib["print_pdf"]["class"] = "column-cmd";

		$td_attrib["counter"]["class"] = "column-price check-column";
		$td_attrib["cost_subtotal"]["class"] = "column-price";
		$td_attrib["payment"]["class"] = "column-price";



		$table = new G_Table($l, $column, $th_attrib, $td_attrib);


		$table_attrib = array(
					"class" => "widefat",
					"id" => "data_grid",
					"cellspacing" => "0",
					);
		return $table->makeTable($table_attrib);
	}
	public function basketListEdit(IListArgs $params = null)
	{

		if (is_null($params)) {
			$params = new ListArgs();
		}

		$l = $this->basketList($params);

		$imageController = new ImageController();

		$eshopSettings = G_EshopSetting::instance();
	//	print_r($l);
	//	$g = new Zakl();
		//$this->total_price = 0;
		for ($i=0;$i < count($l);$i++)
		{
			//$this->total_price += $l[$i]->prodcena * $l[$i]->mnozstvi;
		/*	if (!empty($l[$i]->file)) {

				if (isset($params->thumb_width)) {
					$thumb_width = $params->thumb_width;
				}

				if (isset($params->thumb_height)) {
					$thumb_height = $params->thumb_height;
				}

				$PreviewUrl = '<img alt="'.$l[$i]->title.'" src="' . $imageController->get_thumb($l[$i]->dir.$l[$i]->file,$thumb_width,$thumb_height,null,false,true) . '" class="imgobal" />';
			} else {
				$PreviewUrl = '';
			}
*/
			new ProductWrapper($l[$i]);
			if (!empty($l[$i]->thumb_link)) {
				$PreviewUrl = '<img alt="'.$l[$i]->title.'" src="' . $l[$i]->thumb_link . '" class="imgobal" />';
			} else {
				$PreviewUrl = '';
			}


			$l[$i]->preview = $PreviewUrl;

			$product_id = $l[$i]->product_id;


		//	$product_url = URL_HOME . get_categorytourl($l[$i]->serial_cat_url) . "/" . $l[$i]->product_id .'-' . $l[$i]->url . '.html';

			$nazev_mat = '<a href="'.$l[$i]->link.'" title="'.$l[$i]->title.'">';
			$nazev_mat .= $l[$i]->title;
			$nazev_mat .= '</a>';

			//$l[$i]->nazev_mat_cs = $nazev_mat;

			$elemQty = new G_Form_Element_Text("qty[" . $i . "]");
			$elemQty->setAnonymous();
			$elemQty->setAttribs(array("is_int"=>true));
			$qtyValue = $this->getRequest->getPost("qty[" . $i . "]", number_format($l[$i]->mnozstvi, 0, ',', ''));
			$elemQty->setAttribs('value',$qtyValue);
			$elemQty->setAttribs('class','qty');
			$elemQty->setDecoration();

			if (!empty($l[$i]->tandem_id)) {
				$elemQty->setAttribs('disabled','disabled');
				$elemQty->setAttribs('class','qty disabled');
			}



			//	$elemQty->setAttribs('label','Nabízené množství:');
			$elemQty->setAttribs('style','width:40px;text-align:right;');
			$l[$i]->mnozstvi_edit = $elemQty->render();




				if ($eshopSettings->get("PRICE_TAX") == "0") {
					$l[$i]->cenacelkem_label = numberFormat($l[$i]->cenacelkem, $this->desetinna_mista) . ' ' . MENA;
					$l[$i]->cenamj = numberFormat($l[$i]->cena_po_sleve, $this->desetinna_mista) . ' ' . MENA;
				} else {
					$l[$i]->cenacelkem_label = numberFormat($l[$i]->cenacelkem_sdph, 0) . ' ' . MENA;
					$l[$i]->cenamj = numberFormat($l[$i]->cena_sdph_po_sleve, 0) . ' ' . MENA;
				}

			$l[$i]->BasketTimeStamp = date("j.n.Y H:i:s",strtotime($l[$i]->BasketTimeStamp)) . "<br />" . $l[$i]->ip_adresa . "<br />(" . $l[$i]->basket_id . ")";
		}

		return $l;
	}

	/**
	 * Přidávací proces do košíku
	 * */
	public function addProductProces($product_id, $qty, $varianty_id = null,
		$tandem_id = false, $tandem_id2 = false, $tandem_id3 = false)
	{

		if ($product_id) {
			$product_id = (int) $product_id;
		} else {
			// Nevyplněn ID productu
			$this->status["status"] = "product_id_not_specified";
			return false;
		}

		$productModel = new models_Products();
		$productDetail = $productModel->getDetailById($product_id);


	//	print_R($productDetail);
	//		exit;
		if (!$productDetail) {
			$this->status["status"] = "product_not_exist";
			return false;
		}

		if ($productDetail->aktivni == 0) {
			$this->status["status"] = "product_not_exist";
			return false;
		}

		if ($productDetail->isVarianty == 1 && is_null($varianty_id) ) {
			$this->status["status"] = "product_not_varianty";
			return false;
		}


		if ($qty > 0) {
			// ok
		} else {
			// Nevyplněno množství
			$this->status["status"] = "qty_not_specified";
			return false;
		}

		// Zavádím seanci
		if (isset($_SESSION["temp_cart"]) && !empty($_SESSION["temp_cart"])) {
			$basket_id = $_SESSION["temp_cart"];
		} else {
			$basket_id = mt_rand();
			$_SESSION["temp_cart"] = $basket_id;
		}
		$model = new models_Basket();

		$isProduct = $model->isProductBasket($product_id, $basket_id, $varianty_id);
		if ($isProduct == false) {

			// bez slevy,
			$jednotkovaCena = $productDetail->prodcena; // $productDetail->cena_bezdph;


			$jednotkovaCenaSDani = $productDetail->prodcena_sdph;

			if ($varianty_id > 0) {
				$modelProductVarianty = new models_ProductVarianty();
				$variantyDetail = $modelProductVarianty->getDetailById($varianty_id);

				if ($variantyDetail->product_id != $product_id) {
					$this->status["status"] = "wrong_varianty";
					return false;
				}
				if ($variantyDetail->price > 0) {
					$jednotkovaCena = $variantyDetail->price;

					$jednotkovaCenaSDani = $variantyDetail->price_sdani;
				}

			}





			$productBasketEntity = new ProductBasketEntity();
			$productBasketEntity->product_id = $product_id;
			$productBasketEntity->basket_id = $basket_id;
			$productBasketEntity->varianty_id = $varianty_id;
			$productBasketEntity->price = $jednotkovaCena;
			$productBasketEntity->price_sdani = $jednotkovaCenaSDani;
			$productBasketEntity->mnozstvi = $qty;
			$productBasketEntity->sleva = $productDetail->sleva;
			$productBasketEntity->typ_slevy = $productDetail->druh_slevy;

		//	print_r($productBasketEntity);
			$model->addProduct2($productBasketEntity);
			// neexistuje, přidávám
			if ($tandem_id) {
				$productBasketEntity->product_id = $tandem_id;
				$productBasketEntity->price = null;
				$model->addProduct2($productBasketEntity);

			//	$model->addProduct($tandem_id, $basket_id, $qty, null, $product_id, $varianty_id);
			}
			if ($tandem_id2) {
				$productBasketEntity->product_id = $tandem_id2;
				$productBasketEntity->price = null;
				$model->addProduct2($productBasketEntity);
			//	$model->addProduct($tandem_id2, $basket_id, $qty, null, $product_id, $varianty_id);
			}

			if ($tandem_id3) {
				$productBasketEntity->product_id = $tandem_id3;
				$productBasketEntity->price = null;
				$model->addProduct2($productBasketEntity);

			//	$model->addProduct($tandem_id3, $basket_id, $qty, null, $product_id, $varianty_id);
			}


			$this->status["status"] = "ok";
			return true;
		} else {

			// přidám množství + 1
			$model->updateProduct($product_id, $basket_id,$isProduct->mnozstvi + $qty);

			$this->status["status"] = "ok";
			return false;
		}
	}
	public function addProduct()
	{
    $eshopSettings = G_EshopSetting::instance();
    
		// Ověřím si
		if(($this->getRequest->isPost() && false !== $this->getRequest->getPost('add_product_basket', false))
    || ($this->getRequest->isPost() && false !== $this->getRequest->getPost('add_product_basket2', false) && $eshopSettings->get("BASKET_REDIRECT") == "2" ))
    
		{
			$product_id = $this->getRequest->getPost('product_id', false);
			$tandem_id = $this->getRequest->getPost('tandem_id', false);
			$tandem_id2 = $this->getRequest->getPost('tandem_id2', false);
			$tandem_id3 = $this->getRequest->getPost('tandem_id3', false);
			$varianty_id =  (int) $this->getRequest->getPost('varianty_id', null);


			$qty = (int) $this->getRequest->getPost('qty', 0);

			return $this->addProductProces($product_id, $qty, $varianty_id,
		                                  $tandem_id, $tandem_id2, $tandem_id3);
		}
    
    
	}
	public function changeQtyProduct()
	{
		// Ověřím si
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upd_product_basket', false))
		{


			$product_id = false;
			$qty = 0;
			//print_r($product_id);
			if (is_array($_POST["upd_product_basket"])) {


				foreach ($_POST["upd_product_basket"] as $key => $value){

					$product_id = (int) $_POST["product_id"][$key];
					$qty = (int) $_POST["qty"][$key];
				}
			} else {
				$product_id = $this->getRequest->getPost('product_id', false);
				$qty = (int) $this->getRequest->getPost('qty', 0);
			}
			if ($product_id) {
				$product_id = (int) $product_id;
			} else {
				// Nevyplněn ID productu
				return false;
			}

			if ($qty <= 0) {
				// Nulové nebo záporné množství
				$_SESSION["statusmessage"]="Nelze zadat nulové nebo záporné množství.";
				$_SESSION["classmessage"]="errors";
				return false;
			}
			$model = new models_Basket();
			$model->updateProduct($product_id, $this->basket_id, $qty);
			//$this->getRequest->clearPost();
			$this->getRequest->goBackRef();
		}
	}


	public function changeQtyProductAjax()
	{
		// Ověřím si
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('upd_product_basket', false))
		{



			$product_id = false;
			$qty = 0;

			$product_id = (int) $this->getRequest->getPost('product_id', false);
			$qty = (int) $this->getRequest->getPost('qty', 0);

			if ($product_id) {
				$product_id = (int) $product_id;
			} else {
				// Nevyplněn ID productu
				return false;
			}

			if ($qty <= 0) {
				// Nulové nebo záporné množství
			//	$_SESSION["statusmessage"]="Nelze zadat nulové nebo záporné množství.";
			//	$_SESSION["classmessage"]="errors";
				return false;
			}
      
            $modelProduct = new models_Products();
      
      $productDetail = $modelProduct->getDetailById($product_id);
      
      if (!$productDetail)
      {
      	return false;
			}
      
      if ($productDetail->qty > $qty)
      {
      	return false;
			}
      
			$model = new models_Basket();
			return $model->updateProduct($product_id, $this->basket_id, $qty);
			//$this->getRequest->clearPost();
			//$this->getRequest->goBackRef();
		}
	}

	public function deleteAjaxAction()
	{
		// Je odeslán formulář
		if($this->getRequest->isPost() && "ProductBasketDelete" == $this->getRequest->getPost('action', false))
		{

			$product_id = (int) $this->getRequest->getQuery('id', 0);
			$productModel = new models_Products();
			$productDetail = $productModel->getDetailById($product_id);

			if ($productDetail) {
				$model = new models_Basket();
				return $model->removeProduct($product_id, $this->basket_id);
			}
		}

		// Je odeslán formulář
		if($this->getRequest->isPost() && "ProductBasketAdminDelete" == $this->getRequest->getPost('action', false))
		{

			$product_id = (int) $this->getRequest->getQuery('id', 0);

			if ($product_id) {
				$model = new models_Basket();
				return $model->updateRecords($model->getTablename(), array("isDeleted" => 1),"id=" . $product_id);
			}
		}
	}

	public function saveAjaxAction()
	{
		if($this->getRequest->isPost() && "BasketEdit" ==$this->getRequest->getPost('action', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('BasketEdit');
			// Provedu validaci formu
			if ($form->isValid($this->getRequest->getPost()))
			{

				$postdata = $form->getValues();

				//	$postdata["description"]=  ($postdata["description"]);
				$foto_id = (int) $this->getRequest->getQuery('id', false);

				$FotoEntity = new ProductBasketEntity($foto_id);

				$FotoEntity->sleva = $postdata["sleva"];
				$FotoEntity->mnozstvi = $postdata["qty"];
				$FotoEntity->typ_slevy = $postdata["typ_slevy"];



				$saveEntity = new SaveEntity();

				$saveEntity->addSaveEntity($FotoEntity);

				if ($saveEntity->save()) {
					return true;
				}



			}


		}
	}

	/**
	 * Starý způsob
	 * */
	public function delProduct()
	{
		// Ověřím si
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('del_product_basket', false))
		{

			$product_id = false;
			//print_r($product_id);
			if (is_array($_POST["del_product_basket"])) {


				foreach ($_POST["del_product_basket"] as $key => $value){

					$product_id = $_POST["product_id"][$key];
				}
			} else {
				$product_id = $this->getRequest->getPost('product_id', false);
			}
			if ($product_id) {
				$product_id = (int) $product_id;
			} else {
				// Nevyplněn ID productu
				return false;
			}
/*
   // Zavádím seanci
   if (isset($_SESSION["temp_cart"]) && !empty($_SESSION["temp_cart"])) {
   $basket_id = $_SESSION["temp_cart"];
   } else {
   $basket_id = mt_rand();
   $_SESSION["temp_cart"] = $basket_id;
   }
*/
			$model = new models_Basket();
			$model->removeProduct($product_id, $this->basket_id);
			$this->getRequest->goBackRef();
		}

	}

	public function clearBasket()
	{
		$basket = new models_Basket();
	//	print $this->basket_id;
		$basket->clearBasket($this->basket_id);
	}
	public function getClearBasket()
	{
		// Ověřím si
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('del_all_basket', false))
		{
			$basket = new models_Basket();
			$basket->clearBasket($this->basket_id);
			$this->getRequest->goBackRef();
		}
	}
}
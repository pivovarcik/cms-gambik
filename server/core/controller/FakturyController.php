<?php

class FakturyController extends DokladBase
{
	public $faktura_code;
	public $doklad_id;

	public $faktura_pdf;
	public $faktura_details = array();

	function __construct()
	{
		parent::__construct("Faktura", "RadekFaktury", "RozpisDphFaktury");
	}

	public function fakturyListTable(IListArgs $params = null)
	{

		$sorting = new G_Sorting("date","desc");


		$l = $this->fakturyListEdit($params);

	//	print_r($l);
		$data = array();
		$th_attrib = array();
		//$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
		$column["counter"] = '#';
		$column["faktura"] = $sorting->render("Faktura", "num"); // 'Žádanka /<br />Smlouva';
	//	$column["order_code"] = $sorting->render("Objednávka", "vs"); //$g->get_orderByHead2(array('title'=>'Dodavatel','url'=>'dod','sql'=>'t1.partner'));
		//'Dodavatel';
		$column["shipping_first_name"] = $sorting->render("Odběratel", "stred");
		$column["cost_subtotal"] = $sorting->render("Bez DPH", "price");
		$column["cost_total"] = $sorting->render("Celkem", "price");
		$column["payment"] = $sorting->render("Zaplaceno", "payment");
		$column["maturity_date"] = $sorting->render("Splatnost", "maturity");

		$column["TimeStamp"] =  $sorting->render("Vloženo", "date");
		$column["print_pdf"] = 'Tisk/PDF';
		$column["cmd"] = '';


		$th_attrib["checkbox"]["class"] = "check-column";
		$th_attrib["code"]["class"] = "column-num";
		$th_attrib["order_code"]["class"] = "column-cat";
		$th_attrib["odberatel"]["class"] = "column-cat";

		$th_attrib["cmd"]["class"] = "column-cmd";
		$th_attrib["print_pdf"]["class"] = "column-cmd";

		$td_attrib["counter"]["class"] = "column-price check-column";
		$td_attrib["cost_subtotal"]["class"] = "column-price";
		$td_attrib["cost_total"]["class"] = "column-price";
		$td_attrib["payment"]["class"] = "column-price";



		$table = new G_Table($l, $column, $th_attrib, $td_attrib);


		$table_attrib = array(
							"class" => "widefat",
							"id" => "data_grid",
							"cellspacing" => "0",
							);
		return $table->makeTable($table_attrib);

	}

	public function fakturyList(IListArgs $params = null)
	{
		/*
		$limit 	= self::$getRequest->getQuery('limit', 100);
		if (isset($params['limit']) && is_numeric($params['limit'])) {
			$limit = $params['limit'];
		} else {
			$params['limit'] = $limit;
		}
		$page 	= self::$getRequest->getQuery('pg', 1);
		$params['page'] = $page;

		$date_from = self::$getRequest->getQuery('df', '');
		$date_from = !empty($date_from) ? $date_from : FILTER_FROM_DATE;
		if ( !empty($date_from) ) {
			$date_from_val =$date_from;
			$date_from = strtotime($date_from);
			$date_from = date("Y-m-d H:i:s",$date_from);
			$params['date_from'] = $date_from;
			//print $date_from;
		}
		$date_to = self::$getRequest->getQuery('dt', '');
		$date_to = !empty($date_to) ? $date_to : FILTER_TO_DATE;
		if ( !empty($date_to) ) {
			$date_to_val =$date_to;
			$date_to = strtotime($date_to);
			$date_to = date("Y-m-d",$date_to) . " 23:59:59";
			$params['date_to'] = $date_to;
			//print $date_to;
		}


		$querys = array();
		$querys[] = array('title'=>'žádanka','url'=>'num','sql'=>'t1.number');
		$querys[] = array('title'=>'středisko','url'=>'stred','sql'=>'t1.stredisko');
		$querys[] = array('title'=>'částka','url'=>'price','sql'=>'t1.castka');
		$querys[] = array('title'=>'vloženo','url'=>'date','sql'=>'t1.caszapsani');
		$querys[] = array('title'=>'částka schálená','url'=>'price_check','sql'=>'t1.castka_check');
		$querys[] = array('title'=>'žadatel','url'=>'user','sql'=>'t1.uid_komu');


		if (isset($params['order']) && !empty($params['order'])) {

		} else {
			$orderFromQuery = $this->orderFromQuery($querys, 't1.TimeStamp DESC');
			$params['order'] = $orderFromQuery;
		}
*/
		$model = new models_Faktury();
		$list = $model->getList($params);
		$this->total = $model->total;


		return $list;

	}
	public function fakturyListEdit(IListArgs $params = null)
	{
		$l = $this->fakturyList($params);
		for ($i=0;$i < count($l);$i++)
		{
			$span_start = '';
			$span_end = '';

			if ($l[$i]->storno == 1) {
				$span_start = '<span style="color:red;">';
				$span_end = '</span>';
			}

			$rozdilDnu = '';
			$stav_nazev = 'uhrazená';
			if (!empty($l[$i]->maturity_date) && ($l[$i]->cost_total - $l[$i]->amount_paid) > 0 ) {
				$rozdilA = diff(date("Y-m-d"),$l[$i]->maturity_date);
				$rozdilDnu = ' (' . ($rozdilA["day"]) . ')';
				$stav_nazev = 'neuhrazená';

			} else {
				$span_start = '<span class="vyrizena">';
				$span_end = '</span>';
				$style_color='vyrizena';
			}


			$l[$i]->nazev_stav = $stav_nazev;

			$l[$i]->counter = $span_start . ($i+1) . "." . $span_end;
			$odkaz_zadanka = '<a href="/admin/faktura_detail.php?id='.$l[$i]->id.'">' . $span_start. $l[$i]->code . $span_end . '</a> ';
			$l[$i]->faktura = $odkaz_zadanka;


			$description = '';
			if (!empty($l[$i]->description)) {
				$description = ' <span title="Poznámka: ' . truncateUtf8(trim(strip_tags($l[$i]->description)),300,false,true) .'" class="user_comment">U</span>';
			}
		/*	$description_secret = '';
			if (!empty($l[$i]->description_secret)) {
				$description_secret = ' <span title="Interní poznámka: ' . $l[$i]->description_secret .'" class="secret_comment">S</span>';
			}*/


			$l[$i]->cost_subtotal = $span_start. number_format($l[$i]->cost_subtotal, 2, ',', ' ') . $span_end;
			$l[$i]->cost_total = $span_start. number_format($l[$i]->cost_total, 2, ',', ' ') . $span_end;
			$l[$i]->payment = $span_start. number_format($l[$i]->amount_paid, 2, ',', ' ') . $span_end;

			$l[$i]->shipping_first_name = $span_start .$l[$i]->shipping_first_name . $span_end;

			$l[$i]->TimeStamp = $span_start . gDate($l[$i]->TimeStamp) . $span_end;

			$l[$i]->order_date = $span_start. date("j.n.Y H:i",strtotime($l[$i]->order_date)) . $span_end;

			$l[$i]->code_text = $l[$i]->code;
			$l[$i]->maturity_date = $span_start . gDate($l[$i]->maturity_date,"j.n.Y") . $rozdilDnu .  $span_end;

			$command = '<input class="" style="border:0 none;background-color:transparent;" onclick="return confirm(\'Opravdu STORNOVAT fakturu č. '.$l[$i]->code.'?\')" type="image" src="'.URL_HOME2 . 'admin/images/cancel.png" value="X" name="storno_faktura[' . $i . ']"/>';
			$command .= '<input type="hidden" value="' . $l[$i]->id . '" name="doklad_id[' . $i . ']"/>';
			$command .= '<input class="" style="border:0 none;background-color:transparent;" onclick="return confirm(\'Zkopírovat fakturu č. '.$l[$i]->code.'?\')" type="image" src="'.URL_HOME . 'admin/copy_icon.png" value="X" name="copy_faktura[' . $i . ']"/>';

			$l[$i]->tisk = '<a target="_blank" title="Tisk Objednávky v PDF" href="' . URL_HOME2 . 'admin/faktura_pdf.php?id=' . $l[$i]->id . '"><img src="' . URL_HOME2 . 'admin/style/images/acrobat_ico.gif"></a>';


			$l[$i]->print_pdf = '<a target="_blank" title="Tisk Faktury v PDF" href="' . URL_HOME2 . 'admin/faktura_pdf.php?id=' . $l[$i]->id . '"><img src="' . URL_HOME2 . 'admin/style/images/acrobat_ico.gif"></a>';
			$l[$i]->cmd = $command;


		}
		return $l;
	}
	public function getFaktura($id)
	{
		$model = new models_Faktury();
		$faktura = $model->getFaktura($id);
		$this->faktura_details = $model->getFakturaDetail($id);
		return $faktura;
	}


	public function fakturyListUserTable(IListArgs $params = null)
	{
		$eshopController = new EshopController();
		$sorting = new G_Sorting("date","desc");

		//$params = array();
		$l = $this->fakturyListEdit($params);


		$data = array();
		$th_attrib = array();
		$column["code_text"] = $sorting->render("Číslo", "code");
		if ($eshopController->setting["PLATCE_DPH"] == "1"){
			$column["cost_subtotal"] = $sorting->render("Cena bez DPH", "total");
			$column["cost_total"] = $sorting->render("Cena s DPH", "total");
		} else {
			$column["cost_subtotal"] = $sorting->render("Cena", "total");
		}

		$column["nazev_stav"] = $sorting->render("Stav", "date");
		$column["order_date"] = $sorting->render("Přijato", "date");
		$column["tisk"] = 'Tisk PDF';

		$th_attrib["checkbox"]["class"] = "check-column";
		$th_attrib["preview"]["class"] = "column-thumb";
		$th_attrib["order_code"]["class"] = "column-num";
		$th_attrib["shipping_last_name"]["class"] = "column-cat";
		$th_attrib["shipping_email"]["class"] = "column-cat";
		$th_attrib["cost_total"]["class"] = "column-price";
		$th_attrib["cost_subtotal"]["class"] = "column-price";
		$th_attrib["qty"]["class"] = "column-qty";


		$th_attrib["tisk"]["class"] = "column-cmd";
		$th_attrib["order_date"]["class"] = "column-date";
		$th_attrib["shipping_phone"]["class"] = "column-date";

		$td_attrib =array();
		$td_attrib["cost_subtotal"]["class"] = "column-price";
		$td_attrib["cost_total"]["class"] = "column-price";

		$td_attrib["code_text"]["class"] = "column-cmd";
		$td_attrib["tisk"]["class"] = "column-cmd";
		$td_attrib["nazev_stav"]["class"] = "column-cmd";
		$td_attrib["order_date"]["class"] = "column-date";
		$td_attrib["shipping_phone"]["class"] = "column-date";
		$td_attrib["cost_subtotal"]["class"] = "column-price";
		$td_attrib["cost_total"]["class"] = "column-price";

		$table = new G_Table($l, $column, $th_attrib, $td_attrib);


		$table_attrib = array(
							"class" => "widefat",
							"id" => "data_grid",
							"cellspacing" => "0",
							"print_foot" => "0",
							);
		return $table->makeTable($table_attrib);

	}


	/**
	 * Převede řádky dokladu na wrapper
	 * */
	public function radkyDokladuProTiskWrapper($radkyDokladu = array())
	{
		$radkyWrapper = array();
		for ($i=0; $i<count($radkyDokladu); $i++)
		{
			$product_code = (!empty($radkyDokladu[$i]->product_code)) ? $radkyDokladu[$i]->product_code . "&nbsp;" : "";
			$radkyWrapper[$i]->product_name = $product_code . "" . $radkyDokladu[$i]->product_name;

			$product_description = (!empty($radkyDokladu[$i]->product_description)) ? '<div style="font-style:italic;">' . $radkyDokladu[$i]->product_description . '</div>' : "";
			$radkyWrapper[$i]->product_name .= $product_description;

			$vyse_slevy = 0;
			$znak_slevy = "";
			if ($radkyDokladu[$i]->sleva <> 0 && $radkyDokladu[$i]->price <> 0) {

				if ($radkyDokladu[$i]->typ_slevy == "%") {
					$vyse_slevy = $radky[$i]->price * $radkyDokladu[$i]->sleva / 100;
					$znak_slevy = "%";
				} else {
					$vyse_slevy = $radkyDokladu[$i]->price + $radkyDokladu[$i]->sleva;
					$znak_slevy = "";
				}

				$radkyWrapper[$i]->sleva = $radkyDokladu[$i]->sleva . $znak_slevy;
			}


			$radkyWrapper[$i]->celkem = ($radkyDokladu[$i]->price + $vyse_slevy) * $radkyDokladu[$i]->qty;

			$celkem_na_radku2 = $radkyDokladu[$i]->celkem;
			$castkaDpheRadku = 0;
			$zakladDaneRadku = 0;
			if ($radky[$i]->tax_value > 0) {

				$dphRadku = $radky[$i]->qty * ((100+$radky[$i]->tax_value)*0.01);
				$celkem_na_radku2 = $radky[$i]->price * $dphRadku;
				$celkem_na_radku2 = round($celkem_na_radku2,0);

				$castkaDpheRadku = ($radky[$i]->price * $dphRadku) - ($radky[$i]->price*$radky[$i]->qty);
			}

			if (!isset($rozpisDph[$radky[$i]->tax_id])) {
				$rozpisDph[$radky[$i]->tax_id] = array("tax_id"=>$radky[$i]->tax_id, "sazba"=>$radky[$i]->tax_name,
				"castka"=>$castkaDpheRadku, "zaklad"=>($radky[$i]->price*$radky[$i]->qty));
			} else {
				$rozpisDph[$radky[$i]->tax_id]["castka"] += $castkaDpheRadku;
				$rozpisDph[$radky[$i]->tax_id]["zaklad"] += ($radky[$i]->celkem);
			}


			$radky[$i]->celkem = numberFormatNowrap($celkem_na_radku2);
			$radky[$i]->price = numberFormatNowrap($radky[$i]->price);
			$radky[$i]->qty = numberFormatNowrap($radky[$i]->qty, 0) . "&nbsp;" . $radky[$i]->nazev_mj;
		}

		return $radkyWrapper;

	}
	public function zpracujRadkyDokladu($doklad_id)
	{
		$modelRadkuFaktury = new models_RadekFaktury();

		$params = new ListArgs();
		$params->doklad_id = (int) $doklad_id;
		$params->limit = 1000;
		$radky = $modelRadkuFaktury->getList($params);

		for ($i=0;$i<count($radky);$i++)
		{
			$product_code = (!empty($radky[$i]->product_code)) ? $radky[$i]->product_code . "&nbsp;" : "";
			$radky[$i]->product_name = $product_code . "" . $radky[$i]->product_name;

			$product_description = (!empty($radky[$i]->product_description)) ? '<div style="font-style:italic;">' . $radky[$i]->product_description . '</div>' : "";
			$radky[$i]->product_name .= $product_description;

			$celkem_na_radku2 = $radky[$i]->entitty->celkem;



			$radky[$i]->celkem = numberFormatNowrap($celkem_na_radku2);
			$radky[$i]->price = numberFormatNowrap($radky[$i]->price);
			$radky[$i]->qty = numberFormatNowrap($radky[$i]->qty, 0) . "&nbsp;" . $radky[$i]->nazev_mj;
		}

		return $radky;
	}

	public function radkyDokladuTable($doklad_id)
	{

		$radky = $this->zpracujRadkyDokladu($doklad_id);



		$th_attrib = array();
		$th_attrib["counter"]["class"] = "check-column";
		$th_attrib["product_code"]["class"] = "column-cena";
		$th_attrib["qty"]["class"] = "column-qty";
		$th_attrib["mj"]["class"] = "column-qty";
		$th_attrib["tax"]["class"] = "column-qty";
		$th_attrib["sleva"]["class"] = "column-qty";
		$th_attrib["celkem"]["class"] = "column-price";
		$th_attrib["price"]["class"] = "column-price";
		$th_attrib["cmd"]["class"] = "column-ckeck";

		$td_attrib = array();
		$td_attrib["celkem"]["class"] = "column-price";
		$td_attrib["qty"]["class"] = "column-price";
		$td_attrib["sleva"]["class"] = "column-price";
		$td_attrib["price"]["class"] = "column-price";


		$column["product_name"] =   $translator->prelozitFrazy("product");
		$column["qty"] =   $translator->prelozitFrazy("mnozstvi");
		//		$column["mj"] =   "Jednotka";

		$column["price"] =   $translator->prelozitFrazy("cena_za_jednotku");
		if ($eshopController->setting["PLATCE_DPH"] == "1"){
			$column["tax_name"] =   $translator->prelozitFrazy("sazba_dph");
			$td_attrib["tax_name"]["class"] = "column-price";
		}
		$column["sleva"] =   $translator->prelozitFrazy("sleva");

		$column["celkem"] =   $translator->prelozitFrazy("celkem");






		$table = new G_Table($radky, $column, $th_attrib, $td_attrib);


		$table_attrib = array(
		"class" => "table_header widefat",
		"id" => "data_grid",
		"cellspacing" => "0",
		"print_foot" => 0
		);
		return $table->makeTable($table_attrib);
	}

	public function createHtml($doklad_id)
	{
		//$eshopController = new EshopController();
		$eshopSettings = G_EshopSetting::instance();
		$translator = G_Translator::instance();
		$modelFakrury = new models_Faktury();

		$modelRadkuFaktury = new models_RadekFaktury();

		$modelRozpisDph = new models_RozpisDphFaktury();

		$params = new ListArgs();
		$params->doklad_id = (int) $doklad_id;
		$params->limit = 1000;

		$radkyRozpisuDph = $modelRozpisDph->getList($params);
	//	exit;
		$doklad = $modelFakrury->getDetailById($doklad_id);


		if (!$doklad)
		{
			return;
		}

		$params = new ListArgs();
		$params->doklad_id = (int) $doklad_id;
		$params->limit = 1000;


		$sloupcu = 3;
		if ($eshopSettings->get("PLATCE_DPH") == "1"){
			$sloupcu += 1;
		}




//		$rozpisDph = array();

		//	print_r($doklad);
		$radky = $modelRadkuFaktury->getList($params);

		//print_r($radky);
	//	exit;
		$jeSleva = false;
		for ($i=0;$i<count($radky);$i++)
		{

			$product_code = (!empty($radky[$i]->product_code)) ? $radky[$i]->product_code . "&nbsp;" : "";
			$radky[$i]->product_name = $product_code . "" . $radky[$i]->product_name;

			$product_description = (!empty($radky[$i]->product_description)) ? '<div style="font-style:italic;">' . $radky[$i]->product_description . '</div>' : "";
			$radky[$i]->product_name .= $product_description;


			$celkem_na_radku2 = $radky[$i]->entity->celkem;
			$castkaDpheRadku = 0;
			$zakladDaneRadku = 0;
			/*if ($radky[$i]->tax_value > 0) {

				$celkem_na_radku2 = $radky[$i]->entity->celkem * ((100+$radky[$i]->tax_value)*0.01);;
				$celkem_na_radku2 = round($celkem_na_radku2,0);
			}*/


            /*
			// celková cena řádku bez DPH
			$radky[$i]->celkem = $celkem_na_radku2;

			$radky[$i]->sleva = $radky[$i]->sleva . $radky[$i]->typ_slevy;

		//	$radky[$i]->price = numberFormatNowrap($radky[$i]->price);
			$radky[$i]->qty = numberFormatNowrap($radky[$i]->qty, 0) . "&nbsp;" . $radky[$i]->nazev_mj;
			if ($radky[$i]->sleva <> 0) {
				$jeSleva = true;
			}

			if ($eshopSettings->get("PLATCE_DPH") == "1"){

				if ($radky[$i]->tax_value > 0) {

					$sazba = $radky[$i]->tax_value/100;
					$radky[$i]->celkem = $radky[$i]->celkem + $radky[$i]->celkem * $sazba;
				}
			}

			$radky[$i]->celkem = numberFormatNowrap($radky[$i]->celkem);
      
      
             */
      
      
      
      ///////////////
      
                   			if ($eshopSettings->get("PLATCE_DPH") == "1" &&  $eshopSettings->get("PRICE_TAX") == 0) {
				$celkem_na_radku2 = $radky[$i]->entity->celkem;
			} else {
				$celkem_na_radku2 = $radky[$i]->entity->celkem + ($radky[$i]->tax_value * $radky[$i]->entity->celkem / 100);
			}
			$castkaDpheRadku = 0;
			$zakladDaneRadku = 0;

			// celková cena řádku bez DPH
			$radky[$i]->celkem = $celkem_na_radku2;

			$radky[$i]->sleva = $radky[$i]->sleva . $radky[$i]->typ_slevy;
			$radky[$i]->celkem = numberFormatNowrap($radky[$i]->celkem);

			if ($eshopSettings->get("PLATCE_DPH") == "1" &&  $eshopSettings->get("PRICE_TAX") == 0) {
				$radky[$i]->price = numberFormatNowrap($radky[$i]->price);
			} else {
				$radky[$i]->price = numberFormatNowrap($radky[$i]->price + ($radky[$i]->tax_value * $radky[$i]->price / 100));
			}
			$radky[$i]->qty = numberFormatNowrap($radky[$i]->qty, 0) . "&nbsp;" . $radky[$i]->nazev_mj;

			if ($radky[$i]->sleva <> 0) {
				$jeSleva = true;
			}

      
      
      /////////////

		}

		if ($eshopSettings->get("SLEVA_DOKLAD_TISK") == "1" && $jeSleva){
			$sloupcu += 1;
		}


	//	$rozpisDph2 = $this->radkySazebDphDokladu($radky);
		//		print_r($rozpisDph);
		//	exit;



	//	print_r($doklad);

		$th_attrib = array();
		$td_attrib = array();

		$th_attrib["counter"]["class"] = "check-column";
		$th_attrib["product_code"]["class"] = "column-cena";
		$th_attrib["qty"]["class"] = "column-qty";
		$th_attrib["mj"]["class"] = "column-qty";
		$th_attrib["tax"]["class"] = "column-qty";
		$th_attrib["sleva"]["class"] = "column-qty";

		$th_attrib["celkem"]["class"] = "column-price";
		$th_attrib["price"]["class"] = "column-price";
		$th_attrib["cmd"]["class"] = "column-ckeck";
		//$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
		//	$column["counter"] = '#';
		//	$column["product_code"] =   "Číslo";
		$column["product_name"] =   $translator->prelozitFrazy("product");
		$column["qty"] =   $translator->prelozitFrazy("mnozstvi");
		//		$column["mj"] =   "Jednotka";

		$column["price"] =   $translator->prelozitFrazy("cena_za_jednotku");


		if ($eshopSettings->get("SLEVA_DOKLAD_TISK") == "1" && $jeSleva){
			$column["sleva"] =   $translator->prelozitFrazy("sleva");
		}
		if ($eshopSettings->get("PLATCE_DPH") == "1"){
			$column["tax_name"] =   $translator->prelozitFrazy("sazba_dph");
			$td_attrib["tax_name"]["class"] = "column-price";
		}





		$column["celkem"] =   $translator->prelozitFrazy("celkem");


		$td_attrib["celkem"]["class"] = "column-price";
		$td_attrib["qty"]["class"] = "column-price";
		$td_attrib["sleva"]["class"] = "column-price";

		$td_attrib["price"]["class"] = "column-price";
		$table = new G_Table($radky, $column, $th_attrib, $td_attrib);


		$table_attrib = array(
		"class" => "table_header widefat",
		"id" => "data_grid",
		"cellspacing" => "0",
		"print_foot" => 0
		);



		//	print_r($doklad);
		$th_attrib = array();
		$td_attrib = array();

		$th_attrib["tax"]["class"] = "column-qty";
		$th_attrib["zaklad"]["class"] = "column-cena";
		$th_attrib["castka"]["class"] = "column-cena";

		$td_attrib["castka"]["class"] = "column-price";
		$td_attrib["zaklad"]["class"] = "column-price";


		//	$column["counter"] = '#';
		//	$column["product_code"] =   "Číslo";

		$column = array();
		$column["name"] =   $translator->prelozitFrazy("sazba_dph");
		$column["zaklad_dph_label"] =   $translator->prelozitFrazy("zaklad_dph");
		$column["vyse_dph_label"] =   $translator->prelozitFrazy("castka_dph");

		$tableRozpis = new G_Table($radkyRozpisuDph, $column, $th_attrib, $td_attrib);

		$table_attrib2 = array(
		"class" => "table_rozpis_dph widefat",
		"id" => "data_grid2",
		"cellspacing" => "0",
		"print_foot" => 0
	);
		$table_attrib = array(
		"class" => "table_header widefat",
		"id" => "data_grid",
		"cellspacing" => "0",
		"print_foot" => 0
	);

		/*
		   $zpusob_dopravy_text = $orders->nazev_dopravy;
		   $zpusob_platby_text = $orders->nazev_platby;

		   $mjList = $this->eshop->mj_list(array("limit"=>1000,"debug"=>0));
		   $dphList = $this->eshop->dph_list(array("limit"=>1000,"debug"=>0));
		*/
		$pagetitle = $translator->prelozitFrazy("danovy_doklad_faktura");

		//$g->set_pagetitle($pagetitle);
		//$g->set_pagedescription($pagedescription);
		//$g->print_html_header();
		$html = '';
		$html .= '
		<html lang="cs-CZ">
		<head>';
		$html .= '	<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
		$html .= '<style>' . file_get_contents(dirname(__FILE__) . "/../../admin/style/print_pdf.css") . '</style>';
		//$html .= '<link rel="stylesheet" href="/public/style/print_pdf.css" type="text/css" />';
		$html .= '
		</head>
		<body>';
		$html .= '
		<table class="zahlavi" style="border: 0 none;" border="0">
		<tr height="55px;">
			<td width="360px">';

		if ($eshopSettings->get("LOGO_PDF") != "") {
			$html .= '<img style="max-width:100%;" src="'. URL_IMG . $eshopSettings->get("LOGO_PDF").'">';
		}

		$html .= '</td>
			<td style="text-align:left;"><h2 style="font-weight:bold;">'.$translator->prelozitFrazy($doklad->typ_faktury_name . "_cislo").' '.$doklad->code.'</h2><br />
		'.$translator->prelozitFrazy("variabilni_symbol").': '.$doklad->code.'
		</td>
		</tr>
		</table>';

		$html .= '
		<table style="width:100%;border: 1px solid #000000;table-layout: fixed;" cellspacing="0" cellpadding="0">
			<tr>
			<td rowspan=2 width="50%" style="vertical-align: top;padding:10px;">

				<span style="font-size: 11px;font-style: italic;">'.$translator->prelozitFrazy("dodavatel").':</span><br />
			<div style="padding-left: 25px;">
		<span style="font-size:14px;font-weight:bold;">' . $eshopSettings->get("COMPANY_NAME") . '</span><br /><br />
		<strong>' . $eshopSettings->get("ADDRESS1") . '</strong><br />
		<strong>' . $eshopSettings->get("ZIP_CODE") . ' ' . $eshopSettings->get("CITY") . '</strong>';

		if ($eshopSettings->get("COUNTRY") != "") {
			$html .= '<br /><strong>' . $eshopSettings->get("COUNTRY") . '</strong>';
		}

		if ($eshopSettings->get("EMAIL_ORDER") !="") {
			$html .= '<br /><strong>' . $eshopSettings->get("EMAIL_ORDER") . '</strong><br />';
		}
		$html .= '<br /><br />';


		$html .= $translator->prelozitFrazy("ico").': <strong>' . $eshopSettings->get("ICO") . '</strong><br />
		'.$translator->prelozitFrazy("dic").': <strong>' . $eshopSettings->get("DIC") . '</strong><br /><br />
		'.$translator->prelozitFrazy("cislo_uctu_iban").':<br />
		<strong>' . $eshopSettings->get("UCET") . '</strong><br />
		<strong>' . $eshopSettings->get("IBAN") . '</strong><br />

		<span>' . $eshopSettings->get("OR") . '</span>';

		if ($eshopSettings->get("PLATCE_DPH") == "1"){
			$html .= '<br /><span>'.$translator->prelozitFrazy("dodavatel_platce").'</span>';
		} else {
			$html .= '<br /><span>'.$translator->prelozitFrazy("dodavatel_neplatce").'</span>';
		}
		$html .= '</div>

			</td>

			<td  width="50%" style="vertical-align: top;padding:10px;border: 2px solid #000000;">
						<span style="font-size: 11px;font-style: italic;">'.$translator->prelozitFrazy("odberatel").':</span>

			<div style="padding-left: 25px;">
				<div style="font-size:14px;font-weight:bold;margin-bottom:10px;">' . $doklad->shipping_first_name . '</div>
				<div class="fak_adresa">
					<strong>' . $doklad->shipping_last_name . '</strong><br />
					<strong>' . $doklad->shipping_address_1 . '</strong><br />
					<strong>' . $doklad->shipping_zip_code . ' ' . $doklad->shipping_city . '</strong><br />';

		if (!empty($doklad->shipping_ico)) {
			$html .= ''.$translator->prelozitFrazy("ico").': <strong>' . $doklad->shipping_ico. '</strong><br />';
		}
		if (!empty($doklad->shipping_dic)) {
			$html .= ''.$translator->prelozitFrazy("dic").': <strong>' . $doklad->shipping_dic. '</strong><br />';
		}
		$html .= '
				</div>';

		$html .= '<div class="dod_adresa"><br /><span style="font-size: 11px;font-style: italic;">'.$translator->prelozitFrazy("dodaci_adresa").':</span><br />';
		if (!empty($doklad->shipping_first_name2)) {
			$html .= '<strong>' . $doklad->shipping_first_name2. '</strong><br />';
		}
		if (!empty($doklad->shipping_last_name2)) {
			$html .= '<strong>' . $doklad->shipping_last_name2. '</strong><br />';
		}
		if (!empty($doklad->shipping_address_12)) {
			$html .= '<strong>' . $doklad->shipping_address_12. '</strong><br />';
		}
		if (!empty($doklad->shipping_city2)) {
			$html .= '<strong>' . $doklad->shipping_zip_code2. ' ' . $doklad->shipping_city2. '</strong><br />';
		}


		$html .= '</div>';


		$html .= '
			</div>';
		$html .= '';

		$html .= '</td>
			</tr>
			<tr>
				<td style="vertical-align: top;padding:10px;">
				<div style="padding-left: 25px;">
			'.$translator->prelozitFrazy("order_code").': <strong>'.$doklad->order_code.'</strong><br />

			'.$translator->prelozitFrazy("datum_vystaveni").': <strong>'.gDate($doklad->faktura_date,"j.n.Y").'</strong><br />
'.$translator->prelozitFrazy("datum_splatnosti").': <strong>'.gDate($doklad->maturity_date,"j.n.Y").'</strong>';

		// jen je-li plátce a není proforma
if ($eshopSettings->get("PLATCE_DPH") == "1" && $doklad->faktura_type_id != "2"){
	$html .= '<br />' . $translator->prelozitFrazy("duzp").': <strong>'.gDate($doklad->duzp_date,"j.n.Y").'</strong>';
}
if (!empty($doklad->nazev_dopravy)){
			$html .= '<br />' . $translator->prelozitFrazy("zpusob_dopravy").': <strong>' . $doklad->nazev_dopravy . '</strong>';

}
			$html .= '<br />'.$translator->prelozitFrazy("zpusob_platby").': <strong>' . $doklad->nazev_platby . '</strong><br />
			</div>
			</td></tr>
			</table>
		';


		$html .= '
			<table class="zahlavi" style="border: 0 none;" border="0">
			<tr>
		<td style="text-align:left;">'.$translator->prelozitFrazy("uvodni_text_faktury").'</td>
			</tr>
			</table>';


	//	$html .='<div>' . $doklad->description . '</div>';


		$html .= $table->makeTable($table_attrib);


		$html .='<table id="data_grid" class="table_header" >
		<tr  class="rozpis">
			<td colspan="4" style="text-align:right;"></td>
		     <td style="text-align:right;width:75px;"></td>
		     </tr>';

		$html .='<tr height="25px">

			<td colspan="4" style="text-align:right;font-weight:bold;white-space:nowrap;">'.$translator->prelozitFrazy("mezisoucet").':</td>
			<td style="text-align:right;width:75px;font-weight:bold;white-space:nowrap;">'.numberFormatNowrap($doklad->cost_subtotal).'</td>
		</tr>';

		if ($eshopSettings->get("PLATCE_DPH") == "1"){

			$html .='<tr height="25px">
				<td colspan="4" style="text-align:left;font-weight:bold;text-align:right;white-space:nowrap;">'.$translator->prelozitFrazy("vyse_dane").':</td>
				<td style="text-align:right;width:75px;font-weight:bold;white-space:nowrap;">'.numberFormatNowrap($doklad->cost_tax).'</td>
			</tr>';
	}

		if ($doklad->amount_paid <> 0){

			$html .='<tr height="25px">
				<td colspan="4" style="text-align:left;font-weight:bold;text-align:right;white-space:nowrap;">'.$translator->prelozitFrazy("zaplaceno").':</td>
				<td style="text-align:right;width:75px;font-weight:bold;white-space:nowrap;">'.numberFormatNowrap($doklad->amount_paid).'</td>
			</tr>';
		}

			$html .='<tr height="25px">
					<td colspan="4" style="text-align:left;font-weight:bold;text-align:right;font-size:14px;white-space:nowrap;">'.$translator->prelozitFrazy("celkova_cena_objednavky_sdani").':</td>
					<td style="text-align:right;width:75px;font-weight:bold;font-size:14px;white-space:nowrap;">'.numberFormatNowrap(round($doklad->cost_total - $doklad->amount_paid,0)).'</td>
				</tr>';



		$html .= '</tbody>
			</table>';

		if ($eshopSettings->get("PLATCE_DPH") == "1"){
		$html .= '<strong>'.$translator->prelozitFrazy("rozpis_dph").'</strong>';
			$html .=  $tableRozpis->makeTable($table_attrib2);

			$html .= '<table class="table_footer">
		<tbody>';
		}
		if (($doklad->cost_total - $doklad->amount_paid) <=0) {
			$html .= '

			<tr>
			<td style="text-align:left;font-weight:bold;">'.$translator->prelozitFrazy("faktura_byla_uhrazena").'</td>
			</tr>
			';

		}
		if ($doklad->faktura_type_id == "2") {
		$html .= '
				<tr>
				  <td>
		<span style="font-size:9px;">'.$translator->prelozitFrazy("poznamka_proforma").'</span>
		</td>
				</tr>';
		}


				if (!empty($doklad->description)) {
		$html .= '<tr>
		  <td>
			<span style="font-size:9px;"><strong>'.$translator->prelozitFrazy("poznamka_faktury").':</strong></span>
			</td>
		</tr>';


			$html .= '

			<tr>
				<td style="text-align:left;">' . $doklad->description.'</td>
			</tr>
				';

		}


		if ($eshopSettings->get("RAZITKO_FAK_PDF") !="") {

			$html .= '

			<tr>
			  <td><img src="'.$eshopSettings->get("RAZITKO_FAK_PDF").'" /></td>
			</tr>';
		}

		$html .= '</tbody>
		</table>';
		$html .= '
		</body>
		</html>';

		//	print $table->makeTable($table_attrib);
		return $html;
	}

	public function createPDF($doklad_id, $return_data="F")
	{

	//	$eshopController = new EshopController();
		$translator = G_Translator::instance();
		$modelFakrury = new models_Faktury();

    if (isInt($doklad_id))
    {
       $doklad = $modelFakrury->getDetailById($doklad_id);
    }  else {
       $doklad = $modelFakrury->getDetailByDownloadHash($doklad_id);
    }
		

		$html = $this->createHtml($doklad->id);
		//$mpdf=new mPDF('utf-8','A5-L');
		require_once(PATH_CMS. "plugins/mpdf60/mpdf.php");
	//	require_once(dirname(__FILE__) . "/../library/mpdf60/mpdf.php");
			//	exit;
		$mpdf=new mPDF('utf-8','A4');
		//$mpdf=new mPDF('','A5');
		//$mpdf=new mPDF('en-GB-x','A4','','',10,10,10,10,6,3);
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetMargins(0,0,4);
		$title = "Faktura č." . $doklad->code;
		$mpdf->SetTitle($title);
		$subject = "";
		$mpdf->SetSubject($subject);
		$author = "CMS Gambik - pivovarcik.cz";
		$mpdf->SetAuthor($author);
		$keywords = "";
		$mpdf->SetKeywords($keywords);
		//$stylesheet = file_get_contents('/style/print.css');
		//$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

	//	print $html;
		//return;
		$mpdf->WriteHTML($html);
		//$mpdf->Output($orders->order_code.".pdf","D");
		//$url_file = dirname(__FILE__) . "/../../public/data/" . $doklad->code.".pdf";
    $url_file = PATH_DATA . $orders->code.".pdf";

		if ($return_data == "D" || $return_data == "I") {
			$url_file = $doklad->code.".pdf";
		}


		$mpdf->Output($url_file, $return_data);
		return $url_file;
	}

	public function copyAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('copy_faktura', false))
		{

			$tenzin = self::$getRequest->getPost('copy_faktura', false);
			list($key,$value) = each($tenzin);
			//	print $key;
			$doklad_id = $_POST['doklad_id'][$key];

			if ($doklad_id) {

				if (self::copyDoklad($doklad_id)) {
					$_SESSION["statusmessage"]="Faktura byla zkopírována.";
					$_SESSION["classmessage"]="success";
					//	self::$getRequest->goBackRef();
				}
			}

		}

		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false)
			&& "copyFaktura" == self::$getRequest->getPost('action', false))
		{
			$selectedItems = self::$getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						$model = new models_Faktura();
						$obj = $model->getDetailById($doklad_id);
						if ($obj) {
							if (self::copyDoklad($doklad_id))
							{
								array_push($seznamCiselObjednavek,$obj->code );
							}
						}
					}
				}
				array_reverse($seznamCiselObjednavek);
				$_SESSION["statusmessage"]="Faktura " . implode(",", $seznamCiselObjednavek) . " byla zkopírována.";
				$_SESSION["classmessage"]="success";
				self::$getRequest->goBackRef();
			}
		}
	}

	public function saveAction()
	{
		//&& false !== self::$getRequest->getPost('id', false)
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('save', false)
			)
		{
			// Valid form
			$form = $this->formLoad('FakturaEdit');
			$formRadky = $this->formLoad('RadekFakturyEdit');
			if ($form->isValid(self::$getRequest->getPost()))
			{
				$formdata = $form->getValues();


				$dokladSaveData = self::setDokladData($formdata, $form->doklad);

				$postdataRadky = $formRadky->getValues();
				$postdataRadky = postToArray($postdataRadky);
				$radkySaveData = self::setRadkyData($postdataRadky, $formRadky->radkyOriginal);

				if (self::saveData($dokladSaveData, $radkySaveData)) {
					$form->setResultSuccess("Doklad byl aktualizován.");
					self::$getRequest->goBackRef();
				}
				return false;
			}
		}
	}

	public function createAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('ins', false))
		{
			// Valid form
			$form = $this->formLoad('FakturaCreate');
			$formRadek = $this->formLoad('RadekFakturyCreate');
			if ($form->isValid(self::$getRequest->getPost()))
			{

				$postdata = $form->getValues();


				$postdataRadky = $formRadek->getValues();
				$postdataRadky = postToArray($postdataRadky);

				$savedData = $this->createDoklad($postdata, $postdataRadky);


				if ($savedData) {
					$form->setResultSuccess('Záznam byl přidán. <a href="'.URL_HOME2.'admin/faktura_detail?id='.$savedData["id"].'">Přejít na právě pořízený záznam.</a>');
					self::$getRequest->goBackRef();
				}
					return false;
			}
		}

	}

/*
	// TODO trochu zobecnit a přesunout na předka !!!
	// obecná třída pro založení dokladu odkudkoliv
	public function createDoklad($doklad, $radky)
	{

		$dokladSaveData = self::setDokladData($doklad);

		$code =  $dokladSaveData->getCode();

		if (empty($code)) {

		//	print "tudyyyyyyyyyyyyyyyyyyyy";
			$nextIdModel = new models_NextId();
			$order_code = $nextIdModel->vrat_nextid(array(
					"tabulka"=> T_FAKTURY,
					"polozka"=> "code",
					"rada_id"=> $eshopController->setting["NEXTID_FAKTURA"],
				));
			$dokladSaveData->code = $order_code;
		}

		//print_r($dokladSaveData);
	//	exit;
		$radkySaveData = self::setRadkyData($radky);

		if (self::saveData($dokladSaveData, $radkySaveData)) {
			return self::getDokladSaveData();
		}
		return false;
	}*/

	public function sendEmailZakaznik($order_email)
	{
		$mail = new PHPMailer();
		$eshopController = new EshopController();
		//$eshop = new Eshop();
		$mail->Body ='';
		$mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
		//$mail->Host = "localhost";  // zadáme adresu SMTP serveru


		$mail->Host = $eshopController->setting["EMAIL_SMTP_SERVER"];
		$mail->SMTPAuth = ($eshopController->setting["EMAIL_SMTP_AUTH"]=="1") ? true : false;

		$mail->Username = $eshopController->setting["EMAIL_USERNAME"];  // uživatelské jméno pro SMTP autentizaci
		$mail->Password = $eshopController->setting["EMAIL_PWD"];           // heslo pro SMTP autentizaci

		$mail->From = $eshopController->setting["EMAIL_ORDER"];
		//$mail->From = "objednavky@kolakv.cz";   // adresa odesílatele skriptu
			//$mail->FromName = "Objednávka kolaKV.cz"; // jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)
		$mail->FromName = $eshopController->setting["EMAIL_ORDER_ALIAS"]; //"Objednávka"; // jméno odesílatele
		$mail->AddAddress($order_email);  // přidáme příjemce
		//$mail->AddAddress("rudolf.pivovarcik@centrum.cz");  // přidáme příjemce
		$mail->Subject = $eshopController->setting["EMAIL_ORDER_SUBJECT"] . " " . $this->order_code;
		$mail->AddBCC($eshopController->setting["BCC_EMAIL"]);
		$mail->WordWrap = 120;   // je vhodné taky nastavit zalomení (po 50 znacích)
		$mail->CharSet = "utf-8";
		$mail->IsHTML(true);
		$mail->AddAttachment($this->order_pdf, "objednavka.pdf");
		$mail->Body ='';
		$mail->Body .="<html>";
		$mail->Body .="<head></head>";
		$mail->Body .="<body>";



		$lang = strtoupper(LANG_TRANSLATOR);
		if (empty($lang))
		{
			$lang =  "CS";
		}

		$mail->Body .= $eshopController->setting["EMAIL_ORDER_BODY_$lang"];

		$mail->Body .="</body></html>";

		//$odeslano = $mail->Send();
		return $mail->Send();
	}
	public function sendInfoEmail()
	{
		//$eshop = new Eshop();
		$mail = new PHPMailer();
		$eshopController = new EshopController();
		$mail->Body ='';
		$mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
		//$mail->Host = "localhost";  // zadáme adresu SMTP serveru


		$mail->Host = $eshopController->setting["EMAIL_SMTP_SERVER"];
		$mail->SMTPAuth = ($eshopController->setting["EMAIL_SMTP_AUTH"]=="1") ? true : false;

		$mail->Username = $eshopController->setting["EMAIL_USERNAME"];  // uživatelské jméno pro SMTP autentizaci
		$mail->Password = $eshopController->setting["EMAIL_PWD"];           // heslo pro SMTP autentizaci

		$mail->From = $eshopController->setting["EMAIL_ORDER"];
		//$mail->From = "objednavky@kolakv.cz";   // adresa odesílatele skriptu
		//$mail->FromName = "Objednávka kolaKV.cz"; // jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)
		$mail->FromName = $eshopController->setting["EMAIL_ORDER_ALIAS"]; //"Objednávka"; // jméno odesílatele
		$mail->AddAddress($eshopController->setting["INFO_EMAIL"]);  // přidáme příjemce
		//$mail->AddAddress("rudolf.pivovarcik@centrum.cz");  // přidáme příjemce
		$mail->Subject = "Přijata objednávka " . $this->order_code;
		//$mail->AddBCC($eshop->eshop_setting["BCC_EMAIL"]);
		$mail->WordWrap = 120;   // je vhodné taky nastavit zalomení (po 50 znacích)
		$mail->CharSet = "utf-8";
		$mail->IsHTML(true);
		$mail->AddAttachment($this->order_pdf, "objednavka.pdf");




		$mail->Body ='';
		$mail->Body .="<html>";
		$mail->Body .="<head></head>";
		$mail->Body .="<body>";

		//					$mail->Body .='Dobrý den,<br />Vaší objednávku jsme přijali ke zpracování.<br />V příloze naleznete detail objednávky<br />';
		$mail->Body .='Byla přijata objednávka č.<strong>' . $this->order_code . '</strong> z webu <strong>' . URL_DOMAIN . '</strong>, podrobnější informace o rezervaci naleznete v příloze nebo v <a href="' . URL_HOME2 . 'admin/eshop_order_detail.php?id='.$this->order_id.'">administraci stránek</a>.';
		$mail->Body .='<br /><br />';
		/*
		   $mail->Body .="<p><label>Jméno:</label> <strong>" . $_POST["shipping_first_name"] . "</strong></p>";
		   $mail->Body .="<p><label>Telefon:</label> <strong>" . $_POST["shipping_phone"] . "</strong></p>";
		   $mail->Body .="<p><label>Email:</label> <strong>" . $_POST["shipping_email"] . "</strong></p>";
		   //$mail->Body .="<p><label>Datum rezervace:</label> <strong>" . $_POST["date_reserve"] . "</strong></p>";
		   $mail->Body .="<p><label>Poznamka:</label> <strong>" . $_POST["description"] . "</strong></p>";
		   $mail->Body .="<p><label>Cena:</label> <strong>" . $subtotal . "CZK</strong></p>";
		*/

		/*
		   $mail->Body .="<table>";


		   $mail->Body .= $mail_text;
		   $mail->Body .="</table>";
		*/
		//	$mail->Body .='děkujeme Vám za vytvoření objednávky v internetovém obchodě <a href="http://www.kolakv.cz">www.kolakv.cz</a>. Vaše objednávka byla přijata ke zpracování. V příloze Vám zasíláme kopii objednávky.';
		//	$mail->Body .='<br /><br />';
		$mail->Body .='<br /><br />Tato zpráva byla vygenerována systémem automaticky, neodpovídejte na ní!';
		$mail->Body .='<br />';
		$mail->Body .=URL_DOMAIN; 


		//					$mail->Body .='<p><a href="http://www.kolakv.cz">www.kolakv.cz</a></p>';
		$mail->Body .="</body></html>";

		return $mail->Send();
	}



	public function saveAjaxAction()
	{
		// Je odeslán formulář
		if(self::$getRequest->isPost() && "FakturaEdit" == self::$getRequest->getPost('action', false))
		{
			$form = $this->formLoad('FakturaEdit');

			if ( $this->saveFaktura($form)) {
				//$form->setResultSuccess("Středisko bylo upraveno.");
				//	$this->getRequest->goBackRef();

				return true;
			}

		}
	}


	private function saveFaktura($form)
	{
		if ($form->isValid($form->getPost()))
		{
			$formdata = $form->getValues();
			$detail = $form->doklad;
			if (!$detail) {
				$form->setResultError("Středisko <strong>" . $formdata["stredisko"] . "</strong> nenalezeno!");
				return false;
			}

			//	$model = new models_Strediska();



			$entita = new FakturaEntity($detail);
			$entita->naplnEntitu($formdata);

			$changeData = $entita->getChangedData();
			//	print_r( $formdata);
			//	print_r( $entita);
			//	print_r($changeData);

			/*		$aktivace = false;
			   $deaktivace = false;

			   if (isset($changeData["aktivni"])) {
			   // aktivováno
			   if ($changeData["aktivni"] == 1) {
			   $aktivace = true;
			   }
			   // aktivováno
			   if ($changeData["aktivni"] == 0) {
			   $deaktivace = true;
			   }
			   }

			*/

			$SaveEntity = new SaveEntity();
			$SaveEntity->addSaveEntity($entita);

			if ($SaveEntity->save()) {

				return true;
			}
		}
	}

	public function stornoAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('storno_faktura', false))
		{
			$tenzin = self::$getRequest->getPost('storno_faktura', false);
			list($key,$value) = each($tenzin);
			//	print $key;
			$order_id = $_POST['doklad_id'][$key];

			//	print $order_id;
			//	exit;
			//	print_r(self::$getRequest->getPost('product_id[$key]', false));
			//	$product_id = self::$getRequest->getPost('product_id['.$key.']', false);
			if ($order_id) {

				$model = new models_Faktury();
				$obj = $model->getDetailById($order_id);

				//where `uid_source`=" . $foto_id . " AND `uid_target`= " . $product_id . " AND `table`='" . T_SHOP_PRODUCT . "' LIMIT 1");
				if ($obj) {
					//$_fotoPlaces->setData($data);
					if ($obj->storno == 0)
					{


						$data = array();
						$data["storno"] = 1;
						if($model->updateRecords($model->getTableName(),$data,"id=".$order_id))
						{
							$_SESSION["statusmessage"]="Faktura " . $obj->order_code . " byla stornována.";
							$_SESSION["classmessage"]="success";
							self::$getRequest->goBackRef();
						}
					} else {
						$_SESSION["statusmessage"]="Faktura " . $obj->order_code . " již byla stornována.";
						$_SESSION["classmessage"]="errors";
					}
				}
			}

		}

		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false)
			&& "stornoFaktura" == self::$getRequest->getPost('action', false))
		{

			$selectedItems = self::$getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						$model = new models_Faktura();
						$obj = $model->getDetailById($doklad_id);

						if ($obj) {
							$data = array();
							$data["storno"] = 1;
							if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id .  " and storno=0"))
							{
								array_push($seznamCiselObjednavek,$obj->code );
							}
						}
					}
				}
				array_reverse($seznamCiselObjednavek);
				$_SESSION["statusmessage"]="Faktura " . implode(",", $seznamCiselObjednavek) . " byla stornována.";
				$_SESSION["classmessage"]="success";
				self::$getRequest->goBackRef();
			}

		}
	}


	private function stornoDokladu($doklad_id)
	{
		$model = new models_Faktura();
		$obj = $model->getDetailById($doklad_id);

		if ($obj) {
			$data = array();
			$data["storno"] = 1;
			if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id))
			{
				return $obj;

			}
		}

		return false;
	}

	public function stornoAjaxAction()
	{
		// Je odeslán formulář
		if(self::$getRequest->isPost() && "FakturaStorno" == self::$getRequest->getPost('action', false))
		{

			$doklad_id = (int) self::$getRequest->getQuery('id', 0);



			if ($this->stornoDokladu($doklad_id)) {
				return true;
			}
		}
	}

	public function copyAjaxAction()
	{
		// Je odeslán formulář
		if(self::$getRequest->isPost() && "FakturaCopy" == self::$getRequest->getPost('action', false))
		{

			$doklad_id = (int) self::$getRequest->getQuery('id', 0);
			$model = new models_Faktura();
			$obj = $model->getDetailById($doklad_id);

			if ($obj) {


				if (self::copyDoklad($doklad_id)) {
					return true;
				}
				//	return true;

			}
		}
	}



	public function deleteAction()
	{

		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false)
			&& "deleteFaktura" == self::$getRequest->getPost('action', false))
		{

			$selectedItems = self::$getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						$model = new models_Faktura();
						$obj = $model->getDetailById($doklad_id);

						if ($obj) {
							$data = array();
							$data["isDeleted"] = 1;
							if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id))
							{
								array_push($seznamCiselObjednavek,$obj->code );
							}
						}
					}
				}
				array_reverse($seznamCiselObjednavek);
				$_SESSION["statusmessage"]="Faktura " . implode(",", $seznamCiselObjednavek) . " byla smazána.";
				$_SESSION["classmessage"]="success";
				self::$getRequest->goBackRef();
			}

		}
	}


	public function deleteAjaxAction()
	{
		// Je odeslán formulář
		if(self::$getRequest->isPost() && "FakturaDelete" == self::$getRequest->getPost('action', false))
		{

			$doklad_id = (int) self::$getRequest->getQuery('id', 0);
			if ($this->deleteDoklad($doklad_id)) {
				return true;
			}

		}
	}

	private function deleteDoklad($doklad_id)
	{

		$model = new models_Faktura();
		$obj = $model->getDetailById($doklad_id);


    //print_r($obj);
   // exit;
		if ($obj) {
			//$model = new models_Orders();
			$data = array();
			$data["isDeleted"] = 1;
			//	print $stredisko_id;
			//	exit;
			if ($model->updateRecords($model->getTablename(),$data,"id=".$doklad_id)) {
				return true;
			}


		}
		return false;
	}


}
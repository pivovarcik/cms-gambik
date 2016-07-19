<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */



class OrderController extends DokladBase
{
	public $order_code;
	public $doklad_id;
	public $order_pdf;
	public $order_details = array();
	public $total = 0;

	private $polozkyObjednavkyHtml;

	function __construct($TDoklad = "Orders", $TRadky = "RadekObjednavky")
	{
		parent::__construct($TDoklad, $TRadky, "RozpisDphObjednavky");
	}

	public function getPolozkyObjednavkyHtml(){
		return $this->polozkyObjednavkyHtml;
	}
	private function validacePredUlozenim()
	{

		return true;
	}
	public function akcePredUlozenim()
	{
		return self::validacePredUlozenim();
	}

	public function akcePoUlozeni()
	{
		//print "akce po uložení";


		// Odeslat objeddnávku
		$data = self::getDokladSaveData();

		return $all_query_ok;
	}

	public function orderDetailsList(IListArgs $params = null)
	{
		$model = new models_RadekObjednavky();

		$limit 	= self::$getRequest->getQuery('limit', 100);
		if (isset($params->limit) && is_numeric($params->limit)) {
			$limit = $params->limit;
		} else {
			$params->limit = $limit;
		}



		$status = self::$getRequest->getQuery('status', '0');
		if (isset($params->stav) && is_numeric($params->stav)) {
			$status = $params->stav;
		}
		$params->stav = $status * 1;

		//	$params["uid_user"] = USER_ID;
		$page 	= self::$getRequest->getQuery('pg', 1);
		$params->page = $page;



		//print_r($params);
		$list = $model->getList($params);
		$this->total = $model->total;
		return $list;

	}

	public function orderDetailsListEdit(IListArgs $params = null)
	{
		$l = $this->orderDetailsList($params);
		for ($i=0;$i<count($l);$i++)
		{
			$span_start = '';
			$span_end = '';

			$l[$i]->checkbox = "";
			switch($l[$i]->stav)
			{
				case 1:
					$stav = "Přijatá";
					$span_start = '<span class="prijata">';
					$span_end = '</span>';
					$style_color='';
					break;
				case 2:
					$stav = "Vyexpedovaná";
					$span_start = '<span class="expedice">';
					$span_end = '</span>';
					break;
				case 3:
					$stav = "Vyřizuje se";
					//$style_color='kvyrizeni';
					$span_start = '<span class="kvyrizeni">';
					$span_end = '</span>';
					break;
				case 4:
					$stav = "Dokonceno";
					$span_start = '<span class="vyrizena">';
					$span_end = '</span>';
					$style_color='vyrizena';
					break;
				default:
					break;
			}
			if ($l[$i]->storno == 1) {
				$span_start = '<span style="color:red;">';
				$span_end = '</span>';
			}

			$order_code = $l[$i]->order_code;

			if ($l[$i]->product_id > 0) {
				$link_product = "/admin/edit_product.php?id=" . $l[$i]->product_id;
			}


			$l[$i]->price_total = $span_start. number_format($l[$i]->price * $l[$i]->qty, 2, ',', ' ') . $span_end;

			$l[$i]->qty = $span_start. number_format($l[$i]->qty, 2, ',', ' ') . "&nbsp;"  . $l[$i]->nazev_mj . $span_end;
			$l[$i]->price = $span_start. number_format($l[$i]->price, 2, ',', ' ') . $span_end;
			$l[$i]->order_date = $span_start. date("j.n.Y H:i",strtotime($l[$i]->order_date)) . $span_end;
			$l[$i]->code =  '<strong><a href="' . URL_HOME2 . 'admin/objednavka_detail.php?id=' . $l[$i]->doklad_id . '">' . $span_start . $l[$i]->order_code . $span_end . '</a></strong>';


			$nazevMat = '<a href="'.$link_product.'">' . $l[$i]->product_name . '</a>';
			$productCode= '<a href="'.$link_product.'">' . $l[$i]->product_code . '</a>';

			$description = '';
			if (!empty($l[$i]->description)) {
				$description = '<span title="' . $l[$i]->description .'" class="user_comment"></span>';
			}
			$description_secret = '';
			if (!empty($l[$i]->description_secret)) {
				$description_secret = '<span title="' . $l[$i]->description_secret .'" class="user_comment"></span>';
			}
			$l[$i]->product_code = $productCode . $description . $description_secret;
			$l[$i]->product_name = $nazevMat;
			//$l[$i]->cmd = '<a target="_blank" title="Tisk Objednávky v PDF" href="' . URL_HOME2 . 'admin/orders_pdf.php?id=' . $l[$i]->id . '"><img src="' . URL_HOME2 . 'admin/acrobat_ico.gif"></a>' . $command;
		}


		return $l;
	}

	public function orderDetailsListTable(IListArgs $params = null)
	{
		$eshopController = new EshopController();
		$sorting = new G_Sorting("date","desc");

		//$params = array();
		$l = $this->orderDetailsListEdit($params);


		$data = array();
		$th_attrib = array();
		$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
		$column["code"] = $sorting->render("Číslo", "code");
		$column["product_code"] = $sorting->render("Číslo", "lname");
		$column["product_name"] = $sorting->render("Zboží", "email");
		$column["qty"] = $sorting->render("Množ.", "phone");
		$column["price"] = $sorting->render("Jedn.cena", "address");
		$column["price_total"] = $sorting->render("Celkem", "transfer");


		$column["order_date"] = $sorting->render("Přijato", "date");


		$th_attrib["checkbox"]["class"] = "check-column";
		$th_attrib["preview"]["class"] = "column-thumb";
		$th_attrib["code"]["class"] = "column-num";
		$th_attrib["shipping_last_name"]["class"] = "column-cat";
		$th_attrib["shipping_email"]["class"] = "column-cat";
		$th_attrib["qty"]["class"] = "column-price";
		$th_attrib["price"]["class"] = "column-price";
		$th_attrib["price_total"]["class"] = "column-qty";


		$th_attrib["cmd"]["class"] = "column-cmd";
		$th_attrib["order_date"]["class"] = "column-date";
		$td_attrib["qty"]["class"] = "column-price";
		$td_attrib["price"]["class"] = "column-price";
		$td_attrib["price_total"]["class"] = "column-price";


		$table = new G_Table($l, $column, $th_attrib, $td_attrib);


		$table_attrib = array(
							"class" => "widefat",
							"id" => "data_grid",
							"cellspacing" => "0",
							);
		return $table->makeTable($table_attrib);

	}

	public function ordersList(IListArgs $args = null)
	{
		$model = new models_Orders();
		$list = $model->getList($args);
		$this->total = $model->total;
		return $list;
	}

	public function ordersListUserTable(IListArgs $params = null)
	{
		$eshopController = new EshopController();
		$sorting = new G_Sorting("date","desc");

		//$params = array();
		$l = $this->ordersListEdit($params);


		$data = array();
		$th_attrib = array();
		//$column["code_text"] = $sorting->render("Číslo", "code");
		$column["tisk"] = $sorting->render("Číslo objednávky", "code");
		if ($eshopController->setting["PLATCE_DPH"] == "1"){
			$column["cost_subtotal"] = $sorting->render("Cena bez DPH", "total");
			$column["cost_total"] = $sorting->render("Cena s DPH", "total");
		} else {
			$column["cost_subtotal"] = $sorting->render("Cena", "total");
		}

		$column["nazev_stav"] = $sorting->render("Stav", "date");
		$column["order_date"] = $sorting->render("Přijato", "date");


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

	// TODO - Obsolate - nově se používají datagridProvidery
	public function ordersListTable(IListArgs $params = null)
	{
		$eshopController = new EshopController();
		$sorting = new G_Sorting("date","desc");

		//$params = array();
		$l = $this->ordersListEdit($params);


		$data = array();
		$th_attrib = array();
		$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
		$column["code"] = $sorting->render("Číslo", "code");
		$column["shipping_last_name"] = $sorting->render("Příjmení", "lname");
		$column["shipping_email"] = $sorting->render("Email", "email");
		$column["shipping_phone"] = $sorting->render("Telefon", "phone");
		$column["shipping_city"] = $sorting->render("Adresa", "address");
		$column["nazev_dopravy_platby"] = $sorting->render("Doprava", "transfer") . "<br />" . $sorting->render("Platba", "platba");
		if ($eshopController->setting["PLATCE_DPH"] == "1"){
			$column["cost_subtotal"] = $sorting->render("Cena bez DPH", "total");
			$column["cost_total"] = $sorting->render("Cena s DPH", "total");
		} else {
			$column["cost_subtotal"] = $sorting->render("Cena", "total");
		}


		$column["order_date"] = $sorting->render("Přijato", "date");
		$column["cmd"] = '';

		$th_attrib["checkbox"]["class"] = "check-column";
		$th_attrib["preview"]["class"] = "column-thumb";
		$th_attrib["code"]["class"] = "column-num";
		$th_attrib["shipping_last_name"]["class"] = "column-cat";
		$th_attrib["shipping_email"]["class"] = "column-cat";
		$th_attrib["cost_total"]["class"] = "column-price";
		$th_attrib["cost_subtotal"]["class"] = "column-price";
		$th_attrib["qty"]["class"] = "column-qty";


		$th_attrib["cmd"]["class"] = "column-cmd";
		$th_attrib["order_date"]["class"] = "column-date";
		$th_attrib["shipping_phone"]["class"] = "column-date";
		$td_attrib["cost_subtotal"]["class"] = "column-price";
		$td_attrib["cost_total"]["class"] = "column-price";


		$table = new G_Table($l, $column, $th_attrib, $td_attrib);


		$table_attrib = array(
							"class" => "widefat",
							"id" => "data_grid",
							"cellspacing" => "0",
							);
		return $table->makeTable($table_attrib);

	}

	public function ordersListEdit($params = array())
	{
		$l = $this->ordersList($params);
		//print_r($l);
		for ($i=0;$i<count($l);$i++)
		{
			$span_start = '';
			$span_end = '';

			$l[$i]->checkbox = "";
			switch($l[$i]->stav)
			{
				case 1:
					$span_start = '<span class="prijata">';
					$span_end = '</span>';
					$style_color='';
					break;
				case 2:
				//	$stav = "Vyexpedovaná";
					$span_start = '<span class="expedice">';
					$span_end = '</span>';
					break;
				case 3:
				//	$stav = "Vyřizuje se";
					//$style_color='kvyrizeni';
					$span_start = '<span class="kvyrizeni">';
					$span_end = '</span>';
					break;
				case 4:
					$span_start = '<span class="vyrizena">';
					$span_end = '</span>';
					$style_color='vyrizena';
					break;
				default:
					break;
			}
			$stav = $l[$i]->nazev_stav;
			if ($l[$i]->storno == 1) {
				$stav = "Stornována";
				$span_start = '<span class="storno">';
				$span_end = '</span>';
			}


			if (empty($l[$i]->shipping_last_name)) {
				$l[$i]->shipping_last_name = $l[$i]->shipping_first_name;
			}
			$order_code = $l[$i]->code;

			$l[$i]->nazev_dopravy_platby = $span_start. '<acronym title="'.$l[$i]->nazev_dopravy.'">' . drupal_substr($l[$i]->nazev_dopravy,0,3) . '</acronym> / <acronym title="'.$l[$i]->nazev_platby.'">' . drupal_substr($l[$i]->nazev_platby,0,3) . '</acronym>' . $span_end;

			$l[$i]->cost_subtotal = $span_start. number_format($l[$i]->cost_subtotal, 2, ',', ' ') . $span_end;
			$l[$i]->cost_total = $span_start. number_format($l[$i]->cost_total, 2, ',', ' ') . $span_end;

			$l[$i]->order_date = $span_start. date("j.n.Y H:i",strtotime($l[$i]->order_date)) . $span_end;




			$description = '';
			if (!empty($l[$i]->description)) {
				$description = ' <span title="Vzkaz od zákazníka: ' . $l[$i]->description .'" class="user_comment">U</span>';
			}
			$description_secret = '';
			if (!empty($l[$i]->description_secret)) {
				$description_secret = ' <span title="Interní poznámka: ' . $l[$i]->description_secret .'" class="secret_comment">S</span>';
			}

			$description_heureka = '';
			if ($l[$i]->isHeureka == 1) {
				$description_heureka = ' <span title="Hodnocení: ' . $l[$i]->h_summary .' (' . $l[$i]->h_total_rating .')" class="heureka_comment">H</span>';
			}

			$l[$i]->nazev_stav = $span_start. $stav . $span_end;

			//$l[$i]->product_code = $productCode . $description . $description_secret;
			$l[$i]->code_text = $span_start.$l[$i]->code . $span_end;
			$l[$i]->code =  '<strong><a href="' . URL_HOME2 . 'admin/objednavka_detail.php?id=' . $l[$i]->id . '">' . $span_start . $l[$i]->code . $span_end . '</a></strong>' . $description . $description_secret . $description_heureka;
			$command = '<input class="" style="border:0 none;background-color:transparent;" onclick="return confirm(\'Opravdu STORNOVAT objednávku č. '.$order_code.'?\')" type="image" src="'.URL_HOME2 . 'admin/images/cancel.png" value="X" name="storno_order[' . $i . ']"/>';
			$command .= '<input class="" style="border:0 none;background-color:transparent;" onclick="return confirm(\'Zkopírovat Objednávku č. '.$order_code.'?\')" type="image" src="'.URL_HOME . 'admin/copy_icon.png" value="X" name="copy_order[' . $i . ']"/>';

			$command .= '<input type="hidden" value="' . $l[$i]->id . '" name="doklad_id[' . $i . ']"/>';

			$l[$i]->shipping_last_name = $span_start. $l[$i]->shipping_last_name . $span_end;
			$l[$i]->shipping_email = $span_start. $l[$i]->shipping_email . $span_end;
			$l[$i]->shipping_phone = $span_start. $l[$i]->shipping_phone . $span_end;
			$l[$i]->shipping_city = $span_start. $l[$i]->shipping_city . $span_end;

			$l[$i]->tisk = ''.$span_start.'<a target="_blank" title="Tisk Objednávky v PDF" href="' . URL_HOME2 . 'admin/orders_pdf.php?id=' . $l[$i]->id . '">'.$order_code.'<img src="' . URL_HOME2 . 'admin/style/images/acrobat_ico.gif"></a>'.$span_end.'';

			$l[$i]->cmd = '<a target="_blank" title="Tisk Objednávky v PDF" href="' . URL_HOME2 . 'admin/orders_pdf.php?id=' . $l[$i]->id . '"><img src="' . URL_HOME2 . 'admin/style/images/acrobat_ico.gif"></a>' . $command;
			$l[$i]->tisk .= '<button type="submit" value="' . $l[$i]->id . '" name="order_to_basket[' . $i . ']"><span>Do košíku</span></button>';
		}


		return $l;
	}

	public function getOrder($id, $secret = true)
	{
		$model = new models_Orders();
		//$orders = $model->getOrder($id);
		$orders = $model->getDetailById($id);

	//	print USER_ID;
		if (USER_ID == $orders->user_id || USER_ROLE_ID == "2") {

		//	print "ok";
		} else {

			// TODO vyřešit práva nepřihlášeného uživatele
			if ($secret) {
			//	return FALSE;
			}
			//return FALSE;
		}
	//	print_r($orders);
		$this->order_code = $orders->code;

		$model = new models_OrderDetails();
		$params = new ListArgs();
		$params->doklad_id = (int) $id;
		$params->limit = 1000;
		$this->order_details = $model->getList($params);
		return $orders;
	}

	public function createHtml($doklad_id)
	{
	//	$eshopController = new EshopController();
		$eshopSettings = G_EshopSetting::instance();
		$translator = G_Translator::instance();

		$modelFakrury = new models_Orders();
		$doklad = $modelFakrury->getDetailById($doklad_id);
		if (!$doklad)
		{
			return;
		}

		$modelRadkuFaktury = new models_RadekObjednavky();

		$params = new ListArgs();
		$params->doklad_id = (int) $doklad_id;
		$params->limit = 1000;
		$radky = $modelRadkuFaktury->getList($params);


		$jeSleva = false;
		for ($i=0;$i<count($radky);$i++)
		{

			$product_code = (!empty($radky[$i]->product_code)) ? $radky[$i]->product_code . "&nbsp;" : "";
			$radky[$i]->product_name = $product_code . "" . $radky[$i]->product_name;

			$product_description = (!empty($radky[$i]->product_description)) ? '<div style="font-style:italic;">' . $radky[$i]->product_description . '</div>' : "";
			$radky[$i]->product_name .= $product_description;


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

		}



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
		"style" => "width:100%;border: 1px solid #000000;table-layout: fixed;",
		"id" => "data_grid",
		"cellspacing" => "0",
		"print_foot" => 0
	);






		$pagetitle = $translator->prelozitFrazy("prijata_objednavka");

		$sloupcu = 3;

		if ($eshopSettings->get("PLATCE_DPH") == "1"){
			$sloupcu += 1;
		}

		if ($eshopSettings->get("SLEVA_DOKLAD_TISK") == "1" && $jeSleva){
			$sloupcu += 1;
		}


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
		<table class="zahlavi" style="width:100%;border: 0 none;" border="0">
		<tr height="55px;">
			<td width="360px">';

		if ($eshopSettings->get("LOGO_PDF") != "") {
			$html .= '<img src="'.$eshopSettings->get("LOGO_PDF").'">';
		}


		$html .= '</td>
			<td style="text-align:left;"><h2 style="font-weight:bold;">'.$translator->prelozitFrazy("prijata_objednavka_cislo").' '.$doklad->code.'</h2><br />
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


		$html .= $translator->prelozitFrazy("ico").': <strong>' . $eshopSettings->get("ICO") . '</strong><br />';

		if ($eshopSettings->get("PLATCE_DPH") == "1")
		{
			$html .= $translator->prelozitFrazy("dic").': <strong>' . $eshopSettings->get("DIC") . '</strong><br /><br />';

		}


		$html .= $translator->prelozitFrazy("cislo_uctu_iban").':<br />
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
			'.$translator->prelozitFrazy("datum_vystaveni").': <strong>'.date("j.n.Y",strtotime($doklad->order_date)).'</strong><br />
			'.$translator->prelozitFrazy("zpusob_dopravy").': <strong>' . $doklad->nazev_dopravy . '</strong><br />
			'.$translator->prelozitFrazy("zpusob_platby").': <strong>' . $doklad->nazev_platby . '</strong><br />
			</div>
			</td></tr>
			</table>
		';

		//if (!empty($doklad->description)) {
		$html .= '
			<table class="zahlavi" style="width:100%;border: 0 none;" border="0">
			<tr>
				<td style="text-align:left;">'.$translator->prelozitFrazy("uvodni_text_objednavky").'</td>
			</tr>
			</table>';

		//	}

		$polozky = $table->makeTable($table_attrib);
		$this->polozkyObjednavkyHtml = $polozky;
		$html .= $polozky;


		$html .='<table id="data_grid" class="table_header" >
		<tr  class="rozpis">
			<td colspan="4" style="text-align:right;"></td>
		     <td style="text-align:right;width:75px;"></td>
		     </tr>';

		$html .='<tr height="25px">

			<td colspan="4" style="text-align:right;font-weight:bold;white-space:nowrap;">'.$translator->prelozitFrazy("mezisoucet").':</td>
			<td style="text-align:right;width:75px;font-weight:bold;white-space:nowrap;">'.numberFormatNowrap($doklad->cost_subtotal).'</td>
		</tr>';

		if ($eshopSettings->get("PLATCE_DPH") == "1" &&  $eshopSettings->get("PRICE_TAX") == 0) {

			$html .='<tr height="25px">
				<td colspan="4" style="text-align:left;font-weight:bold;text-align:right;white-space:nowrap;">'.$translator->prelozitFrazy("vyse_dane").':</td>
				<td style="text-align:right;width:75px;font-weight:bold;white-space:nowrap;">'.numberFormatNowrap($doklad->cost_tax).'</td>
			</tr>';
		}


		$html .='<tr height="25px">
					<td colspan="4" style="text-align:left;font-weight:bold;text-align:right;font-size:14px;white-space:nowrap;">'.$translator->prelozitFrazy("celkova_cena_objednavky_sdani").':</td>
					<td style="text-align:right;width:75px;font-weight:bold;font-size:14px;white-space:nowrap;">'.numberFormatNowrap(round($doklad->cost_total - $doklad->amount_paid,0)).'</td>
				</tr>';



		$html .= '</tbody>
			</table>';



			$html .= '<table class="table_footer">
				<tbody>
				<tr>
				  <td>
					<span style="font-size:9px;">'.$translator->prelozitFrazy("poznamka_objednavky").'</span>
					</td>
				</tr>';

		if (!empty($doklad->description)) {
			$html .= '

			<tr>
				<td style="text-align:left;"><br /><strong>'.$translator->prelozitFrazy("poznamka_zakaznika").':</strong><br />' . $doklad->description.'</td>
			</tr>
				';

		}


		$html .= '

		<tr>
			<td style="text-align:left;"><br /><strong>'.$translator->prelozitFrazy("kontaktni_udaje_zakaznika").':</strong>';
		if (!empty($doklad->shipping_last_name)) {
			$html .= '<br />' . $doklad->shipping_last_name;
		}
if (!empty($doklad->shipping_phone)) {
	$html .= '<br />' . $doklad->shipping_phone;
}
if (!empty($doklad->shipping_email)) {
	$html .= '<br />' . $doklad->shipping_email;
}

	$html .= '</td>
		</tr>
			';


//print $eshopController->setting["RAZITKO_OBJ_PDF"];

		if ($eshopSettings->get("RAZITKO_OBJ_PDF") !="") {

			$html .= '

			<tr>
			  <td><img src="'.$eshopSettings->get("RAZITKO_OBJ_PDF").'" />					</td>
			</tr>';
		}

		$html .= '</tbody>
				</table>';
		$html .= '
		</body>
		</html>';

		//	print $table->makeTable($table_attrib);

//	print $html;
//	exit;
		return $html;
	}

	public function createPDF($id, $return_data="F")
	{
		$eshopController = new EshopController();
		$translator = G_Translator::instance();

		if (isset($id) && is_numeric($id))
		{
			$orders = $this->getOrder($id);
			$order_details = $this->order_details;

			if (!$orders) {
				exit;
			}
			//	print_r($order_details);
		} else {
			return;
		}

		$html = $this->createHtml($id);



		require_once(PATH_ROOT. "plugins/mpdf50/mpdf.php");
		//require_once(dirname(__FILE__) . "/../library/mpdf50/mpdf.php");

		//require_once(PATH_ROOT . "/../www/library/mpdf50/mpdf.php");
		//	exit;
		$mpdf=new mPDF('utf-8','A4');
				//exit;
		//$mpdf=new mPDF('','A5');
		//$mpdf=new mPDF('en-GB-x','A4','','',10,10,10,10,6,3);
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetMargins(0,0,4);
		$title = "Objednávka č." . $orders->order_code;
		$mpdf->SetTitle($title);
		$subject = "";
		$mpdf->SetSubject($subject);
		$author = "RS Gambik - pivovarcik.cz";
		$mpdf->SetAuthor($author);
		$keywords = "";
		$mpdf->SetKeywords($keywords);

		//$mpdf->SetHTMLFooter('<div style="font-size:9px;border-top:1px solid silver;">Eshop na míru</div>');
		//$stylesheet = file_get_contents('/style/print.css');
		//$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
		$mpdf->WriteHTML($html);
		//$mpdf->Output($orders->order_code.".pdf","D");
		//$url_file = dirname(__FILE__) . "/../../public/data/" . $orders->order_code.".pdf";
		$url_file = PATH_DATA . $orders->code.".pdf";


		if ($return_data == "D" || $return_data == "I") {
			$url_file = $orders->code.".pdf";
		}


		$mpdf->Output($url_file, $return_data);
		$this->order_pdf = $url_file;
		return $url_file;
	}

	public function createDoklad($doklad, $radky)
	{
		if (empty($doklad["order_date"])) {
			$doklad["order_date"] =  date('Y-m-d H:i:s');
		}


		$doklad["stav"] =  1;
		return parent::createDoklad($doklad, $radky);
	}

	public function sendEmailZakaznik($order_email)
	{
		$mail = new PHPMailer();
		$eshopController = new EshopController();
		$translator = G_Translator::instance();
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
		$mail->Subject = $translator->prelozitFrazy($eshopController->setting["EMAIL_ORDER_SUBJECT"]) . " " . $this->order_code;
		$mail->AddBCC($eshopController->setting["BCC_EMAIL"]);
		$mail->WordWrap = 120;   // je vhodné taky nastavit zalomení (po 50 znacích)
		$mail->CharSet = "utf-8";
		$mail->IsHTML(true);
		if ($this->order_pdf) {
			$mail->AddAttachment($this->order_pdf, $translator->prelozitFrazy("objednavka") . " " . $this->order_code . ".pdf");
		}
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

	// TODO asi se už nepoužívá
	public function sendInfoEmail()
	{
		//$eshop = new Eshop();
	/*	$mail = new PHPMailer();
		$eshopController = new EshopController();


		// ověření emailu nějak zlobí
		if (isEmail($eshopController->eshop_setting["INFO_EMAIL"])  == false) {
		//	return;
		} else {
			//return;
		}

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

*/
		$body ='';
		$body .="<html>";
		$body .="<head></head>";
		$body .="<body>";

		//					$mail->Body .='Dobrý den,<br />Vaší objednávku jsme přijali ke zpracování.<br />V příloze naleznete detail objednávky<br />';
		$body .='Byla přijata objednávka č.<strong>' . $this->order_code . '</strong> z webu <strong>' . URL_DOMAIN . '</strong>, podrobnější informace o rezervaci naleznete v příloze nebo v <a href="' . URL_HOME2 . 'admin/eshop_order_detail.php?id='.$this->doklad_id.'">administraci stránek</a>.';
		$body .='<br /><br />';

		$body .='<br /><br />Tato zpráva byla vygenerována systémem automaticky, neodpovídejte na ní!';
		$body .='<br />';
		$body .=URL_DOMAIN;

		$body.="</body></html>";

		return $mail->Send();


		$eshopSettings = G_EshopSetting::instance();

		$komu = $eshopSettings->get("INFO_EMAIL");
		$subject = "Přijata objednávka " . $this->order_code;
		$eshopController = new MailingController();
		return $eshopController->odeslatEmail($komu,$subject,$body ,$this->order_pdf,"objednavka.pdf");

	}

	protected function createFromBasket($formName, $callbackUrl = "")
	{
		$translator = G_Translator::instance();
		$eshopSettings = G_EshopSetting::instance();

		// Je odeslán formulář
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('save_order', false))
		{

			$form = $this->formLoad($formName);

			// Zapamatuju si hodnoty

			/*
			self::$getRequest->setCookie("shipping_first_name", $form->getPost('shipping_first_name', ''));
			self::$getRequest->setCookie("shipping_first_name2", $form->getPost('shipping_first_name2', ''));
			self::$getRequest->setCookie("shipping_last_name", $form->getPost('shipping_last_name', ''));
			self::$getRequest->setCookie("shipping_last_name2", $form->getPost('shipping_last_name2', ''));
			self::$getRequest->setCookie("shipping_address_1", $form->getPost('shipping_address_1', ''));

			self::$getRequest->setCookie("shipping_address_12", $form->getPost('shipping_address_12', ''));
			self::$getRequest->setCookie("shipping_city", $form->getPost('shipping_city', ''));
			self::$getRequest->setCookie("shipping_city2", $form->getPost('shipping_city2', ''));
			self::$getRequest->setCookie("shipping_zip_code", $form->getPost('shipping_zip_code', ''));
			self::$getRequest->setCookie("shipping_zip_code2", $form->getPost('shipping_zip_code2', ''));

			self::$getRequest->setCookie("shipping_phone", $form->getPost('shipping_phone', ''));
			self::$getRequest->setCookie("shipping_email", $form->getPost('shipping_email', ''));
			self::$getRequest->setCookie("shipping_ico", $form->getPost('shipping_ico', ''));
			self::$getRequest->setCookie("shipping_dic", $form->getPost('shipping_dic', ''));
*/


			// polozky si nactu z kosiku

			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{
				//print_r($form->getValues());
				$postdata = $form->getValues();
				//$model = new models_Products();



				$eshopController = new EshopController();
				$basketController = new BasketController();

				if ($basketController->doprava_id == 0) {

				//	$_SESSION["statusmessage"]= "Nebyl vybrán způsob dopravy.";
					$form->setResultError($translator->prelozitFrazy("nevybran_zpusob_dopravy"));
				//	$_SESSION["classmessage"]="errors";
					//	header("Location: " . URL_HOME2 . "udaje", true, 303);
					return false;
				}

				if ($basketController->platba_id == 0) {

					//$_SESSION["statusmessage"]= "Nebyla vybrána forma úhrady.";
				//	$_SESSION["classmessage"]="errors";
					$form->setResultError($translator->prelozitFrazy("nevybran_zpusob_uhrady"));
					//header("Location: " . URL_HOME2 . "udaje", true, 303);
					return false;
				}

				$nextIdModel = new models_NextId();
				$order_code = $nextIdModel->vrat_nextid(array(
											"tabulka"=> T_SHOP_ORDERS,
											"polozka"=> "code",
											"rada_id"=> $eshopSettings->get("NEXTID_ORDER"),
											));






				$basketlist = $basketController->basketList();

				for ($i=0;$i < count($basketlist);$i++)
				{
					$basketlist[$i]->sleva = $basketlist[$i]->basket_sleva;
					$basketlist[$i]->typ_slevy = $basketlist[$i]->basket_typ_slevy;
				}
				$dopravne_price = 0;
				if ($basketController->isEmpty) {

					$form->setResultError($translator->prelozitFrazy("your_basket_is_empty"));
					return false;
				} else {
					// musím přepošítat cenu

					//print "Doprava_id:" . $basketController->doprava_id;
					if ($basketController->doprava_id > 0) {

						$doprava = $basketController->getDoprava($basketController->doprava_id);
						$mnozstvi_polozek = 0;
						$celkova_castka = 0;

						for($i=0; $i<count($basketlist);$i++)
						{
							$mnozstvi_polozek += $basketlist[$i]->mnozstvi;
							$celkova_castka += ($basketlist[$i]->price * $basketlist[$i]->mnozstvi);
						}



						if ($basketController->getCenaDopravy() > 0) {
							$dopravne_price = $basketController->getJednotkovaCenaDopravy();
						}

						if ($eshopSettings->get("DOPRAVNE_ZDARMA") > 0 && $celkova_castka > $eshopSettings->get("DOPRAVNE_ZDARMA")) {
							$dopravne_price = 0;
						}

					//	print_r($eshopController->setting);
					//	print $dopravne_price;
					//		exit;

						// Doúčtovat dopravné
						if ($eshopSettings->get("DOPRAVNE_ZA_MJ") == 0) {
							$mnozstvi_polozek = 1;
						}

						$obj = new stdClass();
						$obj->radek_added = 1;
						$obj->price = $dopravne_price;

						$obj->price_sdani = $dopravne_price + $dopravne_price * $doprava->value_dph/100;
						$obj->product_name = $doprava->name;
						$obj->mj_id = $doprava->mj_id;
						$obj->tax_id = $doprava->tax_id;
						$obj->qty = $mnozstvi_polozek;

						if (defined("USER_ID")) {
							$obj->user_id = USER_ID;
						}

					//	print_r($basketList);
					//	exit;
						array_push($basketlist, $obj);
						//$dopravne_price = $mnozstvi_polozek * $this->postovne;
					}
				}
				$subtotal = $basketController->getCelkovaCenaBezDph() + $dopravne_price;
				$total = $basketController->getCelkovaCenaSDph() + $dopravne_price;
				$tax = $basketController->getCastkaDph();



				$postdata["code"] = $order_code;
				$postdata["cost_subtotal"] = $subtotal;
				$postdata["cost_total"] = $total;
				$postdata["cost_tax"] = $tax;
				$postdata["order_date"] =  date('Y-m-d H:i:s');
				$postdata["stav"] =  1;
				$postdata["shipping_transfer"] =  $basketController->doprava_id;
				$postdata["shipping_pay"] =  $basketController->platba_id;
				//print_r($postdata);

				if (defined("USER_ID")) {
					$postdata["customer_id"] = USER_ID;
				}

				$dokladSaveData = $this->createDoklad($postdata, $basketlist);
				if ($dokladSaveData) {



					$form->setResultSuccess($translator->prelozitFrazy("objednavka_dokoncena_info"));
					$heureka = new HeurekaController();
					$odeslanoHeureka = $heureka->postRequestHeureka($dokladSaveData["id"]);
					if ($odeslanoHeureka) {
						// tady bych to mohl zaevidovat
					}

					// pokud se jedná o platbu kartou
					$modelPlatby = new models_Platba();
					$platbaDetail = $modelPlatby->getDetailById($basketController->platba_id);

					if ($platbaDetail->brana == "AGMO") {
						$this->platbaAgmo($dokladSaveData);
					}
					if ($platbaDetail->brana == "PAYU") {
						$this->platbaPayU($dokladSaveData);
					}

					self::$getRequest->goBackRef($callbackUrl);
				}
			}
		}
	}

	private function platbaGoPay($dokladSaveData)
	{
		$eshopSettings = G_EshopSetting::instance();



		define('GOID', 8540279704);
		define('SECURE_KEY', "ocxgXEL5psb7PAllKuCSblc9");

		/*
		   * defaultni jazykova mutace platebni brany GoPay
		*/
		define('LANG', 'cs');

		/*
		   * URL eshopu - pro urceni absolutnich cest
		*/
		define('HTTP_SERVER', 'http://www.eshop.cz/');

		define('SUCCESS_URL', HTTP_SERVER . 'example/view_pages/payment_success.php');
		define('FAILED_URL', HTTP_SERVER . 'example/view_pages/payment_failed.php');

		/*
		   * URL skriptu volaneho pri navratu z platebni brany
		*/
		define('CALLBACK_URL', HTTP_SERVER . 'example/soap/callback.php');

		/*
		   * URL skriptu vytvarejiciho platbu na GoPay
		*/
		define('ACTION_URL', HTTP_SERVER . 'example/soap/payment.php');

		/**
		 *  Volba Testovaciho ci Provozniho prostredi
		 *  Testovaci prostredi - GopayConfig::TEST
		 *  Provozni prostredi  - GopayConfig::PROD
		 */
		require_once(dirname(__FILE__) . "/../api/gopay_config.php");
		GopayConfig::init(GopayConfig::TEST);

	}

	/**
	 * Platba metodou Agmo
	 * */
	private function platbaAgmo($dokladSaveData)
	{
		$eshopSettings = G_EshopSetting::instance();


			$paymentsUrl ='https://payments-test.agmo.eu/v1.0/create';
			$testPayment = true;
			if ($eshopSettings->get("AGMO_TEST") == "1") {
				$paymentsUrl ='https://payments.agmo.eu/v1.0/create';
				$testPayment = false;
			}

			$config = array(
			    'paymentsUrl' => $paymentsUrl,
			    'merchant' => $eshopSettings->get("AGMO_MERCHANT"),
			    'test' => $testPayment,
			    'secret' => $eshopSettings->get("AGMO_SECRET")
			);

			require_once(PATH_ROOT. "plugins/Agmo/AgmoPaymentsSimpleDatabase.php");
			require_once(PATH_ROOT. "plugins/Agmo/AgmoPaymentsSimpleProtocol.php");
		//	require_once(dirname(__FILE__) . "/../library/Agmo/AgmoPaymentsSimpleDatabase.php");
		//	require_once(dirname(__FILE__) . "/../library/Agmo/AgmoPaymentsSimpleProtocol.php");

			// initialize payments data object
		$path = PATH_DATA;
	//	$path = "/../../../public/data/";
		//$path = "";
			$paymentsDatabase = new AgmoPaymentsSimpleDatabase(

			    $path,
			    $config['merchant'],
			    $config['test']
			);

			// initialize payments protocol object
			$paymentsProtocol = new AgmoPaymentsSimpleProtocol(
			    $config['paymentsUrl'],
			    $config['merchant'],
			    $config['test'],
			    $config['secret']
			);


			try {

				// prepare payment parameters
				$refId = $paymentsDatabase->createNextRefId();
				$price = $dokladSaveData["cost_total"];
				$currency = 'CZK';

				$pay_method = "ALL";

				// create new payment transaction
				$paymentsProtocol->createTransaction(
				    $price,             // price
				    $currency,          // currency
				    "Úhrada objednávky č. " . $dokladSaveData["code"],     // label
				    $refId,             // refId
				    'PHYSICAL',         // category
				    $pay_method,    // method
				    '', // account
				    $dokladSaveData["shipping_email"], // email
				    '', // phone
				    '', // productName
				    '' // language
				);
				$transId = $paymentsProtocol->getTransactionId();


				$modelObjednavky = new models_Orders();

				$modelObjednavky->updateRecords($modelObjednavky->getTableName(),array("transId"=>$transId),"id=".$dokladSaveData["id"]);



				// save transaction data
				$paymentsDatabase->saveTransaction(
				    $transId,       // transId
				    $refId,         // refId
				    $price,         // price
				    $currency,      // currency
				    'PENDING'       // status
				);

				// redirect to agmo payments system
				header('location: '.$paymentsProtocol->getRedirectUrl());
				exit;
			}
			catch (Exception $e) {
				header('Content-Type: text/plain; charset=UTF-8');
				echo "ERROR\n\n";
				echo $e->getMessage();
			}
	}

	private function platbaPayU($dokladSaveData)
	{
		// adresy pro server PayU a metodu Payment/get
		// addresses for PayU server and the Payment/get method
		$server = "secure.payu.com";
		$server_script = "/paygw/ISO/Payment/get";


		$eshopSettings = G_EshopSetting::instance();

		// parametry pozadovane pro odeslani pozadavku
		// parameters required for checking and signing request
		define("PAYU_POS_ID", $eshopSettings->get("PAYU_POS_ID"));
		define("PAYU_KEY1", $eshopSettings->get("PAYU_KEY1"));
		define("PAYU_KEY2", $eshopSettings->get("PAYU_KEY2"));

		/*
		define("PAYU_POS_ID", 123);
		define("PAYU_KEY1", "1234567890123456");
		define("PAYU_KEY2", "9123456789012345");
		*/
		// vraci pole s indexy:
		// "code" (cislo statusu transakce nebo false v pripade chyby), "message" (popis statusu transakce nebo popis chyby)
		// returns array with values:
		// "code" (numerical transaction status or false in case of error), "message" (status description or error description)
		function get_status($parts)
		{
			// chybne cislo POS ID v odpovedi
			// incorrect POS ID number specified in response
			if($parts[1] != PAYU_POS_ID)
				return array("code" => false, "message" => "incorrect POS number");

			// vypocet podpisu pro porovnani se sig odeslanym ze strany PayU
			// calculating signature for comparison with sig sent by PayU
			$sig = md5($parts[1].$parts[2].$parts[3].$parts[5].$parts[4].$parts[6].$parts[7].PAYU_KEY2);

			// chybnĂ˝ podpis v odpovedi v porovnani s podpisem spocitanzm lokalne
			// incorrect signature in response in comparison to locally calculated one
			if($parts[8] != $sig)
				return array("code" => false, "message" => "incorrect signature");

			// ruzne zpravy dle statusu transakce. Popisy jednotlivĂ˝ch statusu jsou uvedeny v technicke dokumentaci
			// different messages depending on transaction status. For status description, see documentation
			switch($parts[5])
			{
				case 1: return array("code" => $parts[5], "message" => "new");
				case 2: return array("code" => $parts[5], "message" => "cancelled");
				case 3: return array("code" => $parts[5], "message" => "rejected");
				case 4: return array("code" => $parts[5], "message" => "started");
				case 5: return array("code" => $parts[5], "message" => "awaiting receipt");
				case 6: return array("code" => $parts[5], "message" => "no authorization");
				case 7: return array("code" => $parts[5], "message" => "payment rejected");
				case 99: return array("code" => $parts[5], "message" => "payment received - ended");
				case 888: return array("code" => $parts[5], "message" => "incorrect status");
				default: return array("code" => false, "message" => "no status");
			}
		}

		// nektere parametry chybeji
		// some parameters are missing
		if(!isset($_POST["pos_id"]) || !isset($_POST["session_id"]) || !isset($_POST["ts"]) || !isset($_POST["sig"]))
			die("ERROR: EMPTY PARAMETERS");

		// obdrzene cislo POS ID je jine, nez bylo ocekavano
		// received POS ID is different than expected
		if($_POST["pos_id"] != PAYU_POS_ID)
			die("ERROR: INCORRECT POS ID");

		// verifikace obdrzeneho podpisu
		// verification of received signature
		$sig = md5($_POST["pos_id"].$_POST["session_id"].$_POST["ts"].PAYU_KEY2);

		// chybny podpis
		// incorrect signature
		if($_POST["sig"] != $sig)
			die("ERROR: INCORRECT SIGNATURE");

		// podpis, ktery bude odeslan do PayU spolu s pozadavkem
		// signature that will be sent to PayU with request
		$ts = time();
		$sig = md5(PAYU_POS_ID.$_POST["session_id"].$ts.PAYU_KEY1);

		// priprava retezce (string) parametru k odeslani do PayU
		// preparing parameters string to be sent to PayU
		$parameters = "pos_id=".PAYU_POS_ID."&session_id=".$_POST["session_id"]."&ts=".$ts."&sig=".$sig;

		// urceni metodu spojeni (socket nebo CURL)
		// determining connection method (socket or CURL)
		$fsocket = false;
		$curl = false;
		if((PHP_VERSION >= 4.3) && ($fp = @fsockopen("ssl://".$server, 443, $errno, $errstr, 30)))
			$fsocket = true;
		elseif (function_exists("curl_exec"))
			$curl = true;

		// odesilani pozadavku pomoci socket
		// sending request via socket
		if ($fsocket == true)
		{
			$header = "POST ".$server_script." HTTP/1.0"."\r\n"."Host: ".$server."\r\n".
			    "Content-Type: application/x-www-form-urlencoded"."\r\n"."Content-Length: ".
			    strlen($parameters)."\r\n"."Connection: close"."\r\n\r\n";
			@fputs($fp, $header.$parameters);
			$payu_response = "";
			while (!@feof($fp))
			{
				$res = @fgets($fp, 1024);
				$payu_response .= $res;
			}
			@fclose($fp);
		}

		// odesilani pozadavku pomoci CURL
		// sending request via CURL
		elseif ($curl == true)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://".$server.$server_script);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 20);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$payu_response = curl_exec($ch);
			curl_close($ch);
		}

		// neni k dispozici zadna pouzitelna metoda spojeni
		// no connection method available
		else
			die("ERROR: No connect method ...\n");

		// ziskavani odpovedi od PayU
		// parsing PayU response
		$result = false;
		if (preg_match("/<trans>.*<pos_id>([0-9]*)<\/pos_id>.*<session_id>(.*)<\/session_id>.*<order_id>(.*)<\/order_id>.*".
			"<amount>([0-9]*)<\/amount>.*<status>([0-9]*)<\/status>.*<desc>(.*)<\/desc>.*<ts>([0-9]*)<\/ts>.*<sig>([a-z0-9]*)".
			"<\/sig>.*<\/trans>/is", $payu_response, $parts))
			$result = get_status($parts);

		// rozpoznany status transakce
		// recognised status of transaction
		if ($result["code"])
		{
			$pos_id = $parts[1];
			$session_id = $parts[2];
			$order_id = $parts[3];
			$amount = $parts[4];          // v halerich (in hellers)
			$status = $parts[5];
			$desc = $parts[6];
			$ts = $parts[7];
			$sig = $parts[8];

			// TODO:
			// zmena statusu transakce v systemu shopu
			// change of transaction status in system of the shop

			/*  napriklad (for instance):
			   if ($result["code"] == "99")
			   {
			   if(money_are_on_the_account)
			   {
			   // platba je uspesna, takĹľe posilĂˇme zpĂˇtky OK
			   // payment sucessful so we send back OK
			   echo "OK";
			   exit;
			   }
			   }
			   else if ($result["code"] == "2")
			   {
			   // transakce zrusena, muzeme rovnez transakci zrusit
			   // transaction cancelled, we can also cancell transaction
			   }
			   else
			   {
			   // jine akce
			   // other actions
			   }
			*/

			// pokud jsou vsechny operace ukoncene, posilame nazpet OK, v opacnem pripade vygenerujeme error
			// if all operations are done then we send back OK, in other case we generate error
			// if (everything_ok)
			// {
			echo "OK";
			exit;
			// } else {
			//
			// }
		}
		else
		{
			// TODO:
			// sprava plateb se statusem error
			// error transaction status managment
			echo "ERROR: Data error ....\n";
			echo "code=".$result["code"]." message=".$result["message"]."\n";
			echo $payu_response;
			// informace o zmene statusu bude z secure.payu.com odeslana znovu, muzeme zapsat informaci do logu (logs)....
			// information about changing a status will be send again from secure.payu.com, we can write information to logs....
		}
	}

	// Univerzální podpis do emailů
	public function getPodpis()
	{
		$body ='<p>S přáním hezkého dne<br /><br /><br />


			<strong>Váš Tým<br />' . $eshopController->setting["COMPANY_NAME"] . '</strong><br /><br /></p>';

		return $body;
	}

	public function createFromBasketAction()
	{


		return self::createFromBasket('OrderCreate');


	}

	/******
	 * Vytvoření objednávky z Admina
	 ******/
	public function createAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('ins', false))
		{
			// Valid form
			$form = $this->formLoad('ObjednavkaCreate');
			$formRadky = $this->formLoad('RadekObjednavkyCreate');
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{
				//print_r($form->getValues());
				$postdata = $form->getValues();
				$postdataRadky = $formRadky->getValues();
				$postdataRadky = postToArray($postdataRadky);


				$savedData = $this->createDoklad($postdata, $postdataRadky);

				if ($savedData) {
					$form->setResultSuccess('Záznam byl přidán. <a href="'.URL_HOME2.'admin/objednavka_detail?id='.$savedData["id"].'">Přejít na právě pořízený záznam.</a>');
				//	$_SESSION["statusmessage"]='Záznam byl přidán. <a href="'.URL_HOME2.'admin/objednavka_detail.php?id='.$savedData["id"].'">Přejít na právě pořízený záznam.</a>';
				//	$_SESSION["classmessage"]="success";
					self::$getRequest->goBackRef();
				}
			}
		}
	}

	public function saveAction()
	{
		// Je odeslán formulář
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('save', false))
		{
			$form = $this->formLoad('ObjednavkaEdit');
			$formRadky = $this->formLoad('RadekObjednavkyEdit');
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{
				//print_r($form->getValues());
				$postdata = $form->getValues();

				$dokladSaveData = self::setDokladData($postdata, $form->doklad);

				$postdataRadky = $formRadky->getValues();


				$postdataRadky = postToArray($postdataRadky);

				$radkySaveData = self::setRadkyData($postdataRadky, $formRadky->radkyOriginal);
				//	print "tudy3";
				if (self::saveData($dokladSaveData, $radkySaveData)) {
					$form->setResultSuccess('Doklad byl aktualizován.');
					self::$getRequest->goBackRef();
				}

			}

		}

	}




	public function saveAjaxAction()
	{
		// Je odeslán formulář
		if(self::$getRequest->isPost() && "ObjednavkaEdit" == self::$getRequest->getPost('action', false))
		{
			$form = $this->formLoad('ObjednavkaEdit');

			if ( $this->saveObjednavka($form)) {
				//$form->setResultSuccess("Středisko bylo upraveno.");
				//	$this->getRequest->goBackRef();

				return true;
			}

		}
	}


	private function saveObjednavka($form)
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



			$entita = new OrdersEntity($form->doklad);
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


	public function copyAjaxAction()
	{
		// Je odeslán formulář
		if(self::$getRequest->isPost() && "ObjednavkaCopy" == self::$getRequest->getPost('action', false))
		{

			$doklad_id = (int) self::$getRequest->getQuery('id', 0);
			$model = new models_Orders();
			$obj = $model->getDetailById($doklad_id);

			if ($obj) {


				if (self::copyDoklad($doklad_id)) {
					return true;
				}
				//	return true;

			}
		}
	}

	public function copyAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false)
			 && "copyOrders" == self::$getRequest->getPost('action', false))
		{
			$selectedItems = self::$getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						$model = new models_Orders();
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
				$_SESSION["statusmessage"]="Objednávka " . implode(",", $seznamCiselObjednavek) . " byla zkopírována.";
				$_SESSION["classmessage"]="success";
				self::$getRequest->goBackRef();
			}
		}
	}

	public function deleteAction()
	{

		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false)
			&& "deleteOrders" == self::$getRequest->getPost('action', false))
		{

			$selectedItems = self::$getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						$model = new models_Orders();
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
				$_SESSION["statusmessage"]="Objednávka " . implode(",", $seznamCiselObjednavek) . " byla smazána.";
				$_SESSION["classmessage"]="success";
				self::$getRequest->goBackRef();
			}

		}
	}

	public function deleteAjaxAction()
	{
		// Je odeslán formulář
		if(self::$getRequest->isPost() && "ObjednavkaDelete" == self::$getRequest->getPost('action', false))
		{

			$doklad_id = (int) self::$getRequest->getQuery('id', 0);
			$model = new models_Orders();
			$obj = $model->getDetailById($doklad_id);

			if ($obj) {


				if ($this->deleteObjednavka($doklad_id)) {
					return true;
				}
				//	return true;

			}
		}
	}

	private function deleteObjednavka($stredisko_id)
	{

		$model = new models_Orders();
		$data = array();
		$data["isDeleted"] = 1;
		//	print $stredisko_id;
		//	exit;
		if ($model->updateRecords($model->getTablename(),$data,"id=".$stredisko_id)) {
			return true;
		}
		return false;
	}

	private function stornoDokladu($doklad_id)
	{
		$model = new models_Orders();
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
		if(self::$getRequest->isPost() && "ObjednavkaStorno" == self::$getRequest->getPost('action', false))
		{

			$doklad_id = (int) self::$getRequest->getQuery('id', 0);



			if ($this->stornoDokladu($doklad_id)) {
				return true;
			}
		}
	}

	public function stornoAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false)
			&& "stornoOrders" == self::$getRequest->getPost('action', false))
		{

			$selectedItems = self::$getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {

					if ($obj = $this->stornoDokladu($doklad_id)) {
						array_push($seznamCiselObjednavek,$obj->code );
					}
					/*	if ($doklad_id) {
					   $model = new models_Orders();
					   $obj = $model->getDetailById($doklad_id);

					   if ($obj) {
					   $data = array();
					   $data["storno"] = 1;
					   if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id))
					   {
					   array_push($seznamCiselObjednavek,$obj->code );
					   }
					   }
					   }*/
				}
				array_reverse($seznamCiselObjednavek);
				$_SESSION["statusmessage"]="Objednávka " . implode(",", $seznamCiselObjednavek) . " byla stornována.";
				$_SESSION["classmessage"]="success";
				self::$getRequest->goBackRef();
			}

		}
	}

	public function createBasketZObjednavky($id)
	{
		$doklad = $this->getOrder($id);
		$radky = $this->order_details;
		$basketController = new BasketController();

		foreach ($radky as $key => $val) {

			if ($val->product_id > 0 && $val->qty > 0) {
				$basketController->addProductProces($val->product_id, $val->qty);
			}

		}
	}


	public function createBasketZObjednavkyAction()
	{



		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('order_to_basket', false))
		{


			$tenzin = self::$getRequest->getPost('order_to_basket', false);

			if (is_array($tenzin)) {
				list($key,$id) = each($tenzin);
			} else {
				$id = (int) $tenzin;
			}




			$result = $this->createBasketZObjednavky($id);

			//$result = $fakturaController->createDoklad($faktura, $radkyFaktury);

			if ($result) {
				$_SESSION["statusmessage"]='Zboží z objednávky bylo vloženo do košíku.</a>';
				$_SESSION["classmessage"]="success";

				self::$getRequest->goBackRef();
			}



		}

	}


	public function createFakturaZObjednavky($id)
	{
		$doklad = $this->getOrder($id);
		$doklad->faktura_type_id = 1;
		$radky = $this->order_details;
		return $this->createFaktura($doklad,$radky);
	}

	public function odeslatEmailSObjednavkou($komu,$predmet,$body ,$priloha,$nazev_prilohy='objednavka.pdf')
	{

		//$eshopController = new EshopController();

		$eshopSettings = G_EshopSetting::instance();


		if (!isEmail($komu)) {
			//	$odeslano2 = $this->sendInfoEmail();
			return false;
		}

		$skryty = false;
		if (isEmail($eshopSettings->get("BCC_EMAIL"))) {
			$skryty = $eshopSettings->get("BCC_EMAIL");
		}

		$mailController = new MailingController();
		if ($mailController->odeslatEmail($komu,$predmet,$body ,$priloha,$nazev_prilohy,$skryty)) {
			if (isEmail($eshopSettings->get("INFO_EMAIL"))) {
			//	$odeslano2 = $this->sendInfoEmail();

			}
			return true;
		}
	}

	public function createFaktura($doklad,$radky)
	{


		$eshopSettings = G_EshopSetting::instance();



		//$eshopController = new EshopController();


		$faktura = array();

	//	print $eshopController->setting["CISLO_FAK_OBJ"];
		if ($eshopSettings->get("CISLO_FAK_OBJ")  == "1") {
			$faktura["code"] = $doklad->code;
		}




		$faktura["shipping_first_name"] = $doklad->shipping_first_name;
		$faktura["shipping_last_name"] = $doklad->shipping_last_name;
		$faktura["shipping_address_1"] = $doklad->shipping_address_1;
		$faktura["shipping_city"]  = $doklad->shipping_city;
		$faktura["shipping_zip_code"] = $doklad->shipping_zip_code;
		$faktura["shipping_phone"]  = $doklad->shipping_phone;
		$faktura["shipping_email"] = $doklad->shipping_email;
		$faktura["shipping_ico"]  = $doklad->shipping_ico;
		$faktura["shipping_dic"] = $doklad->shipping_dic;
		$faktura["description"]  = $doklad->description;
		$faktura["shipping_pay"] = $doklad->shipping_pay;
		$faktura["shipping_transfer"] = $doklad->shipping_transfer;
		$faktura["order_date"] = $doklad->order_date;
		$faktura["order_code"] = $doklad->code;

		$faktura["description"] = $doklad->description;
		$faktura["description_secret"] = $doklad->description_secret;
		$faktura["faktura_type_id"] = $doklad->faktura_type_id;
		$faktura["customer_id"] = $doklad->customer_id;

		$faktura["faktura_date"] = date("Y-m-d");


		$splatnost = (trim($eshopSettings->get("SPLATNOST"))*1 > 0 ? date("j.n.Y",strtotime("+" . trim($eshopSettings->get("SPLATNOST")) . "days"))  : date("j.n.Y"));
		$faktura["maturity_date"] = $splatnost;

	//	$faktura["maturity_date"] = date("Y-m-d");
		$faktura["duzp_date"] = $doklad->duzp_date;


		$faktura["shipping_first_name2"] = $doklad->shipping_first_name2;
		$faktura["shipping_last_name2"] = $doklad->shipping_last_name2;

		$faktura["shipping_address_12"] = $doklad->shipping_address_12;
		$faktura["shipping_city2"] = $doklad->shipping_city2;
		$faktura["shipping_zip_code2"] = $doklad->shipping_zip_code2;





	//	print_R($faktura);
	//		exit;
		$radkyFaktury = array();
		for($i=0;$i<count($radky);$i++)
		{

			$radkyFaktury["radek_added"][$i] = 1;
			$radkyFaktury["qty"][$i] = $radky[$i]->qty;
			$radkyFaktury["price"][$i] = $radky[$i]->price;
			$radkyFaktury["mj_id"][$i] = $radky[$i]->mj_id;
			$radkyFaktury["product_code"][$i] = $radky[$i]->product_code;
			$radkyFaktury["product_name"][$i] = $radky[$i]->product_name;
			$radkyFaktury["product_description"][$i] = $radky[$i]->product_description;
			$radkyFaktury["tax_id"][$i] = $radky[$i]->tax_id;
			$radkyFaktury["sleva"][$i] = $radky[$i]->sleva;
			$radkyFaktury["typ_slevy"][$i] = $radky[$i]->typ_slevy;
			//$radkyFaktury[$i]["product_id"] = $radky[$i]->product_id;

		}

		$fakturaController = new FakturyController();

		$radkyFaktury = postToArray($radkyFaktury);
		$savedData = $fakturaController->createDoklad($faktura, $radkyFaktury);


		if ($savedData) {
			// propíšu číslo faktury do objednávky
			$modelObjednavky = new models_Orders();

			$modelObjednavky->updateRecords($modelObjednavky->getTableName(),array("faktura_id"=>$savedData["id"]),"id=".$doklad->id);



		}
		return $savedData;
	}

	public function createFakturaAction()
	{



		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('generovat_fakturu', false))
		{


			$id = self::$getRequest->getPost('Application_Form_ObjednavkaEdit_id', false);
			$result = $this->createFakturaZObjednavky($id);

			//$result = $fakturaController->createDoklad($faktura, $radkyFaktury);

			if ($result) {
				$_SESSION["statusmessage"]='Faktura byla vygenerována <a href="'.URL_HOME2.'admin/eshop/faktury/faktura_detail?id='.$result["id"].'">Přejít na právě pořízený záznam.</a>';
				$_SESSION["classmessage"]="success";

				self::$getRequest->goBackRef();
			} else {

				print "tudy";
				exit;
			}



		}

	}

	public function obratkovostSortimentuList($params = array())
	{

		$params2 = array();



		$params2['lang'] = LANG_TRANSLATOR;

		$limit 	= self::$getRequest->getQuery('limit', 100);
		if (isset($params['limit']) && is_numeric($params['limit'])) {
			$limit = $params['limit'];
		}
		$params2['limit'] = $limit;


		$page 	= self::$getRequest->getQuery('pg', 1);
		if (isset($params['page']) && is_numeric($params['page'])) {
			$page = $params['page'];
		}

		$params2['page'] = $page;

		$search_string = self::$getRequest->getQuery('q', '');
		$params2['fulltext'] = $search_string;
		if (isset($params['search']))
		{
			$params2['fulltext'] = $params['search'];
		}


		$date_from = self::$getRequest->getQuery('df', '');
		$date_from = !empty($date_from) ? $date_from : FILTER_FROM_DATE;
		if ( !empty($date_from) ) {
			$date_from_val =$date_from;
			$date_from = strtotime($date_from);
			$date_from = date("Y-m-d H:i:s",$date_from);
			$params2['date_from'] = $date_from;
			//print $date_from;
		}
		$date_to = self::$getRequest->getQuery('dt', '');
		//$date_to = !empty($date_to) ? $date_to : FILTER_TO_DATE;
		if ( !empty($date_to) ) {
			$date_to_val =$date_to;
			$date_to = strtotime($date_to);
			$date_to = date("Y-m-d",$date_to) . " 23:59:59";
			$params2['date_to'] = $date_to;
			//print $date_to;
		}


		$querys = array();
		$querys[] = array('title'=>'Název','url'=>'name','sql'=>'v.title');
		$querys[] = array('title'=>'Číslo','url'=>'num','sql'=>'p.cislo');
		$querys[] = array('title'=>'Výrobce','url'=>'producer','sql'=>'vb.name');
		$querys[] = array('title'=>'Kategorie','url'=>'cat','sql'=>'t3.nazev_cs');
		$querys[] = array('title'=>'Skupina','url'=>'grp','sql'=>'t2.nazev_cs');
		$querys[] = array('title'=>'Cena','url'=>'obrat_price','sql'=>'obrat_price');
		$querys[] = array('title'=>'Množ.','url'=>'obrat_qty','sql'=>'obrat_qty');
		$orderFromQuery = $this->orderFromQuery($querys, 'obrat_qty DESC');

		if (empty($orderFromQuery)) {

			//$orderFromQuery = 't1.vip DESC, RAND(' . $random . ')';
			if (isset($params['order_default']) && !empty($params['order_default']))
			{
				$orderFromQuery = $params['order_default'];
			}
		}
		$params2['order'] = $orderFromQuery;

		$model = new models_Products();
		$list = $model->getObratyList($params2);
		$this->total = $model->total;

		return $list;
	}

	public function obratkovostSortimentuListEdit($params = array())
	{
		$l = $this->obratkovostSortimentuList($params);


		$zisk_celkem = 0;
		$obrat_celkem = 0;
		for ($i=0;$i < count($l);$i++)
		{
			$obrat_celkem += $l[$i]->obrat_price;
			$zisk_celkem += $l[$i]->zisk;
		}


		for ($i=0;$i<count($l);$i++)
		{
			$span_start = '';
			$span_end = '';

			$l[$i]->checkbox = "";
			switch($l[$i]->stav)
			{
				case 1:
					$span_start = '<span class="prijata">';
					$span_end = '</span>';
					$style_color='';
					break;
				case 2:
					$stav = "Vyexpedovaná";
					$span_start = '<span class="expedice">';
					$span_end = '</span>';
					break;
				case 3:
					$stav = "Vyřizuje se";
					//$style_color='kvyrizeni';
					$span_start = '<span class="kvyrizeni">';
					$span_end = '</span>';
					break;
				case 4:
					$stav = "Dokonceno";
					$span_start = '<span class="vyrizena">';
					$span_end = '</span>';
					$style_color='vyrizena';
					break;
				default:
					break;
			}
			if ($l[$i]->storno == 1) {
				$span_start = '<span style="color:red;">';
				$span_end = '</span>';
			}


			$url = "/admin/edit_product.php?id=".$l[$i]->page_id;
			$l[$i]->cislo_mat = '<a href="' . $url . '">' . $l[$i]->cislo . '</a>';
			if (!empty($l[$i]->code01)) {
				$l[$i]->cislo_mat .='<br />' . $l[$i]->code01 . '<br />' . $aktivni_klik;
			}

			if (empty($l[$i]->shipping_last_name)) {
				$l[$i]->shipping_last_name = $l[$i]->shipping_first_name;
			}
			$order_code = $l[$i]->code;

			$l[$i]->nazev_dopravy_platby = $span_start. $l[$i]->nazev_dopravy . "<br />" . $l[$i]->nazev_platby . $span_end;

			$l[$i]->obrat_price = $span_start. number_format($l[$i]->obrat_price, 2, ',', ' ') . $span_end;
			$l[$i]->obrat_qty = $span_start. number_format($l[$i]->obrat_qty, 2, ',', ' ') . $span_end;
			$l[$i]->zisk = $span_start. number_format($l[$i]->zisk, 2, ',', ' ') . $span_end;
			$l[$i]->price_avg = $span_start. number_format($l[$i]->price_avg, 2, ',', ' ') . $span_end;
			$l[$i]->order_date = $span_start. date("j.n.Y H:i",strtotime($l[$i]->order_date)) . $span_end;
			$l[$i]->code =  '<strong><a href="' . URL_HOME2 . 'admin/objednavka_detail.php?id=' . $l[$i]->id . '">' . $span_start . $l[$i]->code . $span_end . '</a></strong>';
			$command = '<input class="" style="border:0 none;background-color:transparent;" onclick="return confirm(\'Opravdu STORNOVAT objednávku č. '.$order_code.'?\')" type="image" src="'.URL_HOME2 . 'admin/images/cancel.png" value="X" name="storno_order[' . $i . ']"/>';
			$command .= '<input type="hidden" value="' . $l[$i]->id . '" name="doklad_id[' . $i . ']"/>';

			$l[$i]->shipping_last_name = $span_start. $l[$i]->shipping_last_name . $span_end;
			$l[$i]->shipping_email = $span_start. $l[$i]->shipping_email . $span_end;
			$l[$i]->shipping_phone = $span_start. $l[$i]->shipping_phone . $span_end;
			$l[$i]->shipping_city = $span_start. $l[$i]->shipping_city . $span_end;


			$l[$i]->cmd = '';
		}

		$novyRadek = count($l);
		$l[$novyRadek] = new stdClass();
		$l[$novyRadek]->checkbox = "&sum;";
		$l[$novyRadek]->obrat_price = '<span class="suma">' . number_format($obrat_celkem, 2, ',', ' ') . '</span>';
		$l[$novyRadek]->zisk = '<span class="suma">' . number_format($zisk_celkem, 2, ',', ' ') . '</span>';
		$l[$novyRadek]->price_avg = "";
		$l[$novyRadek]->cislo_mat = "";
		$l[$novyRadek]->title = "";
		$l[$novyRadek]->nazev_category = "";
		$l[$novyRadek]->obrat_qty = "";


		return $l;
	}

	public function obratkovostSortimentuListTable($params = array())
	{

		$sorting = new G_Sorting("obrat_qty","desc");

		$params = array();
		$l = $this->obratkovostSortimentuListEdit($params);


		$data = array();
		$th_attrib = array();
		$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
		$column["cislo_mat"] = $sorting->render("Číslo", "code");
		$column["title"] = $sorting->render("Název", "lname");
		$column["nazev_category"] = $sorting->render("Umístění", "phone");
		$column["obrat_qty"] = $sorting->render("Množ.", "obrat_qty");
		$column["price_avg"] = $sorting->render("Prům.cena", "price_avg");
		$column["obrat_price"] = $sorting->render("Obrat", "obrat_price");
		$column["zisk"] = $sorting->render("Zisk", "zisk");



		/*
		$column["shipping_city"] = $sorting->render("Adresa", "address");
		$column["nazev_dopravy_platby"] = $sorting->render("Doprava", "transfer") . "<br />" . $sorting->render("Platba", "platba");
		$column["cost_subtotal"] = $sorting->render("Cena", "total");
		$column["order_date"] = $sorting->render("Přijato", "date");
		*/
		//$column["cmd"] = '';

		$th_attrib["checkbox"]["class"] = "check-column";
		$th_attrib["preview"]["class"] = "column-thumb";
		$th_attrib["code"]["class"] = "column-num";
		$th_attrib["shipping_last_name"]["class"] = "column-cat";
		$th_attrib["shipping_email"]["class"] = "column-cat";
		$th_attrib["cost_total"]["class"] = "column-price";
		$th_attrib["qty"]["class"] = "column-qty";


		$th_attrib["cmd"]["class"] = "column-cmd";
		$th_attrib["order_date"]["class"] = "column-date";
		$th_attrib["shipping_phone"]["class"] = "column-date";
		$td_attrib["obrat_qty"]["class"] = "column-price";
		$td_attrib["obrat_price"]["class"] = "column-price";
		$td_attrib["zisk"]["class"] = "column-price";
		$td_attrib["price_avg"]["class"] = "column-price";
		$table = new G_Table($l, $column, $th_attrib, $td_attrib);


		$table_attrib = array(
							"class" => "widefat",
							"id" => "data_grid",
							"cellspacing" => "0",
							);
		return $table->makeTable($table_attrib);

	}

	public function odeslatEmailStavObjednavkyAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('send_stav_order', false))
		{


			$id = self::$getRequest->getPost('Application_Form_ObjednavkaEdit_id', false);
			$doklad = $this->getOrder($id);
//print "tudy" . $id;

	//	print_r($doklad);

	//exit;
			$doklad = object_to_array($doklad);

			/*
			if ($doklad["stav"] == 1) {
				if ($this->odeslatEmail($doklad)) {
					$_SESSION["statusmessage"]="email byl odeslán";
					$_SESSION["classmessage"]="success";
					self::$getRequest->goBackRef();
				}
			}
			*/


			if (!isEmail($doklad["shipping_email"])) {
				$_SESSION["statusmessage"]="Nebyl zadán email";
				$_SESSION["classmessage"]="error";
				return false;
			}

			if ($doklad["storno"] == 1) {
				if ($this->odeslatEmailStorno($doklad)) {

					$model = new models_Orders();
					$data = array();
					$data["odeslano_stav"] = 999;
					$data["odeslanoTimeStamp"] = date("Y-m-d H:i:s");
					$model->updateRecords($model->getTableName(),$data , "id=".$doklad["id"]);


					$_SESSION["statusmessage"]="email byl odeslán";
					$_SESSION["classmessage"]="success";
					self::$getRequest->goBackRef();
				}
			}
			//Vyřizuje se
			if ($doklad["stav"] == 3) {
				if ($this->odeslatEmailVyrizujeSe($doklad)) {

					$model = new models_Orders();
					$data = array();
					$data["odeslano_stav"] = $doklad["stav"];
					$data["odeslanoTimeStamp"] = date("Y-m-d H:i:s");
					$model->updateRecords($model->getTableName(),$data , "id=".$doklad["id"]);

					$_SESSION["statusmessage"]="email byl odeslán";
					$_SESSION["classmessage"]="success";
					self::$getRequest->goBackRef();
				}
			}

			//Vyexpedovaná
			if ($doklad["stav"] == 2) {
			/*	if ($this->odeslatEmailVyrizeno($doklad)) {

					$model = new models_Orders();
					$data = array();
					$data["odeslano_stav"] = $doklad["stav"];
					$data["odeslanoTimeStamp"] = date("Y-m-d H:i:s");
					$model->updateRecords($model->getTableName(),$data , "id=".$doklad["id"]);

					$_SESSION["statusmessage"]="email byl odeslán";
					$_SESSION["classmessage"]="success";
					self::$getRequest->goBackRef();
				}*/
			}

			if ($doklad["stav"] == 4) {

			//	print "tudy";
			//	exit;
				if ($this->odeslatEmailVyrizeno($doklad)) {


					$model = new models_Orders();
					$data = array();
					$data["odeslano_stav"] = $doklad["stav"];
					$data["odeslanoTimeStamp"] = date("Y-m-d H:i:s");
					$model->updateRecords($model->getTableName(),$data , "id=".$doklad["id"]);

					$_SESSION["statusmessage"]="email byl odeslán";
					$_SESSION["classmessage"]="success";
					self::$getRequest->goBackRef();
				}
			}




		}
	}

	protected function getHtmlHeaderEmail()
	{
		$body ='<html lang="cs-CZ">';
		$body .="<head>";

		$html .= '	<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
		$html .= '<style>' . file_get_contents(dirname(__FILE__) . "/../../admin/style/print_pdf.css") . '</style>';
		$body .="</head>";
		$body .="<body>";

		return $body;
	}

	protected function odeslatEmailStorno($data)
	{
		$doklad_id = $data["id"];

		$eshopSettings = G_EshopSetting::instance();

		$body = $this->getHtmlHeaderEmail();

		$body .='<p>Vážený zákazníku,<br /><br /><br />
					zasíláme Vám potvrzení o <strong>storno objednávky č. ' . $data["code"] . '</strong> z webu <a href="'.URL_HOME.'"><strong>' . URL_DOMAIN . '</strong></a><br /><br />
</p>';


		$body .='<p>
				Přejeme Vám hezký den.<br />
				<br /><br />

				<strong>Váš Tým<br />' . $eshopSettings->get("COMPANY_NAME") . '</strong><br /><br /></p>
				<span style="font-style:italic;font-size:11px;">Tato zpráva byla vygenerována systémem automaticky, prosím neodpovídejte na ní!</span>';
		$body .="</body></html>";

		$komu = "rudolf.pivovarcik@centrum.cz";
		$komu = $data["shipping_email"];

		return $this->odeslatEmailSObjednavkou($komu,"Storno objednávky",$body);
	}

	protected function odeslatEmailVyrizeno($data)
	{

		$doklad_id = $data["id"];



		$body = $this->getHtmlHeaderEmail();

		$body .='<p>Vážený zákazníku,<br /><br /><br />
					Děkujeme za Váš nákup a zasíláme Vám potvrzení o expedici zboží objednávky č <strong>' . $data["code"] . '</strong> z webu <a href="'.URL_HOME.'"><strong>' . URL_DOMAIN . '</strong></a><br /><br />
</p>';


		$body .='<p>
				Velice si vážíme, že jste si vybrali pro svůj nákup právě nás a přejeme Vám hezký den.<br />
				<br /><br />';

		$body .= $this->getPodpis();

		//<strong>Váš Tým<br />ACTAPOL spol. s r.o.</strong><br /><br /></p>';
		$body .= '<span style="font-style:italic;font-size:12px;">Tato zpráva byla vygenerována systémem automaticky, prosím neodpovídejte na ní!</span>';
		$body .="</body></html>";


		$komu = "rudolf.pivovarcik@centrum.cz";
		$komu = $data["shipping_email"];

	//	print $komu;
	//	exit;
		return $this->odeslatEmailSObjednavkou($komu,"Expedice zboží",$body);
	}

	protected function odeslatEmailVyrizujeSe($data)
	{

		//		print "posilam email";


		//$eshopController = new EshopController();
		$eshopSettings = G_EshopSetting::instance();
		$doklad_id = $data["id"];


		$body = $this->getHtmlHeaderEmail();

		$body .='<p>Vážený zákazníku,<br /><br /><br />
					Děkujeme za Váš nákup. Objednávka č. <strong>' . $data["code"] . '</strong> z webu <a href="'.URL_HOME.'"><strong>' . URL_DOMAIN . '</strong></a> se nyní vyřizuje a připravuje k expedici.<br />
O dalším zpracování Vás budeme informovat.
<br />
</p>';


		$body .='<p>
				Velice si vážíme, že jste si vybrali pro svůj nákup právě nás a přejeme Vám hezký den.<br />
				<br /><br />

				<strong>Váš Tým<br />' . $eshopSettings->get("COMPANY_NAME") . '</strong><br /><br /></p>
				<span style="font-style:italic;font-size:11px;">Tato zpráva byla vygenerována systémem automaticky, prosím neodpovídejte na ní!</span>';
		$body .="</body></html>";

		$komu = "rudolf.pivovarcik@centrum.cz";
		$komu = $data["shipping_email"];

		//$eshopController->eshop_setting["INFO_EMAIL"]
		//	$eshopController = new EshopController();
		return $this->odeslatEmailSObjednavkou($komu,"Objednávka se vyřizuje",$body);
	}
}
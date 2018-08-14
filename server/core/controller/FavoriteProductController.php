<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class FavoriteProductController extends G_Controller_Action
{
	private $attributes = array();
	private $photos = array();
	public $total = 0;
	public $isEmpty = true;
	public $status = array();
	private $favorite_id;


	public $eshopSetting = array();
	function __construct()
	{
		parent::__construct();

	//	$eshopController = new EshopController();
	//	$this->eshopSetting = $eshopController->setting;
		// Zavádím seanci
		$this->favorite_id = $this->getRequest->getSession("temp_cart",
							$this->getRequest->getCookie("temp_cart",false)
					);

		if (false === $this->favorite_id) {
			$this->favorite_id = mt_rand();
		}
		//$this->getRequest->setSession("temp_cart", $this->favorite_id);
		//$this->getRequest->setCookie("temp_cart", $this->favorite_id);
	}

	public function favoriteList($params = array())
	{


		$params2 = array();
		$limit = 1000;
		$params2["limit"] = $limit;
		if (isset($params['disableQuery'])) {
			$this->getRequest->disableQuery();
		}

		if (isset($params['all']) && $params['all'] == 1) {
		//	$params2["basket_id"] = (int) $params['basket_id'];
		} else {
		/*	if (defined("USER_ID")) {
				$params2["user_id"] = USER_ID;
			} else {
				$params2["basket_id"] = (int) $this->favorite_id;
			}*/
			// není důvod vymezovat se uživatele
			$params2["basket_id"] = (int) $this->favorite_id;

		}

		$params2["lang"] = LANG_TRANSLATOR;
		$basket = new models_ProductFavorite();
		$l = $basket->getList($params2);


		//print_r($l);
		$this->total = $basket->total;

		if ($this->total > 0) {
			$this->isEmpty = false;
		} else {
			$this->isEmpty = true;
		}
		//$this->categoryTable();
		$this->qty = 0;
		$this->total_price = 0;
		$this->total_price_sdph = 0;
		$this->total_tax = 0;
		for ($i=0;$i < count($l);$i++)
		{
			/*
			$this->qty += $l[$i]->mnozstvi;
			$this->total_price += $l[$i]->price * $l[$i]->mnozstvi;
			$this->total_price_sdph += ($l[$i]->cena_sdph * $l[$i]->mnozstvi);
			$this->total_tax += $this->total_price_sdph - $this->total_price;
			*/
		}
		return $l;
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
	public function basketListEdit($params = array())
	{

		$l = $this->basketList($params);

		$imageController = new ImageController();

	//	print_r($l);
	//	$g = new Zakl();
		//$this->total_price = 0;
		for ($i=0;$i < count($l);$i++)
		{
			//$this->total_price += $l[$i]->prodcena * $l[$i]->mnozstvi;
			if (!empty($l[$i]->file)) {

				$PreviewUrl = '<img alt="" title="" src="' . $imageController->get_thumb($l[$i]->file) . '" class="imgobal">';
			} else {
				$PreviewUrl = '';
			}


			$l[$i]->preview = $PreviewUrl;

			$product_id = $l[$i]->product_id;


			$product_url = URL_HOME . get_categorytourl($l[$i]->serial_cat_url) . "/" . $l[$i]->product_id .'-' . $l[$i]->url . '.html';

			$nazev_mat = '<a href="'.$product_url.'" title="'.$l[$i]->title.'">';
			$nazev_mat .= $l[$i]->title;
			$nazev_mat .= '</a>';

			//$l[$i]->nazev_mat_cs = $nazev_mat;

			$elemQty = new G_Form_Element_Text("qty[" . $i . "]");
			$elemQty->setAttribs(array("is_int"=>true));
			$qtyValue = $this->getRequest->getPost("qty[" . $i . "]", number_format($l[$i]->mnozstvi, 0, ',', ''));
			$elemQty->setAttribs('value',$qtyValue);
			$elemQty->setAttribs('class','qty');

			if (!empty($l[$i]->tandem_id)) {
				$elemQty->setAttribs('disabled','disabled');
				$elemQty->setAttribs('class','qty disabled');
			}



			//	$elemQty->setAttribs('label','Nabízené množství:');
			$elemQty->setAttribs('style','width:40px;text-align:right;');
			$l[$i]->mnozstvi_edit = $elemQty->render();
			$l[$i]->cenamj = number_format($l[$i]->price, 0, ',', ' ') . ' Kč';
			$l[$i]->cenacelkem = number_format($l[$i]->price * $l[$i]->mnozstvi, 0, ',', ' ') . ' Kč';
			$l[$i]->BasketTimeStamp = date("j.n.Y H:i:s",strtotime($l[$i]->BasketTimeStamp)) . "<br />" . $l[$i]->ip_adresa . "<br />(" . $l[$i]->basket_id . ")";
		}

		return $l;
	}
	public function addProductAction()
	{
		// Ověřím si
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('add_product_fav', false))
		{

			$product_id = $this->getRequest->getPost('product_id', false);

			$productModel = new models_Products();
			$productDetail = $productModel->getDetailById($product_id);



			if (!$productDetail) {
				return false;
			}

			if ($productDetail->aktivni == 0) {
				return false;
			}

		//	return $this->addProduct($product_id);

			if ($this->addProduct($product_id)) {
				//$_SESSION["statusmessage"]="Produkt byl přidán do seznamu oblíbených položek.";
				//$_SESSION["classmessage"]="success";
			//	$this->getRequest->goBackRef();

				return true;
			}
		}
	}
	public function removeProductAction()
	{
		// Ověřím si
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('remove_product_fav', false))
		{

			$product_id = $this->getRequest->getPost('product_id', false);

			$productModel = new models_Products();
			$productDetail = $productModel->getDetailById($product_id);



			if (!$productDetail) {
				return false;
			}

			if ($productDetail->aktivni == 0) {
				return false;
			}

			//return $this->removeProduct($product_id);

			if ($this->removeProduct($product_id)) {
			//	$_SESSION["statusmessage"]="Produkt byl odebrán ze seznamu oblíbených položek.";
			//	$_SESSION["classmessage"]="success";
			//	$this->getRequest->goBackRef();

				return true;
			}

		}
	}
	private function addProduct($product_id)
	{
		$model = new models_ProductFavorite();

		if (!$model->isProductFavorite($product_id, $this->favorite_id)) {
			// neexistuje, přidávám
			$model->addProduct($product_id, $this->favorite_id);
			$this->status["status"] = "ok";
			return true;
		} else {
			$this->status["status"] = "already";
			return false;
		}

	}

	public function isProduct($product_id)
	{
		$model = new models_ProductFavorite();
		return $model->isProductFavorite($product_id, $this->favorite_id);
	}
	private function removeProduct($product_id)
	{
		$model = new models_ProductFavorite();
		return $model->removeProduct($product_id, $this->favorite_id);


	}
	private function clearFavorite()
	{
		$model = new models_ProductFavorite();
		$model->clear($this->favorite_id);
	}
	public function clearFavoriteAction()
	{
		// Ověřím si
		if($this->getRequest->isPost() && false !== $this->getRequest->getPost('del_all_favorite', false))
		{
			$this->clearFavorite();
		}
	}
}
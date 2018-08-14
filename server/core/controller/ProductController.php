<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */


class ProductController extends PageVersionBase
{
	private $attributes = array();
	private $photos = array();
	private $prices = array();
	public $total = 0;
	private $versioning = false;


	function __construct()
	{
		parent::__construct("Product", "ProductVersion");
		//	self::$isVersioning = (VERSION_CATEGORY == 1) ? true : false;

		$settings = G_Setting::instance();
		$isVersioning = ($settings->get("VERSION_PRODUCT") == 1) ? true : false;
		self::$isVersioning = $isVersioning;
		self::$saveEntity = true;
	//	self::$isVersioning = true;
	}


	public function getProductAuditList($params = array())
	{


		if (isset($params['all']) && $params['all'] == 1) {
			//	$params2["basket_id"] = (int) $params['basket_id'];
		} else {
			if (defined("USER_ID")) {
				$params["user_id"] = USER_ID;
			} else {
				$params["ip_adresa"] = $_SERVER["REMOTE_ADDR"];
			}

		}
		$model = new models_ProductAudit;
		return $model->getList($params);
	}
	private function setProductAudit($product_id)
	{
		$model = new models_ProductAudit;

		$data = array();
		$data["product_id"] = $product_id;
		$data["ip_adresa"] = self::$getRequest->getServer("REMOTE_ADDR");;
		if (defined("USER_ID")) {
			$data["user_id"] = USER_ID;
		}
		$model->insertRecords($model->getTableName(),$data);
	}
	public function get_attributeAssociation($product_id)
	{
		$attributes = new models_Attributes();
		return $attributes->get_attribute_value_association($product_id);
	}

	public function setAttributeProduct($product_id){


		if(self::$getRequest->isPost() &&
			false !== self::$getRequest->getPost('upd_attribute_product', false))
		{
			$data = array();



				$selected = self::$getRequest->getPost('attrib', array());

			//	print_r($selected);
			//	exit;
				$attrib_value = self::$getRequest->getPost('attrib_value', array());
				$data = self::$getRequest->getPost('attrib_is', array());
				$_product = new models_Products();





				foreach ($data as $key => $value){

					if ($value == 1 && isset($selected[$key])) {
						// attribut je přiřazen a zůstal zatržen
						//print "nic - zustava";
					}


					if ($value == 1 && !isset($selected[$key])) {
						// attribut je přiřazen a je odebrán

						$query = "delete FROM `" . T_SHOP_PRODUCT_ATTRIBUTE_VALUE_ASSOC . "` where product_id=" . $product_id . " and attribute_id in
						(SELECT id FROM `" . T_SHOP_PRODUCT_ATTRIBUTE_VALUES . "` WHERE attribute_id in (SELECT attribute_id FROM `" . T_SHOP_PRODUCT_ATTRIBUTE_VALUES . "` WHERE id=" . $attrib_value[$key] . "))";

						$_product->query($query);
					}


					if ($value == 0 && isset($selected[$key])) {
						//attribut bude přidán
						$data = array();
						$data["product_id"] = $product_id;
						$data["attribute_id"] = $attrib_value[$key];
						//	print "pridavam: " . $data["attribute_id"];
						$_product->insertRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUE_ASSOC, $data);

					}

				}
				//	print_r(self::$getRequest->getPost('attr', array()));
				$_SESSION["statusmessage"]="Vlastnosti byly nastaveny.";
				$_SESSION["classmessage"]="success";
				self::$getRequest->goBackRef();
			//}
		}


		if(self::$getRequest->isPost() &&
			false !== self::$getRequest->getPost('F_ProductAtributeEdit_action', false))
		{
			$data = array();


			// to nemusí být pravda, můžu odškrtnout všechny atributy a pak se mi ovšem nenaplní attrib
			//	if (false !== self::$getRequest->getPost('attrib', false)) {
			/*
			   $assoc_attrib = $this->get_attributeAssociation($product_id);
			   $assoc_attrib2 = array();
			   foreach ($assoc_attrib as $key => $value){
			   $assoc_attrib2[$value->ID] = $value->name;
			   }
			*/
			$selected = self::$getRequest->getPost('attrib', array());

			//	print_r($selected);
			//	exit;
			$attrib_value = self::$getRequest->getPost('attrib_value', array());
			$attrib_order = self::$getRequest->getPost('order', array());
			$data = self::$getRequest->getPost('attrib_is', array());
			$_product = new models_Products();





			foreach ($data as $key => $value){

				if ($value == 1 && isset($selected[$key])) {
					// attribut je přiřazen a zůstal zatržen
					//print "nic - zustava";

					$data = array();
				//	$data["product_id"] = $product_id;
				//	$data["attribute_id"] = $attrib_value[$key];
					$data["order"] = $attrib_order[$key];
					//	print "pridavam: " . $data["attribute_id"];
					$_product->updateRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUE_ASSOC, $data,"product_id=" . $product_id . " and attribute_id in
						(SELECT id FROM `" . T_SHOP_PRODUCT_ATTRIBUTE_VALUES . "` WHERE attribute_id in (SELECT attribute_id FROM `" . T_SHOP_PRODUCT_ATTRIBUTE_VALUES . "` WHERE id=" . $attrib_value[$key] . "))");

				}


				if ($value == 1 && !isset($selected[$key])) {
					// attribut je přiřazen a je odebrán

					$query = "delete FROM `" . T_SHOP_PRODUCT_ATTRIBUTE_VALUE_ASSOC . "` where product_id=" . $product_id . " and attribute_id in
						(SELECT id FROM `" . T_SHOP_PRODUCT_ATTRIBUTE_VALUES . "` WHERE attribute_id in (SELECT attribute_id FROM `" . T_SHOP_PRODUCT_ATTRIBUTE_VALUES . "` WHERE id=" . $attrib_value[$key] . "))";

					$_product->query($query);
				}


				if ($value == 0 && isset($selected[$key])) {
					//attribut bude přidán
					$data = array();
					$data["product_id"] = $product_id;
					$data["attribute_id"] = $attrib_value[$key];
					$data["order"] = $attrib_order[$key];
					//	print "pridavam: " . $data["attribute_id"];
					$_product->insertRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUE_ASSOC, $data);

				}

			}

			return true;
			//	print_r(self::$getRequest->getPost('attr', array()));
		//	$_SESSION["statusmessage"]="Vlastnosti byly nastaveny.";
		//	$_SESSION["classmessage"]="success";
		//	self::$getRequest->goBackRef();
			//}
		}
	}
	public function getProduct($product_id){
		$id_item = (int) $product_id;
		$product = new models_Products();
		//$obj = $product->getProduct($product_id);

		$obj = $product->getDetailById($product_id);


		if ($obj->aktivni == 0) {
			return false;
		}
    
    new ProductsWrapper($obj);
   // print_r($obj);
		$attributes = new models_Attributes();
		$this->attributes = $attributes->get_attribute_value_association2($product_id, LANG_TRANSLATOR);
		$this->attributesMulti = $attributes->get_attribute_multi_values($product_id);
    //print $attributes->getLastQuery();
    //print_r($this->attributesMulti);
 
    if (is_array($this->attributes)) {
			foreach ($this->attributes as $key => $value){
				//print_r($value);
        
        if ($value->multi_select == 1)
        {
           $value->attribute_id = array();
           $value->value_name = array();
          foreach ($this->attributesMulti as $key2 => $value2){
            if ($value2->id == $value->id)
            {
               array_push($value->value_name,$value2->value_name);
               array_push($value->attribute_id,$value2->attribute_id);
            } 
          }
        }
        
      }
    }
      
    //     print_r($this->attributes);
    $obj->attributes = $this->attributes;


    $args = new FotoPlacesListArgs();
    $args->gallery_id = (int) $product_id;
    $args->gallery_type = T_SHOP_PRODUCT;
    $model = new models_FilePlaces();
    $obj->files = $model->getList($args);

		//print_r($this->attributes);
		//$this->attributes = $product->getAttributes();
		$this->photos = $product->getPhotos();
		$this->prices = $product->getPrices();


		$this->setProductAudit($product_id);

		return $obj;
	}
	public function getProductAttribures()
	{
		return $this->attributes;
	}
	public function getProductPhotos()
	{
		return $this->photos;
	}
	public function getProductPrices()
	{
		return $this->prices;
	}


	public function getProductVariantText($product_id,$varianty_id)
	{
		$modelVarianty = new models_ProductVarianty();

		$params=array();
		$params['product_id'] = (int) $product_id;
		$params['varianty_id'] = (int) $varianty_id;

		$variantyList = $modelVarianty->getVariantyValueList($params);

		//print_r($variantyList);
		$varianty_text = "";
		foreach ($variantyList as $keya => $varianta)
		{

			//	if ($varianta_id != $varianta->varianty_id) {
			if (!empty($varianta->attribute_name)) {
				$varianty_text .= " " . $varianta->attribute_name . ": " . $varianta->value_name;
			}
			$varianty_text = trim($varianty_text);


			//}
		}
		if (empty($varianty_text)) {
			$varianty_text = $variantyList[0]->varianty_code;
		}

		return $varianty_text;

	}
	public function productListTable($params = array())
	{

		$l = $this->productListEdit($params);

		//print_r($l);
		$sorting = new G_Sorting("num","desc");

		$data = array();
		$th_attrib = array();
		$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
		$column["preview"] = '';
		$column["cislo_mat"] = $sorting->render("Číslo", "num");
		$column["nazev_mat_cs"] = $sorting->render("Produkt", "prod");
		$column["category_nazev"] = $sorting->render("Umístění", "tree") . " / " . $sorting->render("Skupina", "grp");
		$column["nazev_vyrobce"] = $sorting->render("Značka", "vyr");
		//$column["skupina_nazev"] = $headCat;
		$column["prodcena"] = $sorting->render("Prod. cena", "prc");
		$column["qty"] = $sorting->render("Množ.", "qty");
		//$column["et"] = 'ET';
		$column["cmd"] = '';

		$th_attrib["checkbox"]["class"] = "check-column";
		$th_attrib["preview"]["class"] = "column-thumb";

		$th_attrib["cislo_mat"]["class"] = "column-num";
		$th_attrib["skupina_nazev"]["class"] = "column-cat";
		$th_attrib["category_nazev"]["class"] = "column-cat";
		$th_attrib["nazev_vyrobce"]["class"] = "column-cat";
		$th_attrib["prodcena"]["class"] = "column-price";
		$th_attrib["qty"]["class"] = "column-qty";

		$th_attrib["cmd"]["class"] = "column-cmd";


		$td_attrib["qty"]["class"] = "column-qty";
		$td_attrib["prodcena"]["class"] = "column-price";

		$table = new G_Table($l, $column, $th_attrib, $td_attrib);


		$table_attrib = array(
								"class" => "widefat fixed",
								"id" => "data_grid",
								"cellspacing" => "0",
								);
		return $table->makeTable($table_attrib);

	}
	public function productListZboziFeed($params = array())
	{
		$list = $this->productList($params);
		$imageController = new ImageController();
		$xml = new c_xml_generator;
		$root = $xml->add_node(0, 'SHOP');

		for ($i=0;$i<count($list);$i++)
		{
			$item  = $xml->add_node($root, 'SHOPITEM');

			$product  = $xml->add_node($item, 'PRODUCT');

			$nazev_mat = trim(strip_tags($list[$i]->title));
			$xml->add_cdata($product, $nazev_mat);

			$description  = $xml->add_node($item, 'DESCRIPTION');
			$popis = trim(strip_tags($list[$i]->description));
			$xml->add_cdata($description, $popis);

			//$product_url = URL_DOMAIN . '/product/?id=' . $list[$i]->klic_ma;

			$product_url = $list[$i]->link;
			$url  = $xml->add_node($item, 'URL');
			$xml->add_cdata($url, $product_url);

			$type  = $xml->add_node($item, 'ITEM_TYPE');
			$xml->add_cdata($type, "new");

			$delivery_date=0;

			if ($list[$i]->dostupnost=='Běžně skladem') {
				$delivery_date=0;
			}

			if ($list[$i]->dostupnost=='Neznámá-nutno ověřit u výrobce') {
				$delivery_date=8;
			}

			$delivery  = $xml->add_node($item, 'DELIVERY_DATE');

			$xml->add_cdata($delivery, $delivery_date);

			$url_img = (!empty($list[$i]->file)) ? URL_HOME2 . $imageController->get_thumb($list[$i]->file,180,160) : "";
			$img  = $xml->add_node($item, 'IMGURL');
			$xml->add_cdata($img, str_replace("cz//","cz/",$url_img));
			/*
			   $price  = $xml->add_node($item, 'PRICE');
			   $xml->add_cdata($price, $list[$i]->prodcena);
			*/
			$price_vat  = $xml->add_node($item, 'PRICE_VAT');
			$xml->add_cdata($price_vat, $list[$i]->prodcena);

			if ($list[$i]->ppc_zbozicz > 0) {
				$price_vat  = $xml->add_node($item, 'MAX_CPC');
				$xml->add_cdata($price_vat, $list[$i]->ppc_zbozicz);
			}


		}
		return $xml->create_xml();
	}


	public function productListHeurekaFeedLite($params = array())
	{
		$list = $this->productList($params);
		$imageController = new ImageController();
		//$xml = new c_xml_generator;

		$res='<?xml version="1.0" encoding="utf-8"?';
    $res.='>
';
		$res.='<SHOP>
';
		//$root = $xml->add_node(0, 'SHOP');

		for ($i=0;$i<count($list);$i++)
		{
			//$item  = $xml->add_node($root, 'SHOPITEM');
			$res.='<SHOPITEM>
';

			//$product  = $xml->add_node($item, 'PRODUCT');
			$res.='<ITEM_ID>' . $list[$i]->page_id . '</ITEM_ID>
';
			$nazev_mat = trim(strip_tags($list[$i]->title));

			// NÁZEV PRODUKT VČETNĚ PŘÍVLASTKU
			$nazev_mat = "<![CDATA[" . $nazev_mat . "]]>";
			$res.='<PRODUCT>' . $nazev_mat . '</PRODUCT>
';

			// pŘESNÝ NÁZEV PRODUKTU
			$res.='<PRODUCTNAME>' . $nazev_mat . '</PRODUCTNAME>
';
			//$xml->add_cdata($product, $nazev_mat);

			//$description  = $xml->add_node($item, 'DESCRIPTION');
			$popis = truncateUtf8(trim(strip_tags($list[$i]->description)),250,true,true);
			$popis = "<![CDATA[" . $popis . "]]>";
			//$xml->add_cdata($description, $popis);

			$res.='<DESCRIPTION>' . $popis . '</DESCRIPTION>
';

			//$product_url = URL_DOMAIN . '/product/?id=' . $list[$i]->klic_ma;

			$product_url = $list[$i]->link;
			//	$url  = $xml->add_node($item, 'URL');
			//	$xml->add_cdata($url, $product_url);

			$res.='<URL>' . $product_url . '</URL>
';

			// tento příznak uvádět pouze u bazarových položek
			if ($list[$i]->bazar==1) {
			$res.='<ITEM_TYPE>bazar</ITEM_TYPE>
';
			}
			$delivery_date=0;

			if ($list[$i]->dostupnost=='Běžně skladem') {
				$delivery_date=0;
			}

			if ($list[$i]->dostupnost=='Neznámá-nutno ověřit u výrobce') {
				$delivery_date=8;
			}

			//$delivery  = $xml->add_node($item, 'DELIVERY_DATE');

			//$xml->add_cdata($delivery, $delivery_date);

			$res.='<DELIVERY_DATE>' . $delivery_date . '</DELIVERY_DATE>
';
			$url_img = (!empty($list[$i]->file)) ? URL_HOME . $imageController->get_thumb($list[$i]->file,180,160) : "";
			//$url_img = "";
			//$img  = $xml->add_node($item, 'IMGURL');
			//$xml->add_cdata($img, str_replace("cz//","cz/",$url_img));

			$url_img = "<![CDATA[" . $url_img . "]]>";

			$res.='<IMGURL>' . str_replace("cz//","cz/",$url_img) . '</IMGURL>
';
			/*
			   $price  = $xml->add_node($item, 'PRICE');
			   $xml->add_cdata($price, $list[$i]->prodcena);
			*/
			//$price_vat  = $xml->add_node($item, 'PRICE_VAT');
			//$xml->add_cdata($price_vat, $list[$i]->prodcena);

			$res.='<PRICE_VAT>' . $list[$i]->cena_sdph . '</PRICE_VAT>
';

			if ($list[$i]->ppc_zbozicz > 0) {
				//$price_vat  = $xml->add_node($item, 'MAX_CPC');
				//$xml->add_cdata($price_vat, $list[$i]->ppc_zbozicz);
				$res.='<MAX_CPC>' . $list[$i]->ppc_zbozicz . '</MAX_CPC>
';
			}

			$res.='</SHOPITEM>
';
		}
		$res.='</SHOP>';
		return $res;
		//return $xml->create_xml();
	}
	public function productListEdit($params = array())
	{
		$eshopController = new EshopController();
		$l = $this->productList($params);
		//print_r($l);
		$imageController = new ImageController();

		if (self::$getRequest->isPost())
		{
			//$eshop = new Eshop();

			$productCategoryModel = new models_ProductCategory();
			$productCategoryList = $productCategoryModel->getList(array("limit"=>1000,"debug"=>0));

			//$productCategoryList = $eshop->product_category_list(array("limit"=>1000,"debug"=>0));
			$typSortimentuList = array("P"=>"Produkt", "V"=>"Výrobek", "S"=>"Služba");
			$productUmisteniList =array();
			//print "test1000";
			/*		*/
			$tree = new G_Tree();
			//	print "test123";
			$productUmisteniList = $tree->categoryTree(array(
				"parent"=>0,
				"debug"=>0,
			));
		}
		//print_r($productUmisteniList);

		for ($i=0;$i < count($l);$i++)
		{
			$url = URL_HOME . "admin/edit_product.php?id=" . $l[$i]->page_id;

			if (!empty($l[$i]->file)) {

				$PreviewUrl = '<img alt="" title="" src="' . $imageController->get_thumb($l[$i]->file) . '" class="imgobal">';
			} else {
				$PreviewUrl = '';
			}
			$l[$i]->preview = $PreviewUrl;

			if ( (isset($_POST["slct"][$i]) && is_numeric($_POST["slct"][$i])) )
			{

				$klic_ma = $l[$i]->page_id;
				$elemKlicMa = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$klicMaValue = $l[$i]->page_id;
				$elemKlicMa->setAttribs('value', $klicMaValue);
				$elemKlicMa->setAttribs('checked', 'checked');
				$l[$i]->checkbox = $elemKlicMa->render();

				$cislo_mat = $l[$i]->cislo;
				$l[$i]->cislo_mat = '<a href="' . $url . '">' . $l[$i]->cislo . '</a>';

				if (!empty($l[$i]->code01)) {
					$l[$i]->cislo_mat .='<br />' . $l[$i]->code01;
				}

				$elemNazevMat = new G_Form_Element_Text("nazev_mat_cs[" . $i . "]");
				$nazevMatValue = self::$getRequest->getPost("nazev_mat_cs[" . $i . "]", $l[$i]->title);
				$elemNazevMat->setAttribs('value',$nazevMatValue);

				$elemDescription = new G_Form_Element_Textarea("popis[" . $i . "]");
				$elemDescription->setAttribs(array("id"=>"popis"));
				$popis = self::$getRequest->getPost("popis[" . $i . "]", $l[$i]->popis);
				$elemDescription->setAttribs('value',$popis);
				$elemDescription->setAttribs('class','mceEditorX');
				//$elemDescription->setAttribs('label','Popis produktu:');


				$l[$i]->nazev_mat_cs = $elemNazevMat->render() . $elemDescription->render();

				$elemProdCena = new G_Form_Element_Text("prodcena[" . $i . "]");
				$elemProdCena->setAttribs(array("is_money"=>true));
				$prodCenaValue = self::$getRequest->getPost("prodcena[" . $i . "]", $l[$i]->prodcena);
				$elemProdCena->setAttribs('value',$prodCenaValue);
				$elemProdCena->setAttribs('style','text-align:right;width:100px;');
				$l[$i]->prodcena = $elemProdCena->render();

				$elemQty = new G_Form_Element_Text("qty[" . $i . "]");
				$elemQty->setAttribs(array("is_numeric"=>true));
				$qtyValue = self::$getRequest->getPost("qty[" . $i . "]", $l[$i]->qty);
				$elemQty->setAttribs('value',$qtyValue);
				//	$elemQty->setAttribs('label','Nabízené množství:');
				$elemQty->setAttribs('style','width:50px;text-align:right;');
				$l[$i]->qty = $elemQty->render();
				//$l[$i]->prodcena = '<input class="textbox" type="textbox" value="' . $l[$i]->prodcena . '" name="prodcena[' . $i . ']">';

				/**
				 * Skupinové rozdělení
				 * */
				$elemCategory = new G_Form_Element_Select("skupina[" . $i . "]");
				$skupinaValue = self::$getRequest->getPost("skupina[" . $i . "]", $l[$i]->skupina_id);
				$elemCategory->setAttribs('value',$skupinaValue);
				$elemCategory->setAttribs('style','width:100px;');

				$pole = array();
				$pole[0] = " -- žádná skupina -- ";
				foreach ($productCategoryList as $key => $value)
				{
					$pole[$value->uid] = $value->nazev_cs;
				}
				$elemCategory->setMultiOptions($pole);
				$l[$i]->skupina_nazev = $elemCategory->render();

				/**
				 * Umístění v TREE
				 * */
				$elemUmisteni = new G_Form_Element_Select("category[" . $i . "]");
				$value = self::$getRequest->getPost("category[" . $i . "]", $l[$i]->category_id);
				$elemUmisteni->setAttribs('value',$value);
				$elemUmisteni->setAttribs('style','width:100px;');

				$pole = array();
				$attrib =array();
				$pole[0] = " -- bez umístění -- ";
				foreach ($productUmisteniList as $key => $value)
				{
					//$pole[$value->uid] = $value->nazev_cs;

					$pole[$value->id] = $value->title;

					//if () {
					$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;

					//print_r($value->nazev);

				}
				$elemUmisteni->setMultiOptions($pole,$attrib);
				$l[$i]->category_nazev = $elemUmisteni->render() . $elemCategory->render();



				$l[$i]->cmd = '';

			} else {

				$klic_ma = $l[$i]->page_id;
				$cislo_mat = $l[$i]->cislo;

				$elemKlicMa = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$klicMaValue = $l[$i]->id;
				$elemKlicMa->setAttribs('value', $klicMaValue);
				$l[$i]->checkbox = $elemKlicMa->render();
				$l[$i]->qty = number_format($l[$i]->qty, 2, ',', '') . " " . $l[$i]->nazev_mj;
				//$qty = $l[$i]->qty;

				$aktivni_klik = '<a class="storno" id="aktivni_' . $klic_ma . '" href="javascript:aktualizujStavSortimentu(' . $klic_ma . ');">neaktivní</a>';
				if ($l[$i]->aktivni == 1) {
					$aktivni_klik = '<a class="vyrizena" id="aktivni_' . $klic_ma . '" href="javascript:aktualizujStavSortimentu(' . $klic_ma . ');">aktivní</a>';
				}

				$l[$i]->cislo_mat = '<a href="' . $url . '">' . $l[$i]->cislo . '</a>';
				if (!empty($l[$i]->code01)) {
					$l[$i]->cislo_mat .='<br />' . $l[$i]->code01;
				}
				$l[$i]->cislo_mat .='<br />' . $aktivni_klik;


				$nazevMat = '<h4>' . $l[$i]->title . '</h4>';
				$nazevMat .= '<span class="desc">' . trim(truncateUtf8(trim(strip_tags($l[$i]->description)),150,false,true)) . '</span>';



				$l[$i]->nazev_mat_cs = $nazevMat;

				$prodcena = number_format($l[$i]->cena_sdph, 2, ',', ' ');
			//	print $eshopController->setting["PLATCE_DPH"];
				if ($eshopController->setting["PLATCE_DPH"] == "1"){
					$prodcena = number_format($l[$i]->cena_bezdph, 2, ',', ' ');
				}
				$l[$i]->prodcena = '<strong>' . $prodcena . '</strong>';

				if ($eshopController->setting["PLATCE_DPH"] == "1"){
					$l[$i]->prodcena .= '<br /><span class="small">DPH: ' . $l[$i]->nazev_dph . '</span>';
				}
				if ($l[$i]->sleva <> 0) {
					$l[$i]->prodcena .= '<br /><span class="small">SLEVA: ' . $l[$i]->sleva_label . '</span>';
				}
				$l[$i]->category_nazev = $l[$i]->nazev_category . "<br />" . $l[$i]->nazev_skupina;

				$command = '<input class="" style="border:0 none;background-color:transparent;" onclick="return confirm(\'Opravdu SMAZAT sortiment č. '.$cislo_mat.'?\')" type="image" src="'.URL_HOME . 'admin/images/cancel.png" value="X" name="del_product[' . $i . ']"/>';

				$command .= '<input class="" style="border:0 none;background-color:transparent;" onclick="return confirm(\'Zkopírovat sortiment č. '.$cislo_mat.'?\')" type="image" src="'.URL_HOME . 'admin/copy_icon.png" value="X" name="copy_product[' . $i . ']"/>';
				$command .= '<input type="hidden" value="' . $l[$i]->page_id . '" name="product_id[' . $i . ']"/>';
				$command .= '<br /><a style="font-size:90%;" target="_blank" href="'.$l[$i]->link.'">[link]</a>';

				$l[$i]->cmd = $command;
				//$l[$i]->cmd = 'nic';
			}
			$datum_vlozeni = date("j.n.Y H:i", strtotime($l[$i]->caszapsani));
			$l[$i]->vlozeno_zmeneno = $datum_vlozeni;
		}
		return $l;
	}
	public function productList(IListArgs $params = null)
	{


		if (is_null($params)) {
			$params = new ListArgs();
		}



		if (empty($params->lang)) {
			$params->lang = LANG_TRANSLATOR;
		}



		if (isset($params->disableQuery)) {
			self::$getRequest->disableQuery();
		}


		$search_string = self::$getRequest->getQuery('q', '');
		$search_string = trim($search_string);
		$params->fulltext = $search_string;
		$params->withAttribs = true;
		$params->vypocetCeny = true;
		if (isset($params->search))
		{
			$params->fulltext  = $params->search;
		}
    
		$l = self::getList($params);


		$this->total = self::getTotalList();
		$this->limit = self::getLimitQuery();
		return $l;
	}
  public function akcePredUlozenim()
  {
    $data = self::getPageSaveData();
    $zmenaStavu = $data->stav_qty -  $data->stav_qtyOriginal;
     //   print $data->stav_qtyOriginal;
    //exit;
    
          if ($zmenaStavu <> 0)
      {
          // nahodím pohyb Plus/ nebo mínus
          
    
          $savedataPohyb = array();
    			$savedataPohyb["doklad_id"] = null;
    			$savedataPohyb["radek_id"] = null;
    			$savedataPohyb["product_id"] = $data->id;
    		//	$savedataPohyb["varianty_id"] = $page_id;

    			$savedataPohyb["description"] = "ruční změna";
    			$savedataPohyb["mnozstvi"] = $zmenaStavu;
    			$savedataPohyb["datum"] = date("Y-m-d H:i:s");
          
          if (defined("USER_ID")){
              $savedataPohyb["user_id"] = USER_ID;
          }
    			$model = new G_Service(null);
          $model->insertRecords(T_PRODUCT_POHYB,$savedataPohyb);
    
      
      }  /*  */
  }
  
  
	public function akcePoUlozeni()
	{
		//print "akce po uložení";

		$data = self::getPageSaveData();
    $zmenaStavu = $data->stav_qty -  $data->stav_qtyOriginal;
    //print $data->stav_qtyOriginal;
   // exit;
		$page_id = (int) $data->getId();


		$formAtributy = new F_ProductEdit();

		self::$model->deleteRecords(T_PRODUCT_GROUP_ASSOC, "product_id=".$page_id);

		//self::$model->deleteRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUE_ASSOC,"product_id={$page_id}");
		self::$model->commit ? null : $all_query_ok = false;


		$categoryId = $formAtributy->getPost("group_id");


		$gengreNameA = array();
		$gengreIdA = array();





		if (isset($categoryId) && is_array($categoryId)) {


			//	print_r($_POST["category_id"]);
			foreach ($categoryId as $key => $value ){
				$data2 = array();
				$data2["product_id"] = $page_id;
				$data2["group_id"] = $value;
        array_push($gengreIdA, $value);

				//print_r($data2);
				self::$model->insertRecords(T_PRODUCT_GROUP_ASSOC, $data2);

				self::$model->commit ? null : $all_query_ok = false;


				foreach ($formAtributy->skupinaList as $key2 => $val)
				{
					if ($val->id == $value) {
						array_push($gengreNameA, $val->name);
						
						break;
					}
				}



			}
		}
    $postdata = array();
    $postdata["group_label"] = implode("|" ,$gengreNameA);
    $postdata["group_id"] = implode("|" ,$gengreIdA);
     /*
    print_R($gengreNameA);

		
    
     print_R($postdata);
               print $page_id;
         exit;  */
         
//            print_R($postdata);
		self::$model->updateRecords(T_SHOP_PRODUCT,$postdata,"id={$page_id}");
    

		self::$model->commit ? null : $all_query_ok = false;





	//	print "page_id:" . $page_id . ".";
		$all_query_ok = true;
		self::$model->deleteRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUE_ASSOC,"product_id={$page_id}");
		self::$model->commit ? null : $all_query_ok = false;


		$atributy = $formAtributy->getPost("attr");

		$atributyOrder = $formAtributy->getPost("attrOrder");

//		print_r($atributy);
  //  exit;
	//	print_r($atributyOrder);
	//exit;
		if (isset($atributy) && is_array($atributy)) {
			foreach ($atributy as $key => $value ){
      
        if (is_array($value) && count($value)>0)
        {
          foreach ($value as $key2 => $value2 ){
    				$data2 = array();
    				$data2["product_id"] = $page_id;
    				$data2["attribute_id"] = $value2;
    				$data2["order"] = $atributyOrder[$key];
    				//print_r($data2);
    				 self::$model->insertRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUE_ASSOC, $data2);
    
    				 self::$model->commit ? null : $all_query_ok = false;          
          
          }
        
        } else {
  				$data2 = array();
  				$data2["product_id"] = $page_id;
  				$data2["attribute_id"] = $value;
  				$data2["order"] = $atributyOrder[$key];
  				//print_r($data2);
  				 self::$model->insertRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUE_ASSOC, $data2);
  
  				 self::$model->commit ? null : $all_query_ok = false;
          
        }

			}
		}




		// update min/max ceny ceny
		$sql = "update `mm_products` p left join mm_products_version v  on p.id=v.page_id and p.version=v.version
				set p.max_prodcena = v.prodcena,
				p.max_prodcena_sdph = v.prodcena_sdph,
				p.min_prodcena = v.prodcena,
				p.min_prodcena_sdph = v.prodcena_sdph
				where p.id=" . $page_id;

		self::$model->query($sql);
		self::$model->commit ? null : $all_query_ok = false;


		$sql = "update `mm_products` left join (
				SELECT product_id,max(price) as max_price,max(price_sdani) as max_price_sdani,
				min(price) as min_price, min(price_sdani) as min_price_sdani FROM `mm_product_varianty` where product_id=" . $page_id . " and isDeleted=0  and price is not null
				group by product_id) v on `mm_products`.id = v.product_id
				set max_prodcena = v.max_price,
				max_prodcena_sdph = v.max_price_sdani,
				min_prodcena = v.min_price,
				min_prodcena_sdph = v.min_price_sdani
				where `mm_products`.id in (
				SELECT product_id FROM `mm_product_varianty` where product_id =" . $page_id . " and price is not null  and isDeleted=0
				group by product_id)";
	//	print $sql;
	//	exit;
  
		self::$model->query($sql);
		self::$model->commit ? null : $all_query_ok = false;

      //  print self::$model->getLastQuery();
//    exit;
		return $all_query_ok;
	}

	public function saveAction()
	{
		// Je odeslán formulář
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('upd_product', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('ProductEdit');
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{


			//	print_r($_POST);
			//	exit;
				$postdata = $form->getValues();
				$PageEntity = self::setPageData($postdata, $form->page);

			//	print_r($form->page->versionList);
				//$pageSaveData["id"] = $form->page->page_id;
				//$pageVersionSaveData = self::setPageVersionData($postdata, $form->page->page_id, $pageSaveData->version);
				$pageVersionEntities = self::setPageVersionData($postdata, $form->page->versionList, $PageEntity->version);

//print_R($form->page->versionList);
	//			print_R($pageVersionEntities);
		//		exit;
				if (self::saveData($PageEntity, $pageVersionEntities, $form)) {

					$form->setResultSuccess("Produkt byl aktualizován.");
					self::$getRequest->goBackRef();
				}


			}
		}
	}

	public function saveAjaxAction()
	{
		// Je odeslán formulář
		if(self::$getRequest->isPost() && "ProductEdit" == self::$getRequest->getPost('action', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('ProductEdit');
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{


				//	print_r($_POST);
				//	exit;
				$postdata = $form->getValues();

				$postdata["description_cs"]=  ($postdata["description_cs"]);
				//	print_r($postdata);
				//	exit;
				$PageEntity = self::setPageData($postdata, $form->page);


				$pageVersionEntities = self::setPageVersionData($postdata, $form->page->versionList, $PageEntity->version);

				if (self::saveData($PageEntity, $pageVersionEntities, $form)) {

					$form->setResultSuccess("Produkt byl aktualizován.");
					return true;
				}


			}

		}
	}

	public function setPageData($postdata, $originalData = null)
	{
		$eshopSettings = G_EshopSetting::instance();
		if ($eshopSettings->get("PLATCE_DPH") == 0) {
			// pokud nejsem platce mazu DPH !
			$postdata["dph_id"] = null;
		}

		$data = parent::setPageData($postdata, $originalData);


	//	$eshopController = new EshopController();
	//	if ($eshopController->setting["PRODUCT_NEXTID_AUTO"] == "0") {
			$name = 'cislo';
			if (array_key_exists($name, $postdata) && !empty($postdata[$name])) {
				$data->$name = $postdata[$name];
			}
      
      $name = 'objem';
			if (array_key_exists($name, $postdata) && !empty($postdata[$name])) {
				$data->$name = strToNumeric($postdata[$name]);
			}
      $name = 'rozmer';
			if (array_key_exists($name, $postdata) && !empty($postdata[$name])) {
				$data->$name = $postdata[$name];
			}
	//	}

		$name = 'hl_mj';
		if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
			$data->hl_mj_id = $postdata[$name];
			$data->mj_id = $postdata[$name];
		}

		$name = 'dph_id';
		if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {


			$data->$name = ($postdata[$name] == 0) ? NULL : $postdata[$name];
		}


		$name = 'cenik_id';
		if (array_key_exists($name, $postdata)) {
			$data->$name = ($postdata[$name] == 0) ? NULL : $postdata[$name];
		}
		$name = 'category';
		if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
			$data->category_id = $postdata[$name];
		}

		$name = 'skupina';
		if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
		//	$data["skupina_id"] = $postdata[$name];
			$data->skupina_id  = ($postdata[$name] == 0) ? NULL : $postdata[$name];
		}
		$name = 'skupina_id';
		if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
			//	$data["skupina_id"] = $postdata[$name];
			$data->$name = ($postdata[$name] == 0) ? NULL : $postdata[$name];
		}

		$name = 'vyrobce';
		if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
			$data->vyrobce_id = $postdata[$name];
		}

		$name = 'vyrobce_id';
		if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
			$data->$name = $postdata[$name];
		}

		$name = 'dostupnost_id';
		if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
			//	$data["skupina_id"] = $postdata[$name];
			$data->$name = ($postdata[$name] == 0) ? NULL : $postdata[$name];
		}


		$name = 'zaruka_id';
		if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
			//	$data["skupina_id"] = $postdata[$name];
			$data->$name = ($postdata[$name] == 0) ? NULL : $postdata[$name];
		}

		$name = 'qty';
		if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
			$data->$name = $postdata[$name];
		}
		$name = 'code01';
		if (array_key_exists($name, $postdata)) {
			$data->$name = $postdata[$name];
		}
		$name = 'code02';
		if (array_key_exists($name, $postdata)) {
			$data->$name = $postdata[$name];
		}
		$name = 'code03';
		if (array_key_exists($name, $postdata)) {
			$data->$name = $postdata[$name];
		}

		$name = 'aktivni';
		if (array_key_exists($name, $postdata)) {
			$data->$name = $postdata[$name];
		}

		$name = 'bazar';
		if (array_key_exists($name, $postdata)) {
			$data->$name = $postdata[$name];
		}

		$name = 'neexportovat';
		if (array_key_exists($name, $postdata)) {
			$data->$name = $postdata[$name];
		}


		$name = 'nakupni_cena';
		if (array_key_exists($name, $postdata)) {
			$data->$name = $postdata[$name];
		}

		//print_r($data);
		return $data;
	}

	public function setPageVersionData($postdata, $versionList, $version, $languageList = Array())
	{


	//	print_r($postdata);
	//		exit;
		$languageModel = new models_Language();
		$languageList = $languageModel->getActiveLanguage();

		$eshopSettings = G_EshopSetting::instance();
		if ($eshopSettings->get("PLATCE_DPH") == 0) {
			// pokud nejsem platce mazu DPH !
			$postdata["dph_id"] = null;
		}
		$dph_id = $postdata["dph_id"];

		$sazba = 0;
		if ($dph_id > 0) {
			$dph_model = new models_Dph();
			$dphDetail = $dph_model->getDetailById($dph_id);
			$sazba = $dphDetail->value;
		}


		$versionData = parent::setPageVersionData($postdata, $versionList, $version);

	//	print_r($versionData);
	//	$versionData = parent::setPageVersionData($postdata, $page_id, $version, $languageList);


		// zapamatuju si parametry pro hlavní jazyk, v případě, že nebude parametr uveden pro další jazyk, doplním z hlavního

		$parametryPolozky = array();
		for ($i2=1;$i2<=10;$i2++) {

			$name = 'polozka'.$i2;

			if (isset($postdata[$name ."_" . $languageList[0]->code])) {
				$parametryPolozky[$name] = $postdata[$name ."_" . $languageList[0]->code];
			}

			$name = 'cislo'.$i2;
			if (isset($postdata[$name ."_" . $languageList[0]->code])) {
				$parametryPolozky[$name] = $postdata[$name ."_" . $languageList[0]->code];
			}
		}


		$i = 0;
		foreach ($languageList as $key => $val){

		//	$versionData[$i]->prodcena = strToNumeric($postdata["prodcena"]);
		//	$versionData[$i]->prodcena_sdph = strToNumeric($postdata["prodcena_sdph"]);

			$sazbaRadek = $sazba;
			if ($eshopSettings->get("PLATCE_DPH") == 0)
			{
				$versionData[$i]->prodcena = $versionData[$i]->prodcena_sdph;
			} else {
				if ($eshopSettings->get("PRICE_TAX") == 0) {
					// s daní se dopočítává
					if ($sazbaRadek > 0) {
						$sazbaRadek = $sazbaRadek / 100;
					}

					$sazbaRadek = 1 + $sazbaRadek;
					$versionData[$i]->prodcena_sdph = $sazbaRadek * $versionData[$i]->prodcena;
				} else {
					// bez dph se dopočítává
					//1 - 21/(100+21) = 0.8264
					//if ($sazba > 0) {
					$sazbaRadek = 1 - $sazbaRadek / (100 + $sazbaRadek);
					//	}
					$versionData[$i]->prodcena = $sazbaRadek * $versionData[$i]->prodcena_sdph;
				}


			}


			//$versionData[$i]["prodcena_sdph"] = strToNumeric($postdata["prodcena_sdph"]);

			//$versionData[$i]->bezna_cena = strToNumeric($postdata["bezna_cena"]);
		//	$versionData[$i]["sleva"] = strToNumeric($postdata["sleva"]);

			$name = 'hl_mj';
			if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
				$versionData[$i]->hl_mj_id = $postdata[$name];
				$versionData[$i]->mj_id = $postdata[$name];
			}
/*			$name = 'hl_mj_id';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'mj_id';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i]->$name = $postdata[$name];
			}
*/
			$name = 'netto';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i]->$name  = $postdata[$name];
			}

			$name = 'category';
			if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
				$versionData[$i]["category_id"] = $postdata[$name];
			}
			$name = 'category_id';
			if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
				$versionData[$i]->$name  = $postdata[$name];
			}

			$name = 'skupina';
			if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
				//$versionData[$i]["skupina_id"] = $postdata[$name];
				$versionData[$i]->skupina_id  = ($postdata[$name] == 0) ? NULL : $postdata[$name];
			}

			$name = 'skupina_id';
			if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
				//	$data["skupina_id"] = $postdata[$name];
				$versionData[$i]->$name  = ($postdata[$name] == 0) ? NULL : $postdata[$name];
			}

			$name = 'vyrobce';
			if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
			//	$versionData[$i]["vyrobce_id"] = $postdata[$name];
				$versionData[$i]->vyrobce_id	 = ($postdata[$name] == 0) ? NULL : $postdata[$name];
			}
			$name = 'vyrobce_id';
			if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
			//	$versionData[$i]["vyrobce_id"] = $postdata[$name];
				$versionData[$i]->$name  = ($postdata[$name] == 0) ? NULL : $postdata[$name];
			}

			$name = 'sleva';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i]->$name  = strToNumeric($postdata[$name]);
			}
			$name = 'druh_slevy';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i]->$name  = $postdata[$name];
			}


			$name = 'netto';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i]->$name = strToNumeric($postdata[$name]);
			}

			for ($i2=1;$i2<=10;$i2++) {

				$name = 'polozka'.$i2;
				if (array_key_exists($name, $postdata)) {
					$versionData[$i]->$name = $postdata[$name];
				}

				if (isset($postdata[$name ."_" . $val->code])) {

					if (empty($postdata[$name ."_" . $val->code]) && !empty($parametryPolozky[$name])) {
						$versionData[$i]->$name  =$parametryPolozky[$name];
					} else {
						$versionData[$i]->$name = $postdata[$name ."_" . $val->code];
					}


				}

				$name = 'cislo'.$i2;
				if (array_key_exists($name, $postdata)) {
					$versionData[$i]->$name = strToNumeric($postdata[$name]);
				}
				if (isset($postdata[$name ."_" . $val->code])) {



				//	$versionData[$i][$name] = strToNumeric($postdata[$name ."_" . $val->code]);



					if (strToNumeric($postdata[$name ."_" . $val->code]) == 0 && strToNumeric($parametryPolozky[$name]) != 0) {
						$versionData[$i]->$name = strToNumeric($parametryPolozky[$name]);
					} else {
						$versionData[$i]->$name = strToNumeric($postdata[$name ."_" . $val->code]);
					}
				}
			}


			$i++;
		}
	//	print_r($versionData);
	//	exit;
		return $versionData;
	}

	public function deleteAction()
	{

		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false)
			&& "deleteProducts" == self::$getRequest->getPost('action', false))
		{

			$selectedItems = self::$getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						$model = new models_Products();
						$obj = $model->getDetailById($doklad_id);

						if ($obj) {
							$data = array();
							$data["isDeleted"] = 1;
							if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id))
							{
								array_push($seznamCiselObjednavek,$obj->cislo );
							}
						}
					}
				}
				if (count($seznamCiselObjednavek)>0) {
					array_reverse($seznamCiselObjednavek);
					$_SESSION["statusmessage"]="Produkt " . implode(",", $seznamCiselObjednavek) . " byl smazán.";
					$_SESSION["classmessage"]="success";
					self::$getRequest->goBackRef();
				}
			}

		}
	}

	public function deleteAjaxAction()
	{

		if(self::$getRequest->isPost()
			&& "ProductDelete" == self::$getRequest->getPost('action', false))
		{
			$doklad_id = (int) self::$getRequest->getQuery('id', 0);

			if ($doklad_id) {
				$model = new models_Products();
				$obj = $model->getDetailById($doklad_id);

				if ($obj) {
					$data = array();
					$data["isDeleted"] = 1;
					if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id))
					{
						array_push($seznamCiselObjednavek,$obj->id );
						return true;
					}
				}

			}
		}
	}


	public function addProductFotoAction($foto_id, $product_id)
	{
		//$foto_id = 7;
		//$product_id = 4;
		//	print "tudy";
		$_product = new models_Products();

		$data = array(
				"uid_source"=>$foto_id,
				"uid_target"=>$product_id,
				"table"=>$_product->getTableName(),
				);
		//
		$where = array();
		$where[] = "uid_source =" . $foto_id;
		$where[] = "uid_target =" . $product_id;
		$where[] = "`table` ='" . $_product->getTableName() . "'";

		$_fotoPlaces = new models_FotoPlaces();
		$_fotoPlaces->setWhere($where);
		$query = "select * from " . $_fotoPlaces->getTableName() . $_fotoPlaces->getWhere();
		//print $query;
		$row = $_fotoPlaces->getRow($query);

		//where `uid_source`=" . $foto_id . " AND `uid_target`= " . $product_id . " AND `table`='" . T_SHOP_PRODUCT . "' LIMIT 1");




		if (!$row) {
			/*
			   $_fotoPlaces->setData($data);

			   if($_fotoPlaces->insert())
			   {
			   //$_SESSION["statusmessage"]="Foto bylo úspěšně přidáno k produktu.";
			   //$_SESSION["classmessage"]="success";
			   //self::$getRequest->clearPost();
			   return true;
			   }
			*/
			if($_fotoPlaces->insertRecords(T_FOTO_PLACES, $data))
			{
				return true;
				//$this->clear_post();
				//self::$getRequest->clearPost();
			}
		} else {
			$this->removeProductFotoAction($foto_id, $product_id);
			return false;
		}
	}

	public function removeProductFotoAction($foto_id, $product_id)
	{
		//$foto_id = 7;
		//$product_id = 4;
		$_product = new models_Products();
		$data = array(
				"uid_source"=>$foto_id,
				"uid_target"=>$product_id,
				"table"=>$_product->getTableName(),
				);

		$_fotoPlaces = new models_FotoPlaces();

		$where = array();
		$where[] = "uid_source =" . $foto_id;
		$where[] = "uid_target =" . $product_id;
		$where[] = "`table` ='" . $_product->getTableName() . "'";

		$_fotoPlaces->setWhere($where);
		$row = $_fotoPlaces->getRow("select * from " . $_fotoPlaces->getTableName() . $_fotoPlaces->getWhere());

		//where `uid_source`=" . $foto_id . " AND `uid_target`= " . $product_id . " AND `table`='" . T_SHOP_PRODUCT . "' LIMIT 1");
		if ($row) {
			$_fotoPlaces->setData($data);

			if($_fotoPlaces->delete())
			{
				//$_SESSION["statusmessage"]="Foto bylo úspěšně přidáno k produktu.";
				//$_SESSION["classmessage"]="success";

				//self::$getRequest->clearPost();
			}
		}
	}

	// Nastavení version dat k uložení
	private function setVersionData($postdata, $page_id, $version)
	{

		if (is_object($postdata)) {
			$postdata = object_to_array($postdata);
		}

	//	print_r($postdata);
	//	exit;
		$versionData = array();
		// Verzování dle jazyků

		$languageModel = new models_Language();
		$languageList = $languageModel->getActiveLanguage();

		$i = 0;
		foreach ($languageList as $key => $val){

			$versionData[$i]["lang_id"] = $val->id;
			$versionData[$i]["page_id"] = $page_id;
			$versionData[$i]["user_id"] = USER_ID;
			$versionData[$i]["version"] = $version;

			$versionData[$i]["prodcena"] = strToNumeric($postdata["prodcena"]);
			$versionData[$i]["bezna_cena"] = strToNumeric($postdata["bezna_cena"]);

			//	$versionData["hl_mj_id"] = $postdata["hl_mj"];
			//	$versionData["mj_id"] = $postdata["hl_mj"];

		/*	$name = 'cislo1';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'cislo2';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'cislo3';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'cislo4';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'cislo5';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}

			*/
			for ($i2=1;$i2<=10;$i2++) {

				$name = 'polozka'.$i2;
				if (array_key_exists($name, $postdata)) {
					$versionData[$i][$name] = $postdata[$name];
				}

				if (isset($postdata[$name ."_" . $val->code])) {
					$versionData[$i][$name] = $postdata[$name ."_" . $val->code];
				}

				$name = 'cislo'.$i2;
				if (array_key_exists($name, $postdata)) {
					$versionData[$i][$name] = $postdata[$name];
				}
				if (isset($postdata[$name ."_" . $val->code])) {
					$versionData[$i][$name] = $postdata[$name ."_" . $val->code];
				}


			}
		/*	$name = 'polozka1';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'polozka2';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'polozka3';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'polozka4';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'polozka5';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			*/




			$name = 'hl_mj';
			if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
				$versionData[$i]["hl_mj_id"] = $postdata[$name];
				$versionData[$i]["mj_id"] = $postdata[$name];
			}
			$name = 'hl_mj_id';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'mj_id';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}

			$name = 'dostupnost';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}

			$name = 'category';
			if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
				$versionData[$i]["category_id"] = $postdata[$name];
			}
			$name = 'category_id';
			if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
				$versionData[$i]["category_id"] = $postdata[$name];
			}

			$name = 'skupina';
			if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
				$versionData[$i]["skupina_id"] = $postdata[$name];
			}
			$name = 'skupina_id';
			if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
				$versionData[$i]["skupina_id"] = $postdata[$name];
			}

			$name = 'vyrobce';
			if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
				$versionData[$i]["vyrobce_id"] = $postdata[$name];
			}
			$name = 'vyrobce_id';
			if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
				$versionData[$i]["vyrobce_id"] = $postdata[$name];
			}

			$name = 'sleva';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}
			$name = 'druh_slevy';
			if (array_key_exists($name, $postdata)) {
				$versionData[$i][$name] = $postdata[$name];
			}

			if (isset($postdata["title_$val->code"])) {
				$versionData[$i]["title"] = $postdata["title_$val->code"];
			}

			if (isset($postdata["perex_$val->code"])) {
				$versionData[$i]["perex"] = $postdata["perex_$val->code"];
			}

			if (isset($postdata["description_$val->code"])) {
				$versionData[$i]["description"] = $postdata["description_$val->code"];
			}
			if (isset($postdata["pagetitle_$val->code"])) {
				$versionData[$i]["pagetitle"] = $postdata["pagetitle_$val->code"];
			}
			if (isset($postdata["pagedescription_$val->code"])) {
				$versionData[$i]["pagedescription"] = $postdata["pagedescription_$val->code"];
			}

			if (isset($postdata["pagekeywords_$val->code"])) {
				$versionData[$i]["pagekeywords"] = $postdata["pagekeywords_$val->code"];
			}

			/*
			if (isset($postdata["polozka1_$val->code"])) {
				$versionData[$i]["polozka1"] = $postdata["polozka1_$val->code"];
			}
			if (isset($postdata["polozka2_$val->code"])) {
				$versionData[$i]["polozka2"] = $postdata["polozka2_$val->code"];
			}
			if (isset($postdata["polozka3_$val->code"])) {
				$versionData[$i]["polozka3"] = $postdata["polozka3_$val->code"];
			}
			if (isset($postdata["polozka4_$val->code"])) {
				$versionData[$i]["polozka4"] = $postdata["polozka4_$val->code"];
			}
			if (isset($postdata["polozka5_$val->code"])) {
				$versionData[$i]["polozka5"] = $postdata["polozka5_$val->code"];
			}

			if (isset($postdata["polozka6_$val->code"])) {
				$versionData[$i]["polozka6"] = $postdata["polozka6_$val->code"];
			}
			if (isset($postdata["polozka7_$val->code"])) {
				$versionData[$i]["polozka7"] = $postdata["polozka7_$val->code"];
			}
			if (isset($postdata["polozka8_$val->code"])) {
				$versionData[$i]["polozka8"] = $postdata["polozka8_$val->code"];
			}
			if (isset($postdata["polozka9_$val->code"])) {
				$versionData[$i]["polozka9"] = $postdata["polozka9_$val->code"];
			}
			if (isset($postdata["polozka10_$val->code"])) {
				$versionData[$i]["polozka10"] = $postdata["polozka10_$val->code"];
			}
			   */
			$i++;
		}
		return $versionData;
	}
  public function copyAjaxAction()
  {
		// Je odeslán formulář
		if(self::$getRequest->isPost() && "ProductCopy" == self::$getRequest->getPost('action', false))
		{

			$doklad_id = (int) self::$getRequest->getQuery('id', 0);
      
      
      
      $form = $this->formLoad('ProductCopyConfirm');
			if ($form->isValid(self::$getRequest->getPost()))
			{
				$formdata = $form->getValues();
        
        
			$model = new models_Products();
			$obj = $model->getDetailById($doklad_id);

			if ($obj) {
               //
        $params = array();
        $name = "copy_cenik";
        $params[$name] =  $formdata[$name];

        $name = "copy_foto";
        $params[$name] =  $formdata[$name];
        
        $name = "copy_params";
        $params[$name] =  $formdata[$name];
        
        $name = "copy_varianty";
        $params[$name] =  $formdata[$name];
        
        $name = "cislo";
        $params[$name] =  $formdata[$name];
                
				if ($this->copyProduct($doklad_id,$params)) {
					return true;
				}
				//	return true;

			}
			}
		}  
  }
	private function copyProduct($product_id, $params = array())
	{
		$model = new models_Products();
		$obj = $model->getDetailById($product_id);

	/*	print_r($obj);
		print_r($params);
		
    
    EXIT;     */
		//$eshop = new Eshop();
		//$model = new models_Attributes();





		$languageModel = new models_Language();
		$languageList = $languageModel->getActiveLanguage();

		// Prevyplnění volného čísla

    if (isset($params["cislo"]) && !empty($params["cislo"]))
    {
        $cislo_mat = $params["cislo"] ;
    } else {
    
		$nextIdModel = new models_NextId();
		$cislo_mat = $nextIdModel->vrat_nextid(array(
		"tabulka"=>T_SHOP_PRODUCT,
		"polozka"=>"cislo",
	));    
    }




		//$entity = new CategoryEntity();
		$versionEntity = new ProductVersionEntity();

		$version = 0;
		//$postdata = $form->getValues();
		$data = array();

		// Před uložením doplním volné číslo
		$data["cislo"] = $cislo_mat;

		//$formdata["caszapsani"] = date('Y-m-d H:i:s');
		$data["user_id"] = USER_ID;

		$data["version"] = $version;

		$data["dph_id"] = $obj->dph_id;
		//	sleva

		$data["hl_mj_id"] = $obj->hl_mj_id;
		$data["mj_id"] = $obj->mj_id;
		$data["category_id"] = $obj->category_id;
		$data["zaruka_id"] = $obj->zaruka_id;
		$data["vyrobce_id"] = $obj->vyrobce_id;

		$data["qty"] = $obj->vyrobce_id;
		$data["code01"] = $obj->code01;
		$data["code02"] = $obj->code02;
		$data["code03"] = $obj->code03;
    
		$data["dostupnost_id"] = $obj->dostupnost_id;
		$data["bazar"] = $obj->bazar;
		$data["neexportovat"] = $obj->neexportovat;
		$data["dodavatel_id"] = $obj->dodavatel_id;
		$data["zaruka_id"] = $obj->zaruka_id;
		$data["objem"] = $obj->objem;
		$data["rozmer"] = $obj->rozmer;
		$data["nakupni_cena"] = $obj->nakupni_cena;
    if (isset($params["copy_varianty"]) && $params["copy_varianty"] == 1)
    {
		  $data["isVarianty"] = $obj->isVarianty;
    }
	
	//	$data["netto"] = $obj->netto;
    
    
		$data["aktivni"] = 0; // radši neaktivní
		//	$data["aktivni"] = $obj->aktivni;
    if (isset($params["copy_foto"]) && $params["copy_foto"] == 1)
    {
		  $data["foto_id"] = $obj->foto_id;
    }
		$data["qty"] = $obj->qty;

		$all_query_ok=true;
		$model->start_transakce();

		$model->insertRecords($model->getTablename(), $data);
		$model->commit ? null : $all_query_ok = false;

		$page_id = $model->insert_id;

		$versionData = $this->setVersionData($obj, $page_id, $version);

		for ($i=0;$i<count($versionData);$i++)
		{
			$insertData = $versionData[$i];

			//print_r($insertData);
			$model->insertRecords($versionEntity->getTablename(),$insertData);
			$model->commit ? null : $all_query_ok = false;
			if ($model->commit == false) {
				//	print "chyba";
			}
		}
    
    
    $ProductGroupAssoc = new models_ProductGroupAssoc();
    $GroupAssocList = $ProductGroupAssoc->getAssociationList($product_id);
    
    
    if (count($GroupAssocList)>0) {
      $gengreIdA = array();
      $gengreNameA = array();
      foreach ($GroupAssocList as $key => $value ){
      
        if ($value->selected == 1)
        {
    				$data2 = array();
    				$data2["product_id"] = $page_id;
    				$data2["group_id"] = $value->id;
            
            array_push($gengreIdA, $value->id);
            array_push($gengreNameA, $value->name);
            
        		$model->insertRecords(T_PRODUCT_GROUP_ASSOC, $data2);
            $model->commit ? null : $all_query_ok = false;
        }
  
    
  		}
      
      if (count($gengreIdA)>0) {
        $postdata = array();
        $postdata["group_label"] = implode("|" ,$gengreNameA);
        $postdata["group_id"] = implode("|" ,$gengreIdA);
        
        	$model->updateRecords($model->getTablename(), $postdata,"id=" . $page_id);
		      $model->commit ? null : $all_query_ok = false;
       } 
    
    }  
    

    if (isset($params["copy_params"]) && $params["copy_params"] == 1)
    {
  		$attributes = new models_Attributes();
  		//	$this->attributes = $attributes->get_attributeValues2($page_id);
  		$attributesList = $attributes->get_attribute_value_association2($product_id,LANG_TRANSLATOR);
  
  		foreach ($attributesList as $key => $value){
  			$data = array();
  			$data["product_id"] = $page_id;
  			$data["attribute_id"] = $value->attribute_id;
  			$model->insertRecords(T_SHOP_PRODUCT_ATTRIBUTE_VALUE_ASSOC, $data);
  			$model->commit ? null : $all_query_ok = false;
  		}
    }
    
    
    if (isset($params["copy_varianty"]) && $params["copy_varianty"] == 1)
    {
    
    
    		$productVarianty = new models_ProductVarianty();

				$args = new ListArgs();
				$args->doklad_id = $product_id;
				$args->limit = 10000;
				$args->orderBy = 't1.product_id ASC, t1.order ASC, t1.code ASC, t1.name ASC';
				$variantyList = $productVarianty->getList($args);
        
         
  
  		foreach ($variantyList as $key => $value){
  			$data = array();
  			$data["product_id"] = $page_id;
  			$data["dostupnost_id"] = $value->dostupnost_id;
  			$data["name"] = $value->name;
  			$data["code"] = $value->code;
  			$data["order"] = $value->order;
  			$data["qty"] = $value->qty;
  			$data["price"] = $value->price;
  			$data["price_sdani"] = $value->price_sdani;
  			$data["dph_id"] = $value->dph_id;
  			$model->insertRecords(T_SHOP_PRODUCT_VARIANTY, $data);
  			$model->commit ? null : $all_query_ok = false;
        
        $varianty_id = $model->insert_id;
        
        
        
        $attributesList = $productVarianty->getHasAttributeValue($value->id);
        foreach ($attributesList as $akey => $avalue){
          $data = array();
    			$data["varianty_id"] = $varianty_id;
    			$data["attribute_id"] = $avalue->attribute_id;
    			$data["order"] = $avalue->order;
    			$model->insertRecords(T_SHOP_PRODUCT_VARIANTY_VALUE_ASSOC, $data);
    			$model->commit ? null : $all_query_ok = false;
        }
        
        
        
  		}
    }
    
 
    if (isset($params["copy_foto"]) && $params["copy_foto"] == 1)
    {
  		$args = new FotoPlacesListArgs();
  		$args->gallery_id = (int) $product_id;
  		$args->gallery_type = T_SHOP_PRODUCT;
  		$model = new models_FotoPlaces();
  		$fotoGallery = $model->getList($args);
  
  	/*	$params = array();
  		$params['gallery_id'] = (int) $product_id;
  		$params['gallery_type'] = T_SHOP_PRODUCT;
  		$fotoController = new FotoController();
  		$fotoGallery = $fotoController->fotoUmisteniList($params);*/
  
  		foreach ($fotoGallery as $key => $value){
  			$data = array();
  			$data["uid_source"] = $value->id;
  			$data["uid_target"] = $page_id;
  			$data["table"] = T_SHOP_PRODUCT;
  			$model->insertRecords(T_FOTO_PLACES, $data);
  			$model->commit ? null : $all_query_ok = false;
  		}
    
    }    





    		$sql = "update `mm_products` p left join mm_products_version v  on p.id=v.page_id and p.version=v.version
				set p.max_prodcena = v.prodcena,
				p.max_prodcena_sdph = v.prodcena_sdph,
				p.min_prodcena = v.prodcena,
				p.min_prodcena_sdph = v.prodcena_sdph
				where p.id=" . $page_id;

		$model->query($sql);
		$model->commit ? null : $all_query_ok = false;


		$sql = "update `mm_products` left join (
				SELECT product_id,max(price) as max_price,max(price_sdani) as max_price_sdani,
				min(price) as min_price, min(price_sdani) as min_price_sdani FROM `mm_product_varianty` where product_id=" . $page_id . " and isDeleted=0  and price is not null
				group by product_id) v on `mm_products`.id = v.product_id
				set max_prodcena = v.max_price,
				max_prodcena_sdph = v.max_price_sdani,
				min_prodcena = v.min_price,
				min_prodcena_sdph = v.min_price_sdani
				where `mm_products`.id in (
				SELECT product_id FROM `mm_product_varianty` where product_id =" . $page_id . " and price is not null  and isDeleted=0
				group by product_id)";
	//	print $sql;
	//	exit;
  
		$model->query($sql);
		$model->commit ? null : $all_query_ok = false;
    

		if ($model->konec_transakce($all_query_ok)) {
			return $page_id;
		} else {

		}
		return false;
	}
	public function copyAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('copy_product', false))
		{
			//self::$getRequest->getPost('copy_product', false);

			$tenzin = self::$getRequest->getPost('copy_product', false);
		//	print_r($tenzin);
			if (is_array($tenzin)) {
				list($key,$value) = each($tenzin);
				$product_id = $_POST['product_id'][$key];
			} else {

				$form = $this->formLoad('ProductEdit');

				$postdata = $form->getValues();
				$product_id = $postdata["id"];
			}


			$status = $this->copyProduct($product_id);
			if ($status !== false) {

				if (isset($form)) {
						$form->setResultSuccess('Produkt byl úspěšně zkopírován. <a href="/admin/edit_product?id='.$status.'">Zobrazit tento produkt</a>');
				} else {
					$_SESSION["statusmessage"]='Produkt byl úspěšně zkopírován. <a href="/admin/edit_product?id='.$status.'">Zobrazit tento produkt</a>';
					$_SESSION["classmessage"]="success";
				}

				self::$getRequest->goBackRef();
			}
		}

		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false)
			&& "copyProducts" == self::$getRequest->getPost('action', false))
		{

			$selectedItems = self::$getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						$model = new models_Products();
						$obj = $model->getDetailById($doklad_id);

						if ($obj) {
							if($this->copyProduct($doklad_id))
							{
								array_push($seznamCiselObjednavek,$obj->cislo );
							}
						}
					}
				}
				if (count($seznamCiselObjednavek)>0) {
					array_reverse($seznamCiselObjednavek);
					$_SESSION["statusmessage"]="Produkt " . implode(",", $seznamCiselObjednavek) . " byl zkopírován.";
					$_SESSION["classmessage"]="success";
					self::$getRequest->goBackRef();
				}
			}

		}
	}

	// Obecná metoda pro založení produktu
	private function create($postdata = array())
	{
		$pageSaveData = self::setPageData($postdata);
		$pageVersionSaveData = self::setPageVersionData($postdata, $pageSaveData->id, $pageSaveData->version);

		if (self::saveData($pageSaveData, $pageVersionSaveData)) {

			$pageData = self::getPageSaveData();
			return $pageData;
		}
		return false;
	}

	public function createAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('ins_product', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('ProductCreate');
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{

				$postdata = $form->getValues();

				if ($pageData = self::create($postdata)) {
					$page_id = $pageData->getId();
					$form->setResultSuccess('Produkt byl přidán. <a href="'.URL_HOME.'admin/edit_product?id='.$page_id.'">Přejít na právě pořízený záznam.</a>');
					self::$getRequest->goBackRef();
				}
			}
		}
	}

	public function importCenikuAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('import_products', false))
		{
			$filesController = new FilesController();

			$postData = array();
			$postData["popis"] = "natažení ceníku";
			if ($filesController->create($postData,array("xls"))) {
				$fileId = $filesController->getFileId();

				$fileDetail = $filesController->getDetailById($fileId);

				if ($fileDetail) {

					$source = PATH_DATA . $fileDetail->file;
					if($this->importCenikuXls($source))
					{
						$_SESSION["statusmessage"]="Ceník byl aktualizován";
						$_SESSION["classmessage"]="success";
					//	self::$getRequest->goBackRef();
					}
				}
			//	URL_DATA . $l[$i]->file
			}
		}
	}

	private function importCenikuXls($source)
	{

		if (!file_exists($source)) {
			exit("Soubor k natažení nenalezen!");
		}

		//	print $source;

		//exit;
		require_once(PATH_ROOT. "plugins/PHPExcel/Classes/PHPExcel/IOFactory.php");
	//	require_once(PATH_ROOT . "core/library/PHPExcel/Classes/PHPExcel/IOFactory.php"); // dirname(__FILE__) . "/../core/library/PHPExcel/Classes/PHPExcel/IOFactory.php";




		//print $source;
		//$objPHPExcel = new PHPExcel();

		$languageModel = new models_Language();
		$languageList = $languageModel->getActiveLanguage();

		$dph_model = new models_Dph();
		$dphList = $dph_model->getList();

		$mj_model = new models_Mj();
		$mjList = $mj_model->getList();


		$dostupnost_model = new models_ProductDostupnost();
		$dostupnostList = $dostupnost_model->getList();


		//	print_r($dostupnostList);
		$productVyrobceModel = new models_ProductVyrobce();
		$productVyrobceList = $productVyrobceModel->getList();

		//print_r($mjList);


		/*
		   if (!file_exists("cenik.xls")) {
		   exit("Soubor cenik.xls nenalezen!" . PHP_EOL);
		   }
		*/
		$objPHPExcel = PHPExcel_IOFactory::load($source);
		print "==============================<br />";
		print "Aktualizace zboží zahájena<br />";
		print "==============================<br />";
		$model = new models_Products();
		$ProductVersionEntity = new ProductVersionEntity();
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			//	echo 'Worksheet - ' , $worksheet->getTitle() , PHP_EOL;
			$ProdCenaCell = -1;
			$NakupCenaCell =-1;
			$QtyCell = -1;
			$PpcCell = -1;
			$Code01Cell = -1;
			$Code02Cell = -1;
			$Code03Cell = -1;
			$CisloCell = -1;
			$AktivniCell = -1;
			$dostupnostCell = -1;
			$ZnackaCell = -1;
			$skupinaCell = -1;
			$kategorieCell = -1;
			$DphCell =-1;
			$MjCell =-1;
			$PpcCell = -1;
			foreach ($worksheet->getRowIterator() as $row) {
				//	echo ' ' , $row->getRowIndex() ."<br />";

				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set

				$i=0;
				//$data = array();
				$product_cislo = "";
				$product_prodcena = 0;
				$dataVersion = array();
				$dataLanguageVersion = array();
				$data = array();
				foreach ($cellIterator as $cell) {
					if (!is_null($cell)) {
						$value = $cell->getCalculatedValue();

						if ($row->getRowIndex() == 1) {

							if (strtoupper(trim($value)) == "AKTIVNI") {
								$AktivniCell = $i;
							}

							if (strtoupper(trim($value)) == "CISLO") {
								$CisloCell = $i;
							}
							if (strtoupper(trim($value)) == "PRODCENA") {
								$ProdCenaCell = $i;
							}
							if (strtoupper(trim($value)) == "BEZNACENA") {
								$NakupCenaCell = $i;
							}
							if (strtoupper(trim($value)) == "SKUPINA") {
								$skupinaCell = $i;
							}

							if (strtoupper(trim($value)) == "KATEGORIE") {
								$kategorieCell = $i;
							}

							if (strtoupper(trim($value)) == "DOSTUPNOST") {
								$dostupnostCell = $i;
							}

							if (strtoupper(trim($value)) == "DPH") {
								$DphCell = $i;
							}


							if (strtoupper(trim($value)) == "ZNACKA") {
								$ZnackaCell = $i;
							}

							if (strtoupper(trim($value)) == "MJ") {
								$MjCell = $i;
							}

							if (strtoupper(trim($value)) == "QTY") {
								$QtyCell = $i;
							}
							if (strtoupper(trim($value)) == "MAX_PPC") {
								$PpcCell = $i;
							}

							if (strtoupper(trim($value)) == "CODE01") {
								$Code01Cell = $i;
							}

							if (strtoupper(trim($value)) == "CODE02") {
								$Code02Cell = $i;
							}
							if (strtoupper(trim($value)) == "CODE03") {
								$Code03Cell = $i;
							}
							foreach ($languageList as $key => $val)
							{
								$name = strtoupper("nazev_$val->code");

								//print $name;
								if (strtoupper(trim($value)) == $name) {

									$cellName = $name . "Cell";

									//print $cellName;
									$$cellName = $i;
								}

							}


							foreach ($languageList as $key => $val)
							{
								$name = strtoupper("popis_$val->code");

								//print $name;
								if (strtoupper(trim($value)) == $name) {

									$cellName = $name . "Cell";

									//print $cellName;
									$$cellName = $i;
								}

							}


						} else {


							//	echo '        Cell - ' , $cell->getCoordinate() , ' - ' , $cell->getCalculatedValue() , PHP_EOL;

							//print_r($cell->getCalculatedValue());
							/*if ($i==0) {
							   $product_cislo = $value;
							   }*/

							if ($CisloCell >= 0 && $CisloCell == $i) {
								$product_cislo = $value;
							}
							if ($AktivniCell >= 0 && $AktivniCell == $i) {
								$data["aktivni"] = $value;
							}
							if ($QtyCell >= 0 && $QtyCell == $i) {
								$data["qty"] = $value;
							}
							if ($PpcCell >= 0 && $PpcCell == $i) {
								$dataVersion["ppc_zbozicz"] = $value;
							}
							if ($Code01Cell >= 0 && $Code01Cell == $i) {
								$data["code01"] = $value;
							}
							if ($Code02Cell >= 0 && $Code02Cell == $i) {
								$data["code02"] = $value;
							}
							if ($Code03Cell >= 0 && $Code03Cell == $i) {
								$data["code03"] = $value;
							}
							if ($ProdCenaCell >= 0 && $ProdCenaCell == $i) {
								$dataVersion["prodcena"] = $value;
							}
							if ($DphCell >= 0 && $DphCell == $i) {

								foreach ($dphList as $key => $dph)
								{
									//	print $value . "==" . $dph->value . "<br />";
									if ($value == $dph->value) {
										$data["dph_id"] = $dph->id;
										break;
									}
								}
							}

							if ($MjCell >= 0 && $MjCell == $i) {

								foreach ($mjList as $key => $mj)
								{
									if (strtolower($value) == strtolower($mj->name)) {
										$data["mj_id"] = $mj->id;
										$data["hl_mj_id"] = $mj->id;

										break;
									}
								}
							}


							if ($dostupnostCell >= 0 && $dostupnostCell == $i) {

								foreach ($dostupnostList as $key => $mj)
								{
									if (strtolower($value) == strtolower($mj->name)) {
										//$data["mj_id"] = $mj->id;
										$data["dostupnost_id"] = $mj->id;

										break;
									}
								}
							}



							if ($ZnackaCell >= 0 && $ZnackaCell == $i) {

								foreach ($productVyrobceList as $key => $znacka)
								{
									$data["vyrobce_id"] = NULL;
									$dataVersion["vyrobce_id"] = NULL;
									if (strtolower($value) == strtolower($znacka->name)) {
										$data["vyrobce_id"] = $znacka->id;
										$dataVersion["vyrobce_id"] = $znacka->id;
										break;
									}
								}
							}



							if ($NakupCenaCell >= 0 && $NakupCenaCell == $i) {
								$dataVersion["bezna_cena"] = $value;
							}
							/*
							   if ($dostupnostCell >= 0 && $dostupnostCell == $i) {
							   $dataVersion["dostupnost"] = $value;
							   }
							*/


							if ($kategorieCell >= 0 && $kategorieCell == $i) {

								$temapA = explode("|",$value);
								if (count($temapA) == 2) {

									$dataVersion["category_id"] =  trim($temapA[0]) * 1;
								}
							}

							if ($skupinaCell >= 0 && $skupinaCell == $i) {

								$temapA = explode("|",$value);
								if (count($temapA) == 2) {

									$dataVersion["skupina_id"] =  trim($temapA[0]) * 1;
								}
							}


							foreach ($languageList as $key => $val)
							{
								$name = strtoupper("nazev_$val->code");
								$cellName = $name . "Cell";

								if (isset($$cellName)  && $$cellName > 0 && $$cellName == $i) {
									$titleValue = $name . "Value";
									$$titleValue = $value;
								}
							}

							foreach ($languageList as $key => $val)
							{
								$name = strtoupper("popis_$val->code");
								$cellName = $name . "Cell";

								if (isset($$cellName)  && $$cellName > 0 && $$cellName == $i) {
									$titleValue = $name . "Value";
									$$titleValue = $value;
								}
							}



						}
						$i++;
					}
				}



				//print_r($data);


				if (!empty($product_cislo)) {
					$query = "select * from " . T_SHOP_PRODUCT . " where cislo='{$product_cislo}' and isDeleted=0";
					$detail = $model->get_row($query);
					//$detail = true;
					if ($detail) {
						// aktualizuju
						print "Aktualizuji produkt č. " . $product_cislo . "<br />";
						if (count($data) > 0) {
							$model->updateRecords($model->getTableName(),$data,"cislo='" . $product_cislo . "' and isDeleted=0");
							//	print $model->getLastQuery();
						}

						if (count($dataVersion) > 0) {
							$model->updateRecords($ProductVersionEntity->getTableName(),$dataVersion,"page_id in (select id from " . $model->getTableName() .
								" p where p.cislo='" . $product_cislo . "' and isDeleted=0 )");
							//print $model->getLastQuery();
						}


						foreach ($languageList as $key => $val)
						{
							$name = strtoupper("nazev_$val->code");
							$cellName = $name . "Value";

							if (isset($$cellName)  && !empty($$cellName)) {
								$dataLanguageVersion["title"] = $$cellName;
							}

							$name = strtoupper("popis_$val->code");
							$cellName = $name . "Value";

							if (isset($$cellName)  && !empty($$cellName)) {
								$dataLanguageVersion["description"] = $$cellName;
							}

							if (count($dataLanguageVersion) > 0) {
								$model->updateRecords($ProductVersionEntity->getTableName(),$dataLanguageVersion,"lang_id = " . $val->id . " and page_id in (select id from " . $model->getTableName() .
									" p where p.cislo='" . $product_cislo . "'  and isDeleted=0)");
								//	print $model->getLastQuery();
							}


						}

						//	print_r($dataVersion);


						//$product = $model->getDetailByCislo($product_cislo,LANG_TRANSLATOR);
						if (!empty($product_cislo) && is_numeric($product_prodcena)) {
							$query = "update " . $ProductVersionEntity->getTableName() . " set
				prodcena=" . $product_prodcena .
									" where page_id in (select id from " . $model->getTableName() .
								" p where p.cislo='" . $product_cislo . "'  and isDeleted=0)";
						}
					} else {
						// přidávám
						print "Přidávám produkt č. " . $product_cislo . "<br />";

						if (!empty($product_cislo)) {
							$data["cislo"] = $product_cislo;
						}

						foreach ($languageList as $key => $val)
						{
							$name = strtoupper("nazev_$val->code");
							$titleName = strtolower("title_$val->code");
							$cellName = $name . "Value";

							if (isset($$cellName)  && !empty($$cellName)) {
								$dataLanguageVersion["title"] = $$cellName;
								$data[$titleName] = $$cellName;
							}

							$name = strtoupper("popis_$val->code");
							$cellName = $name . "Value";
							$descriptionName = strtolower("description_$val->code");
							if (isset($$cellName)  && !empty($$cellName)) {
								$data[$descriptionName] = $$cellName;
							}



						}

						foreach($dataVersion as $key => $val)
						{
							$data[$key] = $val;
						}


						self::create($data);
						//	print_r($data);
					}


				}


			}
		}

		return true;

	}
}

// kvůli shodě s modelem
class ProductsController extends ProductController{}
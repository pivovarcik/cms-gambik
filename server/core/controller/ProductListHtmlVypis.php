<?php

class ProductListHtmlVypis{


	public $printSale = true;

	public $printPages = true;

	public $radky = array();

	public $celkovyPocetRadku = 0;
	public $itemsListClass = "";
	public $itemClass = "";

	public $page = 1;

	public $limitNaStranku;
	protected $wrapClass = '';

	protected $mena = "";
	public function __construct($radky, $page, $celkovyPocetRadku, $limitNaStranku)
	{

		$settings = G_EshopSetting::instance();
		$this->mena = $settings->get("MENA");


		$this->wrapClass = 'itemsList-ajax col-xs-12';
		$this->radky = $radky;

		$this->page = $page;
		$this->limitNaStranku = $limitNaStranku;
		$this->celkovyPocetRadku = $celkovyPocetRadku;
	}

	public function getStrankovaniHtml()
	{
		$translator = G_Translator::instance();
		$res = '';
		$zobrazenychpolozek = count($this->radky);
		if ($this->printPages && $zobrazenychpolozek  > 0) {
		//	$res = '<div class="itemsList-footer col-xs-12">';
			$res = '<div class="itemsList-footer2 row">';

			if ($this->celkovyPocetRadku > $zobrazenychpolozek) {


				if ($zobrazenychpolozek == $this->limitNaStranku || $this->page > 1) {

					$pager = new G_Paginator($this->page, $this->celkovyPocetRadku, $this->limitNaStranku,true);
					$res .= $pager->render();

					//$res .= $output_product;
				}
			}
			if ($this->celkovyPocetRadku == 1) {
				$sklonovaniPolozek = $translator->prelozitFrazy("polozka"); // 'položka';
			} else if ($this->celkovyPocetRadku > 1 && $this->celkovyPocetRadku < 5) {
				$sklonovaniPolozek = $translator->prelozitFrazy("polozky");//'položky';
			} else {
				$sklonovaniPolozek = $translator->prelozitFrazy("polozek"); // 'položek';
			}


			;

			$res .= '<span class="itemCount">'.$translator->prelozitFrazy("zobrazeno").' ' . $zobrazenychpolozek . ' '.$translator->prelozitFrazy("z").' ' . $this->celkovyPocetRadku . ' ' . $sklonovaniPolozek . '</span>';
			$res .= '</div>';
		}

		return $res;
	}


	public function getRadkyHtml($ajax = false)
	{
		$res = '';
		$radky = $this->radky;
		if (!$ajax) {
			$res .= '<div class="' . $this->wrapClass . '">';
		}
    
    
		if (!empty($this->itemsListClass)) {
			$res .= '<div class="' . $this->itemsListClass . '">';
		} else {
		//	$res .= '<div class="itemsList row">';
			$res .= '<div class="row">';
			$res .= '<div class="itemsList">';
		}


		$imageController = new ImageController();

		$eshopSettings = G_EshopSetting::instance();
		$thumb_width= $eshopSettings->get("PRODUCT_THUMB_WIDTH"); // 190;
		$thumb_height= $eshopSettings->get("PRODUCT_THUMB_HEIGHT"); //200;


		for($i=0;$i<count($radky);$i++)
		{

			new ProductWrapper($radky[$i]);
			$radky[$i]->img_url = '';
			if (!empty($radky[$i]->file)) {
			//	$radky[$i]->img_url = $imageController->get_thumb($radky[$i]->file,$thumb_width,$thumb_height,null,false,false);
				 // tato varianta neprovede výřez fotky, ale pouze jí zmenší na požadovanou velikost
		//		$radky[$i]->img_url = $imageController->getZmensitOriginal($radky[$i]->dir . $radky[$i]->file,$thumb_width,$thumb_height);
				$radky[$i]->img_url = $imageController->getFileUrl($radky[$i]->dir . $radky[$i]->file,$thumb_width,$thumb_height);


			//	$imageController->get_thumb($l[$i]->file,$thumb_width,$thumb_height,null,false,false)
			}
			$res .= $this->getRadekHtml($radky[$i]);
		}

	//	$res .= '<div class="clearfix"><!-- IE --></div>';

    if (!empty($this->itemsListClass)) {
		$res .= '</div>';
		
		} else {
		$res .= '</div>';
		$res .= '</div>';
		//$res .= '</div>';
		}
    
    		if (!$ajax) {
			$res .= '</div>';
		}
		return $res;
	}
	// metod pro možnost změnit data n řádku
	public function getRadek($product) {



	}
	public function getRadekHtml($product)
	{

		$this->getRadek($product);

		//print_r($product);
		$isVarianty = false;
		if (count($product->variantyList) > 0) {

			$isVarianty = true;
			$variantyListGroup = array();

			$varianta_id = 0;
			foreach ($product->variantyList as $keya => $varianta)
			{

				//	if ($varianta_id != $varianta->varianty_id) {
				$variantyListGroup[$varianta->varianty_id] .= " " . $varianta->attribute_name . ": " . $varianta->value_name;
				$variantyListGroup[$varianta->varianty_id] = trim($variantyListGroup[$varianta->varianty_id]);


				//}
			}
			//print_r($variantyListGroup);
			$name = "varianty";
			$elem = new G_Form_Element_Select($name);
			$elem->setDecoration();
			$elem->setAttribs('value', 0);
			$elem->setAttribs('class','selectbox varianty_id');
			$pole = array();
			$poleAttr = array();

			/*
			   foreach ($variantyListGroup as $varianta => $values)
			   {
			   $pole[$varianta] =$values;
			   }
			*/
			$i=0;
			foreach ($product->variantyList as $varianta)
			{
				if ($product->variantyPrice) {
					$price = numberFormat($varianta->price,0) . " " . $this->mena;
					$pole[$i] = array($varianta->id, $varianta->code . ", " . $price);

				} else {
					$pole[$i] = array($varianta->id, $varianta->code);
				}
			//	$poleAttr[$i] = array("value" => $varianta->id);

				$i++;
			}

			//print_r($pole);
			$elem->setMultiOptions($pole,$poleAttr);
		}
		$translator = G_Translator::instance();
		$eshopSettings = G_EshopSetting::instance();


		if (!empty($this->itemClass)) {
			$itemClass = ' class="' . $this->itemClass . '"';
		} else {
			switch ($eshopSettings->get("ROW_PRODUCT_COUNT")) {
				case 1:
					$itemClass = ' class="item col-xs-12"';
					break;
				case 2:
					$itemClass = ' class="item col-xs-12 col-sm-6 col-md-6"';
					break;
				case 3:
					$itemClass = ' class="item col-xs-12 col-sm-6 col-md-4"';
					break;

				case 4:
					$itemClass = ' class="item col-xs-6 col-sm-6 col-md-4 col-lg-3"';
					break;
				case 5:
					$itemClass = ' class="item col-xs-4 col-sm-4 col-md-3 col-lg-15"';
					break;
				default:
					$itemClass = ' class="item col-xs-12 col-sm-6 col-md-4"';
			} // switch
		}



		$res = '<div' . $itemClass. '>';
		$res .= '	<div class="item_in">';


    if ( is_array($product->groups) && count($product->groups) > 0 ) {
       $res .= '	<div class="tags">';
        foreach ($product->groups as $key=>$val){
            $res .= '	<span class="tag tag-' .$val->id. '">' .$val->name. '</span>';
        }
        $res .= '</div>';
         
     }
           /*
		if ($product->novinka == 1) {
			$res .= '	<span class="tag tag-novinka">' .$translator->prelozitFrazy("novinka"). '</span>';
		}

		if ($product->akce == 1) {
			$res .= '	<span class="tag tag-akce">' .$translator->prelozitFrazy("akce"). '</span>';
		}
         */
   		$res .= '			<div class="product_name"><a href="' . $product->link. '">' . $product->title. '</a></div>';
		$res .= '		<div class="product_info">';
		$res .= '			<div class="description">' . truncateUtf8(trim(strip_tags($product->description)),110,false,true). '</div>';
		$res .= '			<div>';


			$res .= '				<div class="product_image">';
			$res .= '					<a href="' . $product->link. '">';
		if (!empty($product->img_url)) {
$res .= '<img  alt="'.$product->title.'" src="' . $product->img_url. '"/>';
		}
$res .= '</a>';
			$res .= '				</div>';



		$res .= '				<div class="product_params">';
		$res .= '					<div class="product_code"><span class="label">' . $translator->prelozitFrazy("kod_zbozi"). ':</span> ' . $product->cislo. '</div>';
		$res .= '				</div>';



		$res .= '				<div class="clearfix"><!-- IE --></div>';
		$res .= '			</div>';



		$res .= '		</div>';
// href="' . $product->link. '"
		$res .= '		<div class="price">';


	//	print_r($product);
		$cenaOd = "";
		//$cenaOd = $product->variantyPrice ."; " . $product->min_prodcena;
		if ($product->variantyPrice && $product->min_prodcena <> $product->max_prodcena) {
			$cenaOd = "od ";
		}
    
    if ( $product->neprodejne == 0 ) {
		if ($eshopSettings->get("PRICE_TAX") == "0") {
			//$pocetDesetin = (round($product->cena_bezdph - round($product->cena_bezdph),2) < 0.09) ? 0 : 2;
			$pocetDesetin = (round($product->min_prodcena - round($product->min_prodcena),2) < 0.09) ? 0 : 2;

			$min_prodcena = $product->min_prodcena;
			if ($min_prodcena  > $product->cena_bezdph && $product->cena_bezdph > 0) {
				$min_prodcena = $product->cena_bezdph;
			}

			$res .= '		<span class="value"><span class="price_label">' .$translator->prelozitFrazy("price_label"). '</span>' . $cenaOd . numberFormatMena($min_prodcena, $pocetDesetin). '&nbsp;'  . '<small> bez DPH</small></span>';

		} else {
			$pocetDesetin = round($product->min_prodcena_sdph - round($product->min_prodcena_sdph),2) < 0.09 ? 0 : 2;
		//	$product->cena_sdph - $product->cena_bezdph;

			$min_prodcena = $product->min_prodcena_sdph;
			if ($min_prodcena > $product->cena_sdph && $product->cena_sdph > 0) {
				$min_prodcena = $product->cena_sdph;
			}

		//	$pocetDesetin = round($product->cena_sdph - round($product->cena_sdph),2) < 0.09 ? 0 : 2;
		//	$res .= '<span class="value"><span class="price_label">' .$translator->prelozitFrazy("price_label"). '</span>' . $cenaOd . numberFormatMena($product->min_prodcena_sdph, $pocetDesetin). '&nbsp;'  . '<small> s DPH</small></span>';
			$res .= '<span class="value"><span class="price_label">' .$translator->prelozitFrazy("price_label"). '</span>' . $cenaOd . numberFormatMena($min_prodcena, $pocetDesetin). '&nbsp;'  . '<small> s DPH</small></span>';
		}
		if ($product->bezna_cena > 0) {
			$res .= '<span class="bezna_cena"><span class="bezna_cena_label">' .$translator->prelozitFrazy("bezna_cena_label"). '</span>' .numberFormatMena($product->bezna_cena, 0). '&nbsp;' .  '</span>';
		}
      }
		$dostupnost_class = 'dostupnost';
		if ($product->dostupnost_id > 0) {
			$dostupnost_class .= ' dostupnost-'.$product->dostupnost_id;
		}
$res .= '<span class="' .$dostupnost_class. '">' .$product->nazev_dostupnost. '</span>';
		$res .= '</div>';

		if ( $product->neprodejne == 0 && $eshopSettings->get("ADD_BASKET_LIST") == "1" && ($eshopSettings->get("ADD_BASKET_BEZSTAVU") == "1" || $product->hodiny_dostupnost <> 1000 )) {
			$res .= '<form method="post">';
			$res .= '<div class="product_buy">';
			$res .= '<input type="hidden" class="product_id" name="product_id" value="' .$product->page_id. '" />';

			if ($isVarianty) {
		//		$res .= '				<div class="product_varianty">';
				$res .= '					' . $elem->render(). '<br />';
			//	$res .= '				</div>';
			}

			$res .= '<span class="qty-box"><input id="product-qty-' .$product->page_id. '" type="text" class="qty" value="' .round($product->qty,0). '" name="qty" autocomplete="off">&nbsp;' .$product->nazev_mj. '</span>';
			$res .= '&nbsp;<a title="' . $product->title. '" class="btn btn-buy btn-sm buy" href="#"><span>' .$translator->prelozitFrazy("koupit"). '</span></a>';


			$res .= '</div>';
			$res .= '</form>';

				} else {
        	$res .= '<div class="product_buy">';
					$res .= '<a title="' . $product->title. '" class="btn btn-buy btn-sm" href="' . $product->link. '"><span>' .$translator->prelozitFrazy("detail"). '</span></a>';
          	$res .= '</div>';
				}


		if ($this->printSale && $product->sleva <> 0) {
			$res .= '<div class="saleoff">' . $product->sleva_label. '</div>';
		}
		if ($product->skupina_id > 0) {
			$res .= '<div class="label label-' . strToUrl($product->nazev_skupina). '">' . $product->nazev_skupina. '</div>';
		}
	/*	if ($product->skupina_id == 1) {
			$res .= '<div class="novinka">Novinka</div>';
		}
		if ($product->skupina_id == 2) {
			$res .= '<div class="vyprodej">výprodej</div>';
		}
		if ($product->skupina_id == 3) {
			$res .= '<div class="akce">akce</div>';
		}*/


		$res .= '</div>';

		$res .= '</div>';

		return $res;
	}
}


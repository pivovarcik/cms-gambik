<?php



class ProductBasketModalCreate extends BootrapModalForm {

	public $form = null;
	public function __construct()
	{
    $formName = "F_ProductBasketCreate";

		$this->form = new $formName();


		parent::__construct("myModal",$this->form , "medium");
	}



	public function setBody()
	{
		$form = $this->form;
                 $eshopSettings = G_EshopSetting::instance();

                 new ProductsWrapper($form->product);
       //    print_R($form);
			$res = '<div class="row">';
			$res .= '<div class="col-xs-3">';
			$res .= '<div class="control-label2"><img src="' . $form->product->thumb_link . '"></div>';
       $res .= '</div>';
       $res .= '<div class="text-left col-xs-6">';
       $res .= '' . $form->product->title . ' ' . $form->product->cislo . '';
       $res .= '<br />' . $form->product->product_description;
       
       $res .= '</div>';
       $res .= '<div class="col-xs-3" style="text-align:right">';
       if ($eshopSettings->get("PRICE_TAX") == "0") {
        $res .= '<span class="product_value cenasdph">' . numberFormatMena( $form->product->cena_bezdph) . '</span>';
      } else {
      
       // $pocetDesetin = round($form->product->cena_sdph - round($form->product->cena_sdph),2) < 0.09 ? 0 : 2;
         $res .= '<span class="product_value cenasdph">' . numberFormatMena( $form->product->cena_sdph) . '</span>';
      }
      $res .= '</div>';
			$res .= $form->getElement("product_id")->render();
		//	if ($form->isvarianty) {
				$res .= $form->getElement("varianty_id")->render();
		//	}
//    $res .= '</div>';
      		//	$res .= '<table>';
			$res .= $form->getElement("qty")->render();
		//	$res .= '</div>';


			$res .= '<div class="form-group">';
			//	$res .= '<label for="message-text" class="control-label">Zpráva:</label>';
			//	$res .= $form->getElement("message")->render();
			$res .= $form->getElement("add_product_basket")->render();

			$res .= '</div>';
			$res .= '</div>';


  
		parent::setBody($res);

	}

}
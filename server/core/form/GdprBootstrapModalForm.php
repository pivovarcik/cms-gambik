<?php


  
class GdprBootstrapModalForm extends BootrapModalForm {

	public $form = null;
	public function __construct($formName)
	{

		$this->form = new $formName();


		parent::__construct("myModal",$this->form , "medium");
	}



	public function setBody($body = '')
	{
		$form = $this->form;


    			$body = '';
		/*	$body .= '<div class="row">';
			$body .= '<div class="col-xs-12">';
			$body .= $form->getElement("code")->render();
			$body .= '</div>';
			$body .= '</div>';
*/

			$body .= '<div class="row">';


			$body .= '<div class="col-xs-3">';
			$body .= $form->getElement("email")->render();
			$body .= '</div>';


			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("subject")->render();
			$body .= '</div>';

      
			$body .= '<div class="col-xs-3">';
			$body .= $form->getElement("souhlas_text")->render();
			$body .= '</div>';



      

    	$body .= '<div class="col-xs-3">';
			$body .= $form->getElement("souhlas_od")->render();
			$body .= '</div>';
      
        			$body .= '<div class="col-xs-3">';
			$body .= $form->getElement("souhlas_do")->render();
			$body .= '</div>';



      			$body .= '<div class="col-xs-3">';
			$body .= $form->getElement("zpusob_overeni")->render();
			$body .= '</div>';
                            
      
     /*
			$eshopSettings = G_EshopSetting::instance();
			if ($eshopSettings->get("PRICE_TAX") == 0) {
				$name = "price";
			} else {
				$name = "price_sdani";
			}

			$body .= '<div class="row">';
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement($name)->render();
			$body .= '</div>';
                                 */

			$body .= '<div class="col-xs-6">';
		//	$form->getElement("dph_id")->setAttrib("label","Daň");
		//	$body .= $form->getElement("dph_id")->render();
			$body .= '</div>';




      
      

      
			$body .= '</div>';
	//		$body .= $form->getElement("action")->render();




	//		$body .= $atributyCheckbox;



		$body .= $form->getElement("action")->render();
		parent::setBody($body);

	}

}



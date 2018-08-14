<?php



class ProductVariantyBootstrapModalForm extends BootrapModalForm {

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
			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("code")->render();
			$body .= '</div>';

			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("qty")->render();
			$body .= '</div>';
			$body .= '</div>';


			$body .= '<div class="row">';
			$body .= '<div class="col-xs-12">';
			$body .= $form->getElement("name")->render();
			$body .= '</div>';
			$body .= '</div>';


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


			$body .= '<div class="col-xs-6">';
			$form->getElement("dph_id")->setAttrib("label","Daň");
			$body .= $form->getElement("dph_id")->render();
			$body .= '</div>';
			$body .= '</div>';

                  			$body .= '<div class="row">';


			$body .= '<div class="col-xs-6">';
			$body .= $form->getElement("order")->render();
			$body .= '</div>';
			$body .= '</div>';
			$body .= $form->getElement("action")->render();





			$atributyCheckbox = '<fieldset class="well">';
			$atributyCheckbox .= '<div class="row">';
			foreach ($form->atributyList as $key => $atribut ) {

				//	print_r($atribut);
				$atributyCheckbox .= '<div class="col-xs-3">';





				$name =  "attribute_original_id[]";
				$elem = new G_Form_Element_Hidden($name);
				$elem->setAttribs('class','attribute_original_id');
				//	$value = $this->getPost($name, $atribut->id);
				//print $value;

				$elem->setAttribs('value',$atribut->id);
				$form->addElement($elem);
				//	$elem->setAnonymous();
				$atributyCheckbox .= $elem->render();


				$name = "has_attribute_id[]";
				$elem= new G_Form_Element_Checkbox($name);
				$elem->setAttribs('class','has_attribute_id');
				$value = $atribut->id;


				$elem->setAttribs('value',$value);
				$elem->setAttribs('label',$atribut->name);

				$has_attribute = false;
				if (($form->Request->isPost() && $form->getPost($name, false))) {
					$elem->setAttribs('checked','checked');
					$has_attribute = true;
				} elseif ($atribut->has_attribute == 1) {
					$has_attribute = true;
					$elem->setAttribs('checked','checked');
				}
				$elem->setAttribs('onclick',"javascript:attrChecked(this);");
				$form->addElement($elem);
				$atributyCheckbox .= $elem->render();

				$name =  "attribute_id[]";
				$elem = new G_Form_Element_Hidden($name);
				if ($has_attribute) {
					$value = $form->getPost($name, $atribut->id);
				} else {
					$value = $form->getPost($name, 0);
				}

				//print $value;
				$elem->setAttribs('class','attribute_id');
				$elem->setAttribs('value',$value);
				$form->addElement($elem);
				//	$elem->setAnonymous();
				$atributyCheckbox .= $elem->render();

				$attribList = $form->atributyValuesList[$atribut->id];
				//get_class($this) .
				$name = "attribute_value_id[{$atribut->id}]";
				$elem = new G_Form_Element_Select($name);
				$elem->setDecoration();
				$value2 = $form->getPost($name, $atribut->attribute_id);
				$elem->setAttribs('value', $value2);
				if (!$has_attribute) {
					$elem->setAttribs('style','display:none;');
				}
				$elem->setAttribs('class','selectbox');
				$pole = array();

				foreach ($attribList as $keya => $valuea)
				{
					$pole[$valuea->id] = $valuea->name;
				}
				//print_r($pole);
				$elem->setMultiOptions($pole);
				//	array_push($elements, $elemAttrib);
				$form->addElement($elem);
				$atributyCheckbox .= $elem->render();


				$atributyCheckbox .= '</div>';
			}
			$atributyCheckbox .= '</div>';
			$atributyCheckbox .= '</fieldset>';
			$body .= $atributyCheckbox;
      
      
      
      			$body .= '<div class="row">';
            
            

			$body .= '<div class="col-xs-3">';
			$body .= $form->getElement("dostupnost_id")->render();
			$body .= '</div>';
      
			$body .= '<div class="col-xs-3">';
			$body .= $form->getElement("stav_qty")->render();
			$body .= '</div>';

			$body .= '<div class="col-xs-3">';
			$body .= $form->getElement("stav_qty_min")->render();
			$body .= '</div>';
      
      
      			$body .= '<div class="col-xs-3">';
			$body .= $form->getElement("stav_qty_max")->render();
			$body .= '</div>';
      
      
			$body .= '</div>';



		$body .= $form->getElement("action")->render();
		parent::setBody($body);

	}

}
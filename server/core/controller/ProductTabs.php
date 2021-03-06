<?php

class ProductTabs extends PageTabs {

	public function __construct($pageForm,$small = false)
	{
		parent::__construct($pageForm,"Products");





		$form = $this->form;
		if ($form->getElement("id")) {

			//	$tabs[] = array("name" => "Attrib", "title" => "Nastavení parametrů","content" => $this->NastaveniAtrtribTab() );
			// TODO varianty na parametr v nastavení

			//if (!$small) {


  			$eshopSettings = G_EshopSetting::instance();
        // && $form->page->isVarianty == 1
  			if ($eshopSettings->get("PRODUCT_VARIANTY")=="1") {
  				$tab = array("name" => "Varianty", "title" => "Varianty","content" => $this->VariantyTab() );
  				$this->addTab($tab,true);
  			}
  
  
        
  			$tab =  array("name" => "Cenik", "title" => "Ceník","content" => $this->CenikTab() );
  			$this->addTab($tab,true);
	//		}
              
              
     if ($form->page->dodavatel_id > 0) {
				$tab = array("name" => "Dodavatel", "title" => "Dodavatel","content" => $this->DodavatelTab() );
				$this->addTab($tab,true);
			}
      

		}
		$tab = array("name" => "Pohyby", "title" => "Sklad","content" => $this->PohybyTab() );
		$this->addTab($tab,true);
		$tab = array("name" => "Description", "title" => "Popis","content" => $this->DescriptionTab() );
		$this->addTab($tab,true);

		$tab = array("name" => "Param", "title" => "Parametry","content" => $this->ParametryTab() );
		$this->addTab($tab,true);

		$tab = array("name" => "Main", "title" => "Hlavní","content" => $this->MainTab() );
		$this->addTab($tab,true);
    

    


	}


	protected function MainTab()
	{

		$form = $this->form;
		$languageList = $this->languageList;

		$contentMain = '';



		$contentMain .='<fieldset class="well">';


		$contentMain .='<div class="row">';

		$contentMain .='<div class="col-sm-4">';
		$contentMain .= $form->getElement("cislo")->render();
		$contentMain .='</div>';

		$contentMain .='<div class="col-sm-8">';
		$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
			$contentMain .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("title_$val->code")->render();
        	$contentMain .='<p class="desc"><a target="_blank" href="https://translate.google.cz/?hl=cs&tab=wT&authuser=0#el/cs/' . urlencode($form->getElement("title_$val->code")->getValue()) . '">Přeložit "' . $form->getElement("title_$val->code")->getValue() . '"</a></p>';
       $contentMain .= '</div>';
		}
		
		$contentMain .='</div>';

		$contentMain .='</div>';


		$contentMain .='<div class="row">';

		$contentMain .='<div class="col-sm-12">';

		//	$contentMain .='<div class="col-sm-8">';
		$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
			$contentMain .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("perex_$val->code")->render() . '</div>';
		}

		$contentMain .='</div>';

		$contentMain .='</div>';


		$contentMain .='<div class="row">';

		$contentMain .='<div class="col-sm-6">';
		$contentMain .= $form->getElement("code02")->render();
		$contentMain .='</div>';

		$contentMain .='<div class="col-sm-6">';
		$contentMain .= $form->getElement("code01")->render();
		$contentMain .='</div>';

		$contentMain .='</div>';



		$contentMain .= '<label class="control-label" for="">Skupina:</label>';
		$contentMain .= '<div class="checkbox-group service-box">';
		$categoryA = $form->getElement("group_id[]");

		foreach ($categoryA as $key => $val)
		{
			$contentMain .= '<span id="sort_primary_sluzba_' .  $val->getValue(). '">' . $val->render()  . '</span>';
			//	$contentMain .= '<p class="desc"></p><br />';
		}
		$contentMain .= '<div class="clearfix"></div></div>';


		/*
		   $contentMain .='<div class="row">';

		   $contentMain .='<div class="col-sm-4">';
		   $contentMain .= $form->getElement("novinka")->render();
		   $contentMain .='</div>';

		   $contentMain .='<div class="col-sm-4">';
		   $contentMain .= $form->getElement("akce")->render();
		   $contentMain .='</div>';

		   $contentMain .='<div class="col-sm-4">';
		   $contentMain .= $form->getElement("doporucujeme")->render();
		   $contentMain .='</div>';

		$contentMain .='</div>';
*/
		$contentMain .='</fieldset>';


		$contentMain .='<fieldset class="well">';

		$contentMain .='<div class="row">';

		$contentMain .='<div class="col-sm-2">';
		$contentMain .= $form->getElement("qty")->render();
		$contentMain .='</div>';
		$contentMain .='<div class="col-sm-2">';
		$contentMain .= $form->getElement("qty_nasobek")->render();
		$contentMain .='</div>';
		$contentMain .='<div class="col-sm-2">';
		$contentMain .= $form->getElement("hl_mj")->render();
		$contentMain .='</div>';

		$eshopSettings = G_EshopSetting::instance();
		if ($eshopSettings->get("PLATCE_DPH") == 0) {
			$contentMain .='<div class="col-sm-6">';
      if ($form->page->min_prodcena_sdph <> $form->page->max_prodcena_sdph ) {
          $form->getElement("prodcena_sdph")->setAttribs('disabled','disabled');
           $form->getElement("prodcena_sdph")->setAttribs(array("is_money"=>false));
          $form->getElement("prodcena_sdph")->setAttribs('value','od ' . numberFormat($form->page->min_prodcena_sdph));
      }
			$contentMain .= $form->getElement("prodcena_sdph")->render();
			if ($form->page->min_prodcena_sdph <> $form->page->max_prodcena_sdph ) {
				$contentMain .='<p class="desc">Cena od <strong>' . numberFormat($form->page->min_prodcena_sdph) . "</strong> do <strong>" . numberFormat($form->page->max_prodcena_sdph) . '</strong></p>';
			}
			$contentMain .='</div>';


		} else {
			if ($eshopSettings->get("PRICE_TAX") == 0) {

				$contentMain .='<div class="col-sm-6">';

				$contentMain .='<div class="row">';
				$contentMain .='<div class="col-sm-4">';
				$contentMain .= $form->getElement("prodcena")->render();
				$contentMain .='</div>';

				$contentMain .='<div class="col-sm-4">';
				$contentMain .= $form->getElement("dph_id")->render();
				$contentMain .='</div>';

				$contentMain .='<div class="col-sm-4">';
        if ($form->page->min_prodcena_sdph <> $form->page->max_prodcena_sdph ) {
            $form->getElement("prodcena_sdph")->setAttribs('disabled','disabled');
             $form->getElement("prodcena_sdph")->setAttribs(array("is_money"=>false));
            $form->getElement("prodcena_sdph")->setAttribs('value','od ' . numberFormat($form->page->min_prodcena_sdph));
        }
      
				$contentMain .= $form->getElement("prodcena_sdph")->render();
				if ($form->page->min_prodcena_sdph <> $form->page->max_prodcena_sdph ) {
					$contentMain .='<p class="desc">Cena od <strong>' . numberFormat($form->page->min_prodcena_sdph) . "</strong> do <strong>" . numberFormat($form->page->max_prodcena_sdph) . '</strong></p>';
				}
				$contentMain .='</div>';

				$contentMain .='</div>';
				$contentMain .='</div>';


			} else {


				$contentMain .='<div class="col-sm-6">';

				$contentMain .='<div class="row">';

				$contentMain .='<div class="col-sm-4">';
				$contentMain .= $form->getElement("prodcena_sdph")->render();
				if ($form->page->min_prodcena_sdph <> $form->page->max_prodcena_sdph ) {
					$contentMain .='<p class="desc">Cena od <strong>' . numberFormat($form->page->min_prodcena_sdph) . "</strong> do <strong>" . numberFormat($form->page->max_prodcena_sdph) . '</strong></p>';
				}
				$contentMain .='</div>';

				$contentMain .='<div class="col-sm-4">';
				$contentMain .= $form->getElement("dph_id")->render();
				$contentMain .='</div>';

				$contentMain .='<div class="col-sm-4">';
				$contentMain .= $form->getElement("prodcena")->render();
				$contentMain .='</div>';

				$contentMain .='</div>';
				$contentMain .='</div>';
			}
		}






		$contentMain .='</div>';



		$contentMain .='<div class="row">';

		$contentMain .='<div class="col-sm-3">';
		$contentMain .= $form->getElement("sleva")->render();
		$contentMain .='</div>';

		$contentMain .='<div class="col-sm-3">';
		$contentMain .= $form->getElement("druh_slevy")->render();
		$contentMain .='</div>';


		$contentMain .='<div class="col-sm-3">';
		$contentMain .= $form->getElement("bezna_cena")->render();
		$contentMain .= '<p class="desc">Škrtnutá cena</p>';
		$contentMain .='</div>';

		$contentMain .='<div class="col-sm-3">';
		$contentMain .= $form->getElement("nakupni_cena")->render();
		$contentMain .= '<p class="desc">Dodavatelská cena</p>';
		$contentMain .='</div>';

		$contentMain .='</div>';

		$contentMain .='</fieldset>';








/*
		$contentMain .='<div class="row">';

		$contentMain .='<div class="col-sm-6">';
		$contentMain .= $form->getElement("category_id")->render();
		$contentMain .='</div>';

		$contentMain .='<div class="col-sm-6">';
	//	$contentMain .= $form->getElement("skupina_id")->render();
		$contentMain .='</div>';

		$contentMain .='</div>';


*/



		$contentMain .='<div class="row">';
		$contentMain .='<div class="col-sm-3">';
		$contentMain .= $form->getElement("category_id")->render();
		$contentMain .='</div>';
		$contentMain .='<div class="col-sm-3">';
		$contentMain .= $form->getElement("vyrobce_id")->render();
		$contentMain .='</div>';
     /*
		$contentMain .='<div class="col-sm-3">';
		$contentMain .= $form->getElement("dostupnost_id")->render();
		$contentMain .='</div>';
                                         */
		$contentMain .='<div class="col-sm-3">';
		$contentMain .= $form->getElement("zaruka_id")->render();
		$contentMain .='</div>';



		$contentMain .='</div>';

		$contentMain .='<div class="row">';

		$contentMain .='<div class="col-sm-3">';
		$contentMain .= '<div class="checkbox">' . $form->getElement("aktivni")->render() . '</div>';
		$contentMain .='</div>';

		$contentMain .='<div class="col-sm-3">';
		$contentMain .= '<div class="checkbox">' . $form->getElement("bazar")->render() . '</div>';
		$contentMain .='</div>';

		$contentMain .='<div class="col-sm-3">';
		$contentMain .= '<div class="checkbox">' . $form->getElement("neexportovat")->render() . '</div>';
		$contentMain .='</div>';

		$contentMain .='<div class="col-sm-3">';
		$contentMain .= '<div class="checkbox">' . $form->getElement("neprodejne")->render() . '</div>';
		$contentMain .='</div>';
    
		$contentMain .='</div>';








		return $contentMain;
	}

	protected function DescriptionTab()
	{
		$languageList = $this->languageList;
		$form = $this->form;
		$contentMain = '';

		$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
			$contentMain .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("description_$val->code")->render() . '</div>';
		}
		$contentMain .='<p class="desc"></p><br />';
		return $contentMain;

	}
	protected function ParametryTab()
	{
		$languageList = $this->languageList;
		$form = $this->form;
		$contentParametry = '';

		$eshopSettings = G_EshopSetting::instance();

		$contentParametry .= '<div class="row">';
		$contentParametry .= '<div class="col-sm-4">';
		$contentParametry .= $form->getElement("netto")->render();
	//	$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= '</div>';
    
		$contentParametry .= '<div class="col-sm-4">';
		$contentParametry .= $form->getElement("objem")->render();
	//	$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= '</div>';
    
    $contentParametry .= '<div class="col-sm-4">';
		$contentParametry .= $form->getElement("rozmer")->render();
	//	$contentParametry .= '<p class="desc"></p><br />';
		$contentParametry .= '</div>';
    
		$contentParametry .= '</div>';




		if ($eshopSettings->get("POLOZKA01_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("polozka1_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}

		if ($eshopSettings->get("POLOZKA02_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("polozka2_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}

		if ($eshopSettings->get("POLOZKA03_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("polozka3_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}


		if ($eshopSettings->get("POLOZKA04_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("polozka4_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}

		if ($eshopSettings->get("POLOZKA05_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("polozka5_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}













		if ($eshopSettings->get("POLOZKA06_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("polozka6_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}

		if ($eshopSettings->get("POLOZKA07_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("polozka7_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}

		if ($eshopSettings->get("POLOZKA08_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("polozka8_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}


		if ($eshopSettings->get("POLOZKA09_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("polozka9_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}

		if ($eshopSettings->get("POLOZKA10_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("polozka10_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}



		if ($eshopSettings->get("CISLO01_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}

				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("cislo1_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}

		if ($eshopSettings->get("CISLO02_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}

				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("cislo2_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}

		if ($eshopSettings->get("CISLO03_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}

				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("cislo3_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}


		if ($eshopSettings->get("CISLO04_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}

				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("cislo4_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}

		if ($eshopSettings->get("CISLO05_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}

				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("cislo5_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}





		if ($eshopSettings->get("CISLO06_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}

				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("cislo6_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}

		if ($eshopSettings->get("CISLO07_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}

				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("cislo7_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}

		if ($eshopSettings->get("CISLO08_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}

				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("cislo8_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}


		if ($eshopSettings->get("CISLO09_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}

				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("cislo9_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}

		if ($eshopSettings->get("CISLO10_CHECK") == "1") {
			$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}

				$contentParametry .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("cislo10_$val->code")->render() . '</div>';
				$first = false;
			}
			$contentParametry .='<p class="desc"></p><br />';
		}

		$elements = $form->getElement();
	/*	for($i=0; $i<count($elements);$i++)
		{
			if (substr($elements[$i]->getName(),0,5) == "attr[") {
				$contentParametry .=$elements[$i]->render();
				$contentParametry .='<p class="desc"></p><br />';
			}

			if (substr($elements[$i]->getName(),0,10) == "attrOrder[") {
				$contentParametry .=$elements[$i]->render();
				//	$contentParametry .='<p class="desc"></p><br />';
			}

		}   */
    
    foreach ($form->attributes as $key => $value){
				//print_r($value);
        
        if ($value->multi_select == 1)
        {
          
    $contentParametry .= '<label class="control-label" for="">' . $value->name . '</label>';
		$contentParametry .= '<div class="checkbox-group service-box">';
		$categoryA = $form->getElement("group_id[]");


	
          $name = "attr[" . $value->id . "]";
          for($i=0; $i<count($elements);$i++)
      		{
      			if (substr($elements[$i]->getName(),0,strLen($name)) == $name) {
      				$contentParametry .=$elements[$i]->render();
      				//$contentParametry .='<p class="desc"></p><br />';
      			}
          }
          
          $contentParametry .= '<div class="clearfix"></div></div>';  
           
           
        
        } else {
          $name = "attr[" . $value->id . "]";
         
    				$contentParametry .=$form->getElement($name)->render();
    				$contentParametry .='<p class="desc"></p><br />';
    		
        }
    }

		return $contentParametry;

	}
   /*
	// TODO - přepracovat na asynchronní dotažení v případě přepnutí na záložku
	protected function NastaveniAtrtribTab()
	{
		$form = $this->form;
		$contentNastaveni = '';
		if (!$form->getElement("id")) {
			return $contentNastaveni;
		}


		$productController = new ProductController();
		$attributy = $productController->get_attributeAssociation($form->getElement("id")->getValue());

		//$contentNastaveni .= '<form class="standard_form" method="post">';
		$contentNastaveni .= '<table>';


		$cols=3;
		$zadna_data="Žádné atributy nejsou k dispozici.";
		if (count($attributy)>0)
		{
			$sudy = false;
			for ($i=0;$i < count($attributy);$i++)
			{

				$checked = '';
				if ($attributy[$i]->has_attribute == 1)
				{
					$checked = ' checked="checked"';
				}
				$contentNastaveni .= '<tr>';
				$contentNastaveni .= '<td><label><input ' . $checked . 'type="checkbox" name="attrib[' . $i . ']" value="' . $attributy[$i]->id . '"> ' . $attributy[$i]->name . '</label>';
				$contentNastaveni .= '<input type="hidden" name="attrib_value[' . $i . ']" value="' . $attributy[$i]->value . '">';
				$contentNastaveni .= '<input type="hidden" name="attrib_is[' . $i . ']" value="' . $attributy[$i]->has_attribute . '">';
				$contentNastaveni .= '</td>';
				$contentNastaveni .= '</tr>';

			}
		}
		$contentNastaveni .= '</table>';
		$contentNastaveni .= '<input class="tlac" type="submit" value="Nastavit parametry" name="upd_attribute_product" />';

		return $contentNastaveni;

	}     */

	protected function VariantyTab()
	{
		$form = $this->form;
		$args = new ListArgs();
		$args->doklad_id = (int) $form->page_id;
		$args->isDeleted = 0;
		$args->limit = 10000;
		$args->orderBy = 't1.order ASC, t1.TimeStamp ASC';

		$DataGridProvider = new DataGridProvider("ProductVarianty", $args);
		$DataGridProvider->setModalForm();

		$contentVarianty = $DataGridProvider->addButton("Nová", '/admin/sortiment?do=variantyCreate&id='.$form->page_id);

		//	$contentVarianty = '<a id="dg-add-form" href="#" data-url="/admin/sortiment?do=variantyCreate&id='.$form->page_id.'" class="btn btn-sm btn-info">Nová</a>';
		$contentVarianty .= $DataGridProvider->ajaxtable();
		/*	$form = $this->form;
		   $Variantyform = new ProductVariantyForm();
		   $contentVarianty = $Variantyform->tableRender();
		*/

		return $contentVarianty;

	}
  
  protected function PohybyTab()
	{
		$form = $this->form;
    
    
    		$form = $this->form;
        $contentVarianty = '';
		$contentVarianty .='<div class="row">';
    
    		$contentVarianty .='<div class="col-sm-3">';
		$contentVarianty .= $form->getElement("dostupnost_id")->render();
		$contentVarianty .='</div>';
    
		$contentVarianty .='<div class="col-sm-3">';
   
   		$contentVarianty .=$form->getElement("stav_qty")->render();
    
    	$contentVarianty .='</div>';
      
      
      		$contentVarianty .='<div class="col-sm-3">';
   
   		$contentVarianty .=$form->getElement("stav_qty_min")->render() ;
    
    	$contentVarianty .='</div>';
      
      
      		$contentVarianty .='<div class="col-sm-3">';
   
   		$contentVarianty .=$form->getElement("stav_qty_max")->render() ;
    
    	$contentVarianty .='</div>';
      
      	$contentVarianty .='</div>';
    
    
		$args = new ListArgs();
		$args->product_id = (int) $form->page_id;
    
		$args->isDeleted = 0;
		$args->lang = LANG_TRANSLATOR;
		$args->limit = 10000;
		//$args->orderBy = 't1.order ASC, t1.TimeStamp ASC';

		$DataGridProvider = new DataGridProvider("ProductPohyb", $args);
		$DataGridProvider->setModalForm();
  
	//	$contentVarianty = $DataGridProvider->addButton("Nová", '/admin/sortiment?do=variantyCreate&id='.$form->page_id);

		//	$contentVarianty = '<a id="dg-add-form" href="#" data-url="/admin/sortiment?do=variantyCreate&id='.$form->page_id.'" class="btn btn-sm btn-info">Nová</a>';
		$contentVarianty .= $DataGridProvider->ajaxtable();
		/*	$form = $this->form;
		   $Variantyform = new ProductVariantyForm();
		   $contentVarianty = $Variantyform->tableRender();
		*/

		return $contentVarianty;

	}
  
	protected function DodavatelTab()
	{
		$form = $this->form;

		$contentMain .='<div class="row">';
		$contentMain .='<div class="col-sm-3">';
    
		$contentMain .= '<div class="form-group"><label for="code" class="control-label">Poslední aktualizace</label>';
		$contentMain .= '<input value="' . date("j.n.Y H:i:s",strtotime($form->page->LastSyncTime)) . '" readonly="readonly" class="textbox readonly form-control" type="text"></div>';

		$contentMain .='</div>';
		$contentMain .='<div class="col-sm-3">';

    		$contentMain .= '<div class="form-group"><label for="code" class="control-label">Dodavatel</label>';
		$contentMain .= '<input value="' . $form->page->dodavatel_name . '" readonly="readonly" class="textbox readonly form-control" type="text"></div>';


		$contentMain .='</div>';

		$contentMain .='<div class="col-sm-3">';
    		$contentMain .= '<div class="form-group"><label for="code" class="control-label">Product Id</label>';
		$contentMain .= '<input value="' . $form->page->reference . '" readonly="readonly" class="textbox readonly form-control" type="text"></div>';


		$contentMain .='</div>';


     		$contentMain .='<div class="col-sm-3">';
    		$contentMain .= '<div class="form-group"><label for="code" class="control-label">Číslo importu</label>';
		$contentMain .= '<input value="' . $form->page->import_id . '" readonly="readonly" class="textbox readonly form-control" type="text"></div>';
    
		$contentMain .='</div>';
    
    
		$contentMain .='<div class="col-sm-12">';

    $contentMain .= '<div class="form-group"><label for="code" class="control-label">Kategorie dodavatele</label>';
		$contentMain .= '<textarea readonly="readonly" class="textbox readonly form-control">' . $form->page->import_category . '</textarea></div>';
    
		$contentMain .='</div>';


 		$contentMain .='<div class="col-sm-3">';
		$contentMain .= '<div class="checkbox">' . $form->getElement("sync_not")->render() . '</div>';
		$contentMain .='</div>';
    

    
		$contentMain .='</div>';

		return $contentMain;

	}

	protected function CenikTab()
	{
		$form = $this->form;

		if (!$form->getElement("id")) {
			return $contentNastaveni;
		}

		$args = new ProductCenaListArgs();
		$args->product_id= $form->getElement("id")->getValue();
    
   // print_r($args);
		$DataGridProvider = new DataGridProvider("ProductCena",$args);
    $contentVarianty = $DataGridProvider->addButton("Přidat ceník", '/admin/product_ceny?do=ProductCenaCreate');
		$contentVarianty .= $DataGridProvider->ajaxtable();

		return $contentVarianty;

	}


	public function makeTabs($tabs = array()) {

		/*	$eshopSettings = G_EshopSetting::instance();

		   $tabs[] = array("name" => "Main", "title" => "Hlavní","content" => $this->MainTab() );
		   $tabs[] = array("name" => "Param", "title" => "Parametry","content" => $this->ParametryTab() );
		   $form = $this->form;
		   if ($form->getElement("id")) {

		   //	$tabs[] = array("name" => "Attrib", "title" => "Nastavení parametrů","content" => $this->NastaveniAtrtribTab() );
		   // TODO varianty na parametr v nastavení
		   if ($eshopSettings->get("PRODUCT_VARIANTY")=="1") {
		   $tabs[] = array("name" => "Varianty", "title" => "Varianty","content" => $this->VariantyTab() );
		   }

		   $tabs[] = array("name" => "Cenik", "title" => "Ceník","content" => $this->CenikTab() );

		   }*/
		return parent::makeTabs($tabs);
	}

}
<?php

class ProductTabs extends PageTabs {

	public function __construct($pageForm)
	{
		parent::__construct($pageForm,"Products");





		$form = $this->form;
		if ($form->getElement("id")) {

			//	$tabs[] = array("name" => "Attrib", "title" => "Nastavení parametrů","content" => $this->NastaveniAtrtribTab() );
			// TODO varianty na parametr v nastavení
			$eshopSettings = G_EshopSetting::instance();
			if ($eshopSettings->get("PRODUCT_VARIANTY")=="1") {
				$tab = array("name" => "Varianty", "title" => "Varianty","content" => $this->VariantyTab() );
				$this->addTab($tab,true);
			}

			$tab =  array("name" => "Cenik", "title" => "Ceník","content" => $this->CenikTab() );
			$this->addTab($tab,true);

		}
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
				$contentMain .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("title_$val->code")->render() . '</div>';
			}
		//	$contentMain .='<p class="desc">Výstižný název článku - Povinný údaj.</p>';
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

		$contentMain .='</fieldset>';


		$contentMain .='<fieldset class="well">';

		$contentMain .='<div class="row">';

			$contentMain .='<div class="col-sm-3">';
			$contentMain .= $form->getElement("qty")->render();
			$contentMain .='</div>';

			$contentMain .='<div class="col-sm-3">';
			$contentMain .= $form->getElement("hl_mj")->render();
			$contentMain .='</div>';

				$eshopSettings = G_EshopSetting::instance();
			if ($eshopSettings->get("PLATCE_DPH") == 0) {
				$contentMain .='<div class="col-sm-6">';
				$contentMain .= $form->getElement("prodcena_sdph")->render();
				$contentMain .='</div>';

			} else {
				if ($eshopSettings->get("PRICE_TAX") == 0) {

					$contentMain .='<div class="col-sm-6">';

					$contentMain .='<div class="col-sm-4">';
					$contentMain .= $form->getElement("prodcena")->render();
					$contentMain .='</div>';

					$contentMain .='<div class="col-sm-4">';
					$contentMain .= $form->getElement("dph_id")->render();
					$contentMain .='</div>';

					$contentMain .='<div class="col-sm-4">';
					$contentMain .= $form->getElement("prodcena_sdph")->render();
					$contentMain .='</div>';

					$contentMain .='</div>';


				} else {


					$contentMain .='<div class="col-sm-6">';

					$contentMain .='<div class="col-sm-4">';
					$contentMain .= $form->getElement("prodcena_sdph")->render();
					$contentMain .='</div>';

					$contentMain .='<div class="col-sm-4">';
					$contentMain .= $form->getElement("dph_id")->render();
					$contentMain .='</div>';

					$contentMain .='<div class="col-sm-4">';
					$contentMain .= $form->getElement("prodcena")->render();
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









		$contentMain .='<div class="row">';

			$contentMain .='<div class="col-sm-6">';
			$contentMain .= $form->getElement("category_id")->render();
			$contentMain .='</div>';

			$contentMain .='<div class="col-sm-6">';
			$contentMain .= $form->getElement("skupina_id")->render();
			$contentMain .='</div>';

		$contentMain .='</div>';






		$contentMain .='<div class="row">';

		$contentMain .='<div class="col-sm-4">';
		$contentMain .= $form->getElement("vyrobce_id")->render();
		$contentMain .='</div>';

		$contentMain .='<div class="col-sm-4">';
		$contentMain .= $form->getElement("dostupnost_id")->render();
		$contentMain .='</div>';

		$contentMain .='<div class="col-sm-4">';
		$contentMain .= $form->getElement("zaruka_id")->render();
		$contentMain .='</div>';

		$contentMain .='</div>';

		$contentMain .='<div class="row">';

		$contentMain .='<div class="col-sm-4">';
		$contentMain .= '<div class="checkbox">' . $form->getElement("aktivni")->render() . '</div>';
		$contentMain .='</div>';

		$contentMain .='<div class="col-sm-4">';
		$contentMain .= '<div class="checkbox">' . $form->getElement("bazar")->render() . '</div>';
		$contentMain .='</div>';

		$contentMain .='<div class="col-sm-4">';
		$contentMain .= '<div class="checkbox">' . $form->getElement("neexportovat")->render() . '</div>';
		$contentMain .='</div>';

		$contentMain .='</div>';






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


		$contentParametry .= $form->getElement("netto")->render() . '
		<p class="desc"></p><br />';


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
		for($i=0; $i<count($elements);$i++)
		{
			if (substr($elements[$i]->getName(),0,5) == "attr[") {
				$contentParametry .=$elements[$i]->render();
				$contentParametry .='<p class="desc"></p><br />';
			}

			if (substr($elements[$i]->getName(),0,10) == "attrOrder[") {
				$contentParametry .=$elements[$i]->render();
			//	$contentParametry .='<p class="desc"></p><br />';
			}

		}

		return $contentParametry;

	}

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

	}

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


	protected function CenikTab()
	{
		$form = $this->form;

		if (!$form->getElement("id")) {
			return $contentNastaveni;
		}

		$args = new ProductCenaListArgs();
		$args->product_id= $form->getElement("id")->getValue();
		$DataGridProvider = new DataGridProvider("ProductCena",$args);

		$contentVarianty = $DataGridProvider->table();

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
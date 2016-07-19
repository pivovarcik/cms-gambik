<?php

class CategoryTabs extends PageTabs {

	public function __construct($pageForm)
	{
		parent::__construct($pageForm,"Category");
		$tab = array("name" => "Main", "title" => "Hlavní","content" => $this->MainTab() );
		$this->addTab($tab,true);
	}


	protected function SeoTabs()
	{

		$contentSeo = parent::SeoTabs();

		$form = $this->form;

		$contentSeo .=$form->getElement("icon_class")->render();

		$contentSeo .= '<p class="desc"></p><br />';

		return $contentSeo;
	}


	protected function MainTab()
	{

		$form = $this->form;
		$languageList = $this->languageList;

		$contentMain = '';
		//	$contentMain = $form->getElement("cislo")->render() . '<p class="desc"></p><br />';

		$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
			$contentMain .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("title_$val->code")->render() . '</div>';
		}
		$contentMain .='<p class="desc">Výstižný název článku - Povinný údaj.</p>
		<br />';


		$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
			$contentMain .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("perex_$val->code")->render() . '</div>';

		}
		$contentMain .='<p class="desc"></p><br />';

		$contentMain .= $form->getElement("category_id")->render() . '
		<p class="desc"></p><br />';





		$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";$first = false;} else { $style="display:none;";}
			$contentMain .='<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("description_$val->code")->render() . '</div>';
		}
		$contentMain .='<p class="desc"></p><br />';

		return $contentMain;
	}


	public function makeTabs($tabs = array()) {

		//	parent::makeTabs

	//	$tabs[] = array("name" => "Main", "title" => "Hlavní","content" => $this->MainTab() );


		//	$tabs[] = array("name" => "Seo", "title" => "SEO","content" => $this->SeoTabs());
		$form = $this->form;
		if ($form->getElement("id")) {

			//	$tabs[] = array("name" => "Attrib", "title" => "Nastavení parametrů","content" => $this->NastaveniAtrtribTab() );
			//	$tabs[] = array("name" => "Varianty", "title" => "Varianty","content" => $this->VariantyTab() );
		}
		return parent::makeTabs($tabs);
	}

}
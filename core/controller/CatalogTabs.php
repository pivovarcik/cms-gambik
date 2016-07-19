<?php

class CatalogTabs extends PageTabs {

	public function __construct($pageForm,$entityName)
	{
		parent::__construct($pageForm,$entityName);
		$tab = array("name" => "Main", "title" => "Hlavní","content" => $this->MainTab() );
		$this->addTab($tab,true);

	}


	protected function MainTab()
	{

		$form = $this->form;
		$languageList = $this->languageList;

		$contentMain = '';
		$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";} else { $style="display:none;";}
			$contentMain .= '<div class="lang lang_' . $val->code . '" style="' . $style . '">' . $form->getElement("title_$val->code")->render() . '</div>';
			$first = false;}
		$contentMain .= '<p class="desc"></p><br />';

		/*
		   $first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";} else { $style="display:none;";}
		   $contentMain .= '<div class="lang lang_' . $val->code . '" style="' . $style . '">' . $form->getElement("perex_$val->code")->render() . '</div>';
		   $first = false;}
		   $contentMain .= '<p class="desc"></p><br />';
		*/
		$contentMain .= $form->getElement("status_id")->render();
		$contentMain .= '<p class="desc"></p><br />';

		/*	$contentMain .= $form->getElement("category_id")->render();
		   $contentMain .= '<p class="desc"></p><br />';*/
		$contentMain .= $form->getElement("address1")->render();
		$contentMain .= '<p class="desc"></p><br />';
		$contentMain .= '<div class="address_box">';
		$contentMain .=$form->getElement("city")->render() . $form->getElement("mesto_id")->render();
		$contentMain .= '<p class="desc"></p><br />';
		$contentMain .= '</div>';
		$contentMain .=$form->getElement("zip_code")->render();
		$contentMain .= '<p class="desc"></p><br />';
		$contentMain .=$form->getElement("telefon")->render();
		$contentMain .= '<p class="desc"></p><br />';
		$contentMain .=$form->getElement("email")->render();
		$contentMain .= '<p class="desc"></p><br />';

		$contentMain .=$form->getElement("www")->render();
		$contentMain .= '<p class="desc"></p><br />';



		$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";} else { $style="display:none;";}
			$contentMain .= '<div class="lang lang_' . $val->code . '" style="' . $style . '">' . $form->getElement("description_$val->code")->render() . '</div>';
			$first = false;}
		$contentMain .= '<p class="desc"></p><br />';

		return $contentMain;
	}



	protected function StatsTab()
	{
		$form = $this->form;
		$content ='<label>Link:</label><a href="' . $form->page->link . '" target="_blank">' . $form->page->link . ' </a>';
		$content .= '<p class="desc"></p><br />';

		$content .='<label>Vloženo:</label>' . date("j.n.Y H:i:s",strtotime($form->page->TimeStamp)) . ' ' . $form->page->user_add . '';
		$content .= '<p class="desc"></p><br />';

		$content .='<label>Poslední aktualizace:</label>' . date("j.n.Y H:i:s",strtotime($form->page->ChangeTimeStamp)) . ' ' . $form->page->user_edit . '';
		$content .= '<p class="desc"></p><br />';

		$content .='<label>Počet zobrazení:</label>' . $form->page->counter . '';
		$content .= '<p class="desc"></p><br />';

		$content .=$form->getElement("vlastnik_id")->render();
		$content .= '<p class="desc"></p><br />';
		$content .='<input type="submit" name="create_user_catalog" value="Vytvoř vlastníka">';

		return $content;

	}



	public function makeTabs($tabs = array()) {

		//	parent::makeTabs

	//	$tabs[] = array("name" => "Main", "title" => "Hlavní","content" => $this->MainTab() );


		//	$tabs[] = array("name" => "Program", "title" => "Služby","content" => $this->SluzbyTab() );
		//	$tabs[] = array("name" => "OpenDay", "title" => "Otevírací doba","content" => $this->OpenDayTab() );

		//	array_push($tabs, array("name" => "Fakturace", "title" => 'Fakturace',"content" => $this->FakturaceTab()));

		$form = $this->form;
		if ($form->getElement("id")) {

			$tabs[] = array("name" => "Stats", "title" => "Stats","content" => $this->StatsTab() );
		}
		return parent::makeTabs($tabs);
	}

}

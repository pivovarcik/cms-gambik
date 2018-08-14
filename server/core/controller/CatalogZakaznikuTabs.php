<?php

require_once("CatalogTabs.php");
class CatalogZakaznikuTabs extends CatalogTabs {
	public function __construct($pageForm)
	{
		parent::__construct($pageForm,"CatalogWeb");
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

		$contentMain .= $form->getElement("category_id")->render();
		$contentMain .= '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("status_id")->render();
		$contentMain .= '<p class="desc"></p><br />';

		$contentMain .= $form->getElement("ftp_server")->render();
		$contentMain .= '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("ftp_username")->render();
		$contentMain .= '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("ftp_password")->render();
		$contentMain .= '<p class="desc"></p><br />';


		$contentMain .= $form->getElement("db_server")->render();
		$contentMain .= '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("db_username")->render();
		$contentMain .= '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("db_password")->render();
		$contentMain .= '<p class="desc"></p><br />';


		$contentMain .= $form->getElement("db_name")->render();
		$contentMain .= '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("phpmyadmin")->render();
		$contentMain .= '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("web_created")->render();
		$contentMain .= '<p class="desc"></p><br />';

		$contentMain .= $form->getElement("cms_expired")->render();
		$contentMain .= '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("cms_licence_key")->render();
		$contentMain .= '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("cms_version")->render();
		$contentMain .= '<p class="desc"></p><br />';

		$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";} else { $style="display:none;";}
			$contentMain .= '<div class="lang lang_' . $val->code . '" style="' . $style . '">' . $form->getElement("description_$val->code")->render() . '</div>';
			$first = false;}
		$contentMain .= '<p class="desc"></p><br />';

		return $contentMain;
	}



	public function makeTabs($tabs = array()) {

		//	parent::makeTabs

		//	$tabs[] = array("name" => "Postava", "title" => "Postava","content" => $this->PostavaTab() );
		/*
		   $tabs[] = array("name" => "Main", "title" => "Hlavní","content" => $this->MainTab() );
		   $tabs[] = array("name" => "Postava", "title" => "Postava","content" => $this->PostavaTab() );
		   $tabs[] = array("name" => "Program", "title" => "Služby","content" => $this->SluzbyTab() );
		   $tabs[] = array("name" => "OpenDay", "title" => "Otevírací doba","content" => $this->OpenDayTab() );

		   array_push($tabs, array("name" => "Fakturace", "title" => 'Fakturace',"content" => $this->FakturaceTab()));

		   $form = $this->form;
		   if ($form->getElement("id")) {

		   $tabs[] = array("name" => "Stats", "title" => "Stats","content" => $this->StatsTab() );
		   }
		*/

		return parent::makeTabs($tabs);
	}


}

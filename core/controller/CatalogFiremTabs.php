<?php

require_once("CatalogTabs.php");
class CatalogFiremTabs extends CatalogTabs {

	public function __construct($pageForm)
	{
		parent::__construct($pageForm,"CatalogFirem");
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

		$contentMain .=$form->getElement("website")->render();
		$contentMain .= '<p class="desc"></p><br />';

		$contentMain .= $form->getElement("cenik_id")->render() . '
		<p class="desc"></p><br />';

		$first = true;foreach ($languageList as $key => $val){ if ($first) {$style="display:block;";} else { $style="display:none;";}
			$contentMain .= '<div class="lang lang_' . $val->code . '" style="' . $style . '">' . $form->getElement("description_$val->code")->render() . '</div>';
			$first = false;}
		$contentMain .= '<p class="desc"></p><br />';

		return $contentMain;
	}

	protected function SluzbyTab()
	{
		$form = $this->form;
		$contentSluzby ='<fieldset>';
		$contentSluzby .='<legend>Poskytované služby</legend>';

		$contentSluzby .='<div class="check-list">';
		$elements = $form->getElement();
		for($i=0; $i<count($elements);$i++)
		{
			if (substr($elements[$i]->getName(),0,8) == "program[") {
				$contentSluzby .='<div class="sluzba_item">';
				$contentSluzby .= $elements[$i]->render();
				$contentSluzby .='</div>';

			}
		}
		$contentSluzby .='</div>
		<div class="clearfix"> </div>';
		$contentSluzby .='</fieldset>';



		$contentSluzby .='<fieldset>';
		$contentSluzby .='<legend>Vybavení</legend>';

		$contentSluzby .='<div class="check-list">';
		$elements = $form->getElement();
		for($i=0; $i<count($elements);$i++)
		{
			if (substr($elements[$i]->getName(),0,9) == "vybaveni[") {
				$contentSluzby .='<div class="sluzba_item">';
				$contentSluzby .= $elements[$i]->render();
				$contentSluzby .='</div>';

			}
		}
		$contentSluzby .='</div>
		<div class="clearfix"> </div>';
		$contentSluzby .='</fieldset>';

		return $contentSluzby;

	}

	protected function OpenDayTab()
	{
		$form = $this->form;

		$contentOpenDay ='<fieldset>';
		$contentOpenDay .='<legend>Otevírací doba</legend>';
		$contentOpenDay .='<div class="clearfix"> </div>';
		$PoPaStart = $form->getElement("popa_start1")->render() . ":".$form->getElement("popa_start2")->render();
		$PoPaEnd = $form->getElement("popa_end1")->render() . ":".$form->getElement("popa_end2")->render();
		$UtStart = $form->getElement("ut_start1")->render() . ":".$form->getElement("ut_start2")->render();
		$UtEnd = $form->getElement("ut_end1")->render() . ":".$form->getElement("ut_end2")->render();
		$StStart = $form->getElement("st_start1")->render() . ":".$form->getElement("st_start2")->render();
		$StEnd = $form->getElement("st_end1")->render() . ":".$form->getElement("st_end2")->render();
		$CtStart = $form->getElement("ct_start1")->render() . ":".$form->getElement("ct_start2")->render();
		$CtEnd = $form->getElement("ct_end1")->render() . ":".$form->getElement("ct_end2")->render();
		$PaStart = $form->getElement("pa_start1")->render() . ":".$form->getElement("pa_start2")->render();
		$PaEnd = $form->getElement("pa_end1")->render() . ":".$form->getElement("pa_end2")->render();
		$SoNeStart = $form->getElement("sone_start1")->render() . ":".$form->getElement("sone_start2")->render();
		$SoNeEnd = $form->getElement("sone_end1")->render() . ":".$form->getElement("sone_end2")->render();
		$NeStart = $form->getElement("ne_start1")->render() . ":".$form->getElement("ne_start2")->render();
		$NeEnd = $form->getElement("ne_end1")->render() . ":".$form->getElement("ne_end2")->render();

		$contentOpenDay .= $PoPaStart . ' - ' . $PoPaEnd . ' <a onclick="OPnonstop(\'popa\');return false;" href="#">[Non-stop]</a> <a onclick="OPclose(\'popa\');return false;" href="#">[Zavřeno]</a>';
		$contentOpenDay .='<p class="note-input"></p>';
		$contentOpenDay .= $UtStart . ' - ' . $UtEnd . ' <a onclick="OPnonstop(\'ut\');return false;" href="#">[Non-stop]</a> <a onclick="OPclose(\'ut\');return false;" href="#">[Zavřeno]</a>';
		$contentOpenDay .='<p class="note-input"></p>';
		$contentOpenDay .= $StStart . ' - ' .  $StEnd . ' <a onclick="OPnonstop(\'st\');return false;" href="#">[Non-stop]</a> <a onclick="OPclose(\'st\');return false;" href="#">[Zavřeno]</a>';
		$contentOpenDay .='<p class="note-input"></p>';
		$contentOpenDay .= $CtStart . ' - ' . $CtEnd . ' <a onclick="OPnonstop(\'ct\');return false;" href="#">[Non-stop]</a> <a onclick="OPclose(\'ct\');return false;" href="#">[Zavřeno]</a>';
		$contentOpenDay .='<p class="note-input"></p>';
		$contentOpenDay .= $PaStart . ' - ' . $PaEnd . ' <a onclick="OPnonstop(\'pa\');return false;" href="#">[Non-stop]</a> <a onclick="OPclose(\'pa\');return false;" href="#">[Zavřeno]</a>';
		$contentOpenDay .='<p class="note-input"></p>';
		$contentOpenDay .= $SoNeStart . ' - ' . $SoNeEnd . ' <a onclick="OPnonstop(\'sone\');return false;" href="#">[Non-stop]</a> <a onclick="OPclose(\'sone\');return false;" href="#">[Zavřeno]</a>';
		$contentOpenDay .='<p class="note-input"></p>';
		$contentOpenDay .= $NeStart . ' - ' . $NeEnd . ' <a onclick="OPnonstop(\'ne\');return false;" href="#">[Non-stop]</a> <a onclick="OPclose(\'ne\');return false;" href="#">[Zavřeno]</a>';
		$contentOpenDay .='</fieldset>';

		return $contentOpenDay;

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

	protected function FakturaceTab()
	{

		$form = $this->form;
		$contentFakturace ='';

		$contentFakturace .='<fieldset>';
		$contentFakturace .='<legend>Faktuarční adresa</legend>';
		$contentFakturace .= $form->getElement("fnazev_firmy")->render();
		$contentFakturace .= '<p class="desc"></p><br />';
		$contentFakturace .= $form->getElement("address2")->render();
		$contentFakturace .= '<p class="desc"></p><br />';
		$contentFakturace .= $form->getElement("city2")->render();
		$contentFakturace .= '<p class="desc"></p><br />';
		$contentFakturace .= $form->getElement("zip_code2")->render();
		$contentFakturace .= '<p class="desc"></p><br />';
		$contentFakturace .= $form->getElement("femail")->render();
		$contentFakturace .= '<p class="desc"></p><br />';
		$contentFakturace .= $form->getElement("ftelefon")->render();
		$contentFakturace .= '<p class="desc"></p><br />';
		$contentFakturace .= $form->getElement("ico")->render();
		$contentFakturace .= '<p class="desc"></p><br />';
		$contentFakturace .= $form->getElement("dic")->render();
		$contentFakturace .= '<p class="desc"></p><br />';
		/*
		   $contentFakturace .= $form->getElement("firstname2")->render();
		   $contentFakturace .= '<p class="desc"></p><br />';
		   $contentFakturace .=$form->getElement("lastname2")->render();
		   $contentFakturace .= '<p class="desc"></p><br />';
		*/
		$contentFakturace .='</fieldset>';

		$contentFakturace .='<fieldset>';
		$contentFakturace .='<legend>Kontaktní údaje</legend>';

		$contentFakturace .= $form->getElement("firstname")->render();
		$contentFakturace .= '<p class="desc"></p><br />';
		$contentFakturace .=$form->getElement("lastname")->render();
		$contentFakturace .= '<p class="desc"></p><br />';


		$contentFakturace .='</fieldset>';

		$contentFakturace .='<fieldset>';
		$contentFakturace .='<legend>Interní informace</legend>';
		$contentFakturace .= $form->getElement("registrace")->render();
		$contentFakturace .= '<p class="desc"></p><br />';
		$contentFakturace .= $form->getElement("expirace")->render();
		$contentFakturace .= '<p class="desc"></p><br />';
		$contentFakturace .= $form->getElement("interni_poznamka")->render();
		$contentFakturace .= '<p class="desc"></p><br />';
		$contentFakturace .='</fieldset>';
		return $contentFakturace;
	}

	public function makeTabs($tabs = array()) {

		//	parent::makeTabs

		//	$tabs[] = array("name" => "Main", "title" => "Hlavní","content" => $this->MainTab() );

		/*	$tabs[] = array("name" => "Program", "title" => "Služby","content" => $this->SluzbyTab() );
		   $tabs[] = array("name" => "OpenDay", "title" => "Otevírací doba","content" => $this->OpenDayTab() );

		   array_push($tabs, array("name" => "Fakturace", "title" => 'Fakturace',"content" => $this->FakturaceTab()));

		   $form = $this->form;
		   if ($form->getElement("id")) {

		   $tabs[] = array("name" => "Stats", "title" => "Stats","content" => $this->StatsTab() );
		   }*/
		return parent::makeTabs($tabs);
	}

}


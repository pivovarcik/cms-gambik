<?php

class PublishTabs extends PageTabs {

	public function __construct($pageForm)
	{
		parent::__construct($pageForm,"Publish");
		$tab = array("name" => "Main", "title" => "Hlavní","content" => $this->MainTab() );
		$this->addTab($tab,true);
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



		$contentMain .= $form->getElement("public_date")->render();
		$contentMain .='<p class="desc"></p><br />';

		$contentMain .= $form->getElement("public_date_end")->render();
		$contentMain .='<p class="desc">Vyplňte pouze pokud chcete datumově omezit zobrazení příspěvky. Časová platnost od-do</p><br />';

		$contentMain .= $form->getElement("logo_url")->render();
		$contentMain .='<p class="desc"></p><br />';

		return $contentMain;
	}



	protected function NewsletterTab()
	{

		$form = $this->form;

		$contentMain .= '<input class="textbox" type="email" name="email_test" value="" />';
		$contentMain .='<p class="desc"></p><br />';

		$contentMain .= '<button class="btn btn-sm btn-default" type="submit" name="send_newsletter_test">Odeslat testovací newsletter</button>';
		$contentMain .='<p class="desc"></p><br />';

		$contentMain .= '<button class="btn btn-sm btn-warning" type="submit" name="send_newsletter">Odeslat newsletter</button>';
		$contentMain .='<p class="desc"></p><br />';



		return $contentMain;
	}

	public function makeTabs($tabs = array()) {

		//	parent::makeTabs

	//	$tabs[] = array("name" => "Main", "title" => "Hlavní","content" => $this->MainTab() );

		array_push($tabs, array("name" => "Newsletter", "title" => "Newsletter","content" => $this->NewsletterTab() ));

		//	$form = $this->form;
		return parent::makeTabs($tabs);
	}
}
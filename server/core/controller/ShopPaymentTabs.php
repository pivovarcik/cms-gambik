<?php



class ShopPaymentTabs extends G_Tabs {

	protected $form;
	protected $languageList;
	protected $entityName;
	protected $paymentList = array();
	public function __construct($pageForm, $entityName=null)
	{

		$this->form = $pageForm;

		$this->entityName = $entityName;
		$languageModel = new models_Language();
		$this->languageList = $languageModel->getActiveLanguage();





	}

	protected function MainTabs()
	{

		$contentSeo = '';
		$form = $this->form;
		$languageList = $this->languageList;
		// Verzování dle jazyků
		$first = true;
		foreach ($languageList as $key => $val)
		{
			$style = ($first) ? "display:block;" : "display:none;";$first = false;
			$contentSeo .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("name_$val->code")->render() . '</div>';
		}
		if ($form->getElement("id")) {
			$contentSeo .=$form->getElement("id")->render();
		}

		$contentSeo .= '<p class="desc"></p><br />';


		$first = true;
		foreach ($languageList as $key => $val)
		{
			$style = ($first) ? "display:block;" : "display:none;";$first = false;
			$contentSeo .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("description_$val->code")->render() . '</div>';
		}
		$contentSeo .= '<p class="desc"></p><br />';


		$contentSeo .= $form->getElement("brana")->render();
		$contentSeo .= $form->getElement("aktivni")->render();
		$contentSeo .= '<p class="desc"></p><br />';

		$contentSeo .= $form->getElement("order")->render();
		$contentSeo .= '<p class="desc"></p><br />';

		if ($form->getElement("id")) {
			$contentSeo .= $form->getElement("id")->render();
		}
		return $contentSeo;

	}


	public function makeTabs($tabs = array()) {
		array_push($tabs, array("name" => "Main", "title" => 'Hlavní',"content" => $this->MainTabs()));
		return parent::makeTabs($tabs);
	}
}
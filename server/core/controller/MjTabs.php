<?php
/*class MjTabs extends CiselnikTabs {

}
       */
class MjTabs extends G_Tabs {

	protected $form;
	protected $languageList;
	protected $entityName;
	protected $paymentList = array();
	public function __construct($pageForm)
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



		$contentSeo .= '<div class="row">';
		$contentSeo .= '<div class="col-xs-12">';
//		$contentSeo .= $form->getElement("keyword")->render();
		$contentSeo .= '</div>';
		$contentSeo .= '</div>';

		$contentSeo .= '<div class="row">';
		$contentSeo .= '<div class="col-xs-12">';
				$first = true;
		foreach ($languageList as $key => $val)
		{

			$style = ($first) ? "display:block;" : "display:none;";$first = false;
			$contentSeo .= '<div class="lang lang_' .$val->code. '" style="' .$style. '">' . $form->getElement("name_$val->code")->render() . '</div>';
		}

		$contentSeo .= '</div>';
		$contentSeo .= '</div>';
		if ($form->getElement("id")) {
			$contentSeo .=$form->getElement("id")->render();
		}
		return $contentSeo;

	}


	public function makeTabs($tabs = array()) {
		array_push($tabs, array("name" => "Main", "title" => 'Hlavní',"content" => $this->MainTabs()));
		return parent::makeTabs($tabs);
	}

}
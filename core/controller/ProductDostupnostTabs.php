<?php


class ProductDostupnostTabs extends CiselnikTabs {


	public function __construct($pageForm)
	{

		$this->form = $pageForm;
		//	$form = new Application_Form_CategoryEdit();

		//	$languageModel = new models_Language();
		//	$this->languageList = $languageModel->getActiveLanguage();
	}

	protected function MainTabs()
	{


		$form = $this->form;

		//	print_r($form);
		$contentMain = parent::MainTabs();

		//	print "tudy";

		$contentMain .= $form->getElement("hodiny")->render() . '<p class="desc"></p><br />';
		return $contentMain;
	}


	public function makeTabs($tabs = array()) {
		//	array_push($tabs, array("name" => "Main", "title" => 'Hlavní',"content" => $this->MainTabs()));
		return parent::makeTabs($tabs);
	}

}
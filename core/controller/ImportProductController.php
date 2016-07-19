<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */

/**
 *
 *
 */


class ImportProductSettingTabs extends CiselnikTabs {


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

		$contentMain .= $form->getElement("url")->render() . '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("deactive_product")->render() . '<p class="desc">Produkty v databázi před natažením deaktivovat?</p><br />';
		$contentMain .= $form->getElement("import_product_is_active")->render() . '<p class="desc">Importované produkty označit jako aktivní?.</p><br />';
		$contentMain .= $form->getElement("import_images")->render() . '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("nextid_product")->render() . '<p class="desc"></p><br />';
		$contentMain .= $form->getElement("block_size")->render() . '<p class="desc"></p><br />';

		$contentMain .= '<a href="/export/import_xml.php" target="_blank" class="desc">import</a>';

		return $contentMain;
	}


	public function makeTabs($tabs = array()) {
		//	array_push($tabs, array("name" => "Main", "title" => 'Hlavní',"content" => $this->MainTabs()));
		return parent::makeTabs($tabs);
	}

}

class ImportProductController extends CiselnikBase
{
	function __construct()
	{
		parent::__construct("ImportProductSetting");
	}
}
?>
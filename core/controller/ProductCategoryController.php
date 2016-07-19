<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */


class ProductCategoryTabs extends CiselnikTabs {


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

		$contentMain .= $form->getElement("cenik_id")->render() . '<p class="desc"></p><br />';
		return $contentMain;
	}


	public function makeTabs($tabs = array()) {
		//	array_push($tabs, array("name" => "Main", "title" => 'Hlavní',"content" => $this->MainTabs()));
		return parent::makeTabs($tabs);
	}

}

class ProductCategoryController extends CiselnikBase
{

	function __construct()
	{
		parent::__construct("ProductCategory");
	}
	public function categoryList($params = array())
	{
		return parent::ciselnikList($params);
	}

}
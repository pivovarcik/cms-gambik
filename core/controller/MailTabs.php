<?php

class MailTabs extends G_Tabs {

	protected $form;
	protected $entityName;
	public function __construct($pageForm)
	{

		$this->form = $pageForm;
		//	$form = new Application_Form_CategoryEdit();
		$this->entityName = "Mail";
	}

	protected function MainTabs()
	{
		$form = $this->form;
		$contentMain ='';
		$contentMain .=$form->getElement("adresat_id")->render();
		$contentMain .='<p class="desc"></p><br />';
		$contentMain .=$form->getElement("subject")->render();
		$contentMain .='<p class="desc"></p><br />';
		$contentMain .=$form->getElement("description")->render();
		$contentMain .='<p class="desc"></p><br />';
		return $contentMain;

	}

	public function makeTabs($tabs = array()) {


		array_push($tabs, array("name" => "Main", "title" => 'Obecné',"content" => $this->MainTabs()));
		return parent::makeTabs($tabs);
	}

}
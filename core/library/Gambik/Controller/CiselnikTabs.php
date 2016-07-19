<?php
require_once(dirname(__FILE__).'/../G_Tabs.php');
class CiselnikTabs extends G_Tabs {

	protected $form;
	public function __construct($cislnikForm)
	{

		$this->form = $cislnikForm;
	}

	protected function MainTabs()
	{
		$form = $this->form;

		$contentMain = '';
		$contentMain .= $form->getElement("name")->render();
		$contentMain .='<p class="desc"></p><br />';

		$contentMain .= $form->getElement("parent")->render();
		$contentMain .='<p class="desc"></p><br />';

		$contentMain .= $form->getElement("description")->render();

		if ($form->getElement("id") !== false) {
			$contentMain .= $form->getElement("id")->render();
		}

		if ($form->getElement("action") !== false) {
			$contentMain .= $form->getElement("action")->render();
		}

		$contentMain .='<p class="desc"></p><br />';
		return $contentMain;
	}

	public function makeTabs($tabs = array()) {
		// nastavení aby byla vždy první !!!
		array_unshift($tabs, array("name" => "Main", "title" => 'Obecné',"content" => $this->MainTabs()));
		return parent::makeTabs($tabs);
	}
}
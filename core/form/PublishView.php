<?php


class PublishCreateViewModel extends PageViewModel {


	protected function load()
	{
		parent::load();

		$this->pagetitle = "Nový článek";
		$this->form = new Application_Form_PublishPostCreate();

		$tabs = new PublishTabs($this->form);
		$this->body = $tabs->makeTabs();
	}

}

class PublishEditViewModel extends PageViewModel {


	protected function load()
	{
		parent::load();

		$this->pagetitle = "Editace článku";
		$this->form = new Application_Form_PublishPostEdit();

		$tabs = new PublishTabs($this->form);
		$this->body = $tabs->makeTabs();
	}

}

?>
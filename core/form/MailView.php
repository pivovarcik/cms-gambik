<?php



class MailCreateViewModel extends PageViewModel {


	protected function load()
	{
		parent::load();

		$this->pagetitle = "Nový email";
		$this->form = new Application_Form_MailCreate();

		$tabs = new MailTabs($this->form);
		$this->body = $tabs->makeTabs();
	}

}

class MailEditViewModel extends PageViewModel {


	protected function load()
	{
		parent::load();

		$this->pagetitle = "Editace emailu";
		$this->form = new Application_Form_MailEdit();

		$tabs = new MailTabs($this->form);
		$this->body = $tabs->makeTabs();
	}

}

?>
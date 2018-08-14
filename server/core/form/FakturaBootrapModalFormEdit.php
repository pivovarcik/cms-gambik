<?php


require_once("DokladBootrapModalForm.php");
class FakturaBootrapModalFormEdit extends DokladBootrapModalForm {

	public function __construct()
	{
		parent::__construct("F_FakturaEdit");
		$this->setBody();
	}

	public function setBody($body = '')
	{
		$form = $this->form;

		$GTabs = new FakturaTabs($form);
		$body = $GTabs->makeTabs();


		$body .= $form->getElement("action")->render();


		parent::setBody($body);

	}
}
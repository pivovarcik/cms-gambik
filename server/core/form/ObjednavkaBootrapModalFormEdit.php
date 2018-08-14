<?php


require_once("DokladBootrapModalForm.php");
class ObjednavkaBootrapModalFormEdit extends DokladBootrapModalForm {

	public function __construct()
	{
		parent::__construct("F_ObjednavkaEdit");
		$this->setBody();
	}


	public function setBody($body = '')
	{
		$form = $this->form;

		$GTabs = new ObjednavkaTabs($form);
		$body = $GTabs->makeTabs();


		$body .= $form->getElement("action")->render();


		parent::setBody($body);

	}

}
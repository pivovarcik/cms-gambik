<?php
abstract class UserBootrapModalForm extends BootrapModalForm {

	public $form = null;
	public function __construct($formName)
	{

		//	$formName = "Application_Form_CarReserveEdit";

		$this->form = new $formName();

		parent::__construct("myModal",$this->form , "medium");
	}

	public function setBody($body = '')
	{
		$form = $this->form;

		$GTabs = new UserTabs($form);
		$body = $GTabs->makeTabs();


		$body .= $form->getElement("action")->render();


		parent::setBody($body);

	}
}
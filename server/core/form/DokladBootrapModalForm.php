<?php


abstract class DokladBootrapModalForm extends BootrapModalForm {

	public $form = null;
	public function __construct($formName)
	{

		$this->form = new $formName();


		parent::__construct("myModal",$this->form , "medium");
	}


}
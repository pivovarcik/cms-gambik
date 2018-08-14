<?php

require_once("NextIdForm.php");
class F_NextIdCreate extends NextIdForm
{

	public $formName = "Nová číselná řada";

	public $submitButtonName = "ins_nextid";
	public $submitButtonTitle = "Přidej";

	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{
		parent::loadElements();
		$elem = new G_Form_Element_Button("ins_nextid");
		$elem->setAttribs('value','Přidej');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

	}
}
<?php
/**
 * Třída pro přidání nového hitu
 * */
//require_once("CiselnikForm.php");
require_once(PATH_ROOT . "core/form/CiselnikForm.php");
class MJForm extends CiselnikForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct("models_Mj");

	}
	public function loadElements()
	{
		parent::loadElements();


		$page = $this->page;
	}
}
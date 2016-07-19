<?php
/**
 * Společný předek pro formuláře typu Objednávka
 * */

require_once(PATH_ROOT . "core/form/RadekDokladuForm.php");
class RadekObjednavkyForm extends RadekDokladuForm
{

	function __construct()
	{
		//parent::__construct("models_OrderDetails");
		parent::__construct("RadekObjednavkyEntity");
	}

}
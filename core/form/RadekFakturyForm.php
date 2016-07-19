<?php
/**
 * Společný předek pro formuláře typu Faktura
 * */
require_once(PATH_ROOT . "core/form/RadekDokladuForm.php");
class RadekFakturyForm extends RadekDokladuForm
{

	function __construct()
	{
		parent::__construct("RadekFakturyEntity");
	}

}
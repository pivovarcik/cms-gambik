<?php
/**
 * Třída pro přidání nového hitu
 * */
//require_once("CiselnikForm.php");
require_once(PATH_ROOT . "core/form/CiselnikForm.php");
abstract class ProductZarukaForm extends CiselnikForm
{

	function __construct()
	{
		// Typ Page
		parent::__construct("models_ProductZaruka");

	}

}
<?php
/**
 * Třída pro přidání nového žádanky
 * */
require_once("RadekFakturyForm.php");
class Application_Form_RadekFakturyEdit extends RadekFakturyForm
{

	function __construct()
	{
		parent::__construct();
		$this->init();
	}

	public function init()
	{

		$id = (int) $this->Request->getQuery("id",null);
		$this->loadPage($id);
		$this->loadElements();
		$doklad = $this->doklad;
	}
}
<?php
/**
 * Třída pro přidání nového žádanky
 * */
require_once("RadekObjednavkyForm.php");
class F_RadekObjednavkyEdit extends RadekObjednavkyForm
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
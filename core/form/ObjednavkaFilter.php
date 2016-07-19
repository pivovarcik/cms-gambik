<?php
/**
 * Filter pro produkty
 * */
require_once("DokladFilter.php");
class ObjednavkaFilter extends DokladFilter
{

	function __construct()
	{
		parent::__construct(true);
		$this->init();
	}

/*	public function loadModel()
	{
		parent::loadModel();
	}
	public function init()
	{
		$this->loadModel();
		parent::init();
	}*/
}
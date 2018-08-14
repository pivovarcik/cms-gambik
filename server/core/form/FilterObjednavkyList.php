<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("FilterList.php");
class F_FilterObjednavkyList extends F_FilterList
{

	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{
		parent::init();

		$stavyList = array( 0 => "Vše", 1 => "Přijatá", 2 => "Vyexpedovaná", 3 => "Vyřizuje se", "Vyřízená");

		$elem = new G_Form_Element_Select("status");
		$elem->setAttribs('class','selectbox');
		//$elem->setAttribs(array("id"=>"cat","required"=>false));
		$value = $this->Request->getQuery("status", 0);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('onchange',"document.location.href='".AKT_PAGE."?status='+this.value");
		$pole = array();
		foreach ($stavyList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);
	}
}
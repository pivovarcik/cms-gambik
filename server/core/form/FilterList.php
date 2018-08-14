<?php
/**
 * Třída pro přidání nového hitu
 * */

require_once("ListFilter.php");
class F_FilterList extends ListFilter
{

	function __construct()
	{
		// anonymní předání
		parent::__construct(true);
		$this->init();
	}
	public function init()
	{
		parent::init();
		$elem = new G_Form_Element_Text("q");
		$value = $this->Request->getQuery("q", "");
		$elem->setAttribs('class','textbox');
		$elem->setAttribs('placeholder','Fultextové vyhledávání');
		$elem->setAttribs('value',$value);
		$elem->setAttribs('style','width:300px;');
		$this->addElement($elem);


		$limitList = array(25,50,100,200,500,1000);

		$name="limit";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs('class','selectbox');
		//$elem->setAttribs(array("id"=>"cat","required"=>false));
		$value = $this->Request->getQuery($name, DEFAULT_LIMIT);

	//	PRINT $value . "<BR />";
		$elem->setAttribs('value',$value);
		$elem->setAttribs('onchange',"document.location.href='".AKT_PAGE."?{$name}='+this.value");
		$pole = array();
		foreach ($limitList as $key => $value)
		{
			$pole[$value] = $value;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);

		$elem = new G_Form_Element_Button("s");
		$elem->setAttribs('value','Hledej');
		$elem->setAttribs('class','tlac');

		//$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

	}
}
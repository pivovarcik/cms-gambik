<?php
/**
 * Třída pro filtrování produktů
 * */
require_once("ListFilter.php");
class Application_Form_ProductsListFilter extends ListFilter
{

	function __construct()
	{
		parent::__construct();
		$this->loadModel();
		$this->init();
	}
	public function init()
	{
		parent::init();
		$translator = G_Translator::instance();

		$registerQuery = array("lowestPrice","highestPrice","df","dt","stav","q","str","user","pg","limit",
		"car","typecar","motorcar","prumer","tree","vyr","sirka", "profil","atr","sort","order");



		$orderlist = array("title" => $translator->prelozitFrazy("Názvu"), "prodcena" => $translator->prelozitFrazy("Ceny"), "nazev_vyrobce" => $translator->prelozitFrazy("Výrobce"));
		$name = "order";
		$elem = new G_Form_Element_Select($name);
		//$elem->setAttribs('class','selectbox');
		$elem->setAttribs(array(
				"id" => "orderFilter",
				"class" => "selectbox",
				));
		if (false !== ($this->Request->getQuery($name, false))) {
			$this->Request->setCookie($name,$this->Request->getQuery($name, ""));
		}
		$value = $this->Request->getQuery($name, $this->Request->getCookie($name, ""));
		$elem->setAttribs('value',$value);
	//	$elem->setAttribs('onchange','document.location.href=\'' . AKT_PAGE ."?" . $name . "='+this.value+'" . queryBuilder($name,$registerQuery) . '\'');
		//$elem->setAttribs('label','řadit dle:');

		$elem->setDecoration();
		$pole = array();
		$attrib = array();
		foreach ($orderlist as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$name = "lowestPrice";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs('id',$name);

		// ukládám si filtr do Relace
		if (false !== ($this->Request->getQuery($name, false))) {
			$this->Request->setSession($name,$this->Request->getQuery($name, ""));
		}
		$value = $this->Request->getQuery($name, $this->Request->getSession($name, ""));
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Od:');
		$this->addElement($elem);

		$name = "highestPrice";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs('id',$name);

		// ukládám si filtr do Relace
		if (false !== ($this->Request->getQuery($name, false))) {
			$this->Request->setSession($name,$this->Request->getQuery($name, ""));
		}
		$value = $this->Request->getQuery($name, $this->Request->getSession($name, ""));
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Do:');
		$this->addElement($elem);

		$name = "s";
		$elem = new G_Form_Element_Button($name);
		$elem->setAttribs('value','Hledat');
		$this->addElement($elem);

	}
}
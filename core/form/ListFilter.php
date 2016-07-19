<?php
/**
 * Třída pro přidání nového hitu
 * */
class ListFilter extends G_Form
{

	public $registerQuery = array();
	public $limity = array();
	public $sortlist = array();
	public $orderlist = array();
	function __construct()
	{
		parent::__construct(true);
		//$this->init();
	}


	public function loadModel()
	{
		$translator = G_Translator::instance();
		$this->registerQuery = array("lowestPrice","highestPrice","df","dt","stav","q","str","user","pg","limit",
		"car","typecar","motorcar","prumer","tree","vyr","sirka", "profil","atr","sort","order");

		$this->limity = array("8","16","32","64","100","200");

		$this->sortlist = array("asc" => $translator->prelozitFrazy("trideni_vzestupne"),
					"desc" => $translator->prelozitFrazy("trideni_sestupne"));

		$this->orderlist = array("name" => "Názvu", "price" => "Ceny", "producer" => "Výrobce");
	}
	public function init()
	{



		$name = "limit";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array(
								"id" => "LimitFilter",
								"class" => "selectbox"));

		if (false !== ($this->Request->getQuery($name, false))) {
			$this->Request->setCookie($name,$this->Request->getQuery($name, ""));
		}
		$value = $this->Request->getQuery($name, $this->Request->getCookie($name, ""));
		$elem->setAttribs('value',$value);
		$elem->setDecoration();
		//print $value;
	//	$elem->setAttribs('onchange','document.location.href=\'' . AKT_PAGE ."?" . $name . "='+this.value+'" . queryBuilder($name,$this->registerQuery) . '\'');
		//$elem->setAttribs('label','Typ podniku:');
		$pole = array();
		$attrib = array();
		foreach ($this->limity as $key => $value)
		{
			$pole[$value] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		/**
		 * Řazení podle položky
		 **/
		$name = "order";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array(
				"id" => "orderFilter",
				"class" => "selectbox",
				));
		if (false !== ($this->Request->getQuery($name, false))) {
			$this->Request->setCookie($name,$this->Request->getQuery($name, ""));
		}
		$value = $this->Request->getQuery($name, $this->Request->getCookie($name, ""));
		$elem->setAttribs('value',$value);
		$elem->setDecoration();
	//	$elem->setAttribs('onchange','document.location.href=\'' . AKT_PAGE ."?" . $name . "='+this.value+'" . queryBuilder($name,$this->registerQuery) . '\'');
		//$elem->setAttribs('label','řadit dle:');
		$pole = array();
		$attrib = array();
		foreach ($this->orderlist as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		/**
		 * Způsob třídění
		 **/

		$name = "sort";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array(
				"id" => "sortFilter",
				"class" => "selectbox",
				));
		if (false !== ($this->Request->getQuery($name, false))) {
			$this->Request->setCookie($name,$this->Request->getQuery($name, ""));
		}
		$value = $this->Request->getQuery($name, $this->Request->getCookie($name, ""));

		$elem->setDecoration();
		$elem->setAttribs('value',$value);
		$elem->setDecoration();
	//	$elem->setAttribs('onchange','document.location.href=\'' . AKT_PAGE ."?" . $name . "='+this.value+'" . queryBuilder($name,$this->registerQuery) . '\'');
		//$elem->setAttribs('label','řadit dle:');
		$pole = array();
		$attrib = array();
		foreach ($this->sortlist as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		//"3" => "Částečně schválená",
		$aktivnilist = array ( "0"=> "Neaktivní", "1" => "Aktivní");
		$elem = new G_Form_Element_Select("status");
		$elem->setAttribs(array(
				"id" => "aktivniFilter",
				"class" => "selectbox",
				"style" => "width:100px;",
				));
		$value = $this->Request->getQuery("status", 1);
		//print "Hodnota".$value;
		$elem->setAttribs('value',$value);
		$elem->setAttribs('onchange','document.location.href=\'' . AKT_PAGE ."?status='+this.value+'" . queryBuilder("status",$this->registerQuery) . '\'');

		$pole = array();
		$attrib = array();
		foreach ($aktivnilist as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);




		$elem = new G_Form_Element_Text("df");
		$elem->setAttribs(array(
						"class" => "date form_edit date_from",
						"style" => "width: 65px;",
						));
		$value = $this->Request->getQuery("df", "");
		$value = !empty($value) ? $value : (defined("FILTER_FROM_DATE") ? FILTER_FROM_DATE : "");
		$elem->setAttribs('value',$value);
		$this->addElement($elem);


		$elem = new G_Form_Element_Text("dt");
		$elem->setAttribs(array(
				"class" => "date form_edit date_to",
				"style" => "width: 65px;",
				));
		$value = $this->Request->getQuery("dt", "");
		$value = !empty($value) ? $value :  (defined("FILTER_TO_DATE") ? FILTER_TO_DATE : "");
		$elem->setAttribs('value',$value);
		$this->addElement($elem);


		$elem = new G_Form_Element_Text("q");
		$elem->setAttribs(array(
		"class" => "textbox",
		"style" => "width: 185px;",
		));
		$value = $this->Request->getQuery("q", "");
		//$value = !empty($value) ? $value : FILTER_TO_DATE;
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

	}
}
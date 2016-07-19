<?php
/**
 * Společný předek pro formuláře typu Faktura
 * */

// TODO měla by být abstaktní třída

require_once(PATH_ROOT . "core/form/RadekForm.php");
class RadekDokladuForm extends RadekForm
{
	function __construct($TEntity)
	{

		if ( !is_subclass_of($TEntity,"RadekDokladuEntity")) {
			throw new Exception('Prvek musi byt typu RadekDokladuEntity!');
		}
		$this->pocet_prazdnych_radku = 1;
		parent::__construct($TEntity);
	}


	// načte datový model
	public function loadPage($doklad_id = null)
	{

		parent::loadPage($doklad_id);

	//	print_r($this->radky);
		// Dopočítávání celkové částky na řádku
		for ($i=0;$i < count($this->radky);$i++)
		{
			$this->radky[$i]->celkem = strToNumeric($this->radky[$i]->price) * strToNumeric($this->radky[$i]->qty);
		}


	}
	/**
	 * Sestaví z entit formulářové prvky pro interpretaci v gridu
	 * */
	public function loadElements()
	{

		parent::loadElements();

		$radek = $this->radky;

		$eshopController = new EshopController();
		$dph_model = new models_Dph();
		$params = new ListArgs();
		$params->platne = date("Ymd");
		$dphList = $dph_model->getList($params);

		$mj_model = new models_Mj();
		$mjList = $mj_model->getList();



		$druhSlevyList = array("%","");

		$radek = $this->getEntity();
		for ($i=0;$i < count($radek);$i++)
		{
			$name = "mj_id";
			$elem= new G_Form_Element_Select($name."[]");
			$value = $this->getPost($name."[".$i."]", $radek[$i]->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('onblur','prepocti_cenu2();');
			$elem->setAttribs('class',$name);
			if ($this->mode == "readonly") {
				$elem->setAttribs('readonly','readonly');
				$elem->setAttribs('disabled','disabled');
			}
			$elem->setDecoration();
			$pole = array();
			//$pole[0] = " -- neuveden -- ";
			$attrib = array();
			foreach ($mjList as $key => $value)
			{
				$pole[$value->id] = $value->name;
			}
			$elem->setMultiOptions($pole,$attrib);
			$this->addElement($elem);
			//$radek[$i]->mj = $elem->render();
			$this->radky[$i]->mj = $elem->render();

			$name = "product_description";
			$elem2= new G_Form_Element_Text($name."[]");
			$value = $this->getPost($name."[".$i."]", $radek[$i]->$name);
			$elem2->setAttribs('value',$value);
			$elem2->setAttribs('class',$name);
			$elem2->setAttribs('style','text-align:left');
			if ($this->mode == "readonly") {
				$elem2->setAttribs('readonly','readonly');
				$elem2->setAttribs('disabled','disabled');
			}
			$elem2->setDecoration();
			$this->addElement($elem2);/**/

			$name = "product_name";
			$elem= new G_Form_Element_Text($name."[]");
			$value = $this->getPost($name."[".$i."]", $radek[$i]->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class',$name);
			$elem->setAttribs('style','text-align:left');
			if ($this->mode == "readonly") {
				$elem->setAttribs('readonly','readonly');
				$elem->setAttribs('disabled','disabled');
			}
			$elem->setDecoration();
			$this->addElement($elem);
			$this->radky[$i]->product_name = $elem->render() . $elem2->render();

			$name = "product_code";
			$elem= new G_Form_Element_Text($name."[]");
			$value = $this->getPost($name."[".$i."]", $radek[$i]->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class',$name);
			$elem->setAttribs('style','text-align:left');
			if ($this->mode == "readonly") {
				$elem->setAttribs('readonly','readonly');
				$elem->setAttribs('disabled','disabled');
			}
			$elem->setDecoration();
			$this->addElement($elem);
			$this->radky[$i]->product_code = $elem->render();


			$name = "typ_slevy";
			$elem= new G_Form_Element_Select($name."[]");
			$value = $this->getPost($name."[".$i."]", $radek[$i]->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class',$name);
			if ($this->mode == "readonly") {
				$elem->setAttribs('readonly','readonly');
				$elem->setAttribs('disabled','disabled');
			}
			$elem->setDecoration();
			$elem->setAttribs('onchange','prepocti_cenu2();');

			//	print_r($dphList);
			$pole = array();
			//$pole[0] = " -- neuveden -- ";
			$attrib = array();
			foreach ($druhSlevyList as $key => $value)
			{
				$pole[$value] = $value;
			}
			$elem->setMultiOptions($pole,$attrib);
			$this->addElement($elem);
			$this->radky[$i]->$name = $elem->render();

			$name = "tax_id";
			$elem= new G_Form_Element_Select($name."[]");
			$value = $this->getPost($name."[".$i."]", $radek[$i]->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class',$name);
			if ($this->mode == "readonly") {
				$elem->setAttribs('readonly','readonly');
				$elem->setAttribs('disabled','disabled');
			}
			$elem->setDecoration();
			$elem->setAttribs('onchange','prepocti_cenu2();');

			if ($eshopController->setting["PLATCE_DPH"] == "0") {
				$elem->setAttribs('disabled','disabled');
			}

		//	print_r($dphList);
			$pole = array();
			//$pole[0] = " -- neuveden -- ";
			$attrib = array();
			foreach ($dphList as $key => $value)
			{
				$pole[$value->id] = $value->name;
			}
			$elem->setMultiOptions($pole,$attrib);
			$this->addElement($elem);
		//	$radek[$i]->tax = $elem->render();
			$this->radky[$i]->tax = $elem->render() . $this->radky[$i]->typ_slevy;



			$name = "sleva";
			$elem= new G_Form_Element_Text($name."[]");
			$value = $this->getPost($name."[".$i."]", $radek[$i]->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class',$name);
			$elem->setAttribs('is_numeric','true');
			$elem->setAttribs('style','text-align:right');
			$elem->setAttribs('onblur','prepocti_cenu2();');
			if ($this->mode == "readonly") {
				$elem->setAttribs('readonly','readonly');
				$elem->setAttribs('disabled','disabled');
			}
			$elem->setDecoration();
			$this->addElement($elem);
			$this->radky[$i]->sleva = $elem->render();

			$name = "price";
			$elem= new G_Form_Element_Text($name."[]");
			$value = $this->getPost($name."[".$i."]", $radek[$i]->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class',$name);
			$elem->setAttribs('style','text-align:right;');
			$elem->setAttribs('is_money','true');
			$elem->setAttribs('onblur','prepocti_cenu2();');
			if ($this->mode == "readonly") {
				$elem->setAttribs('readonly','readonly');
				$elem->setAttribs('disabled','disabled');
			}
			$elem->setDecoration();
			$this->addElement($elem);
			$this->radky[$i]->price = $elem->render() . $this->radky[$i]->sleva;

			$name = "celkem";
			$elem= new G_Form_Element_Text($name."[]");
			$value = $this->getPost($name."[".$i."]", $radek[$i]->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class',$name);
			$elem->setAttribs('readonly','readonly');
			$elem->setAttribs('style','text-align:right;');
			$elem->setAttribs('is_money','true');
			if ($this->mode == "readonly") {
				$elem->setAttribs('readonly','readonly');
				$elem->setAttribs('disabled','disabled');
			}
			$elem->setDecoration();
			$this->addElement($elem);
			$this->radky[$i]->celkem = $elem->render();



			$name = "qty";
			$elem= new G_Form_Element_Text($name."[]");
			$value = $this->getPost($name."[".$i."]", $radek[$i]->$name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class',$name);
			$elem->setAttribs('is_numeric','true');
			$elem->setAttribs('style','text-align:right');
			$elem->setAttribs('onblur','prepocti_cenu2();');
			if ($this->mode == "readonly") {
				$elem->setAttribs('readonly','readonly');
				$elem->setAttribs('disabled','disabled');
			}
			$elem->setDecoration();
			$this->addElement($elem);
			$this->radky[$i]->qty = $elem->render() . $this->radky[$i]->mj;










		}
	}


	public function tableRender()
	{
		$data = $this->radky;

	//	print_r($data);
		$th_attrib = array();


		$th_attrib["counter"]["class"] = "check-column";
		$th_attrib["product_code"]["class"] = "column-cena";
		$th_attrib["qty"]["class"] = "column-qty";
		$th_attrib["mj"]["class"] = "column-qty";
		$th_attrib["tax"]["class"] = "column-qty";
		$th_attrib["sleva"]["class"] = "column-qty";
		$th_attrib["typ_slevy"]["class"] = "column-qty";
		$th_attrib["celkem"]["class"] = "column-cena";
		$th_attrib["price"]["class"] = "column-cena";
		$th_attrib["cmd"]["class"] = "column-ckeck";
		//$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
		$column["counter"] = '#';
		$column["product_code"] =   "Číslo";
		$column["product_name"] =   "Název";
		$column["qty"] =   "Množství / MJ";
	//	$column["mj"] =   "Jednotka";

		$column["price"] =   "Jedn. cena / Sleva";
	//	$column["sleva"] =   "Sleva";
	//	$column["typ_slevy"] =   "Typ";
		$column["tax"] =   "Sazba DPH";
		$column["celkem"] =   "Celkem";
		//$column["cmd"] =   "";
		$l = array();
		$table = new G_Table($data, $column, $th_attrib, $td_attrib);


		$table_attrib = array(
				"class" => "table_header widefat",
				"id" => "radky",
				"cellspacing" => "0",
				"print_foot" => 0
				);

		return $table->makeTable($table_attrib);
	}
}
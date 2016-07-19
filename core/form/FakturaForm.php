<?php
/**
 * Společný předek pro formuláře typu Faktura
 * */
require_once("DokladForm.php");
class FakturaForm extends DokladForm
{

	function __construct()
	{
		parent::__construct("Faktura");
	}

	public function loadElements()
	{
		parent::loadElements();

		$doklad = $this->doklad;
		$model = new models_TypyFaktur();

		$params= array();
		$params["order"] = "order ASC";
		$typyfakturList = $model->getList();

		$name = "faktura_type_id";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox');
		$elem->setAttribs('label','Typ faktury:');
		$pole = array();
		//$pole[0] = " -- neuvedeno -- ";
		$attrib = array();
		foreach ($typyfakturList as $key => $value)
		{
			$pole[$value->id] = $value->name;
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$name = "order_code";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs('style','width:185px;');
		$value = $this->getPost($name, $doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Číslo objednávky:');
		$elem->setAttribs('class','textbox medium_size');
		$this->addElement($elem);



		$name = "pay_account";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name,$doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Z účtu:');
		$elem->setAttribs('class','textbox medium_size');
		$this->addElement($elem);

		$name = "pay_date";
		$value = $doklad->$name;
		$value = (!empty($value)) ? date("j.n.Y", strtotime($value)) : "";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name,$value);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('id',$name);
		$elem->setAttribs('label','Datum přijetí platby');
		$elem->setAttribs('class','textbox small_size datepicker');
		$this->addElement($elem);

		$name = "amount_paid";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name,$doklad->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Částka platby:');
		$elem->setAttribs('style','text-align:right;');
		$elem->setAttribs('is_money','true');
		$elem->setAttribs('class','textbox small_size');
		$this->addElement($elem);

		$name = "faktura_date";
		// Musím převést na D.M.RRRR
		$value = $doklad->$name;
		$value = (!empty($value)) ? date("j.n.Y", strtotime($value)) : "";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name,$value);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('id',$name);
		$elem->setAttribs('label','Datum vystavení:');
		$elem->setAttribs('class','textbox small_size datepicker');
		$this->addElement($elem);


		$name = "maturity_date";

		$value = $doklad->$name;
		$value = (!empty($value)) ? date("j.n.Y", strtotime($value)) : "";
		$elem = new G_Form_Element_Text($name);

		$value = $this->getPost($name,$value);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('id',$name);
		$elem->setAttribs('label','Datum splatnosti:');
		$elem->setAttribs('class','textbox small_size datepicker');
		$this->addElement($elem);

		$name = "duzp_date";
		$value = $doklad->$name;
		$value = (!empty($value)) ? date("j.n.Y", strtotime($value)) : "";
		$elem = new G_Form_Element_Text($name);
		$value = $this->getPost($name,$value);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('id',$name);
		$elem->setAttribs('label','DUZP:');
		$elem->setAttribs('class','textbox small_size datepicker');
		$this->addElement($elem);


	}
}
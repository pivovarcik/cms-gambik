<?php
/**
 * Třída pro přidání nového hitu
 * */
class F_ProductPricesEdit extends G_Form
{

	function __construct($id)
	{
		parent::__construct();
		$this->init($id);
	}
	public function init($id_item)
	{
		//error_reporting(E_ALL);
	//	ini_set("display_errors", 1);
/*
		if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
			$id_item = $_GET["id"];
		} else {
			print "Není vybrán ID";
			return;
		}
*/
		//$eshop = new Eshop();
		//$g = new Gambik();
		$_product = new models_Products();
		$elements = array();
	//	$_product->getProduct($id_item);

		//$product = $eshop->get_product(array('id' => $_GET["id"]));
		$product = $_product->getProduct($id_item);


		// Vázané ceny
		$prices = $_product->getPrices();
		//print_r($prices);
		for ($i=0;$i<count($prices);$i++)
		{


			$elemPrice = new G_Form_Element_hidden("cena_id[$i]");
			$value2 = $this->getPost("marze[$i]", $prices[$i]->uid);
			$elemPrice->setAttribs('value', $value2);
			array_push($elements, $elemPrice);

			$elemPrice = new G_Form_Element_Text("zakl_cena[$i]");
			$value2 = $this->getPost($product->prodcena, $product->prodcena);
			$elemPrice->setAttribs('value', $value2);
			$elemPrice->setAttribs('style','width:100px;text-align:right;');
			$elemPrice->setAttribs(array("readonly"=>"readonly"));
			$elemPrice->setAttribs(array("is_money"=>true));
			array_push($elements, $elemPrice);

			$elemPrice = new G_Form_Element_Text("marze[$i]");
			$value2 = $this->getPost("marze[$i]", $prices[$i]->marze);
			$elemPrice->setAttribs('value', $value2);
			$elemPrice->setAttribs('style','width:100px;text-align:right;');
			$elemPrice->setAttribs(array("is_money"=>true));
			array_push($elements, $elemPrice);

			$value = round(($prices[$i]->marze+100)/100 * $product->prodcena);
			$elemPrice = new G_Form_Element_Text("cena_cena[$i]");
			$value2 = $this->getPost($value,$value);
			$elemPrice->setAttribs('value', $value2);
			$elemPrice->setAttribs('style','width:100px;text-align:right;font-weight:bold;');
			$elemPrice->setAttribs(array("is_money"=>true));
			$elemPrice->setAttribs(array("readonly"=>"readonly"));
			$elemPrice->setAttribs(array("disabled"=>"disabled"));
			array_push($elements, $elemPrice);


			$elemPrice = new G_Form_Element_Text("marze_cenik[$i]");
			$value2 = $this->getPost($prices[$i]->marze_cenik,$prices[$i]->marze_cenik);
			$elemPrice->setAttribs('value', $value2);
			$elemPrice->setAttribs('style','width:100px;text-align:right;');
			$elemPrice->setAttribs(array("is_money"=>true));
			$elemPrice->setAttribs(array("readonly"=>"readonly"));
			$elemPrice->setAttribs(array("disabled"=>"disabled"));
			array_push($elements, $elemPrice);

			$value = date("j.n.Y",strtotime($prices[$i]->platnost_od));
			$elemPrice = new G_Form_Element_Text("platnost_od[$i]");
			$value2 = $this->getPost($value, $value);
			$elemPrice->setAttribs('value', $value2);
			$elemPrice->setAttribs('style','width:100px;text-align:right;');
		//	$elemPrice->setAttribs(array("is_money"=>true));
			$elemPrice->setAttribs(array("readonly"=>"readonly"));
			$elemPrice->setAttribs(array("disabled"=>"disabled"));
			array_push($elements, $elemPrice);

			$value = date("j.n.Y",strtotime($prices[$i]->platnost_do));
			$elemPrice = new G_Form_Element_Text("platnost_do[$i]");
			$value2 = $this->getPost($value,$value);
			$elemPrice->setAttribs('value', $value2);
			$elemPrice->setAttribs('style','width:100px;text-align:right;');
	//		$elemPrice->setAttribs(array("is_money"=>true));
		//	$elemPrice->setAttribs(array("readonly"=>"readonly"));
		//	$elemPrice->setAttribs(array("disabled"=>"disabled"));
			array_push($elements, $elemPrice);

			$elemPrice = new G_Form_Element_Text("oznaceni[$i]");
			$value2 = $this->getPost($prices[$i]->oznaceni,$prices[$i]->oznaceni);
			$elemPrice->setAttribs('value', $value2);
		//	$elemPrice->setAttribs('style','width:100px;text-align:right;');
			//$elemPrice->setAttribs(array("is_money"=>true));
			$elemPrice->setAttribs(array("readonly"=>"readonly"));
		//	$elemPrice->setAttribs(array("disabled"=>"disabled"));
			array_push($elements, $elemPrice);
		}


		$this->addElements($elements);
		/*
		$this->addElements(array(
			$elemCisloMat, $elemNazevMat, $elemNazevMatDE, $elemNazevMatEN, $elemNazevMatRU, $elemTypSort,
			$elemCategory, $elemProdCena, $elemDescription,$elemAktivni,
$elemQty,$elemVyrobce,$elemRubrika,

$elemDostupnost,
			$elemFotoId,$elemHMJ,
			$elemSubmit, $elemKlicMa,
		));
		*/
	}
}
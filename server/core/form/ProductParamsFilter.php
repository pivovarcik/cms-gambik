<?php
/**
 * Filter pro produkty
 * */
require_once("ListFilter.php");
class ProductParamsFilter extends ListFilter
{

	public $skupinyList = array();
	public $vyrobceList = array();

	// minimální částka za rubriku
	public $minCena = 0;
	public $maxCena = 999999;

	public $minCenaVMene = 0;
	public $maxCenaVMene = 999999;
	function __construct()
	{
		parent::__construct(true);
    $this->setStyle(BootstrapForm::getStyle());
		$this->init();
	}

	public function loadModel()
	{
		parent::loadModel();

		$minCena = $this->minCena;
		$maxCena = $this->maxCena;
		$eshopSettings = G_EshopSetting::instance();

		$params= new ListArgs();
		if (!defined("ADMIN") && defined("PAGE_ID") && PAGE_ID>0) {
			$params->child = (int) PAGE_ID;
		}

		if (!defined("ADMIN")) {
			$params->aktivni = 1;
		//}
		//if (!defined("USER_ROLE_ID") || USER_ROLE_ID != 2) {
			$params->aktivni = 1;
		}
	//	$params->aktivni = 1;
		$productModel = new models_Products();

		$params->lang = LANG_TRANSLATOR;
		$this->vyrobceList = $productModel->getVyrobciProductList($params);

		$minCena = false;
		$maxCena = false;
		foreach ($this->vyrobceList as $key => $vyrobce) {

			if ($eshopSettings->get("PRICE_TAX") == "0") {
				if (!$minCena || $vyrobce->cena_od < $minCena) {
					$minCena = $vyrobce->cena_od;
				}

				if (!$maxCena || $vyrobce->cena_do > $maxCena) {
					$maxCena = $vyrobce->cena_do;
				}
			} else {
				if (!$minCena || $vyrobce->cenasdph_od < $minCena) {
					$minCena = $vyrobce->cenasdph_od;
				}

				if (!$maxCena || $vyrobce->cenasdph_do > $maxCena) {
					$maxCena = $vyrobce->cenasdph_do;
				}
			}

		}

		if ($minCena) {
			$this->minCena = $minCena;
			$this->minCenaVMene = $minCena  / (LANG_KURZ*1);
		}

		if ($maxCena) {
			$this->maxCena = $maxCena;
			$this->maxCenaVMene = $maxCena  / (LANG_KURZ*1);
		}

		$params->lowestPrice = $this->minCena;
		if (isset($_POST['cenaOd'])) {
			$params->lowestPrice = (int) $_POST['cenaOd'];
		}

		if (isset($_GET['lowestPrice'])) {
			$params->lowestPrice = (int) $_GET['lowestPrice'];
		}


		$params->highestPrice = $this->maxCena;
		if (isset($_POST['cenaDo'])) {
			$params->highestPrice = (int) $_POST['cenaDo'];
		}

		if (isset($_GET['highestPrice'])) {
			$params->highestPrice = (int) $_GET['highestPrice'];
		}


	//	$params->lowestPrice = isset($_GET['lowestPrice']) ? $_GET['lowestPrice'] : $this->minCena;
	//	$params->highestPrice = isset($_GET['highestPrice']) ? $_GET['highestPrice'] : $this->maxCena;
		$params->fulltext = isset($_GET['q']) ? $_GET['q'] : "";




		$this->vyrobceList = $productModel->getVyrobciProductList($params);

      $ProductGroupAssoc = new models_ProductGroupAssoc();
      
    // $this->skupinyList = $ProductGroupAssoc->getList(); 
   //  print $ProductGroupAssoc->getLastQuery();
	//	print_r($this->vyrobceList);

  		$this->skupinyList = $productModel->getSkupinyProductList($params);
	}
	public function init()
	{

		$this->loadModel();
		parent::init();
		$minCena = $this->minCena;
		$maxCena = $this->maxCena;

/*
		$params=array();
		if (defined("PAGE_ID") && PAGE_ID>0) {
			$params['child'] = (int) PAGE_ID;
		}

		$params['lowestPrice'] = $_GET['lowestPrice'];
		$params['highestPrice'] = $_GET['highestPrice'];
		$params['fulltext'] = $_GET['q'];

		if (!defined("USER_ROLE_ID") || USER_ROLE_ID != 2) {
			$params['aktivni'] = 1;
		}
*/


	//	print_r($skupinyList);

		if (is_array($this->vyrobceList)) {


			foreach ($this->vyrobceList as $key => $val)
			{


				if ($val->cena_od < $minCena) {
					$minCena = $val->cena_od;
				}
				if ($val->cena_do > $maxCena) {
					$maxCena = $val->cena_do;
				}
				if ($val->id > 0) {
					$selected = '';
					if ($select_value == $val->id) {
						$selected =' checked="checked"';
						$naselValue = true;
					}
					//$slct .= '<label><input type="checkbox"'.$selected.' name="vyr['.$value->id.']">'.$value->name.'</label>';


					$name = "vyr[" . $val->id . "]";
					$elem= new G_Form_Element_Checkbox($name);
					//$value = $this->Request->getPost($name, false);
					//$elem->setAttribs('value',$value);

					//$elem->setAttribs('value',1);
					if ($val->selected == 1 || $this->Request->getQuery($name, false) || isset($_GET["vyr"][$val->id])) {
						$elem->setAttribs('checked','checked');
					}
					//	print "title" . $val->title;
					$elem->setAttribs('label',$val->name . '<em class="prodCount">('.$val->pocet.')</em>');
					$elem->setAttribs("class","vyr");
				//	$elem->setValue($val->id);
					$this->addElement($elem);
				}


			}

		}
    //print_r($this->skupinyList);
		if (is_array($this->skupinyList)) {
			foreach ($this->skupinyList as $key => $val)
		{

			if ($val->group_id > 0) {
				$selected = '';
				if ($select_value == $val->group_id) {
					$selected =' checked="checked"';
					$naselValue = true;
				}
				//$slct .= '<label><input type="checkbox"'.$selected.' name="vyr['.$value->id.']">'.$value->name.'</label>';


				$name = "skupina[" . $val->group_id . "]";
				$elem= new G_Form_Element_Checkbox($name);
				//$value = $this->Request->getPost($name, false);
				//$elem->setAttribs('value',$value);

				//$elem->setAttribs('value',1);
				if ($val->selected == 1 || $this->Request->getQuery($name, false) || isset($_GET["skupina"][$val->group_id])) {
					$elem->setAttribs('checked','checked');
				}
				$elem->setAttribs("class","group");
				//	print "title" . $val->title;
				$elem->setAttribs('label',$val->name . '<em class="prodCount">('.$val->pocet.')</em>');

				$this->addElement($elem);
			}


		}
		}
		$name = "lowestPrice";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array(
				"id" => $name,
				"class" => "textbox num",
				"style" => "width: 65px;",
				));

	/*	if ($minCena == $maxCena) {
			$minCena -=500;
			$maxCena +=500;
		}*/

		$minCena = $minCena / (LANG_KURZ*1);

		$value = round($this->Request->getQuery($name, $minCena));
		//$value = !empty($value) ? $value : FILTER_FROM_DATE;
		$elem->setAttribs('value',$value);
		$elem->setDecoration();
		$this->addElement($elem);



		$name = "highestPrice";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array(
				"id" => $name,
				"class" => "textbox num",
				"style" => "width: 65px;",
				));
		$maxCena = $maxCena / (LANG_KURZ*1);
		$value = round($this->Request->getQuery($name, $maxCena));
		//$value = !empty($value) ? $value : FILTER_TO_DATE;
		$elem->setAttribs('value',$value);
		$elem->setDecoration();
		$this->addElement($elem);

		$name = "status2";
		$elem= new G_Form_Element_Radio($name);
    
    $value = $this->getPost($name, 2);
		$elem->setAttribs('value',$value);
    
    //$elem->setAttribs('label','Pouze aktivní');
    
   $druhSlevyList = array("0" => "Pouze neaktivní", "1" => "Pouze aktivní","2" => "Všechny"); 
    		$pole = array();
		//$pole[0] = " -- neuveden -- ";
		$attrib = array();
		foreach ($druhSlevyList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);
    
    
    $this->addElement($elem);
    
    
		$name = "status";
		$elem= new G_Form_Element_Checkbox($name);
		//$value = $this->Request->getPost($name, false);
		$elem->setAttribs('value',1);

		//$elem->setAttribs('value',1);
		if ($this->Request->getQuery($name, false)) {
			$elem->setAttribs('checked','checked');
		}
		//	print "title" . $val->title;
		$elem->setAttribs('label','Pouze aktivní');

		$this->addElement($elem);


    $name = "bazar";
		$elem= new G_Form_Element_Checkbox($name);
		//$value = $this->Request->getPost($name, false);
		$elem->setAttribs('value',1);

		//$elem->setAttribs('value',1);
		if ($this->Request->getQuery($name, false)) {
			$elem->setAttribs('checked','checked');
		}
		//	print "title" . $val->title;
		$elem->setAttribs('label','Bazarová položka');

		$this->addElement($elem);

    $name = "neprenaset";
		$elem= new G_Form_Element_Checkbox($name);
		//$value = $this->Request->getPost($name, false);
		$elem->setAttribs('value',1);

		//$elem->setAttribs('value',1);
		if ($this->Request->getQuery($name, false)) {
			$elem->setAttribs('checked','checked');
		}
		//	print "title" . $val->title;
		$elem->setAttribs('label','Ne do feedu');

		$this->addElement($elem);
        
    
    $name =  "category_id";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name,"required"=>false));
		$value = $this->getPost($name, 0);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Umístění:');
		$elem->setAttribs('class','selectbox');
		$pole = array();
		$pole[0] = " -- vše -- ";
	//	$pole[-1] = " -- nezařazené -- ";
		$attrib = array();
	//	print_r($this->categoryTreeList);
		foreach ($this->categoryTreeList as $key => $value)
		{

		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);
    
    		$tree = new G_CiselnikTree("ProductDostupnost");
		$productDostupnostList = $tree->categoryTree();
    $name = "dostupnost_id";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Dostupnost:');
		$elem->setAttribs('class','selectbox');
		$pole = array();
		$pole[0] = " -- vše -- ";
		foreach ($productDostupnostList as $key => $value)
		{
			//$pole[$value->id] = $value->name;
			$pole[$value->id] = $value->title;
			$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);



    $tree = new G_CiselnikTree("ImportProductSetting");
		$productDostupnostList = $tree->categoryTree();
    $name = "dodavatel_id";
		$elem = new G_Form_Element_Select($name);
		$elem->setAttribs(array("id"=>$name));
		$value = $this->getPost($name, $product->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Dodavatel:');
		$elem->setAttribs('class','selectbox');
		$pole = array();
		$pole[0] = " -- vše -- ";
		foreach ($productDostupnostList as $key => $value)
		{
			//$pole[$value->id] = $value->name;
			$pole[$value->id] = $value->title;
			$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);
    
        
		$elem = new G_Form_Element_Text("q");
		$elem->setAttribs(array(
		"class" => "textbox searchbox",
		));
		$value = $this->Request->getQuery("q", "");

	//	$elem->setAttribs('label','Dle názvu');
		$elem->setAttribs('placeholder','Hledejte podle názvu ...');
		$elem->setAttribs('value',$value);
		$this->addElement($elem);

	}
}
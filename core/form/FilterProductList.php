<?php
/**
 * Třída pro přidání nového hitu
 * */
require_once("FilterList.php");

// Asi uz se nepouziva - nahrazeno ProductListFilter
class Application_Form_FilterProductList extends Application_Form_FilterList
{

	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{

		parent::init();
/*
		$tree = new G_Tree();
		$rubrikyList = $tree->categoryTree(array(
				"parent"=>0,
				"debug"=>0,
				));
*/
			$rubrikyList = array();
		$elem = new G_Form_Element_Select("tree");
		//$elem->setAttribs(array("id"=>"tree","required"=>false));
		$value = $this->Request->getQuery("tree", "");
		$elem->setAttribs('value',$value);
		$elem->setAttribs('class','selectbox');
		$elem->setAttribs('onchange',"document.location.href='".AKT_PAGE."?tree='+this.value");
		$pole = array();
		$pole[0] = " -- vše -- ";
		$attrib = array();
		foreach ($rubrikyList as $key => $value)
		{
			$pole[$value->id] = $value->title;

			//if () {
			$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
			//}
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);


		$productCategoryModel = new models_ProductCategory();
		$productCategoryList = $productCategoryModel->getList();

		$elem = new G_Form_Element_Select("cat");
		$elem->setAttribs('class','selectbox');
		//$elem->setAttribs(array("id"=>"cat","required"=>false));
		$value = $this->Request->getQuery("cat", "");
		$elem->setAttribs('value',$value);
		$elem->setAttribs('onchange',"document.location.href='".AKT_PAGE."?cat='+this.value");
		$pole = array();
		$pole[0] = " -- všechny skupiny -- ";
		foreach ($productCategoryList as $key => $value)
		{
			$pole[$value->id] = $value->name;
		}
		$elem->setMultiOptions($pole);
		$this->addElement($elem);

		$stavyList = array( 0 => "Vše", 1 => "Aktivní", 2 => "Neaktivní", 3 => "Smazané");

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
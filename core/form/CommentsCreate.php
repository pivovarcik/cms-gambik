<?php
/**
 * Společný předek pro formuláře typu Page
 * */
class Application_Form_CommentsCreate extends G_Form
{

	public $formName = "Nová komentář";

	public $submitButtonName = "ins_message";
	public $submitButtonTitle = "Odeslat";
	function __construct()
	{
		$this->setStyle(BootstrapForm::getStyle());
		parent::__construct();
		$this->init();
	}

	public function init()
	{
		//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$tree = new G_Tree();
		$categoryTreeList = $tree->categoryTree(array(
			"parent"=>$this->category_root,
			"debug"=>0,
			));


		$elem = new G_Form_Element_Select("category_id");
		$elem->setAttribs(array("id"=>"category_id","required"=>false));
		$value = $this->getPost("category_id", $page->category_id);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Rubrika:');
		$pole = array();
		$pole[0] = " -- nezařazené -- ";
		$attrib = array();
		foreach ($categoryTreeList as $key => $value)
		{

		//	if (!in_array($value->id, $this->ignore_category)) {
				$pole[$value->id] = $value->title;
				$attrib[$value->id]["class"] = "vnoreni" . $value->vnoreni;
			//}
		}
		$elem->setMultiOptions($pole,$attrib);
		$this->addElement($elem);

		// Perex
		$name = "message";
		$elem = new G_Form_Element_Textarea($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		//$elem->setAttribs('style','width:300px;font-weight:bold;');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Mes.:');
		$this->addElement($elem);

		$name = "ins_message";
		$elem = new G_Form_Element_Button($name);
		//$elem->setAttribs(array("id"=>"perex_$val","required"=>true));
		//$elem->setAttribs('style','width:300px;font-weight:bold;');
		//$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value','Přidej');


		//$elem->setAttribs('label','Mes.:');
		$this->addElement($elem);


		$name = "action";
		$elem = new G_Form_Element_Hidden($name);

		$elem->setAttribs('value',"ins_message");

		$this->addElement($elem);


	}
}
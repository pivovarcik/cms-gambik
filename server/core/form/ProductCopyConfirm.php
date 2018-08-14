<?php



require_once("CopyConfirmForm.php");
class F_ProductCopyConfirm extends CopyConfirmForm {

	public $submitButtonTitle = "Kopírovat";
	public $formName = "Opravdu kopírovat produkt?";

	function __construct()
	{

		parent::__construct("Products");
		$this->init();
	}

	public function init()
	{
     $eshopSettings = G_EshopSetting::instance();
  
  		$nextIdModel = new models_NextId();
		$cislo_mat = $nextIdModel->vrat_nextid(array(
		"tabulka"=>T_SHOP_PRODUCT,
		"polozka"=>"cislo",
	)); 
  
  		$name = "cislo";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		//	$elem->setAttribs('style','width:300px;font-weight:bold;');
		$elem->setAttribs('class','textbox');
		if ($eshopSettings->get("PRODUCT_NEXTID_AUTO") == "1") {
			$elem->setAttribs('readonly','readonly');
		}


		$value = $this->getPost($name, $cislo_mat);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Nové katalogové číslo:');
		$this->addElement($elem);
    
		$name = "action";
		$elem = new G_Form_Element_Hidden($name);
		$elem->setAttribs(array("id"=>$name));
		$elem->setAttribs('value',"ProductCopy");
		$elem->setAnonymous();
		$this->addElement($elem);

    $name = "copy_foto";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, 1);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Včetně obrázků');
		$this->addElement($elem);
    
    $name = "copy_params";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, 1);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Včetně parametrů');
		$this->addElement($elem);

    $name = "copy_varianty";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, 1);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Včetně variant');
		$this->addElement($elem);

    $name = "copy_cenik";
		$elem = new G_Form_Element_Checkbox($name);
		$value = $this->getPost($name, 1);
		$elem->setAttribs('value',1);
		if ($value == 1) {
			$elem->setAttribs('checked','checked');
		}
		$elem->setAttribs('label','Včetně ceníku');
		$this->addElement($elem);
               
	//	$this->formName = "Kopírovat produkt č. ".$this->page->cislo." ?";
    $this->formName = "Kopírovat produkt č. ".$this->page->cislo." ".$this->page->title." ?";
	}

}
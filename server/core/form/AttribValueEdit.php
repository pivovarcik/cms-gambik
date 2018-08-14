<?php
/**
 * Třída pro přidání nového hitu
 * */
class F_AttribValueEdit extends G_Form
{

	function __construct()
	{
		parent::__construct();
    $this->setStyle(BootstrapForm::getStyle());
		$this->init();
	}
	public function init()
	{
		$id = (int) $this->Request->getQuery("id", 0);
		$model = new models_Attributes();

		$attrValues = $model->get_attributeValues($id);

		for ($i=0;$i<count($attrValues);$i++){
			//$attrValues[$i];
			$elem = new G_Form_Element_Text("attrVal[$i]");
			$value = $this->getPost("attrVal[$i]", $attrValues[$i]->name);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textbox');
			$this->addElement($elem);

      $elem = new G_Form_Element_Text("attrCode[$i]");
			$value = $this->getPost("attrCode[$i]", $attrValues[$i]->attribute_code);
			$elem->setAttribs('value',$value);
			$elem->setAttribs('class','textbox');
			$this->addElement($elem);
      
			$elem = new G_Form_Element_Hidden("attrValId[$i]");
			$value = $this->getPost("attrValId[$i]", $attrValues[$i]->id);
			$elem->setAttribs('value',$value);
			$this->addElement($elem);


			$elem = new G_Form_Element_Submit("attrValDel[$i]");
			$elem->setAttribs('value','smazat');
			$this->addElement($elem);

		}

		$elem = new G_Form_Element_Hidden("attr_id");
		$elem->setAttribs('value', $id);
		$this->addElement($elem);

		$elem = new G_Form_Element_Hidden("count");
		$elem->setAttribs('value', count($attrValues));
		$this->addElement($elem);

		/*
		$elemSubmit = new G_Form_Element_Submit("upd_attrib");
		$elemSubmit->setAttribs('value','Ulož');
		$elemSubmit->setAttribs('class','tlac');
		$elemSubmit->setAttribs('label','');
		$elemSubmit->setIgnore(true);
		$paramSubmit = $elemSubmit->render();
		*/

	}
}
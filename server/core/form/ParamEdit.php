<?php
/**
 * Třída pro přidání nového hitu
 * */
class F_ParamEdit extends G_Form
{

	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{

		//$product = new Product();
		$paramController = new ParamController();
		$paramDetail = $paramController->detailAction($_GET["id"]);

		//$_productParam = new models_ProductParam();

		$elemParamName = new G_Form_Element_Text("name");
		$elemParamName->setAttribs(array(
						"id"=>"param_name",
						"required"=>true
						));
		$paramNameValue = $this->getPost("name", $paramDetail->name);
		$elemParamName->setAttribs('value',$paramNameValue);
		$elemParamName->setAttribs('label','Název parametru:');

		//$paramName = $elemParamName->render();

		$elemDescription = new G_Form_Element_Textarea("description");
		$elemDescription->setAttribs(array("id"=>"description"));
		$descriptionValue = $this->getPost("description", $paramDetail->description);
		$elemDescription->setAttribs('value',	$descriptionValue);
		$elemDescription->setAttribs('label','Popis:');
		$paramDescription = $elemDescription->render();

		$typParamList = array(
						"string"=>"Text",
						"numeric"=>"Celé číslo",
						"decimal"=>"Částka",
						"enum"=>"Seznam",
						);
		$elemTypParam = new G_Form_Element_Select("type");
		$elemTypParam->setAttribs(array("id"=>"typ_param","required"=>true));
		$typParamValue = $this->getPost("typ_param", $paramDetail->type);
		$elemTypParam->setAttribs('value', $typParamValue);
		$elemTypParam->setAttribs('label','Typ:');
		$pole = array();
		foreach ($typParamList as $key => $value)
		{
			$pole[$key] = $value;
		}
		$elemTypParam->setMultiOptions($pole);
		$typParam = $elemTypParam->render();

		$elemSubmit = new G_Form_Element_Submit("save_param");
		$elemSubmit->setAttribs('value','Ulož');
		$elemSubmit->setAttribs('class','tlac');
		$elemSubmit->setAttribs('label','');
		$elemSubmit->setIgnore(true);
		$paramSubmit = $elemSubmit->render();

		$elemParamId = new G_Form_Element_Hidden("id");
		$elemParamId->setAttribs('value', $paramDetail->id);

		$this->addElements(array(
						$elemParamName, $elemDescription, $elemTypParam,
						$elemSubmit, $elemParamId,
		));
	}
}
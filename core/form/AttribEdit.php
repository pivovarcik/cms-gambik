<?php
/**
 * Třída pro přidání nového hitu
 * */
class Application_Form_AttribEdit extends G_Form
{

	function __construct()
	{
		parent::__construct();
		$this->init();
	}
	public function init()
	{
		$id = (int) $this->Request->getQuery("id", 0);
		$model = new models_Attributes();
		$row = $model->get_row("select * from {$model->getTableName()} where id={$id} LIMIT 1");

		$elem = new G_Form_Element_Text("name");
		$elem->setAttribs(array(
						"id"=>"name",
						"required"=>true
						));
		$value = $this->getPost("name", $row->name);
		$elem->setAttribs('label','Název:');
		$elem->setAttribs('style','width:300px;font-weight:bold;');
		$elem->setAttribs('value',$value);
		$this->addElement($elem);





		//$paramName = $elemParamName->render();

		$elem = new G_Form_Element_Textarea("description");
		$elem->setAttribs(array("id"=>"description"));
			$elem->setAttribs('class','textarea');
		$value = $this->getPost("description", $row->description);
		$elem->setAttribs('value',	$value);
		$elem->setAttribs('label','Popis:');
		$this->addElement($elem);

		$elem = new G_Form_Element_Hidden("id");
		$elem->setAttribs('value', $row->id);
		$this->addElement($elem);


		$elem = new G_Form_Element_Button("upd_attrib");
		$elem->setAttribs('value','Ulož');
		$elem->setAttribs('class','btn btn-sm btn-success');
		$elem->setAttribs('label','');
		$elem->setIgnore(true);
		$this->addElement($elem);

	}
}
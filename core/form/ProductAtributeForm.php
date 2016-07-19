<?php

abstract class ProductAtributeForm extends G_Form
{

	public $pageModel;
	public $page;
	public $page_id;

	function __construct()
	{
		parent::__construct();
		$this->loadModel("models_Attributes");
		$this->setStyle(BootstrapForm::getStyle());


		//$this->loadElements();

	}

	// načte datový model
	public function loadModel($model)
	{
		$this->pageModel = new $model;
	}
	// načte datový model
	public function loadPage($page_id = null)
	{

		//	print "ID:" . $page_id;
		if ($page_id == null) {
			$this->page = array();
		//	$this->page->name = null;
		//	$this->page->description = null;
		//	$this->page->parent = null;

		} else {
			$this->page = $this->pageModel->get_attribute_value_association($page_id);
			//print_r($this->page);
			$this->page_id = $page_id;


			//	$this->filterDefinitionRender();
		}

	}


	public function filterDefinitionRender()
	{


		$attributy = $this->page;

		$contentNastaveni = '<table>';


		$cols=3;
		$zadna_data="Žádné atributy nejsou k dispozici.";
		if (count($attributy)>0)
		{
			$sudy = false;
			for ($i=0;$i < count($attributy);$i++)
			{
				$checked = '';
				if ($attributy[$i]->has_attribute == 1)
				{
					$checked = ' checked="checked"';
				}
				$contentNastaveni .= '<tr>';
				$contentNastaveni .= 	'<td><input ' . $checked . 'type="checkbox" name="attrib[' . $i . ']" value="' . $attributy[$i]->id . '"></td>';
				$contentNastaveni .= 	'<td><label>' . $attributy[$i]->name . '</label><input type="hidden" name="attrib_value[' . $i . ']" value="' . $attributy[$i]->value . '"></td>';
				$contentNastaveni .= 	'<td><input type="hidden" name="attrib_is[' . $i . ']" value="' . $attributy[$i]->has_attribute . '"></td>';
				$contentNastaveni .= 	'<td><input class="textbox" style="width:45px;" type="number" name="order[' . $i . ']" value="' . $attributy[$i]->order . '"/></td>';
				$contentNastaveni .= '</tr>';
			}
		}
		$contentNastaveni .= '</table>';


		return $contentNastaveni;
	}

	// načte datový model
	public function loadElements()
	{
		//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");



		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}

		// Akce
		/*	$elem = new G_Form_Element_Hidden("action",true);
		   $elem->setAnonymous();
		   $elem->setAttribs('value',str_replace("Application_Form_", "" ,get_class($this) ));
		   $this->addElement($elem);*/
	}
}
<?php

abstract class DataGridDefinitionForm extends G_Form
{

	public $pageModel;
	public $page;
	public $page_id;

	function __construct()
	{
		parent::__construct();
		$this->loadModel("models_FilterView");
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
			$this->page = new stdClass();
			$this->page->name = null;
			$this->page->description = null;
			$this->page->parent = null;

		} else {
			$this->page = $this->pageModel->getDetailById($page_id);
			//print_r($this->page);
      
      if ($this->page->isDefault == 0)
      {
      
      }
			$this->page_id = $page_id;


		//	$this->filterDefinitionRender();
		}

	}


	private function parseFilterDefinitionFromXml($xml)
	{
		if (empty($xml)) {

			return;
		}
		$feed = new SimpleXMLElement($xml);

		//print_r($feed->definition);

		$columns = $feed->column;

		$filterColumns = array();

		for($i=0;$i<count($columns);$i++)
		{
			$name = trim($columns[$i]->attributes()->name);
			$header = trim($columns[$i]->attributes()->header);
			$class = trim($columns[$i]->attributes()->class);
			$visibility = trim($columns[$i]->attributes()->visibility);
			$order = trim($columns[$i]->attributes()->order);
			$edit = trim($columns[$i]->attributes()->edit);
			//	print $name;
			$filterColumns[$name] = array("header" => $header, "class" => $class,"visibility" => $visibility, "order" => $order);

			//, "edit" => $edit
			if (!empty($edit)) {
				$filterColumns[$name]["edit"] = 1;
			}

			//print_r($filterColumns[$name]);
			//	print $header;
		}

		$filterColumns = $this->orderFilterDefinition($filterColumns);
		return $filterColumns;
	}

	// setřídí sloupce
	private function orderFilterDefinition($filterColumns)
	{
		$filterColumnsOrder = array();
		$filterColumnsIndexOrder = array();
		$filterColumnsIndexVisibility = array();
		foreach ($filterColumns as $columnName => $attrib ) {

			$filterColumnsIndexOrder[$columnName] = $attrib["order"];

		}
		asort($filterColumnsIndexOrder);
		//	array_reverse($filterColumnsIndexOrder);

		$i = 0;
		foreach ($filterColumnsIndexOrder as $columnName => $attrib ) {

			$filterColumnsOrder[$columnName] = $filterColumns[$columnName];

			if (isset($filterColumns[$columnName]["visibility"])) {
				$filterColumnsIndexVisibility[$columnName] = ($filterColumns[$columnName]["visibility"] == "1") ?  0 : 1+$i;
			} else {
				$filterColumnsIndexVisibility[$columnName] = 1 + $i;
			}
			$i++;
		}
		return $filterColumnsOrder;
	}


	public function filterDefinitionRender()
	{
/*		$res = '<form method="post" class="datagrid_filter_definition standard_form" style="display:none;">';
		$res .= '<a class="closeBtn" href="javascript:closeFilterDefinitionWizzard();"><i class="fa fa-times"></i></a>';

		$res.='<select name="filter_id" onchange="changeFilterDefinition();">';
		foreach ($this->filterDefinitionList as $key => $filter) {

			$res.='<option value="' . $filter->id . '">' . $filter->name . '</option>';

		}
		$res.='</select>';

		$disabled = ($this->filterDefinitionSelected->isDefault== 1) ? ' disabled="disabled"' : '';

		$res.='<input' . $disabled. ' type="text" name="filtername" value="'.$this->filterDefinitionSelected->name.'" />';

		$res.='<input name="id" type="hidden" value="'.$this->filterDefinitionSelected->id.'" />';


*/
		$xml = $this->page->definition;

		$filterColumns = $this->parseFilterDefinitionFromXml($xml);
		$columns = $this->orderFilterDefinition($filterColumns);



		$res='<table>';

$res.='<tr>';
$res.='<th>Zobr.</th>';
//$res.='<th>Edit.</th>';
//$res.='<th>Položka</th>';
$res.='<th>Položka</th>';
		$res.='<th>Třída</th>';
		$res.='<th>Poř.</th>';
$res.='</tr>';
				foreach ($columns as $columnName => $attr) {


			$name = $columnName;
			$header = $attr["header"];
			$class = $attr["class"];
			$visibility = $attr["visibility"];
			$order = $attr["order"];
			$edit = $attr["edit"];

			$checked = '';
			if ($visibility == 1) {
				$checked = ' checked="checked"';
			}
			$checked_edit = '';
			if ($edit == 1) {
				$checked_edit = ' checked="checked"';
			}

					//<td><input'.$checked_edit.' id="edit_'.$name.'" name="edit['.$name.']" type="checkbox" value="'.$name.'"/></td>
			//<td><label for="'.$name.'">'.$name.'</label></td>
			$res.='<tr>';
			$res.='<td><input name="name[]" type="hidden" value="'.$name.'"/>
<input'.$checked.' id="'.$name.'" name="column['.$name.']" type="checkbox" value="'.$name.'"/></td>

<td><input class="textbox" placeholder="'.$name.'" title="'.$name.'"  type="text" name="header[]" value="'.$header.'"/></td>
<td><input class="textbox" type="text" name="class[]" value="'.$class.'"/></td>
<td><input class="textbox" style="width:45px;" type="number" name="order[]" value="'.$order.'"/>';
			$res.='</td></tr>';
		}


		$res.='</table>';
/*		$res .= '		<button class="saveFilter" type="submit" name="saveFilter"><span>Uložit</span></button>';
		$res .= '		<button class="" type="submit" name="setFilter"><span>Nastavit</span></button>';

		$res .= '		<button class="" type="submit" name="copyFilter"><span>Kopírovat</span></button>';
		$res.='</form>';*/

		return $res;
	}

	// načte datový model
	public function loadElements()
	{
		//	$this->setAction(TRANSACTION_PAGE);
		$this->setAction($_SERVER["PHP_SELF"]);
		$this->setClass("standard_form");

		$page = $this->page;


		$name = "name";
		$elem = new G_Form_Element_Text($name);
		$elem->setAttribs(array("id"=>$name,"required"=>true));
		$elem->setAttribs('style','width:300px;font-weight:bold;');
		$value = $this->getPost($name, $page->$name);
		$elem->setAttribs('value',$value);
		$elem->setAttribs('label','Název:');
		$this->addElement($elem);



		if ($this->page_id)
		{

			$elem = new G_Form_Element_Hidden("id");
			$elem->setAttribs('value',$this->page_id);
			$this->addElement($elem);
		}

	}
}
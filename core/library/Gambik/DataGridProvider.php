<?php

//http://www.pivovarcik.cz/admin/ajax/dataGridExport.php?model=Faktura&export
// seleted
// Možnost změny pořadí sloupců

/**
 * Provider pro kompletní zpracování dat v gridu
 * */
class DataGridProvider {

	// výběr řádků
	private $selectable = true;

	// zapnuté třídění na sloupcích
	private $sortable = true;

	// zapnuté filtrování na sloupcích
	private $filter = false;
	// číslování řádku
	private $counter = false;

	private $filterDefinitionList = array();

	private $dataCollection = array();

	private $actionCollection = array();

	private $filterDefinition = array();
	private $selectedRowsCollection = array();

	public $filterDefinitionSelectedId;


	// seznam zobrazovaných sloupců kolekce
	protected $columns = array();
	protected $columnsName = array();

	// pro dopočtení čísla řádku u stránkování
	protected $offset = 1;

	protected $model;
	protected $modelName;

	protected $total = 0;

	protected $limit = 0;
	protected $page = 1;

	protected $params;

	protected $modalForm = false;

	protected $isAjaxTable = false;

	protected $wrapper = false;

	protected $datagridId = null;
	//$data = array(),



	private function loadListArgs($listArgs)
	{

		//print_r($listArgs);
		if (is_null($listArgs)) {
			$className = $this->modelName . "ListArgs";
			if (class_exists($className)) {
				// generate the class here
				$this->params = new $className();

			} else {
				$this->params = new ListArgs();
			}
			foreach ($_GET as $key => $val)
			{
				$this->params->$key = $val;
			}



			// nevím proč to bylo přes POST
/*
	foreach ($_POST as $key => $val)
			{
				$this->params->$key = $val;
			}
*/
			// v žádankách to musí jít tudy
			$paramsArray = get_object_vars($this->params->postdata);
			foreach ($paramsArray as $key => $val)
			{
				$this->params->$key = $val;
			}


		/*	$paramsArray = get_object_vars($_POST);

			foreach ($paramsArray as $key => $val)
			{
				$this->params->$key = $val;
			}*/

			//	print_r($this->params);
		} else {
			$this->params = $listArgs;
		}

		if (defined("LANG_TRANSLATOR")) {
			// kvuli zduplikovani radku ve vypisu !!
			$this->params->lang = LANG_TRANSLATOR;
		}


		if (isset($this->params->cmdList) && count($this->params->cmdList)>0) {

			foreach ($this->params->cmdList as $key=>$val) {

				//print $key . ":" . $val;

				$this->actionRegister($key,$val);
			}
		}

	}

	private function loadWrapper($wrapper)
	{

		if (!$wrapper) {
			$className = $this->modelName . "Wrapper";
			if (class_exists($className)) {
				$this->wrapper = $className;
			} else {
				$this->wrapper = false;
			}

		} else {
			$className = $wrapper;
			if (class_exists($className)) {
				$this->wrapper = $className;

			} else {
				$this->wrapper = false;
			}
		}
	}
	public function __construct($modelName, IListArgs $listArgs = null, $wrapper = false, $gridId = null)
	{
		$this->modelName = $modelName;
		$this->loadWrapper($wrapper);

		if (!is_null($gridId)) {
			$this->datagridId = $gridId;
		} else {
			$this->datagridId = "dg-". rand();
		}
		$this->selectable = false;
		//$actionList = array(""=>"","delete"=>"Odstranit");
		$this->actionCollection = array(""=>"","delete" . $this->modelName =>"Odstranit");

		$this->loadListArgs($listArgs);


		$modelName = "models_" . $modelName;
		$this->model = new $modelName;



		if (is_a($this->model,"ACiselnikModel")) {
			$this->modalForm = true;
		}

		// automatické registování
		$this->saveFilterDefinitionAction();
		$this->copyFilterDefinitionAction();
		$this->setFilterDefinitionAction();
		$this->loadFilterDefinition();
	}
	public function setModalForm($isModalForm = true)
	{
		$this->modalForm = $isModalForm;
	}
	public function setSelectable($isSortable)
	{
		$this->selectable = $isSortable;
	}
	public function isSelectable()
	{
		return $this->selectable;
	}

	public function getColumnsName()
	{
		return $this->columnsName;
	}
	public function isSortable()
	{
		return $this->sortable;
	}

	public function setSortable($isSortable)
	{
		$this->sortable = $isSortable;
	}

	public function getRow($index)
	{

	}

	public function getSelectedRows()
	{
		return $this->selectedRowsCollection;
	}

	public function setColumns($columns)
	{
		if (is_array($columns)) {
			foreach ($columns as $column => $header) {
				$this->addColumn($column, $header);
			}
		}
	}

	public function addColumn($column, $header)
	{
		$this->columns[$column] = $header;
	}

	public function removeColumn($column)
	{
		unset($this->columns[$column]);
	}


	public function loadFilterDefinition()
	{
		$xml = $this->loadFilterDefinitionDb();

		if ($xml) {
			$this->columns = $this->parseFilterDefinitionFromXml($xml);
		}
	}

	// načtení definice z DB
	private function loadFilterDefinitionDbById($id)
	{
		// načtení všech definic, základní + uživatele

		$model = new models_FilterView();

		$result =  $model->getDetailById($id);
		return $result;
	}
	// načtení definice z DB
	private function loadFilterDefinitionDb()
	{
		// načtení všech definic, základní + uživatele
		$model = new models_FilterView();
		//$user_id = defined("USER_ID") ? USER_ID : 0;

		$args = new ListArgs();

		if (defined("USER_ID")) {
			$args->user_id = USER_ID;
		}
		$args->modelName = $this->modelName;
		$result = $model->getList($args);
		// zatím načítám jen Defaultní pohled

		if ($result) {
			$this->filterDefinitionList = $result;
			$this->filterDefinitionSelected = $result[0];

			$this->filterDefinitionSelectedId = $result[0]->id;

			$this->filterDefinition = $result[0]->definition;
			return $this->filterDefinition;
		}
		return false;
	}

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
		/*
		   asort($filterColumnsIndexVisibility);

		   print_r($filterColumnsIndexVisibility);
		   //array_reverse($filterColumnsIndexVisibility);
		   //array_reverse($filterColumnsIndexVisibility);
		   foreach ($filterColumnsIndexVisibility as $columnName => $attrib ) {

		   $filterColumnsOrder[$columnName] = $filterColumns[$columnName];
		   }
		*/

		return $filterColumnsOrder;
		//	print_r($filterColumnsOrder);
		//return vsort($filterColumns,'order', true, false);
		//	return $result->definition;
	}
	public function saveFilterDefinitionAction()
	{
		$request = new G_Html();
		if($request->isPost() && false !== $request->getPost('saveFilter', false))
		{
			$filterName = $request->getPost('filtername', '');
			$columnName = $request->getPost('name[]', array());
			$columnHeader = $request->getPost('header[]', array());
			$columnClass = $request->getPost('class[]', array());
			$columnOrder = $request->getPost('order[]', array());
			$id = $request->getPost('id', 0);
			//print_r($columnName);

			$saveFilterDefinition = array();
			for ($i=0; $i<count($columnHeader);$i++)
			{
				if ($request->getPost('column['.$columnName[$i].']', false)) {
					$saveFilterDefinition[$i]->visibility = "1";
				} else {
					$saveFilterDefinition[$i]->visibility = "0";
				}

				if ($request->getPost('edit['.$columnName[$i].']', false)) {
					$saveFilterDefinition[$i]->edit = "1";
				} else {
					$saveFilterDefinition[$i]->edit = "0";
				}

				$saveFilterDefinition[$i]->order = $columnOrder[$i];
				$saveFilterDefinition[$i]->name = $columnName[$i];
				$saveFilterDefinition[$i]->header = $columnHeader[$i];
				$saveFilterDefinition[$i]->class = $columnClass[$i];


			}

			if ($this->saveFilterDefinition($saveFilterDefinition, $filterName, $id)) {
				$request->goBackRef();
			}

		}
	}

	public function saveFilterDefinitionAjaxAction()
	{
		$request = new G_Html();
		if($request->isPost() && false !== $request->getPost('Application_Form_DataGridDefinitionEdit_action', false))
		{
			$filterName = $request->getPost('Application_Form_DataGridDefinitionEdit_name', '');
			$columnName = $request->getPost('name[]', array());
			$columnHeader = $request->getPost('header[]', array());
			$columnClass = $request->getPost('class[]', array());
			$columnOrder = $request->getPost('order[]', array());
			$id = $request->getPost('Application_Form_DataGridDefinitionEdit_id', 0);


			$saveFilterDefinition = array();
			for ($i=0; $i<count($columnHeader);$i++)
			{
				if ($request->getPost('column['.$columnName[$i].']', false)) {
					$saveFilterDefinition[$i]->visibility = "1";
				} else {
					$saveFilterDefinition[$i]->visibility = "0";
				}

				if ($request->getPost('edit['.$columnName[$i].']', false)) {
					$saveFilterDefinition[$i]->edit = "1";
				} else {
					$saveFilterDefinition[$i]->edit = "0";
				}

				$saveFilterDefinition[$i]->order = $columnOrder[$i];
				$saveFilterDefinition[$i]->name = $columnName[$i];
				$saveFilterDefinition[$i]->header = $columnHeader[$i];
				$saveFilterDefinition[$i]->class = $columnClass[$i];


			}

			if ($this->saveFilterDefinition($saveFilterDefinition, $filterName, $id)) {
				return true;
			}

		}
	}


	public function setFilterDefinitionAction()
	{

		$request = new G_Html();
		if($request->isPost() && false !== $request->getPost('setFilter', false))
		{
			$id = $request->getPost('filter_id', 0);
			$detail = $this->loadFilterDefinitionDbById($id);
			$detail = get_object_vars($detail);

			$updateData = array();
			$updateData["selected"] = 0;
			$this->model->updateRecords(T_FILTERVIEW,$updateData,"modelname='{$this->modelName}'");


			$updateData = array();
			$updateData["selected"] = 1;
			$this->model->updateRecords(T_FILTERVIEW,$updateData,"modelname='{$this->modelName}' and id=".$id);

			$request->goBackRef();

		}
	}

	public function copyFilterDefinitionAction()
	{

		$request = new G_Html();
		if($request->isPost() && false !== $request->getPost('copyFilter', false))
		{
			$id = $request->getPost('id', 0);
			$detail = $this->loadFilterDefinitionDbById($id);
			$detail = get_object_vars($detail);
			if ($this->copyFilterDefinition($detail)) {
				$request->goBackRef();
			}
		}
	}
	private function saveFilterDefinition($saveFilterDefinition = array(), $filtername, $id)
	{
		// převod na XML

		$res='<definition>';

		for($i=0;$i<count($saveFilterDefinition);$i++)
		{
			/*	*/
			$name = trim($saveFilterDefinition[$i]->name);
			$header = trim($saveFilterDefinition[$i]->header);
			$class = trim($saveFilterDefinition[$i]->class);
			$visibility = trim($saveFilterDefinition[$i]->visibility);
			$order = trim($saveFilterDefinition[$i]->order);
			$edit = trim($saveFilterDefinition[$i]->edit);
			$res.='<column name="'.$name.'" header="'.$header.'" class="'.$class.'" order="'.$order.'" visibility="'.$visibility.'" edit="'.$edit.'"/>';
		}


		$res.='</definition>';

		$updateData = array();
		$updateData["definition"] = $res;
		$updateData["name"] = $filtername;

		$filterViewModel = new models_FilterView();

		$filterViewDetail = $filterViewModel->getDetailById($id);

		if ($filterViewDetail->isDefault == 1) {

			$updateData["modelname"] = $this->modelName;
			$updateData["isDefault"] = 0;
			$updateData["selected"] = 1;
			$updateData["user_id"] = USER_ID;
			$this->model->updateRecords(T_FILTERVIEW,array("selected" => 0),"modelname='{$this->modelName}' and id={$id}");
			return $this->model->insertRecords(T_FILTERVIEW,$updateData);

		} else {
			return $this->model->updateRecords(T_FILTERVIEW,$updateData,"modelname='{$this->modelName}' and id={$id}");
		}
		// zjistím jestli jde o defaultní pohled nebo o uživatelský



	}

	private function copyFilterDefinition($insertData = array())
	{
		$insertData["id"] = null;
		$insertData["name"] = $insertData["name"] . " - kopie";
		$insertData["isDefault"] = 0;
		$insertData["user_id"] = (int) USER_ID;

		$model = new models_FilterView();
		return $model->insertRecords($model->getTableName(),$insertData);
	//	return $this->model->insertRecords(T_FILTERVIEW,$insertData);
	}


	public function filterBox()
	{
		$res = '';
		//<i class="fa fa-sort-amount-asc"></i>
	}

	// zobrazení nabídky na změnu zobrazení
	public function filterDefinitionRender()
	{
		$res = '<form method="post" class="datagrid_filter_definition standard_form" style="display:none;">';



		$res .= '<a class="closeBtn" href="javascript:closeFilterDefinitionWizzard();"><i class="fa fa-times"></i></a>';
		$res.='<select name="filter_id" onchange="changeFilterDefinition();">';
		foreach ($this->filterDefinitionList as $key => $filter) {

			$res.='<option value="' . $filter->id . '">' . $filter->name . '</option>';

		}
		$res.='</select>';

		$disabled = ($this->filterDefinitionSelected->isDefault== 1) ? ' disabled="disabled"' : '';

		$res.='<input' . $disabled. ' type="text" name="filtername" value="'.$this->filterDefinitionSelected->name.'" />';

		$res.='<input name="id" type="hidden" value="'.$this->filterDefinitionSelected->id.'" />';

		$res.='<ul>';

		$xml = $this->filterDefinition;

		$filterColumns = $this->parseFilterDefinitionFromXml($xml);
		$columns = $this->orderFilterDefinition($filterColumns);



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


			$res.='<li>';
			$res.='<input name="name[]" type="hidden" value="'.$name.'"/>
<input'.$checked.' id="'.$name.'" name="column['.$name.']" type="checkbox" value="'.$name.'"/>
<input'.$checked_edit.' id="edit_'.$name.'" name="edit['.$name.']" type="checkbox" value="'.$name.'"/>

<input class="textbox" placeholder="'.$name.'" title="'.$name.'"  type="text" name="header[]" value="'.$header.'"/>
<input class="textbox" type="text" name="class[]" value="'.$class.'"/><input class="textbox" type="text" name="order[]" value="'.$order.'"/>';
			$res.='</li>';
		}


		$res.='</ul>';
		$res .= '		<button class="saveFilter" type="submit" name="saveFilter"><span>Uložit</span></button>';
		$res .= '		<button class="" type="submit" name="setFilter"><span>Nastavit</span></button>';

		$res .= '		<button class="" type="submit" name="copyFilter"><span>Kopírovat</span></button>';
		$res.='</form>';

		return $res;
	}

	private function parseFilterDefinitionFromXml($xml)
	{
		if (empty($xml)) {

			return;
		}
		$feed = new SimpleXMLElement($xml);


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

			$filterColumns[$name] = array("header" => $header, "class" => $class,"visibility" => $visibility, "order" => $order);

		//, "edit" => $edit
			if (!empty($edit)) {
				$filterColumns[$name]["edit"] = 1;
			}

		}

		$filterColumns = $this->orderFilterDefinition($filterColumns);
		return $filterColumns;
	}

	/**
	 * Vygeneruje z vybraných sloupců a dat XLS dokument
	 * akceptuje třídění, limity, stejně jako Grid
	 * */
	public function exportDataToXls()
	{
		$this->loadData($this->params);
		$list = $this->dataCollection;

		require_once(PATH_ROOT. "plugins/PHPExcel/Classes/PHPExcel/IOFactory.php");

	//	include PATH_ROOT . "core/library/PHPExcel/Classes/PHPExcel.php";
		$objPHPExcel = new PHPExcel();


		$nazevListu = "Data";
		$nazevSouboru = "export.xls";
		// Set document properties
		//echo date('H:i:s') , " Set document properties" , PHP_EOL;
		$objPHPExcel->getProperties()->setCreator("RS Gambik - pivovarcik.cz")
							 ->setLastModifiedBy("RS Gambik - pivovarcik.cz")
							 ->setTitle("Produkty")
							 ->setSubject("Produkty")
							 ->setDescription("Produkty z eshopu.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
		// Create the worksheet
		//echo date('H:i:s') , " Add data" , PHP_EOL;
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle($nazevListu);

		$bunky = array("A1","B1","C1","D1","E1","F1","G1","H1","I1","J1","K1","L1","M1","N1","O1","P1","Q1","R1","S1","T1","U1");

		$bunka=0;

		foreach ($this->columns as $columnName => $attribs) {

			if (array_key_exists("visibility", $attribs) && $attribs["visibility"] == "0") {

			} else {
				$name = ($columnName);
				if (array_key_exists("header", $attribs)) {
					$name = $column[$columnName] = $attribs["header"];
				}

				$objPHPExcel->getActiveSheet()->setCellValue($bunky[$bunka], $name);
				$bunka++;
			}

		}

		$dataArray = array();
		for ($i=0;$i<count($list);$i++)
		{
			$dataArray[$i] = array();

			foreach ($this->columns as $columnName => $attribs) {

				if (array_key_exists("visibility", $attribs) && $attribs["visibility"] == "0") {

				} else {
					if (isset($list[$i]->$columnName)) {
						array_push($dataArray[$i],$list[$i]->$columnName);
					} else {
						array_push($dataArray[$i],"");
					}
				}
			}

		}
		$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A2');

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$nazevSouboru.'"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');


	}

	public function exportDataToCsv()
	{
		$this->loadData($this->params);
		$list = $this->dataCollection;

		$nazevSouboru = "export.csv";

		$dataArray = array();
		for ($i=0;$i<count($list);$i++)
		{
			$dataArray[$i] = array();

			foreach ($this->columns as $columnName => $attribs) {

				if (array_key_exists("visibility", $attribs) && $attribs["visibility"] == "0") {

				} else {
					if (isset($list[$i]->$columnName)) {
						array_push($dataArray[$i],$list[$i]->$columnName);
					} else {
						array_push($dataArray[$i],"");
					}
				}
			}

		}
		$text = '';
		foreach ($dataArray as $index => $row) {

			$text .='"' . implode('","', $row) . '"' . "\n";
		}
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename="'.$nazevSouboru.'"');
		header('Cache-Control: max-age=0');
		print $text;
	}
	// Načtení dat
	public function loadData(IListArgs $args)
	{
		// potřebuju kolekci,
		// počet záznamů



		//print_r($args);
		if ($this->isSortable()) {
			$args->orderByQueryRegister();
		}


		$args->limitByQueryRegister();
		$args->pageByQueryRegister();



		$this->limit = $args->getLimit();
		$this->page = $args->getPage();

		//print_r($args);

		// kvuli exportum musim prevzit limit/page
		$this->params->limit = $this->limit;
		$this->params->page = $this->page;

		$list = $this->model->getList($args);


		$this->total = $this->model->total;

		$this->dataCollection = $list;

	}

	public function actionRegister($action, $actionHeader)
	{
		// delete, storno, copy

		$this->actionCollection[$action . $this->modelName] = $actionHeader;
		/*$actionList = array();
		   $actionList["delete"];*/
	}
	public function actions()
	{
		$result = '<div class="datagrid_filter">';
		$result .= '<form method="get" class="form-search">';
		$request = new G_Html();
		$registerQuery = array("df","dt","order","status","q","sort","user","limit","sirka", "profil","car","typecar","motorcar","prumer");
		//	$limity = array("25","50","75","100","150","200");
		$limity = array("10","25","50","100","200","500","1000");


		$name = "limit";
		$elem = new G_Form_Element_Select($name);
		$elem->setAnonymous();
		$elem->setAttribs(array(
						"id" => "LimitFilter",
						"class" => "form_edit LimitFilter"));

		if (false !== ($request->getQuery($name, false))) {
			$request->setCookie($name,$request->getQuery($name, ""));
		}
		$value = $this->limit; //$request->getQuery($name, $request->getCookie($name, "100"));
		$elem->setAttribs('value',$value);


		if (!$this->isAjaxTable) {
		$elem->setAttribs('onchange','document.location.href=\'' . AKT_PAGE ."?" . $name . "='+this.value+'" . queryBuilder($name,$registerQuery) . '\'');
		}

		//$elem->setAttribs('label','Typ podniku:');
		$pole = array();
		$attrib = array();
		foreach ($limity as $key => $value)
		{
			$pole[$value] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);




		$result .= "Zobrazit " . $elem->render() . " na stránku | Celkem nalezeno " . $this->total . " záznamů | ";
		//	$this->addElement($elem);


		$elem = new G_Form_Element_Text("q");
		$elem->setAnonymous();
		$value = $request->getQuery("q", "");
		$elem->setAttribs('class','textbox search-text');
		$elem->setAttribs('placeholder','Fultextové vyhledávání');
		$elem->setAttribs('value',$value);
		$elem->setAttribs('style','width:200px;');
		//$this->addElement($elem);

		$result .= $elem->render();

		$result .= '		<button class="btn btn-default btn-xs btn-search" type="submit">Hledej</button>';




		$exporty = array("XLS","CSV");
		$name = "export";
		$elem = new G_Form_Element_Select($name);
		$elem->setAnonymous();
		$elem->setDecoration();
		$elem->setAttribs(array(
				"id" => "ExportFilter",
				"class" => ""));
		$elem->setAttribs('value',$value);
		$pole = array();
		$attrib = array();
		foreach ($exporty as $key => $value)
		{
			$pole[$value] = $value;
		}
		$elem->setMultiOptions($pole,$attrib);

		$result .=  " | " . $elem->render();
		$result .= '		<a class="btn btn-default btn-xs" href="javascript:exportDataGrid();" >Export</a>';


		if ($this->isAjaxTable) {
			$result .= ' |<p class="filter-settings"><a class="grid-refresh" href="#"><i class="fa fa-refresh"></i><span>Refresh</span></a> <a class="grid-settings" href="#"><i class="fa fa-cog"></i><span>Sloupce</span></a>';
		} else {
			$result .= ' | <a class="filter-settings" href="javascript:openFilterDefinitionWizzard();"><i class="fa fa-cog"></i><span>Sloupce</span></a>';
		}




		$result .= '</form>';

		if ($this->isSelectable()) {


			$result .= '<form method="post" class="actionSubmit">';
			$actionList = array(""=>"","delete"=>"Odstranit");
			$name = "action";
			$elem = new G_Form_Element_Select($name);
			$elem->setAnonymous();
			$elem->setDecoration();
			$elem->setAttribs(array(
					"id" => "ActionFilter",
					"class" => ""));
			$elem->setAttribs('value',$value);
			$pole = array();
			$attrib = array();

			foreach ($this->actionCollection as $key => $value)
			{
				$pole[$key] = $value;
			}
			$elem->setMultiOptions($pole,$attrib);
			$result .=  " | Označené " . $elem->render();
			$result .= '		<button class="btn btn-default btn-xs" type="submit">Proveď</button>';
			$result .= '</form>';

		}
		$result .= '</div>';
		return $result;

	}

	public function getTotal()
	{
		return $this->total;
	}
	public function paging()
	{
		$pager = new G_Paginator($this->params->getPage() , $this->total, $this->params->getLimit(), $this->isAjaxTable);
		$output = $pager->render();

		return $output;
	}


	public function addButton($label = "Nová", $url = "#")
	{
		$res = '';
		$res .= '<a href="#" data-url="'.$url.'" class="btn btn-sm btn-info '.$this->datagridId.'-add-form">'.$label.'</a>';
		return $res;
		// data-url="/admin/options/mj?do=create" ;
	}
	public function ajaxTable()
	{
		$res = '';

		$res .= '<div id="'.$this->datagridId.'"></div>';
		$res .= '<script type="text/javascript">';
	//	$res .= '$(document).ready(function(){';
	//	$res .= 'loadGrid("'.$this->modelName.'");';

		//$res .= 'var args = {modelName : "'.$this->modelName.'"};';
		$res .= 'var args = {id:"'.$this->datagridId.'", modelName : "'.$this->modelName.'", wrapper : '. ($this->wrapper !== false ? '"'.$this->wrapper.'"' : 'false').'};';
		$res .= 'var dataGrid = new DataGridProvider(args);';


		$paramsArray = get_object_vars($this->params);

	//	print_r($paramsArray);
		$res .= 'var params = {';
		foreach ($paramsArray as $key => $val) {

			if (!is_object($val)) {


			if (!empty($val) && $key != "limit" && $key != "page" && $key != "isDeleted") {
				$res .= $key .':"' . $val . '",';
			}
					}


		}
		$res .= '};';

		$res .= 'dataGrid.setParams(params);';


		if ($this->modalForm) {
			$res .= 'dataGrid.setModal(true);';
		}


		$res .= 'dataGrid.loadData();';
	//	$res .= '});';

$res .= '$(document).ready(function(){';
	//	$res .= 'function registerGridEvent(){';
		$res .= '$(".'.$this->datagridId.'-add-form").on( "click",function(e){';
		$res .= 'e.preventDefault();';
	//	$res .= 'console.log("klik");';

		// pro datagrid zaregistruji tlačítko přidej
		$res .= 'dataGrid.modalFormCreate($(this).attr("data-url"));';

		$res .= '});';
$res .= '});';
//$res .= '}';

		$res .= '</script>';

		return $res;
	}
	/**
	 * registrace prokliku na řádku
	 * */
	public function linkRowRegister()
	{
		// link, label, class, column

	//	new OdkazSloupce($radek, $sloupec, $)
	}
	public function table($params = array())
	{

		if (isset( $this->model->formNameEdit)) {
			$form = (string)  $this->model->formNameEdit;
			$formName = 'Application_Form_' . ucfirst($form);
			$formclass = new $formName();

		}
		$this->loadData($this->params);
		$data = $this->dataCollection;



		if ($this->isSortable()) {
			$sorting = new G_Sorting("date","desc", $this->isAjaxTable);
		}
		$column = array();

		$th_attrib = array();
		$td_attrib = array();
		$tr_attrib = array();
		$span_start="";
		$span_end="";

		for ($i=0; $i<count($data);$i++)
		{

			if ($this->wrapper !== false) {

				$wrapperName = $this->wrapper;

				$myClass = $this->wrapper;
				$refl = new ReflectionClass($myClass);
				$instance = $refl->newInstanceArgs( array(
   $data[$i]));

			//$aaa =	new "" . $wrapperName;
			//	$wrap =	new $this->wrapper($data[$i]);
		//	$wrap =	new $this->wrapper($data[$i]);
			}
			if ($this->isSelectable()) {
				$columnName = "checkbox";
				$elem = new G_Form_Element_Checkbox("slct[" . $i . "]");
				$elem->setAttribs('value', $data[$i]->id);
				$elem->setAttribs('class', 'selectable');
				$elem->setAnonymous();
				$data[$i]->$columnName = $elem->render();
			}


			if (!isset($data[$i]->cmd)) {
				$data[$i]->cmd = '';
			}


			$data[$i]->cmd .= '<div class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">akce <span class="caret"></span></a>
			<ul class="dropdown-menu">';
			if (isset($data[$i]->dg_commands) && is_array($data[$i]->dg_commands) && count($data[$i]->dg_commands) > 0) {

				foreach ($data[$i]->dg_commands as $command) {

				//	print_r($command);
					$data_url = '';
					$class = 'dropdown-toggle '. $command->name. 'Link ';
					if (!empty($command->data_url)) {
						$data_url = ' data-url="'.$command->data_url.'"';
						$class .= $this->datagridId.'-modal-form';
					}


					$href = 'href="#"';
					if (!empty($command->link)) {
						$href = ' href="'.$command->link.'"';

					}

					$data[$i]->cmd .= '<li><a class="'. $class. '" '.$data_url.' '.$href.'>'.$command->label.'</a></li>';
				}


			} else {


				if (isset($data[$i]->link_edit)) {

					if ($this->modalForm && $this->isAjaxTable) {
						$data[$i]->cmd .= '<li><a class="dropdown-toggle editLink '.$this->datagridId.'-modal-form" data-url="'.$data[$i]->link_edit.'" href="#"><i class="fa fa-pencil fa-2"></i> <span>edit</span>' . $span_start. '' . $span_end . '</a></li>';

					} else {
						$data[$i]->cmd .= '<li><a class="dropdown-toggle editLink" href="'.$data[$i]->link_edit.'"><i class="fa fa-pencil-square-o fa-2"></i> edit' . $span_start. '' . $span_end . '</a></li>';

					}
				}


				if (isset($data[$i]->link_delete)) {
					if ($this->modalForm && $this->isAjaxTable) {
						$data[$i]->cmd .= '<li><a class="dropdown-toggle deleteLink '.$this->datagridId.'-modal-form" data-url="'.$data[$i]->link_delete.'" href="#"><i class="fa fa-trash-o"></i> <span>smazat</span>' . $span_start. '' . $span_end . '</a></li>';

					} else {
						$data[$i]->cmd .= '<li><a class="dropdown-toggle deleteLink" href="'.$data[$i]->link_delete.'"><i class="fa fa-times fa-2"></i>' . $span_start. '' . $span_end . '</a></li>';

					}

				}

				if (isset($data[$i]->link_print)) {
					$data[$i]->cmd .= '<li><a class="dropdown-toggle printLink" target="_blank" title="Tisk v PDF" href="'.$data[$i]->link_print.'">' . $span_start. '<span>Tisk</span>' . $span_end . '</a></li>';
				}
			}



if (isset($data[$i]->link_view)) {
	$data[$i]->cmd .= '<li><a class="dropdown-toggle viewLink" href="'.$data[$i]->link_view.'">' . $span_start. '<span>Detail</span>' . $span_end . '</a></li>';
}





$data[$i]->cmd .= '</ul>
		</div>';

/*
			if (isset($data[$i]->link_view)) {
				$data[$i]->cmd .= '<a class="viewLink" title="Zobrazit" href="'.$data[$i]->link_view.'">' . $span_start. '<span>Detail</span>' . $span_end . '</a> ';
			}


			if (isset($data[$i]->link_edit)) {

				if ($this->modalForm && $this->isAjaxTable) {
					$data[$i]->cmd .= '<a class="editLink '.$this->datagridId.'-modal-form" data-url="'.$data[$i]->link_edit.'" href="#"><i class="fa fa-pencil fa-2"></i> <span>edit</span>' . $span_start. '' . $span_end . '</a> ';

				} else {
					$data[$i]->cmd .= '<a class="editLink" href="'.$data[$i]->link_edit.'"><i class="fa fa-pencil-square-o fa-2"></i> edit' . $span_start. '' . $span_end . '</a> ';

				}
			}


			if (isset($data[$i]->link_delete)) {
				if ($this->modalForm && $this->isAjaxTable) {
					$data[$i]->cmd .= ' <a class="deleteLink '.$this->datagridId.'-modal-form" data-url="'.$data[$i]->link_delete.'" href="#"><i class="fa fa-trash-o"></i> <span>smazat</span>' . $span_start. '' . $span_end . '</a> ';

				} else {
					$data[$i]->cmd .= ' <a class="deleteLink" href="'.$data[$i]->link_delete.'"><i class="fa fa-times fa-2"></i>' . $span_start. '' . $span_end . '</a> ';

				}

			}

			if (isset($data[$i]->link_print)) {
				$data[$i]->cmd .= '<a target="_blank" class="printLink" title="Tisk v PDF" href="'.$data[$i]->link_print.'">' . $span_start. '<span>Tisk</span>' . $span_end . '</a> ';
			}
			*/


		}
		//			array_unshift($column,$columnName);
		if ($this->isSelectable()) {
			$columnName = "checkbox";
			$elem = new G_Form_Element_Checkbox("slctAll");
			$elem->setAttribs('value', 1);
			$elem->setAttribs('class', 'slctAll');
			$elem->setAnonymous();
			$column[$columnName] = $elem->render();
			//$columnName = '#';

			$th_attrib[$columnName]["class"] = "check-column";
		}

		// přidání sloupců v daném pořadí
		foreach ($this->columns as $columnName => $attribs)
		{

			$headerLabel = $columnName;
			if (array_key_exists("header", $attribs)) {
				$headerLabel = $attribs["header"];
			}
			if ($this->isSortable() && isset($this->params->allowedOrder[$columnName])) {


				$headerLabel = $sorting->render($headerLabel, $columnName);


			}

			if ($this->isVisibility($attribs))
			{

				$column[$columnName] = $headerLabel;

				if (array_key_exists("class", $attribs) && !empty($attribs["class"])) {
					$th_attrib[$columnName]["class"] = $attribs["class"] . "-column";
					$td_attrib[$columnName]["class"] = $attribs["class"] . "-column";
				} else {
					$th_attrib[$columnName]["class"] = $columnName . "-column";
					$td_attrib[$columnName]["class"] = $columnName . "-column";
				}
			}

		}



		// Nakonec CMD
		$columnName = "cmd";
		$column[$columnName] = 'Akce';
		//$columnName = '#';

		$th_attrib[$columnName]["class"] = "cmd-column";

		// převod na formát

		for ($i=0; $i<count($data);$i++)
		{
			foreach ($this->columns as $columnName => $attribs) {


				if (isset($data[$i]->$columnName) && array_key_exists("class", $attribs)) {


					switch ($attribs["class"]) {
						case "money":
							$data[$i]->$columnName = number_format($data[$i]->$columnName, 2, ',', ' ');
							break;
						case "checkbox":
							$elem = new G_Form_Element_Checkbox($columnName . "[]");
							$elem->setAttribs('value', 1);
							$elem->setAttribs('disabled', 'disabled');
							//	$data[$i]->$columnName = $elem->render();
							//	$column[$columnName] = $elem->render();
							if ($data[$i]->$columnName == "1") {
								$elem->setAttribs('checked','checked');
							}
							$data[$i]->$columnName = $elem->render();
							break;
						case "datetime":
							$data[$i]->$columnName = gDate($data[$i]->$columnName);
							break;
						case "date":
							$data[$i]->$columnName = gDate($data[$i]->$columnName,"j.n.Y");
							break;
						case "url":
							if (isUrl($data[$i]->$columnName)) {
								$data[$i]->$columnName = '<a target="_blank" title="'.$data[$i]->$columnName.'" href="'.$data[$i]->$columnName.'">'.$data[$i]->$columnName.'</a>';
							}

							break;
						default:
						;
					} // switch


				}

					if (array_key_exists("edit", $attribs)) {



						if (isset($formclass) && $formclass->getElement($columnName)) {
							$elem = $formclass->getElement($columnName);
							$elem->setAttribs('value', is_null($data[$i]->$columnName) ? "" : $data[$i]->$columnName);
							$elem->setAttribs('data-origin-value', is_null($data[$i]->$columnName) ? "" : $data[$i]->$columnName);
							$elem->setAttribs('style', 'width: 90%;');
							$elem->setAttribs('id', '');
							$elem->setAttribs('class',$attribs["class"] . " edit");
							$elem->setDecoration();
							$elem->setAttribs('label', '');
							$data[$i]->$columnName = $elem->render();
						} else {
							// editační zobrazení
							/*$elem = new G_Form_Element_Text($columnName . "[]");
							$elem->setAttribs('value', $data[$i]->$columnName);
							$elem->setAttribs('data-origin-value', $data[$i]->$columnName);
							$elem->setAttribs('style', 'width: 90%;');
							$elem->setAttribs('class',$attribs["class"] . " edit");
							$elem->setDecoration();*/
						}



						//	$elem->setAttribs('disabled', 'disabled');

					}
				//}


			}
			// zobrazení krátkého popisu
			$name = "description";
			if (isset($data[$i]->$name) && !empty($data[$i]->$name)) {
				$data[$i]->$name = ' <span title="Poznámka: ' . truncateUtf8(trim(strip_tags($data[$i]->$name)),300,false,true) .'" class="user_comment">U</span>';
			}

			$name = "description_secret";
			if (isset($data[$i]->$name) && !empty($data[$i]->$name)) {
				$data[$i]->$name = ' <span title="Interní poznámka: ' . truncateUtf8(trim(strip_tags($data[$i]->$name)),300,false,true) .'" class="secret_comment">S</span>';
			}

			// nastavení řádků ze statustu


			if (isset($data[$i]->status) && trim(strip_tags($data[$i]->status)) == trim($data[$i]->status)) {
				$tr_attrib[$i]["class"] = $data[$i]->status;
			}

		}


		// filter
		if ($this->filter && isset($data[0])) {
			$request = new G_Html();
			$filterColumns = clone $data[0];


			//$request = new G_Html();
			//$filterColumns = clone $data[0];
			array_unshift($tr_attrib, array("class" => ""));

			if (isset($filterColumns->checkbox)) {
				$filterColumns->checkbox = "";
			}

			if (isset($filterColumns->cmd)) {
				$filterColumns->cmd = "";

				$elem = new G_Form_Element_Button($columnName);
				$elem->setDecoration();
				$elem->setAttribs('value', 'Filtruj');
				//	$elem->setAttribs('style', 'width: 90%;');

				$filterColumns->cmd = $elem->render();

			}
			foreach ($this->columns as $columnName => $attribs) {

				if (isset($data[0]->$columnName))
				{
					$filterColumns->$columnName = "";



					if (array_key_exists("class", $attribs)) {


						switch ($attribs["class"]) {
							case "money":

								$elem = new G_Form_Element_Text($columnName);
								$elem->setDecoration();

								$value = $request->getQuery($columnName, '');
								$elem->setAttribs('value', $value);

								$elem->setAttribs('style', 'width: 90%;');

								$filterColumns->$columnName = $elem->render();
								break;
							case "checkbox":
								/*	$elem = new G_Form_Element_Checkbox($columnName . "[]");
								   $elem->setAttribs('value', 1);
								   $elem->setAttribs('disabled', 'disabled');
								   if ($data[$i]->$columnName == "1") {
								   $elem->setAttribs('checked','checked');
								   }
								   $data[$i]->$columnName = $elem->render();*/
								break;
							case "datetime":
								//	$data[$i]->$columnName = gDate($data[$i]->$columnName);
								break;
							case "date":
								//	$data[$i]->$columnName = gDate($data[$i]->$columnName,"j.n.Y");
								break;
							case "url":


								break;
							default:

								$elem = new G_Form_Element_Text($columnName);
								$value = $request->getQuery($columnName, '');
								$elem->setAttribs('value', $value);
								$elem->setAttribs('style', 'width: 90%;');
								$elem->setDecoration();
								$filterColumns->$columnName = $elem->render();
						} // switch
					}
				}
			}

			array_unshift($data, $filterColumns);
		}
	//	$this->columnsName = $column;
		$table = new G_Table($data, $column, $th_attrib, $td_attrib, $tr_attrib);


		$table_attrib = array(
							"class" => "widefat",
							"id" => "data_grid",
							"cellspacing" => "0",
							);

		$result = '<div class="dataGridProvider">';
		$paging = $this->paging();

		$result .= $this->actions();
//overflow-x: scroll;
		$result .='<form id="filterDefinition2" class="standard_form" method="get" style=" border: 0 none;">';
		$result .=   $table->makeTable($table_attrib);
		$result .= '</form>';
		$result .= $paging;

		if (!$this->isAjaxTable) {
			$result .=   $this->filterDefinitionRender();
		}

		$result .=   $this->javascriptRender();
		$result .= '</div>';
		return $result;

	}


	private function isVisibility($attribs = array())
	{
		if (array_key_exists("visibility", $attribs) && $attribs["visibility"] == "0") {
			return false;
		}
		return true;
	}


	private function paramsToUrl()
	{

		$res = '';
		foreach ($this->params as $key => $val){

						if (!is_object($val)) {
			if (is_array($val)) {
				foreach ($val as $key2 => $valA){

					$res .= '&' .$key . '[]=' . $valA;
				}
			} else {
				$res .= '&' .$key . '=' . $val;
			}


						}

		}
		return $res;
	}

	public function getAllowedOrder() {
		return $this->params->allowedOrder;
	}
	public function getColumns() {
		return $this->columnsName;
	}

	public function javascriptRender()
	{
		$res = '<script type="text/javascript">';
		$res .= 'function closeFilterDefinitionWizzard(){$(".datagrid_filter_definition").css("display","none");}';
		$res .= 'function openFilterDefinitionWizzard(){$(".datagrid_filter_definition").css("display","block");}';
		//	$res .= 'function changeFilterDefinition(){$("#filterDefinition2 .saveFilter").click();}';


		// chybí parametry

		//	queryBuilder("",$this->params);

		$registerQuery = array("df","dt","order","status","q","sort","user","limit","sirka", "profil","car","typecar","motorcar","prumer","pg");
		//str_replace("&amp;","&",queryBuilder("export",$registerQuery)).
		$res .= 'function exportDataGrid(){var typExport = $("#ExportFilter").val();var link = "'.URL_HOME2.'admin/ajax/dataGridExport.php?model='.$this->modelName.'&export="+typExport+"'.$this->paramsToUrl() . '";document.location=link;/*window.open(link,"export");*/}';

		$res .= '$(".widefat").delegate("tr", "mouseover", function() {
			$(this).addClass("row_style_radek");
			return false;
		});

		$(".widefat").delegate("tr", "mouseout", function() {
			$(this).removeClass("row_style_radek");
			return false;
		});';


		if (!$this->isAjaxTable) {


		$res .= '$(".widefat").delegate("tr", "click", function() {
			$(".widefat tr").removeClass("focused_row");
			$(this).addClass("focused_row");
		//	return false;
		});';


		$res .= '$(".widefat").delegate("tr", "dblclick", function() {
			var editLink = $(this).find(".editLink");
			var url = $(editLink).attr("href");
			if (url)
			{
				$(location).attr("href",url);
			}
			return false;
		});';

		$res .= '$(".widefat").delegate(".edit", "blur", function() {

		if (typeof $(this).attr("data-origin-value") == "undefined")
		{
			$(this).attr("data-origin-value","");
		}
		if ($(this).val() != $(this).attr("data-origin-value"))
		{
		console.log($(this).val() + "!="+ $(this).attr("data-origin-value"));
			var id = $(".widefat .focused_row .selectable").val();
		//	alert("zmena" + id);
			changedValue($(this).attr("name"), $(this).val(), $(this).attr("data-origin-value"), id,$(this));
		}
		});';

					}

	//alert(name + id);
		$res .= 'function changedValue(name, value, oldValue, id, that){
if (typeof id == "undefined")
{
	return;
}
that.css("background-color","#A0D8DF");

	var data = {};
	var name = name.replace("[]","");

	';
// celý název už vrací samotný formulář
	/*	if (isset($this->model->formNameEdit)) {
			$res .= 'name = "Application_Form_'.$this->model->formNameEdit.'_" + name;';
		}*/
	// prefix

	$res .= 'data[name] = value;
			data["action"] = "'.$this->model->formNameEdit.'";
			data["callback"] = "json";

					$.ajax({
	  	type: "POST",
		url: UrlBase + "/ajax/dataGridUpdate.php?id=" + id + "&model='.$this->modelName.'",
		dataType: "json",
		data: data,
		success: function(r) {
			that.attr("data-origin-value",value);
			//that.val(value);

			if (r.status == "saved")
			{
				that.css("background-color","#e9fada");
			} else {
				that.css("background-color","#faedec");
			}

	},
	failure: function() {
	},
	error: function () {
	}

});
			}';




		$res .= '$(".actionSubmit").submit( function(event) {
			var form = this;
			//event.preventDefault();
			var selectable = $(".selectable:checked");
			//alert(selectable.length);

			if (selectable.length > 0)
			{
				var slctArray = [];
				$(selectable).each(function( index ) {
					$("<input>").attr({
            			"type":"hidden",
            			"name":"slct["+index+"]"
        			}).val($( this ).val()).appendTo(form);

				});
				//return false;
			} else {
				alert("Nebyl vybrán žádný záznam!");
				event.preventDefault();
				return false;
			}


		});

		$(".slctAll").click( function(event) {
		if ($(this).is(":checked"))
		{
			selectedAllRows(true);
		} else {
		selectedAllRows(false);
		}
		});

		function selectedAllRows(checked)
		{
			$(".selectable").attr("checked",checked);
		}
		';


		$res .= '</script>';

		return $res;
	}

	public function getDataLoaded()
	{
		return $this->dataCollection;
	}
}



class AjaxDataGridProvider extends DataGridProvider {
	public function __construct($modelName, IListArgs $listArgs = null, $wrapper = false, $gridId)
	{
		$this->isAjaxTable = true;
		parent::__construct($modelName, $listArgs, $wrapper, $gridId);
	}
}
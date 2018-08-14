<?php
require_once("ACiselnikBase.php");
class CiselnikBase extends ACiselnikBase {

	function __construct($pageModel)
	{
		parent::__construct($pageModel);
	}
	public function setResultError($chybovaHlaska = "")
	{
		$this->chybovaHlaska = $chybovaHlaska;
	}
	public function akcePredUlozenim()
	{
		$data = $this->saveEntity->getChangedData();
		if (isset($data["parent"]))
		{

			if ($data["parent"] == $this->saveEntity->getId()) {
				//print "Nelze vybrat jako umístění sám sebe!";
				$this->setResultError("Nelze vybrat jako umístění sám sebe!");
				return false;
			}
			$categoryParent = self::$model->getDetailById($data["parent"]);

			//print_r($categoryParent);
			if (strpos($categoryParent->serial_id . "|", "|" . $this->saveEntity->getId() . "|" )) {
				$this->setResultError("Nelze vybrat jako umístění kategorii, která je vně této rubriky!");
				return false;
			}
		}

	}

	// Možnost připojit vlastní logiku
	public function akcePoUlozeni()
	{

	}

	// Možnost připojit vlastní logiku
	public function akcePoUlozeniSChybou()
	{
		return $this->chybovaHlaska;
	}

	public function akcePredUlozenimSChybou()
	{
		return $this->chybovaHlaska;
	}
	public function formLoad($form)
	{
		$form = (string) $form;
		$formName = 'F_' . ucfirst($form);
		$class = new $formName();
		return $class;
	}

	public function orderFromQuery($querys, $default, $order = 'order', $sort = 'sort')
	{

		$result = "";
		foreach ($querys as $key => $value){
			if ($value['url'] == self::$getRequest->getQuery($order, '')) {

				$sort_default = isset($value[$sort]) ? $value[$sort] : '';
				if (self::$getRequest->getQuery($sort, $sort_default) == 'desc') {
					$sort = 'desc';
				} else {
					$sort = 'asc';
				}


				$result = $value['sql'] . " " . $sort;
			}
		}
		if (empty($result) && !empty($default)) {
			$result = $default;
		}
		return $result;
	}

	public function createAjaxAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false) && self::$getRequest->getPost('action', false) == $this->pageModel .'Create')
		{

			//	print "tudy";
			// načtu Objekt formu
			$form = $this->formLoad($this->pageModel . 'Create');
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{

				//	print_r($postdata);
				//	exit;
				$postdata = $form->getValues();

				$pageSaveData = self::setPageData($postdata, $form->page);
				if (self::saveData($pageSaveData)) {

					return true;
					//$result["status"] = "success";
					//return true;
				} else {
					$result = array();
					$result["status"] = "wrong";
					$json = json_encode($result);
					print_r($json);
					exit;

				}
			}
		}

	}


	public function saveAjaxAction()
	{

		// Je odeslán formulář
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false) && self::$getRequest->getPost('action', false) == $this->pageModel .'Edit')
		{
			// načtu Objekt formu
			$form = $this->formLoad($this->pageModel . 'Edit');
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{
				$postdata = $form->getValues();


				$pageSaveData = $this->setPageData($postdata, $form->page);
				if (self::saveData($pageSaveData)) {

					return true;
					//$result["status"] = "success";
					//return true;
				} else {
					$result = array();
					$result["status"] = "wrong";
					$json = json_encode($result);
					print_r($json);
					exit;

				}
			}



			//$callback = self::$getRequest->goBackRef();
			//self::saveMethod($callback);
		}
	}


	public function deleteAjaxAction()
	{


	//	print self::$getRequest->getPost('action', false);
	//	exit;

		// mazání z datagridu
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false)
			&& "delete" . $this->pageModel == self::$getRequest->getPost('action', false))
		{
		//	print "tudy";
/*
			$selectedItems = self::$getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						//	$model = new models_Products();
						$obj = parent::$model->getDetailById($doklad_id);

						if ($obj) {
							$data = array();
							$data["isDeleted"] = 1;
							if(parent::$model->updateRecords(parent::$model->getTableName(),$data,"id=".$doklad_id))
							{
								array_push($seznamCiselObjednavek,$obj->name );
							}
						}
					}
				}
				if (count($seznamCiselObjednavek)>0) {
					array_reverse($seznamCiselObjednavek);
					//$_SESSION["statusmessage"]="Záznam " . implode(",", $seznamCiselObjednavek) . " byl smazán.";
					//$_SESSION["classmessage"]="success";
					return true;
					//self::$getRequest->goBackRef();
				} else {
					$result = array();
					$result["status"] = "wrong";
					$json = json_encode($result);
					print_r($json);
					exit;

				}

			}*/



			$doklad_id = (int) self::$getRequest->getQuery('id', 0);

			if ($doklad_id) {
			//	$model = new models_Products();
				$obj = parent::$model->getDetailById($doklad_id);

				if ($obj) {
					$data = array();
					$data["isDeleted"] = 1;
					if(parent::$model->updateRecords(parent::$model->getTableName(),$data,"id=".$doklad_id))
					{
						array_push($seznamCiselObjednavek,$obj->id );
						return true;
					}
				}

			}

		}
	}

	protected function createData()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false) && self::$getRequest->getPost('action', false) == $this->pageModel .'Create')
		{

			//	print "tudy";
			// načtu Objekt formu
			$form = $this->formLoad($this->pageModel . 'Create');
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{

				//	print_r($postdata);
				//	exit;
				$postdata = $form->getValues();

				$pageSaveData = self::setPageData($postdata, $form->page);

				if (self::saveData($pageSaveData))
				{

					$form->setResultSuccess("Záznam byl přidán.");
					self::$getRequest->goBackRef();
				}
			}
		}
	}
	public function createAction()
	{
		//print $this->pageModel;
		//print self::$getRequest->getPost('action', false) . "==" . $this->pageModel .'Create';
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false) && self::$getRequest->getPost('action', false) == $this->pageModel .'Create')
		{

		//	print "tudy";
			// načtu Objekt formu
			$form = $this->formLoad($this->pageModel . 'Create');
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{

			//	print_r($postdata);
			//	exit;
				$postdata = $form->getValues();

				$pageSaveData = self::setPageData($postdata, $form->page);

				if (self::saveData($pageSaveData))
				{
					$form->setResultSuccess("Záznam byl přidán.");
					self::$getRequest->goBackRef();
				}
			}
		}
	}

	public function deleteAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost($this->pageModel .'Delete', false))
		{
			print "mažu";
			//print

			$tenzin = self::$getRequest->getPost($this->pageModel .'Delete', false);
			list($key,$value) = each($tenzin);
			//	print $key;
			$product_id = $_POST['ciselnik_id'][$key];
			if ($product_id) {

				$row = parent::$model->getRow($product_id);

				if ($row) {
					//$_fotoPlaces->setData($data);

					if(parent::$model->delete($product_id))
					{
						$_SESSION["statusmessage"]="Záznam byl smazán.";
						$_SESSION["classmessage"]="success";
						self::$getRequest->goBackRef();
					}
				}
			}

		}


		// mazání z datagridu
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false)
			&& "delete" . $this->pageModel == self::$getRequest->getPost('action', false))
		{

			$selectedItems = self::$getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
					//	$model = new models_Products();
						$obj = parent::$model->getDetailById($doklad_id);

						if ($obj) {
							$data = array();
							$data["isDeleted"] = 1;
							if(parent::$model->updateRecords(parent::$model->getTableName(),$data,"id=".$doklad_id))
							{
								array_push($seznamCiselObjednavek,$obj->name );
							}
						}
					}
				}
				if (count($seznamCiselObjednavek)>0) {
					array_reverse($seznamCiselObjednavek);
					$_SESSION["statusmessage"]="Záznam " . implode(",", $seznamCiselObjednavek) . " byl smazán.";
					$_SESSION["classmessage"]="success";
					self::$getRequest->goBackRef();
				}
			}

		}
	}

	public function saveAction()
	{
		// Je odeslán formulář
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false) && self::$getRequest->getPost('action', false) == $this->pageModel .'Edit')
		{
			// načtu Objekt formu
			$form = $this->formLoad($this->pageModel . 'Edit');
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{
				$postdata = $form->getValues();


				$pageSaveData = self::setPageData($postdata, $form->page);
				if (self::saveData($pageSaveData)) {

					if (self::$getRequest->getPost('callback', false) == false) {
						$form->setResultSuccess("Záznam byl aktualizován.");
						self::$getRequest->goBackRef();
					}
					return true;
				} else {

					if (self::$getRequest->getPost('callback', false) == false) {
						$form->setResultError(self::akcePredUlozenimSChybou());
						$form->setResultError(self::akcePoUlozeniSChybou());
					}
					return false;
				}
			}
			//$callback = self::$getRequest->goBackRef();
			 //self::saveMethod($callback);
		}
	}

	public function saveMethod($callback = null)
	{
		// načtu Objekt formu
		$form = $this->formLoad($this->pageModel . 'Edit');
		// Provedu validaci formu



		if ($form->isValid(self::$getRequest->getPost()))
		{
			$postdata = $form->getValues();
		//	print_r($form->page);

		//	print_r($postdata);
		//	exit;
			//exit;
			$pageSaveData = self::setPageData($postdata, $form->page);
			if (self::saveData($pageSaveData)) {
				$form->setResultSuccess("Záznam byl aktualizován.");
				if (!is_null($callback)) {
					call_user_func($callback);
				}
			} else {
				$form->setResultError(self::akcePredUlozenimSChybou());
				$form->setResultError(self::akcePoUlozeniSChybou());
			}
		}
	}


	public function ciselnikList($params = array())
	{


		$params2 = array();

		$limit 	= self::$getRequest->getQuery('limit', 100);
		$params2['limit'] = $limit;
		$page 	= self::$getRequest->getQuery('pg', 1);
		$params2['page'] = $page;

		$search_string = self::$getRequest->getQuery('q', '');
		$params2['fulltext'] = $search_string;

		$querys = array();
		$querys[] = array('title'=>'Název','url'=>'name','sql'=>'t1.name');
		$orderFromQuery = $this->orderFromQuery($querys, 't1.name ASC');

		$params2['order'] = $orderFromQuery;


		$list = parent::$model->getList($params2);

		return $list;
	}

	public function ciselnikListEdit($params = array())
	{

		$l = $this->ciselnikList($params);
		for ($i=0;$i < count($l);$i++)
		{

			$elem = new G_Form_Element_Checkbox("slct[" . $i . "]");
			$value = $l[$i]->id;
			$elem->setAttribs('value', $value);
			$l[$i]->checkbox = $elem->render();


			//$prodejniCena = $l[$i]->prodcena;
			$command = '<input class="" style="border-color:white;" onclick="return confirm(\'Opravdu SMAZAT kategorii: '.$l[$i]->name.'?\')" type="image" src="'.URL_HOME . 'admin/action_delete.gif" value="X" name="' . $this->pageModel .'Delete[' . $i . ']"/>';

			$command .= '<input type="hidden" value="' . $l[$i]->id . '" name="ciselnik_id[' . $i . ']"/>';


			$l[$i]->cmd = $command;

			$l[$i]->name = '<a href="/admin/' . $this->pageModel .'Edit.php?id='.$l[$i]->id.'">' . $l[$i]->name . '</a>';
			//		$command = '<input class="tlac" onclick="return confirm(\'Opravdu SMAZAT sortiment č. '.$l[$i]->cislo_mat.'?\')" type="submit" value="X" name="del_product[' . $i . ']"/><input type="hidden" value="' . $l[$i]->klic_ma . '" name="product_id[' . $i . ']"/>';


		}
		return $l;
	}

	public function CiselnikTable($params = array())
	{

		$l = $this->ciselnikListEdit($params);

		$sorting = new G_Sorting("name","asc");

		$data = array();

		$column["checkbox"] = '<input onclick="multi_check(this);" type="checkbox">';
		$column["name"] = $sorting->render("Název", "name");
		$column["description"] = $sorting->render("Popis", "desc");
		$column["cmd"] = "";


		$th_attrib = array();
		$th_attrib["checkbox"]["class"] = "check-column";
		$th_attrib["name"]["class"] = "column-cat";
		$th_attrib["cmd"]["class"] = "column-cmd";


		$table = new G_Table($l, $column, $th_attrib, $td_attrib);


		$table_attrib = array(
				"class" => "widefat fixed",
				"id" => "data_grid",
				"cellspacing" => "0",
				);

		return $table->makeTable($table_attrib);
	}
}
?>
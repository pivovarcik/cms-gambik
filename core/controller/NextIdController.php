<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class NextIdController extends CiselnikBase
{

	function __construct()
	{
		parent::__construct("NextId");
	}

	public function vrat_nextid($params = array())
	{
		$model = new models_NextId();
		return $model->vrat_nextid($params);
	}
	public function createAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('ins_nextid', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('NextIdCreate');
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{

				$polozky = array(
							strToUpper(T_SHOP_PRODUCT) => "cislo",
							strToUpper(T_SHOP_ORDERS) => "code",
							strToUpper(T_FAKTURY) => "code",
							);
				$model = new models_NextId();
				$formData = $form->getValues();

				$nazevRady = $formData["nazev"];
				$radaDokladu = $formData["rada"];
				$delkaDokladu = $formData["delka"];
				$tabulkaDokladu = $formData["tabulka"];
				//	print $tabulkaDokladu;
				//	print_r($polozky);
				$polozkaDokladu = "";
				if (isset($polozky[$tabulkaDokladu])) {
					$polozkaDokladu = $polozky[$tabulkaDokladu];
				}
				if (empty($polozkaDokladu)) {
					$_SESSION["statusmessage"]= "errors";
					$_SESSION["statustext"]= "Pro daný typ dokladu neexistuje vazební položka!";
					//$form->addError("rada","Tato řada již existuje!");
					$form->setResultError("Pro daný typ dokladu neexistuje vazební položka!");
					return false;
					return false;

				}
				//	return;
				$tabulkaDokladu = strtoupper($tabulkaDokladu);
				// Ověření existence řady
				$query = "select * from " . T_NEXTID . " where tabulka='" . $tabulkaDokladu . "' and polozka='" . $polozkaDokladu . "' and polozka='" . $radaDokladu . "' LIMIT 1";
				$row = $model->get_row($query);
				//	print $query;
				//	print_r($row);
				if (isset($row->tabulka) && !empty($row->tabulka)) {
					$form->addError("rada","Tato řada již existuje!");
					$form->setResultError("Tato řada již existuje!");
					return false;
				}

				$data = array();
				$data["rada"] = $radaDokladu;
				$data["polozka"] = $polozkaDokladu;
				$data["delka"] = $delkaDokladu;
				$data["nazev"] = $nazevRady;
				$data["tabulka"] = $tabulkaDokladu;
				if($model->insertRecords(T_NEXTID, $data))
				{
					$form->setResultSuccess("Řada byla přidána.");
					self::$getRequest->goBackRef();
				}
			}
		}
	}

	public function saveAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('upd_nextid', false))
		{

			// načtu Objekt formu
			$form = $this->formLoad('NextIdEdit');
			// Provedu validaci formu
			if ($form->isValid(self::$getRequest->getPost()))
			{

				$polozky = array(
							strToUpper(T_SHOP_PRODUCT) => "cislo",
							strToUpper(T_SHOP_ORDERS) => "code",
							strToUpper(T_FAKTURY) => "code",
							);
				$model = new models_NextId();
				$formData = $form->getValues();

				$nazevRady = $formData["nazev"];
				$radaDokladu = $formData["rada"];
				$delkaDokladu = $formData["delka"];
				$tabulkaDokladu = $formData["tabulka"];
				$id = $formData["id"];
				//	print $tabulkaDokladu;
				//	print_r($polozky);
				$polozkaDokladu = "";
				if (isset($polozky[$tabulkaDokladu])) {
					$polozkaDokladu = $polozky[$tabulkaDokladu];
				}
				/*
				if (empty($polozkaDokladu)) {
					$_SESSION["statusmessage"]= "errors";
					$_SESSION["statustext"]= "Pro daný typ dokladu neexistuje vazební položka!";
					return false;

				}*/
				//	return;


				$tabulkaDokladu = strtoupper($tabulkaDokladu);
				// Ověření existence řady
				$query = "select * from " . T_NEXTID . " where tabulka='" . $tabulkaDokladu . "' and polozka='" . $polozkaDokladu . "' and polozka='" . $radaDokladu . "' and id<>" . $id . " LIMIT 1";
				$row = $model->get_row($query);
				//	print $query;
				//	print_r($row);
				if (isset($row->tabulka) && !empty($row->tabulka)) {
					$form->addError("rada","Tato řada již existuje!");
					$form->setResultError("Tato řada již existuje!");
					return false;
				}

				$data = array();

				$data["rada"] = $radaDokladu;
				$data["polozka"] = $polozkaDokladu;
				$data["delka"] = $delkaDokladu;
				$data["nazev"] = $nazevRady;
				$data["tabulka"] = $tabulkaDokladu;
				if($model->updateRecords(T_NEXTID, $data,"id={$id}"))
				{
					$form->setResultSuccess("Řada byla uložena.");
					self::$getRequest->goBackRef();
				}
			}
		}
	}

	public function deleteAction()
	{

		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('action', false)
			&& "deleteNextId" == self::$getRequest->getPost('action', false))
		{

			$selectedItems = self::$getRequest->getPost('slct', array());
			$seznamCiselObjednavek = array();
			if (count($selectedItems) > 0) {
				foreach ($selectedItems as $key => $doklad_id) {
					if ($doklad_id) {
						$model = new models_NextId();
						$obj = $model->getDetailById($doklad_id);

						if ($obj) {

						/*	if ($obj->user_id != USER_ID) {
								// Nejsi vlastník
								if (USER_ROLE_ID != 2) {
									// Ani správce
									$_SESSION["statusmessage"]= "Smazat článek může pouze vlastník nebo správce.";
									$_SESSION["classmessage"]="errors";
									return false;
								}
							}*/

							$data = array();
							$data["isDeleted"] = 1;
							if($model->updateRecords($model->getTableName(),$data,"id=".$doklad_id))
							{
								array_push($seznamCiselObjednavek,$obj->nazev );
							}
						}
					}
				}
				array_reverse($seznamCiselObjednavek);
				$_SESSION["statusmessage"]="Řada " . implode(",", $seznamCiselObjednavek) . " byla smazána.";
				$_SESSION["classmessage"]="success";
				self::$getRequest->goBackRef();
			}

		}
	}

	public function nextIdList($params = array())
	{
		$model = new models_NextId();


		$limit 	= self::$getRequest->getQuery('limit', 100);
		if (isset($params['limit']) && is_numeric($params['limit'])) {
			$limit = $params['limit'];
		} else {
			$params['limit'] = $limit;
		}
		//	$params["uid_user"] = USER_ID;
		$page 	= self::$getRequest->getQuery('pg', 1);
		$params['page'] = $page;
		$search_string = self::$getRequest->getQuery('q', '');
		if ( !empty($search_string) ) {
			$params['fulltext'] = $search_string;
			//print $date_from;
		}

		$id = self::$getRequest->getQuery('id', 0);
		if ( ($id > 0 ) ) {
			$id = (int) $id;
			$params['id'] = $id;
			//print $zadatel;
		}

		$querys = array();
		$querys[] = array('title'=>'Řada','url'=>'num','sql'=>'t1.rada');
		$querys[] = array('title'=>'Název','url'=>'name','sql'=>'t2.nazev');

		if (isset($params['order']) && !empty($params['order'])) {

		} else {
			$orderFromQuery = $this->orderFromQuery($querys, 't1.rada ASC');
			//print $orderFromQuery;
			$params['order'] = $orderFromQuery;
		}

		$list = $model->getList($params);


		$this->total = $model->total;

		return $list;
	}

	public function nextIdListEdit($params = array())
	{
		$l = $this->nextIdList($params);
		for ($i=0;$i < count($l);$i++)
		{
			$l[$i]->rada = '<a href="/nextid_detail.php?rada='.$l[$i]->rada.'">' . $l[$i]->rada . '</a>';
			$l[$i]->counter = ($i+1) . ".";
		}
		return $l;
	}

	public function nextIdListTable($params = array())
	{

		$sorting = new G_Sorting("date","desc");

		$params = array();
		//	$params['limit'] = 25;
		//	$zadankyController = new ZadankyController();
		//	$l = $zadankyController->zadankyListEdit($params);
		$l = $this->nextIdListEdit($params);


		$sorting = new G_Sorting("num","desc");
		$data = array();
		$th_attrib = array();

		$column["counter"] = '#';

		$column["rada"] = $sorting->render("Řada", "num");
		$column["nazev"] =  $sorting->render("Název řady", "dadd");
		$column["delka"] =   $sorting->render("Délka", "len");
		$column["tabulka"] =   $sorting->render("Tabulka", "tab");

		//$th_attrib["counter"]["class"] = "column-price";
		$th_attrib["rada"]["class"] = "column-cat";
		$th_attrib["delka"]["class"] = "column-cat";

		$td_attrib["counter"]["class"] = "column-price check-column";



		$table = new G_Table($l, $column, $th_attrib, $td_attrib);


		$table_attrib = array(
							"class" => "widefat",
							"id" => "data_grid",
							"cellspacing" => "0",
							);
		return $table->makeTable($table_attrib);

	}
}